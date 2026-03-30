<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>JFA Inventory System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>

<body class="bg-slate-100 min-h-screen flex flex-col">

<?php 
$role = $_SESSION['user']['role'] ?? null;
$page = $_GET['page'] ?? 'dashboard';
?>

<header class="bg-white shadow-sm border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">

        <div class="flex items-center gap-3">
            <img src="assets/img/logo-jfa.png" class="h-10 object-contain" alt="Logo JFA">
            <div>
                <h1 class="font-extrabold text-lg leading-tight">
                    JFA <span class="text-yellow-500">INVENTARIS</span>
                </h1>
                <p class="text-xs text-slate-400">Production Equipment System</p>
            </div>
        </div>

        <nav class="flex items-center gap-6 text-sm font-semibold">

            <a href="index.php?page=dashboard"
               class="<?= $page === 'dashboard' ? 'text-black font-bold' : 'text-slate-600 hover:text-black' ?>">
               Dashboard
            </a>

            <?php if ($role === 'admin'): ?>
                <a href="index.php?page=items"
                   class="<?= $page === 'items' ? 'text-black font-bold' : 'text-slate-600 hover:text-black' ?>">
                   Kelola Barang
                </a>

                <a href="index.php?page=categories"
                   class="<?= $page === 'categories' ? 'text-black font-bold' : 'text-slate-600 hover:text-black' ?>">
                   Kelola Kategori
                </a>

                <a href="index.php?page=users"
                   class="<?= $page === 'users' ? 'text-black font-bold' : 'text-slate-600 hover:text-black' ?>">
                   Kelola User
                </a>
            <?php endif; ?>

            <?php if ($role === 'petugas'): ?>
                <a href="index.php?page=items"
                   class="<?= $page === 'items' ? 'text-black font-bold' : 'text-slate-600 hover:text-black' ?>">
                   Katalog
                </a>

                <a href="index.php?page=loans"
                   class="<?= $page === 'loans' ? 'text-black font-bold' : 'text-slate-600 hover:text-black' ?>">
                   Peminjaman
                </a>
            <?php endif; ?>

            <a href="index.php?page=logout"
               class="text-red-500 hover:text-red-700">
               Logout
            </a>

        </nav>

    </div>
</header>

<main class="flex-1">
    <?= $content ?>
</main>

<footer class="bg-white border-t border-slate-200 text-center py-4 text-xs text-slate-400">
    © <?= date('Y') ?> JFA Production. All rights reserved.
</footer>

</body>
</html>