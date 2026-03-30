<?php
// 1. Inisialisasi Session & Error Reporting
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 2. Definisi Path Dasar
define('BASE_PATH', dirname(__DIR__));

// 3. Load Database & Helper
require_once BASE_PATH . '/app/config/database.php';
require_once BASE_PATH . '/app/helpers/auth.php';

// 4. Auto-Load Controllers
$controllers = ['AuthController', 'DashboardController', 'ItemController', 'LoanController', 'UserController', 'CategoryController'];
foreach ($controllers as $ctrl) {
    $file = BASE_PATH . "/app/controllers/{$ctrl}.php";
    if (file_exists($file)) {
        require_once $file;
    }
}

// 5. Router Logic
$page = $_GET['page'] ?? 'login';

// Halaman Publik (Login & Logout)
if (in_array($page, ['login', 'logout'])) {
    $auth = new AuthController();
    $page === 'login' ? $auth->login($pdo) : $auth->logout();
    exit;
}

// Proteksi Halaman Private (Wajib Login)
if (!check()) {
    header("Location: index.php?page=login");
    exit;
}

// 6. Execution Switch (Rute Aplikasi)
switch ($page) {
    case 'dashboard':
        (new DashboardController())->index($pdo);
        break;

    // --- MANAJEMEN BARANG (ADMIN & PETUGAS) ---
    case 'items':
        (new ItemController())->index($pdo);
        break;

    case 'items_create':
        if (!in_array($_SESSION['role'], ['admin', 'petugas'])) header("Location: index.php?page=dashboard");
        (new ItemController())->create($pdo);
        break;

    case 'items_store':
        if (!in_array($_SESSION['role'], ['admin', 'petugas'])) exit;
        (new ItemController())->store($pdo);
        break;

    case 'items_edit':
        if (!in_array($_SESSION['role'], ['admin', 'petugas'])) header("Location: index.php?page=dashboard");
        (new ItemController())->edit($pdo);
        break;

    case 'items_update':
        if (!in_array($_SESSION['role'], ['admin', 'petugas'])) exit;
        (new ItemController())->update($pdo);
        break;

    case 'items_delete':
        if (!in_array($_SESSION['role'], ['admin', 'petugas'])) exit;
        (new ItemController())->delete($pdo);
        break;

    // --- MANAJEMEN KATEGORI (ADMIN ONLY) ---
    case 'categories':
        if ($_SESSION['role'] !== 'admin') {
            header("Location: index.php?page=dashboard");
            exit;
        }
        (new CategoryController())->index($pdo);
        break;

    case 'categories_create':
        if ($_SESSION['role'] !== 'admin') exit;
        (new CategoryController())->create();
        break;

    case 'categories_store':
        if ($_SESSION['role'] !== 'admin') exit;
        (new CategoryController())->store($pdo);
        break;

    case 'categories_edit':
        if ($_SESSION['role'] !== 'admin') exit;
        (new CategoryController())->edit($pdo);
        break;

    case 'categories_update':
        if ($_SESSION['role'] !== 'admin') exit;
        (new CategoryController())->update($pdo);
        break;

    case 'categories_delete':
        if ($_SESSION['role'] !== 'admin') exit;
        (new CategoryController())->delete($pdo);
        break;

    // --- FITUR PEMINJAMAN (MAHASISWA) ---
    case 'checkout':
        $id = $_GET['id'] ?? null;
        $stmt = $pdo->prepare("
            SELECT i.*, c.name as category_name 
            FROM items i 
            LEFT JOIN categories c ON i.category_id = c.id 
            WHERE i.id = ?
        ");
        $stmt->execute([$id]);
        $item = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$item) {
            die("<div class='p-10 text-center font-bold'>Barang tidak ditemukan!</div>");
        }

        ob_start();
        require BASE_PATH . '/app/views/peminjaman/checkout.php';
        $content = ob_get_clean();
        require BASE_PATH . '/app/views/layouts/main.php';
        break;

    case 'process_checkout':
        (new LoanController())->store($pdo);
        break;

    case 'request_return':
        // Menangani pengajuan pengembalian dari sisi Mahasiswa
        if ($_SESSION['role'] !== 'mahasiswa') exit;
        (new LoanController())->requestReturn($pdo);
        break;

    // --- FITUR VERIFIKASI PENGAMBILAN & PENGEMBALIAN (PETUGAS/ADMIN) ---
    case 'confirm_pickup':
        // Hanya Admin/Petugas yang bisa verifikasi fisik pengambilan
        if (!in_array($_SESSION['role'], ['admin', 'petugas'])) exit;
        (new LoanController())->pickup($pdo);
        break;

    case 'cancel_pickup':
        // Jika stok bermasalah saat barang mau diambil, petugas bisa membatalkan
        if (!in_array($_SESSION['role'], ['admin', 'petugas'])) exit;
        (new LoanController())->cancelPickup($pdo);
        break;

    case 'return_item':
        // Hanya Admin/Petugas yang bisa verifikasi pengembalian & denda
        if (!in_array($_SESSION['role'], ['admin', 'petugas'])) exit;
        (new LoanController())->returnItem($pdo);
        break;

    // --- FITUR APPROVAL (PETUGAS & ADMIN) ---
    case 'approvals':
        if (!in_array($_SESSION['role'], ['admin', 'petugas'])) {
            header("Location: index.php?page=dashboard");
            exit;
        }
        (new LoanController())->approvals($pdo);
        break;

    case 'approve_loan':
        if (!in_array($_SESSION['role'], ['admin', 'petugas'])) exit;
        (new LoanController())->approve($pdo);
        break;

    case 'reject_loan':
        if (!in_array($_SESSION['role'], ['admin', 'petugas'])) exit;
        (new LoanController())->reject($pdo);
        break;

    // --- MANAJEMEN USER (ADMIN ONLY) ---
    case 'users':
        if ($_SESSION['role'] !== 'admin') {
            header("Location: index.php?page=dashboard");
            exit;
        }
        (new UserController())->index($pdo);
        break;

    default:
        http_response_code(404);
        echo "<div style='text-align:center; padding-top:100px; font-family:sans-serif;'>
                <h1 style='font-size:100px; color:#cbd5e1; margin:0;'>404</h1>
                <p style='color:#64748b;'>Halaman yang Anda cari tidak ditemukan.</p>
                <a href='index.php?page=dashboard' style='color:#2563eb; text-decoration:none; font-weight:bold;'>Kembali ke Dashboard</a>
            </div>";
        break;
}