<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JFA Inventory System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <<script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    midnight: '#0F172A',   // Biru gelap yang sangat pekat (Elegan & Serius)
                    gold: '#C5A059',       // Emas redup (Mewah & Klasik)
                    platinum: '#F8FAFC',   // Putih dengan sedikit rona abu (Bersih)
                    obsidian: '#1E293B',   // Warna sekunder untuk card/sidebar
                    bronze: '#A87F32',     // Untuk hover atau aksen penting
                }
            }
        }
    }
</script>

    <!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JFA Inventory | Premium System</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        midnight: '#0F172A',   // Deep Navy (Elegan)
                        obsidian: '#1E293B',   // Secondary Dark
                        gold: '#C5A059',       // Muted Gold (Mewah)
                        bronze: '#A87F32',     // Darker Gold Aksen
                        platinum: '#F8FAFC',   // Off-white Clean
                        slatebg: '#F1F5F9',    // Soft Background
                    }
                }
            }
        }
    </script>

    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #F1F5F9; 
            color: #1E293B;
        }

        /* Navigasi Elegant dengan Indikator Underline Gold */
        .nav-active {
            color: #C5A059 !important;
            position: relative;
        }
        .nav-active::after {
            content: '';
            position: absolute;
            bottom: -6px;
            left: 1rem;
            right: 1rem;
            height: 2px;
            background: linear-gradient(to right, #C5A059, #A87F32);
            border-radius: 10px;
        }

        /* Smooth Animation */
        .animate-fadeIn {
            animation: fadeIn 0.5s ease-out forwards;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #F1F5F9; }
        ::-webkit-scrollbar-thumb { background: #CBD5E1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94A3B8; }
    </style>
</head>

<body class="min-h-screen flex flex-col">

<?php 
// Sinkronisasi variabel role dan page untuk navigasi
$role = $_SESSION['role'] ?? null;
$page = $_GET['page'] ?? 'dashboard';
?>

<header class="bg-midnight text-platinum shadow-2xl sticky top-0 z-50 border-b border-gold/20">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">

        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center shadow-lg p-1.5">
                <img src="public/assets/img/logo-jfa.png" alt="Logo JFA" class="w-full h-full object-contain">
            </div>
            
            <div class="flex flex-col">
                <h1 class="font-black text-xl text-white tracking-tighter uppercase leading-none">
                    JFA <span class="text-gold">INVENTORY</span>
                </h1>
                <p class="text-[9px] font-bold text-gold/60 uppercase tracking-[0.3em] mt-1.5">Premium Asset Management</p>
            </div>
        </div>

        <nav class="hidden md:flex items-center gap-2 text-[11px] font-black uppercase tracking-widest">
            
            <a href="index.php?page=dashboard"
               class="px-4 py-2 transition-all duration-300 <?= $page === 'dashboard' ? 'nav-active' : 'text-platinum/50 hover:text-gold' ?>">
               Dashboard
            </a>

            <?php if (in_array($role, ['admin', 'petugas'])): ?>
                <a href="index.php?page=items"
                   class="px-4 py-2 transition-all duration-300 <?= $page === 'items' ? 'nav-active' : 'text-platinum/50 hover:text-gold' ?>">
                   <?= $role === 'admin' ? 'Inventory' : 'Katalog' ?>
                </a>

                <a href="index.php?page=approvals"
                   class="px-4 py-2 transition-all duration-300 <?= $page === 'approvals' ? 'nav-active' : 'text-platinum/50 hover:text-gold' ?>">
                   Approvals
                </a>
            <?php endif; ?>

            <?php if ($role === 'admin'): ?>
                <a href="index.php?page=categories"
                   class="px-4 py-2 transition-all duration-300 <?= $page === 'categories' ? 'nav-active' : 'text-platinum/50 hover:text-gold' ?>">
                   Categories
                </a>

                <a href="index.php?page=users" 
                   class="px-4 py-2 transition-all duration-300 <?= $page === 'users' ? 'nav-active' : 'text-platinum/50 hover:text-gold' ?>">
                   Users
                </a>
            <?php endif; ?>

            <div class="h-5 w-[1px] bg-platinum/10 mx-3"></div>
            
            <a href="index.php?page=logout"
               class="px-6 py-2 border border-gold/40 text-gold hover:bg-gold hover:text-midnight rounded-full transition-all duration-500 text-[10px] font-black">
               LOGOUT
            </a>
        </nav>

        <div class="md:hidden">
            <button class="p-2 text-gold">
                <i class="fa-solid fa-bars-staggered text-2xl"></i>
            </button>
        </div>

    </div>
</header>

<main class="flex-1 w-full max-w-7xl mx-auto px-4 sm:px-6 py-8">
    <div class="animate-fadeIn">
        <?= $content ?>
    </div>
</main>

<footer class="bg-white border-t border-slate-200 py-10 mt-auto">
    <div class="max-w-7xl mx-auto px-6">
        <div class="flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 bg-midnight rounded-lg flex items-center justify-center">
                    <i class="fa-solid fa-film text-[12px] text-gold"></i>
                </div>
                <div class="flex flex-col">
                    <span class="text-xs font-black text-midnight uppercase tracking-tighter">Jogja Film Academy</span>
                    <span class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Production Department</span>
                </div>
            </div>
            
            <div class="flex flex-col items-end gap-1">
                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em]">
                    © <?= date('Y') ?> JFA Inventory System • Version 1.0 Elegant
                </p>
                <div class="flex gap-4 text-slate-300 text-xs">
                    <i class="fa-brands fa-instagram hover:text-gold cursor-pointer transition-colors"></i>
                    <i class="fa-brands fa-youtube hover:text-gold cursor-pointer transition-colors"></i>
                    <i class="fa-solid fa-globe hover:text-gold cursor-pointer transition-colors"></i>
                </div>
            </div>
        </div>
    </div>
</footer>

</body>
</html>