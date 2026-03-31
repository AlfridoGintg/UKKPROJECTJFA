<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JFA Inventory System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        
        .nav-active {
            color: #2563eb !important;
            background-color: #eff6ff;
            border-radius: 0.75rem;
        }
    </style>
</head>

<body class="bg-slate-100 min-h-screen flex flex-col">

<?php 
// Sinkronisasi variabel role dan page
$role = $_SESSION['role'] ?? null;
$page = $_GET['page'] ?? 'dashboard';
?>

<header class="bg-white shadow-sm border-b border-slate-200 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">

        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-blue-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-200">
                <i class="fa-solid fa-camera-retro text-white"></i>
            </div>
            <div>
                <h1 class="font-extrabold text-lg leading-tight tracking-tighter">
                    JFA <span class="text-blue-600">INVENTARIS</span>
                </h1>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest text-center">Equipment System</p>
            </div>
        </div>

        <nav class="hidden md:flex items-center gap-2 text-sm font-bold uppercase tracking-wider">
            
            <a href="index.php?page=dashboard"
               class="px-4 py-2 transition-all <?= $page === 'dashboard' ? 'text-blue-600 bg-blue-50 rounded-xl' : 'text-slate-500 hover:text-blue-600' ?>">
               Dashboard
            </a>

            <?php if (in_array($role, ['admin', 'petugas'])): ?>
                <a href="index.php?page=items"
                   class="px-4 py-2 transition-all <?= $page === 'items' ? 'text-blue-600 bg-blue-50 rounded-xl' : 'text-slate-500 hover:text-blue-600' ?>">
                   <?= $role === 'admin' ? 'Kelola Barang' : 'Katalog Alat' ?>
                </a>

                <a href="index.php?page=approvals"
                   class="px-4 py-2 transition-all <?= $page === 'approvals' ? 'text-blue-600 bg-blue-50 rounded-xl' : 'text-slate-500 hover:text-blue-600' ?>">
                   Persetujuan
                </a>
            <?php endif; ?>

            <?php if ($role === 'admin'): ?>
                <a href="index.php?page=categories"
                   class="px-4 py-2 transition-all <?= $page === 'categories' ? 'text-blue-600 bg-blue-50 rounded-xl' : 'text-slate-500 hover:text-blue-600' ?>">
                   Kategori
                </a>

                <a href="index.php?page=users" 
                   class="flex items-center gap-2 px-4 py-2 transition-all group <?= $page === 'users' ? 'text-blue-600 bg-blue-50 rounded-xl' : 'text-slate-500 hover:text-blue-600' ?>">
                    <svg class="w-4 h-4 <?= $page === 'users' ? 'text-blue-600' : 'text-slate-400 group-hover:text-blue-600' ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <span>Kelola User</span>
                </a>
            <?php endif; ?>

            <div class="h-6 w-[1px] bg-slate-200 mx-2"></div>
            <a href="index.php?page=logout"
               class="px-4 py-2 text-red-500 hover:bg-red-50 rounded-xl transition-all flex items-center gap-2">
               <i class="fa-solid fa-right-from-bracket text-xs"></i>
               LOGOUT
            </a>
        </nav>

        <div class="md:hidden">
            <button class="p-2 text-slate-600">
                <i class="fa-solid fa-bars-staggered text-xl"></i>
            </button>
        </div>

    </div>
</header>

<main class="flex-1 w-full">
    <div class="animate-fadeIn">
        <?= $content ?>
    </div>
</main>

<footer class="bg-white border-t border-slate-200 py-8">
    <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row justify-between items-center gap-4">
        <div class="flex items-center gap-2 opacity-50">
            <div class="w-6 h-6 bg-slate-400 rounded-md flex items-center justify-center">
                <i class="fa-solid fa-camera text-[10px] text-white"></i>
            </div>
            <span class="text-xs font-black text-slate-500 uppercase tracking-tighter">JFA Production</span>
        </div>
        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">
            © <?= date('Y') ?> Jogja Film Academy • Monitoring System v2.0
        </p>
    </div>
</footer>

<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fadeIn {
        animation: fadeIn 0.4s ease-out forwards;
    }
</style>

</body>
</html>