<?php

require_once BASE_PATH . '/app/helpers/auth.php';

class ItemController
{
    /**
     * Helper untuk validasi apakah user login adalah Admin
     * Diperbaiki agar konsisten dengan AuthController
     */
    private function isAdmin() {
        // AuthController menyimpan role langsung di $_SESSION['role']
        return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
    }

    /**
     * TAMPILAN UTAMA: Katalog Alat Produksi
     */
    public function index($pdo)
    {
        if (!check()) {
            header("Location: index.php?page=login");
            exit;
        }

        $keyword = $_GET['q'] ?? '';
        $category_id = $_GET['category'] ?? '';
        
        $limit = 12; 
        $page = isset($_GET['p']) ? (int)$_GET['p'] : 1;
        $offset = ($page - 1) * $limit;

        $query = "SELECT i.*, c.name as category_name 
                  FROM items i 
                  LEFT JOIN categories c ON i.category_id = c.id 
                  WHERE 1=1";
        
        $params = [];

        if (!empty($keyword)) {
            $query .= " AND (i.name LIKE ? OR i.brand LIKE ?)";
            $params[] = "%$keyword%";
            $params[] = "%$keyword%";
            
            $role = $_SESSION['role'] ?? '';
            $userId = $_SESSION['user_id'] ?? 0;

            if($role === 'mahasiswa' && $userId > 0) {
                try {
                    $stmtHist = $pdo->prepare("INSERT INTO search_history (user_id, keyword) VALUES (?, ?)");
                    $stmtHist->execute([$userId, $keyword]);
                } catch (PDOException $e) {
                    // Abaikan jika tabel tidak ada
                }
            }
        }

        if (!empty($category_id)) {
            $query .= " AND i.category_id = ?";
            $params[] = $category_id;
        }

        $query .= " ORDER BY i.id DESC LIMIT $limit OFFSET $offset";

        $stmt = $pdo->prepare($query);
        $stmt->execute($params);
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

        ob_start();
        require BASE_PATH . '/app/views/items/index.php';
        $content = ob_get_clean();
        require BASE_PATH . '/app/views/layouts/main.php';
    }

    /**
     * Tambah Barang Baru (Admin Only)
     */
    public function create($pdo)
    {
        if (!$this->isAdmin()) {
            header("Location: index.php?page=items");
            exit;
        }

        $stmt = $pdo->query("SELECT * FROM categories ORDER BY name ASC");
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

        ob_start();
        // Pastikan file view ini ada: app/views/items/create.php
        require BASE_PATH . '/app/views/items/create.php';
        $content = ob_get_clean();
        require BASE_PATH . '/app/views/layouts/main.php';
    }

    /**
     * Simpan Data Barang (Admin Only)
     */
    public function store($pdo)
    {
        if (!$this->isAdmin() || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?page=items");
            exit;
        }

        // Pastikan semua field dari form tambah barang terisi
        $data = [
            $_POST['name'],
            $_POST['brand'],
            $_POST['category_id'],
            $_POST['condition_status'],
            $_POST['stock'],
            $_POST['purchase_price']
        ];

        $stmt = $pdo->prepare("INSERT INTO items (name, brand, category_id, condition_status, stock, purchase_price) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute($data);

        header("Location: index.php?page=items&msg=success");
        exit;
    }

    /**
     * Edit Data Barang (Admin Only)
     */
    public function edit($pdo)
    {
        if (!$this->isAdmin()) {
            header("Location: index.php?page=items");
            exit;
        }

        $id = $_GET['id'] ?? 0;
        $stmt = $pdo->prepare("SELECT * FROM items WHERE id = ?");
        $stmt->execute([$id]);
        $item = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$item) die("Barang tidak ditemukan.");

        $stmtCat = $pdo->query("SELECT * FROM categories ORDER BY name ASC");
        $categories = $stmtCat->fetchAll(PDO::FETCH_ASSOC);

        ob_start();
        require BASE_PATH . '/app/views/items/edit.php';
        $content = ob_get_clean();
        require BASE_PATH . '/app/views/layouts/main.php';
    }

    /**
     * Update Data Barang (Admin Only)
     * Diperbaiki agar mendukung update spesifik (Kondisi & Stok)
     */
    public function update($pdo)
    {
        if (!$this->isAdmin() || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: index.php?page=items");
            exit;
        }

        $id = $_POST['id'];

        // Jika form edit hanya mengirim id, condition_status, dan stock:
        if (isset($_POST['condition_status']) && isset($_POST['stock']) && !isset($_POST['name'])) {
            $stmt = $pdo->prepare("UPDATE items SET condition_status = ?, stock = ? WHERE id = ?");
            $stmt->execute([
                $_POST['condition_status'],
                $_POST['stock'],
                $id
            ]);
        } else {
            // Jika form edit mengirim data lengkap (Full CRUD)
            $data = [
                $_POST['name'],
                $_POST['brand'],
                $_POST['category_id'],
                $_POST['condition_status'],
                $_POST['stock'],
                $_POST['purchase_price'],
                $id
            ];
            $stmt = $pdo->prepare("UPDATE items SET name=?, brand=?, category_id=?, condition_status=?, stock=?, purchase_price=? WHERE id=?");
            $stmt->execute($data);
        }

        header("Location: index.php?page=items&msg=updated");
        exit;
    }

    /**
     * Hapus Barang (Admin Only)
     */
    public function delete($pdo)
    {
        if (!$this->isAdmin()) {
            header("Location: index.php?page=items");
            exit;
        }

        $id = $_GET['id'] ?? 0;
        $stmt = $pdo->prepare("DELETE FROM items WHERE id = ?");
        $stmt->execute([$id]);

        header("Location: index.php?page=items&msg=deleted");
        exit;
    }
}