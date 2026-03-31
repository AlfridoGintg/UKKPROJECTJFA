<?php

require_once BASE_PATH . '/app/helpers/auth.php';

class UserController 
{
    /**
     * ADMIN ONLY: Menampilkan daftar seluruh user (Mahasiswa & Petugas)
     */
    public function index($pdo)
    {
        // 1. Pastikan session sudah aktif sebelum diakses (Proteksi dari kode awal)
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // 2. Cek login dan role admin secara ketat
        if (!check() || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header("Location: index.php?page=dashboard");
            exit;
        }

        // 3. Ambil data user (Hanya mahasiswa dan petugas agar admin tidak terhapus sengaja)
        // Menggunakan filter WHERE role IN untuk keamanan tambahan
        $stmt = $pdo->query("SELECT id, username, name, role, created_at FROM users WHERE role IN ('mahasiswa', 'petugas') ORDER BY role, username ASC");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // 4. Render view dengan layout utama
        ob_start();
        require BASE_PATH . '/app/views/users/index.php';
        $content = ob_get_clean();

        require BASE_PATH . '/app/views/layouts/main.php';
    }

    /**
     * ADMIN ONLY: Simpan User Baru
     */
    public function store($pdo) 
    {
        // Proteksi role dan metode request
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin' || $_SERVER['REQUEST_METHOD'] !== 'POST') {
            exit("Unauthorized Access");
        }

        $name = htmlspecialchars($_POST['name'] ?? '', ENT_QUOTES, 'UTF-8');
        $username = htmlspecialchars($_POST['username'] ?? '', ENT_QUOTES, 'UTF-8');
        $password = password_hash($_POST['password'] ?? '', PASSWORD_DEFAULT);
        $role = $_POST['role'] ?? 'mahasiswa';

        try {
            // Cek duplikasi username
            $check = $pdo->prepare("SELECT id FROM users WHERE username = ?");
            $check->execute([$username]);
            if ($check->fetch()) {
                die("<script>alert('Username sudah digunakan!'); history.back();</script>");
            }

            $stmt = $pdo->prepare("INSERT INTO users (name, username, password, role, created_at) VALUES (?, ?, ?, ?, NOW())");
            $stmt->execute([$name, $username, $password, $role]);

            header("Location: index.php?page=users&msg=added");
            exit;
        } catch (PDOException $e) {
            die("Gagal menambah user: " . $e->getMessage());
        }
    }

    /**
     * ADMIN ONLY: Hapus User
     */
    public function delete($pdo) 
    {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            exit("Unauthorized Access");
        }
        
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        
        if ($id) {
            try {
                // Pastikan yang dihapus BUKAN akun admin demi keamanan sistem
                $stmt = $pdo->prepare("DELETE FROM users WHERE id = ? AND role != 'admin'");
                $stmt->execute([$id]);

                header("Location: index.php?page=users&msg=deleted");
                exit;
            } catch (PDOException $e) {
                die("Gagal menghapus user: " . $e->getMessage());
            }
        }
    }
}