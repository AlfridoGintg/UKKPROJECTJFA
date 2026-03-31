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

// 6. Execution Switch dengan Proteksi Role Ketat
switch ($page) {
    case 'dashboard':
        (new DashboardController())->index($pdo);
        break;

    // --- MANAJEMEN BARANG (ADMIN ONLY) ---
    case 'items':
        (new ItemController())->index($pdo);
        break;
    case 'items_create':
    case 'items_store':
    case 'items_edit':
    case 'items_update':
    case 'items_delete':
        if ($_SESSION['role'] !== 'admin') { 
            header("Location: index.php?page=dashboard&msg=unauthorized"); 
            exit; 
        }
        $action = explode('_', $page)[1] ?? 'index';
        (new ItemController())->$action($pdo);
        break;

    // --- MANAJEMEN KATEGORI (ADMIN ONLY) ---
    case 'categories':
    case 'categories_create':
    case 'categories_store':
    case 'categories_edit':
    case 'categories_update':
    case 'categories_delete':
        if ($_SESSION['role'] !== 'admin') { 
            header("Location: index.php?page=dashboard&msg=unauthorized"); 
            exit; 
        }
        $action = str_replace('categories_', '', $page);
        if ($action == 'categories') $action = 'index';
        (new CategoryController())->$action($pdo);
        break;

    // --- FITUR PEMINJAMAN (MAHASISWA) ---
    case 'checkout':
        // Logika khusus checkout untuk ambil data barang sebelum view
        $id = $_GET['id'] ?? null;
        $stmt = $pdo->prepare("SELECT i.*, c.name as category_name FROM items i LEFT JOIN categories c ON i.category_id = c.id WHERE i.id = ?");
        $stmt->execute([$id]);
        $item = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$item) die("Barang tidak ditemukan!");
        
        ob_start();
        require BASE_PATH . '/app/views/peminjaman/checkout.php';
        $content = ob_get_clean();
        require BASE_PATH . '/app/views/layouts/main.php';
        break;

    case 'process_checkout':
    case 'request_return':
    case 'history':
        if ($_SESSION['role'] !== 'mahasiswa' && $page !== 'history') exit;
        $action = ($page == 'process_checkout') ? 'store' : 
                  (($page == 'request_return') ? 'requestReturn' : 'history');
        (new LoanController())->$action($pdo);
        break;

    // --- FITUR APPROVAL, PICKUP & RETURN (PETUGAS/ADMIN) ---
    case 'approvals':
    case 'approve_loan':
    case 'reject_loan':
    case 'confirm_pickup':
    case 'cancel_pickup':
    case 'return_item':
    case 'print_report':
        if (!in_array($_SESSION['role'], ['admin', 'petugas'])) {
            header("Location: index.php?page=dashboard&msg=unauthorized");
            exit;
        }
        $method = ($page == 'print_report') ? 'generateReport' : 
                  (($page == 'return_item') ? 'returnItem' : 
                  (($page == 'cancel_pickup') ? 'cancelPickup' :
                  (($page == 'confirm_pickup') ? 'pickup' :
                  str_replace('_loan', '', $page))));
        (new LoanController())->$method($pdo);
        break;

    // --- MANAJEMEN USER (ADMIN ONLY) ---
    case 'users':
    case 'users_store':
    case 'users_delete':
        if ($_SESSION['role'] !== 'admin') {
            header("Location: index.php?page=dashboard&msg=unauthorized");
            exit;
        }
        $action = str_replace('users_', '', $page);
        if ($action == 'users') $action = 'index';
        (new UserController())->$action($pdo);
        break;

    default:
        http_response_code(404);
        echo "<div style='text-align:center; padding-top:100px; font-family:sans-serif;'>
                <h1 style='font-size:100px; color:#cbd5e1; margin:0;'>404</h1>
                <p style='color:#64748b;'>Halaman tidak ditemukan.</p>
                <a href='index.php?page=dashboard' style='color:#2563eb; text-decoration:none; font-weight:bold;'>Kembali ke Dashboard</a>
              </div>";
        break;
}