<?php

class AuthController
{
    public function login($pdo)
    {
        // Jika sudah login, tendang ke dashboard (biar gak login dua kali)
        if (isset($_SESSION['role'])) {
            header("Location: index.php?page=dashboard");
            exit;
        }

        $error = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            // Ambil data user berdasarkan username
            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->execute([$username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Cek user ada dan password cocok
            if ($user && password_verify($password, $user['password'])) {
                
                // Simpan data penting ke SESSION (flat structure)
                $_SESSION['user_id']  = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['name']     = $user['name'];
                $_SESSION['role']     = $user['role']; // admin, petugas, atau mahasiswa

                header("Location: index.php?page=dashboard");
                exit;
            } else {
                $error = "Username atau password salah!";
            }
        }

        // Panggil view login
        require_once BASE_PATH . '/app/views/auth/login.php';
    }

    public function logout()
    {
        // Hancurkan semua session
        session_unset();
        session_destroy();
        
        // Balikin ke login
        header("Location: index.php?page=login");
        exit;
    }
}