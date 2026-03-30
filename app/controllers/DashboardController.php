<?php

require_once BASE_PATH . '/app/helpers/auth.php';

class DashboardController 
{
    public function index($pdo)
    {
        if (!check()) {
            header("Location: index.php?page=login");
            exit;
        }

        $user_id = $_SESSION['user_id'];
        $role = $_SESSION['role'];

        $stats = [
            'total_users' => 0, 'total_items' => 0, 'total_loans' => 0, 
            'pending_approval' => 0, 'items_broken' => 0, 'total_stock' => 0
        ];
        $recent_activities = [];
        $history = [];
        $equipments = [];

        try {
            if ($role === 'admin') {
                // 1. Ambil data statistik untuk card di bagian atas
                $stats['total_users']   = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn() ?: 0;
                $stats['total_items']   = $pdo->query("SELECT COUNT(*) FROM items")->fetchColumn() ?: 0;
                $stats['total_loans']   = $pdo->query("SELECT COUNT(*) FROM loans")->fetchColumn() ?: 0;
                $stats['total_stock']   = $pdo->query("SELECT SUM(stock) FROM items")->fetchColumn() ?: 0;
                $stats['pending_approval'] = $pdo->query("SELECT COUNT(*) FROM loans WHERE status = 'pending'")->fetchColumn() ?: 0;
                $stats['items_broken']     = $pdo->query("SELECT COUNT(*) FROM items WHERE condition_status = 'Rusak'")->fetchColumn() ?: 0;
                
                // 2. Query untuk Antrean Persetujuan (Hanya yang pending untuk Admin)
                $stmt = $pdo->query("
                    SELECT l.*, u.username as student_name, i.name as item_name 
                    FROM loans l 
                    JOIN users u ON l.user_id = u.id 
                    JOIN items i ON l.item_id = i.id
                    WHERE l.status = 'pending' 
                    ORDER BY l.created_at DESC LIMIT 5
                ");
                $recent_activities = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // 3. Ambil data peralatan untuk tabel Katalog Inventaris di Admin Console
                $equipments = $pdo->query("SELECT * FROM items ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);

            } elseif ($role === 'petugas') {
                $stats['total_stock']      = $pdo->query("SELECT SUM(stock) FROM items")->fetchColumn() ?: 0;
                $stats['pending_approval'] = $pdo->query("SELECT COUNT(*) FROM loans WHERE status = 'pending'")->fetchColumn() ?: 0;
                $stats['items_broken']     = $pdo->query("SELECT COUNT(*) FROM items WHERE condition_status = 'Rusak'")->fetchColumn() ?: 0;
                
                $equipments = $pdo->query("SELECT * FROM items ORDER BY name ASC")->fetchAll(PDO::FETCH_ASSOC);

                // PERBAIKAN DI SINI:
                // Mengambil SEMUA status yang masih aktif agar muncul di 3 tabel berbeda (Persetujuan, Siap Diambil, dan Sedang Dipinjam)
                $stmt = $pdo->query("
                    SELECT l.*, u.username as student_name, i.name as item_name 
                    FROM loans l 
                    JOIN users u ON l.user_id = u.id 
                    JOIN items i ON l.item_id = i.id
                    WHERE l.status IN ('pending', 'approved', 'borrowed', 'on_loan', 'return_pending')
                    ORDER BY l.created_at DESC
                ");
                $recent_activities = $stmt->fetchAll(PDO::FETCH_ASSOC);

            } else {
                // Mahasiswa
                $equipments = $pdo->query("SELECT * FROM items WHERE stock > 0 LIMIT 8")->fetchAll(PDO::FETCH_ASSOC);
                
                $stmt = $pdo->prepare("
                    SELECT l.*, i.name as item_name 
                    FROM loans l
                    LEFT JOIN items i ON l.item_id = i.id
                    WHERE l.user_id = ? ORDER BY l.created_at DESC LIMIT 5
                ");
                $stmt->execute([$user_id]);
                $history = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (PDOException $e) {
            die("Database Error: " . $e->getMessage());
        }

        $data = [
            'stats' => $stats,
            'recent_activities' => $recent_activities,
            'history' => $history,
            'equipments' => $equipments,
            'role' => $role,
            'title' => 'Dashboard ' . ucfirst($role)
        ];

        extract($data);

        ob_start();
        $viewPath = BASE_PATH . "/app/views/dashboard/{$role}.php";
        if (file_exists($viewPath)) {
            require $viewPath;
        } else {
            echo "View not found: " . $viewPath;
        }
        $content = ob_get_clean();

        require BASE_PATH . '/app/views/layouts/main.php';
    }
}