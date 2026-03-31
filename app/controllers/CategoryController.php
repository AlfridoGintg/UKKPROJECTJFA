<?php

class CategoryController 
{
    /**
     * Menampilkan daftar kategori
     */
    public function index($pdo)
    {
        // Validasi akses: Hanya admin yang boleh masuk
        if ($_SESSION['role'] !== 'admin') { 
            header("Location: index.php"); 
            exit; 
        }

        // Mengurutkan berdasarkan ID terbaru sesuai referensi
        $stmt = $pdo->query("SELECT * FROM categories ORDER BY id DESC");
        $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

        ob_start();
        require BASE_PATH . '/app/views/categories/index.php';
        $content = ob_get_clean();
        require BASE_PATH . '/app/views/layouts/main.php';
    }

    /**
     * Menampilkan form tambah kategori
     */
    public function create()
    {
        ob_start();
        require BASE_PATH . '/app/views/categories/create.php';
        $content = ob_get_clean();
        require BASE_PATH . '/app/views/layouts/main.php';
    }

    /**
     * Menyimpan kategori baru ke database
     */
    public function store($pdo)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Mempertahankan keamanan htmlspecialchars
            $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
            
            $stmt = $pdo->prepare("INSERT INTO categories (name) VALUES (?)");
            $stmt->execute([$name]);

            header("Location: index.php?page=categories");
            exit;
        }
    }

    /**
     * Menghapus kategori
     */
    public function delete($pdo)
    {
        $id = $_GET['id'] ?? null;
        if ($id) {
            $stmt = $pdo->prepare("DELETE FROM categories WHERE id = ?");
            $stmt->execute([$id]);
        }
        header("Location: index.php?page=categories");
        exit;
    }
}