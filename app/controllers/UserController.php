<?php

require_once BASE_PATH . '/app/helpers/auth.php';

class UserController 
{
    public function index($pdo)
    {
        // Pastikan session sudah aktif sebelum diakses
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Cek login dan role admin
        if (!check() || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header("Location: index.php?page=dashboard");
            exit;
        }

        // Ambil data user
        $stmt = $pdo->query("SELECT id, username, name, role, created_at FROM users ORDER BY created_at DESC");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        ob_start();
        require BASE_PATH . '/app/views/users/index.php';
        $content = ob_get_clean();

        require BASE_PATH . '/app/views/layouts/main.php';
    }
}