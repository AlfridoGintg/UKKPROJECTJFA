<?php
require_once BASE_PATH . '/app/helpers/auth.php';

class LoanController {
    
    // PETUGAS: Melihat antrean approval
    public function approvals($pdo) {
        if (!check() || !in_array($_SESSION['role'], ['admin', 'petugas'])) {
            header("Location: index.php?page=dashboard");
            exit;
        }

        $stmt = $pdo->query("SELECT l.*, u.username, i.name as item_name 
                             FROM loans l 
                             LEFT JOIN users u ON l.user_id = u.id 
                             LEFT JOIN items i ON l.item_id = i.id 
                             WHERE l.status = 'pending' 
                             ORDER BY l.created_at DESC");
        $pending_loans = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        ob_start();
        require BASE_PATH . '/app/views/admin/approvals.php';
        $content = ob_get_clean();
        require BASE_PATH . '/app/views/layouts/main.php';
    }

    // MAHASISWA: Proses simpan dengan validasi stok & tanggal (Stage 1)
    public function store($pdo) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') exit;

        $user_id = $_SESSION['user_id'];
        
        // Validasi dan Sanitasi Input
        $item_id = filter_input(INPUT_POST, 'item_id', FILTER_VALIDATE_INT);
        $condition = htmlspecialchars($_POST['initial_condition'] ?? '', ENT_QUOTES, 'UTF-8');
        $return_date = htmlspecialchars($_POST['return_date'] ?? '', ENT_QUOTES, 'UTF-8');

        // 1. Validasi Durasi (Max 4 Hari)
        $today = new DateTime(date('Y-m-d'));
        $returning = new DateTime($return_date);
        $interval = $today->diff($returning);
        $diff = $interval->days;

        if ($diff > 4 || $returning < $today || $interval->invert == 1) {
            die("<script>alert('Error: Durasi peminjaman maksimal 4 hari atau format tanggal salah.'); history.back();</script>");
        }

        // 2. Validasi Stok Sisi Server
        $stmt = $pdo->prepare("SELECT stock FROM items WHERE id = ?");
        $stmt->execute([$item_id]);
        $item = $stmt->fetch();

        if (!$item || $item['stock'] <= 0) {
            die("<script>alert('Error: Stok barang sudah habis. Silakan pilih alat lain.'); history.back();</script>");
        }

        try {
            $stmt = $pdo->prepare("INSERT INTO loans (user_id, item_id, return_date, status, condition_start, created_at) VALUES (?, ?, ?, 'pending', ?, NOW())");
            $stmt->execute([$user_id, $item_id, $return_date, $condition]);
            header("Location: index.php?page=dashboard&status=success");
            exit;
        } catch (Exception $e) {
            die("Gagal: " . $e->getMessage());
        }
    }

    // PETUGAS/ADMIN: Approve (Stage 1 -> 2)
    public function approve($pdo) {
        if (!in_array($_SESSION['role'], ['admin', 'petugas'])) exit;
        
        $loan_id = filter_input(INPUT_POST, 'loan_id', FILTER_VALIDATE_INT);

        try {
            $pdo->beginTransaction();
            $qr = "JFA-" . strtoupper(substr(md5(uniqid()), 0, 6));
            
            // Ambil data untuk memastikan status masih pending
            $stmt = $pdo->prepare("SELECT item_id FROM loans WHERE id = ? AND status = 'pending'");
            $stmt->execute([$loan_id]);
            $loan = $stmt->fetch();

            if ($loan) {
                // Update status ke approved & Buat kode QR
                $pdo->prepare("UPDATE loans SET status = 'approved', qr_code = ?, pickup_code = ? WHERE id = ?")
                    ->execute([$qr, $qr, $loan_id]);
                
                // Kurangi stok (Booking item)
                $pdo->prepare("UPDATE items SET stock = stock - 1 WHERE id = ?")
                    ->execute([$loan['item_id']]);
            }

            $pdo->commit();
            header("Location: index.php?page=dashboard&status=approved");
            exit;
        } catch (Exception $e) {
            $pdo->rollBack();
            die($e->getMessage());
        }
    }

    // PETUGAS/ADMIN: Tolak Peminjaman
    public function reject($pdo) {
        if (!in_array($_SESSION['role'], ['admin', 'petugas'])) exit;
        
        $loan_id = filter_input(INPUT_POST, 'loan_id', FILTER_VALIDATE_INT);
        $pdo->prepare("UPDATE loans SET status = 'rejected' WHERE id = ?")->execute([$loan_id]);
        
        header("Location: index.php?page=dashboard&status=rejected");
        exit;
    }

    /**
     * VERIFIKASI PENGAMBILAN (Stage 2 -> Stage 3)
     * Mengubah status dari 'approved' menjadi 'borrowed'
     * Logic: Menghitung ulang return_date agar durasi tetap sama dihitung dari hari ini.
     */
    public function pickup($pdo) {
        if (!in_array($_SESSION['role'], ['admin', 'petugas'])) exit;
        $loan_id = filter_input(INPUT_POST, 'loan_id', FILTER_VALIDATE_INT);

        // Ambil data untuk menghitung selisih hari peminjaman
        $stmt = $pdo->prepare("SELECT created_at, return_date FROM loans WHERE id = ?");
        $stmt->execute([$loan_id]);
        $loan = $stmt->fetch();

        if ($loan) {
            // Hitung durasi (hari) dari tanggal pengajuan ke rencana awal pengembalian
            $created = new DateTime(date('Y-m-d', strtotime($loan['created_at'])));
            $returning = new DateTime($loan['return_date']);
            $diff = $created->diff($returning)->days;
            
            // Set return_date baru dihitung dari HARI INI (saat di-pickup)
            $new_return_date = date('Y-m-d', strtotime("+$diff days"));

            $stmt = $pdo->prepare("UPDATE loans SET status = 'borrowed', start_date = NOW(), return_date = ? WHERE id = ? AND status = 'approved'");
            $stmt->execute([$new_return_date, $loan_id]);
        }
        header("Location: index.php?page=dashboard&status=picked_up");
        exit;
    }

    /**
     * BATALKAN PENGAMBILAN (Jika mahasiswa tidak datang / bermasalah)
     */
    public function cancelPickup($pdo) {
        if (!in_array($_SESSION['role'], ['admin', 'petugas'])) exit;
        $loan_id = filter_input(INPUT_POST, 'loan_id', FILTER_VALIDATE_INT);
        
        try {
            $pdo->beginTransaction();
            // Ambil item_id untuk mengembalikan stok
            $stmt = $pdo->prepare("SELECT item_id FROM loans WHERE id = ? AND status = 'approved'");
            $stmt->execute([$loan_id]);
            $loan = $stmt->fetch();

            if ($loan) {
                // Ubah status jadi rejected dan kembalikan stok
                $pdo->prepare("UPDATE loans SET status = 'rejected' WHERE id = ?")->execute([$loan_id]);
                $pdo->prepare("UPDATE items SET stock = stock + 1 WHERE id = ?")->execute([$loan['item_id']]);
            }
            $pdo->commit();
            header("Location: index.php?page=dashboard&status=rejected");
            exit;
        } catch (Exception $e) {
            $pdo->rollBack();
            die($e->getMessage());
        }
    }

    /**
     * MAHASISWA: Ajukan Pengembalian Barang
     */
    public function requestReturn($pdo) {
        if ($_SESSION['role'] !== 'mahasiswa') exit;
        $loan_id = filter_input(INPUT_POST, 'loan_id', FILTER_VALIDATE_INT);
        $user_id = $_SESSION['user_id'];
        
        // Ubah status menjadi return_pending agar masuk ke dashboard petugas
        $pdo->prepare("UPDATE loans SET status = 'return_pending' WHERE id = ? AND user_id = ? AND status = 'borrowed'")
            ->execute([$loan_id, $user_id]);
            
        header("Location: index.php?page=dashboard&status=return_requested");
        exit;
    }

    /**
     * VERIFIKASI PENGEMBALIAN (Stage 3 -> Selesai)
     * Menghitung denda, mengembalikan stok, dan mencatat waktu kembali
     */
    public function returnItem($pdo) {
        if (!in_array($_SESSION['role'], ['admin', 'petugas'])) exit;
        
        $loan_id = filter_input(INPUT_POST, 'loan_id', FILTER_VALIDATE_INT);
        $kondisi = htmlspecialchars($_POST['condition'] ?? 'Baik', ENT_QUOTES, 'UTF-8');

        // Ambil info harga barang untuk denda dan ID barang untuk stok
        $stmt = $pdo->prepare("SELECT i.id, i.purchase_price FROM items i JOIN loans l ON i.id = l.item_id WHERE l.id = ?");
        $stmt->execute([$loan_id]);
        $item = $stmt->fetch();

        if ($item) {
            // Hitung denda: Rusak 50%, Hilang 100%
            $denda = 0;
            if ($kondisi === 'Rusak') {
                $denda = $item['purchase_price'] * 0.5;
            } elseif ($kondisi === 'Hilang') {
                $denda = $item['purchase_price'];
            }

            try {
                $pdo->beginTransaction();

                // Kembalikan stok ke tabel items jika barang tidak Hilang
                if ($kondisi !== 'Hilang') {
                    $pdo->prepare("UPDATE items SET stock = stock + 1 WHERE id = ?")->execute([$item['id']]);
                }

                // Update status loans ke 'returned', simpan denda, kondisi akhir, dan waktu kembali (NOW)
                $pdo->prepare("UPDATE loans SET status = 'returned', fine = ?, condition_end = ?, returned_at = NOW() WHERE id = ?")
                    ->execute([$denda, $kondisi, $loan_id]);

                $pdo->commit();
            } catch (Exception $e) {
                $pdo->rollBack();
                die("Gagal memproses pengembalian: " . $e->getMessage());
            }
        }

        header("Location: index.php?page=dashboard&msg=returned");
        exit;
    }

    // SEMUA ROLE: Melihat riwayat
    public function history($pdo) {
        if (!check()) {
            header("Location: index.php?page=login");
            exit;
        }

        $role = $_SESSION['role'];
        $user_id = $_SESSION['user_id'];

        if (in_array($role, ['admin', 'petugas'])) {
            $stmt = $pdo->query("SELECT l.*, u.username as student_name, i.name as item_name 
                                 FROM loans l 
                                 JOIN users u ON l.user_id = u.id 
                                 JOIN items i ON l.item_id = i.id 
                                 ORDER BY l.created_at DESC");
        } else {
            $stmt = $pdo->prepare("SELECT l.*, u.username as student_name, i.name as item_name 
                                   FROM loans l 
                                   JOIN users u ON l.user_id = u.id 
                                   JOIN items i ON l.item_id = i.id 
                                   WHERE l.user_id = ? 
                                   ORDER BY l.created_at DESC");
            $stmt->execute([$user_id]);
        }

        $history = $stmt->fetchAll(PDO::FETCH_ASSOC);

        ob_start();
        require BASE_PATH . '/app/views/history/index.php';
        $content = ob_get_clean();
        require BASE_PATH . '/app/views/layouts/main.php';
    }
}