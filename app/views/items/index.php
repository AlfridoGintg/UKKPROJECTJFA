<div class="max-w-7xl mx-auto px-6 py-10 relative">
    
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4 relative z-20">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900">Katalog Alat Produksi</h1>
            <p class="text-slate-500 text-sm mt-1">Cari, filter, dan temukan alat yang Anda butuhkan.</p>
        </div>
        
        <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
            <?php if ($_SESSION['role'] === 'admin'): ?>
                <a href="index.php?page=items_create" class="bg-emerald-600 text-white px-6 py-3 rounded-2xl font-bold hover:bg-emerald-700 shadow-lg shadow-emerald-100 transition-all flex items-center justify-center gap-2">
                    <i class="fas fa-plus"></i> Tambah
                </a>
            <?php endif; ?>

            <form action="index.php" method="GET" class="flex flex-col sm:flex-row gap-3 relative" id="searchForm">
                <input type="hidden" name="page" value="items">
                
                <select name="category" onchange="this.form.submit()" 
                        class="bg-white border border-slate-200 text-slate-700 text-sm rounded-2xl px-4 py-3 outline-none focus:ring-2 focus:ring-blue-500 transition-shadow shadow-sm font-medium cursor-pointer">
                    <option value="">Semua Kategori</option>
                    <?php if (isset($categories)): ?>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>" <?= (isset($_GET['category']) && $_GET['category'] == $cat['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cat['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>

                <div class="relative w-full sm:w-64">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-search text-slate-400"></i>
                    </div>
                    <input type="text" name="q" id="searchInput" autocomplete="off" placeholder="Cari alat..." 
                           class="w-full bg-white border border-slate-200 text-slate-900 text-sm rounded-2xl pl-10 pr-4 py-3 outline-none focus:ring-2 focus:ring-blue-500 transition-shadow shadow-sm"
                           value="<?= isset($_GET['q']) ? htmlspecialchars($_GET['q']) : '' ?>">
                    
                    <div id="searchHistoryDropdown" class="hidden absolute top-full mt-2 w-full bg-white border border-slate-100 rounded-2xl shadow-xl overflow-hidden z-50">
                        <div class="flex justify-between items-center px-4 py-3 border-b border-slate-50 bg-slate-50/50">
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Riwayat</span>
                            <button type="button" onclick="clearHistory()" class="text-[10px] text-red-500 hover:text-red-700 font-bold uppercase">Hapus</button>
                        </div>
                        <ul class="max-h-48 overflow-y-auto custom-scrollbar" id="historyList"></ul>
                    </div>
                </div>

                <button type="submit" onclick="showLoading()" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-2xl font-bold shadow-lg shadow-blue-200 transition-all flex items-center justify-center gap-2">
                    <span id="btnText">Cari</span>
                    <i id="btnSpinner" class="fas fa-spinner fa-spin hidden"></i>
                </button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
        </div>
</div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
        <?php if (!empty($items)): ?>
            <?php foreach ($items as $item): ?>
                <?php
                    $isAvailable = $item['stock'] > 0;
                    $statusBadge = $isAvailable ? "bg-emerald-100 text-emerald-700" : "bg-gray-100 text-gray-500";
                    $conditionColor = $item['condition_status'] === 'Baik' ? "text-green-600 bg-green-50" : "text-red-600 bg-red-50";
                    $isWishlisted = $item['is_wishlisted'] ?? false; 
                ?>

                <div class="group bg-white rounded-[2rem] border border-slate-200 p-5 shadow-sm hover:shadow-2xl hover:border-blue-200 transition-all duration-300 flex flex-col relative">
                    
                    <button onclick="toggleWishlist(<?= $item['id'] ?>, this)" class="absolute top-8 right-8 z-10 w-8 h-8 bg-white/80 backdrop-blur rounded-full flex items-center justify-center text-rose-500 hover:scale-110 shadow-sm transition-all">
                        <i class="<?= $isWishlisted ? 'fas' : 'far' ?> fa-heart text-lg"></i>
                    </button>

                    <div class="aspect-[4/3] bg-slate-100 rounded-[1.5rem] mb-5 overflow-hidden relative">
                        <img src="public/assets/img/items/<?= htmlspecialchars($item['image']) ?>" 
                             onerror="this.src='https://images.unsplash.com/photo-1516035069371-29a1b244cc32?q=80&w=600'"
                             class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                        <span class="absolute top-3 left-3 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider shadow-sm <?= $conditionColor ?>">
                            <?= $item['condition_status'] ?>
                        </span>
                    </div>

                    <div class="flex-1">
                        <h3 class="font-bold text-slate-800 text-lg leading-tight group-hover:text-blue-600 transition truncate">
                            <?= htmlspecialchars($item['name']) ?>
                        </h3>
                        <p class="text-[10px] text-slate-400 font-semibold uppercase tracking-widest mt-1">
                            <?= htmlspecialchars($item['category_name'] ?? 'Kategori') ?> • <?= htmlspecialchars($item['brand']) ?>
                        </p>

                        <?php if ($_SESSION['role'] === 'admin'): ?>
                            <div class="mt-4 p-3 bg-slate-50 rounded-2xl border border-dashed border-slate-200">
                                <p class="text-[9px] font-bold text-slate-400 uppercase mb-1">Estimasi Denda</p>
                                <div class="flex justify-between text-[11px]">
                                    <span class="text-slate-500">Hilang (100%)</span>
                                    <span class="font-bold text-red-600">Rp <?= number_format($item['purchase_price'], 0, ',', '.') ?></span>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="flex items-center justify-between mt-4">
                            <span class="text-xs font-medium text-slate-500">Stok: <b class="text-slate-900"><?= $item['stock'] ?> Unit</b></span>
                            <span class="px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase <?= $statusBadge ?>">
                                <?= $isAvailable ? 'Tersedia' : 'Habis' ?>
                            </span>
                        </div>
                    </div>

                    <div class="mt-6">
                        <?php if ($_SESSION['role'] === 'admin'): ?>
                            <div class="grid grid-cols-2 gap-3">
                                <a href="index.php?page=items_edit&id=<?= $item['id'] ?>" class="py-3 text-center rounded-xl font-bold text-xs bg-slate-900 text-white hover:bg-blue-600 transition-all">Edit</a>
                                <a href="index.php?page=items_delete&id=<?= $item['id'] ?>" onclick="return confirm('Hapus item?')" class="py-3 text-center rounded-xl font-bold text-xs bg-red-50 text-red-600 hover:bg-red-600 hover:text-white transition-all">Hapus</a>
                            </div>
                        <?php else: ?>
                            <?php if ($isAvailable): ?>
                                <a href="index.php?page=checkout&id=<?= $item['id'] ?>" 
                                   class="block w-full py-3.5 text-center rounded-2xl font-bold text-sm transition-all shadow-md bg-blue-600 text-white hover:bg-blue-700 hover:-translate-y-1">
                                    Ajukan Peminjaman
                                </a>
                            <?php else: ?>
                                <button disabled class="w-full py-3.5 rounded-2xl font-bold text-sm bg-slate-100 text-slate-400 cursor-not-allowed">Stok Habis</button>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-span-full py-20 flex flex-col items-center opacity-50">
                <i class="fas fa-box-open text-6xl text-slate-300 mb-4"></i>
                <p class="text-slate-500 font-medium text-lg">Tidak ada alat yang ditemukan.</p>
            </div>
        <?php endif; ?>
    </div>
    
    <?php if (isset($totalPages) && $totalPages > 1): ?>
    <div class="mt-10 flex flex-wrap justify-center items-center gap-2">
        <?php 
            // Menyimpan filter pencarian agar saat pindah halaman filter tidak hilang
            $queryParams = $_GET;
            unset($queryParams['p']); 
            $baseUrl = 'index.php?' . http_build_query($queryParams) . '&p=';
        ?>

        <?php if ($currentPage > 1): ?>
            <a href="<?= $baseUrl . ($currentPage - 1) ?>" class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-blue-600 transition-all"><i class="fas fa-chevron-left"></i></a>
        <?php else: ?>
            <button disabled class="w-10 h-10 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-center text-slate-300 cursor-not-allowed"><i class="fas fa-chevron-left"></i></button>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <?php if ($i == $currentPage): ?>
                <button class="w-10 h-10 rounded-xl bg-blue-600 text-white font-bold shadow-lg shadow-blue-200"><?= $i ?></button>
            <?php else: ?>
                <a href="<?= $baseUrl . $i ?>" class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center font-bold text-slate-600 hover:bg-slate-50 transition-all"><?= $i ?></a>
            <?php endif; ?>
        <?php endfor; ?>

        <?php if ($currentPage < $totalPages): ?>
            <a href="<?= $baseUrl . ($currentPage + 1) ?>" class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-slate-400 hover:text-blue-600 transition-all"><i class="fas fa-chevron-right"></i></a>
        <?php else: ?>
            <button disabled class="w-10 h-10 rounded-xl bg-slate-50 border border-slate-200 flex items-center justify-center text-slate-300 cursor-not-allowed"><i class="fas fa-chevron-right"></i></button>
        <?php endif; ?>
    </div>
    <?php endif; ?>
</div>

<div id="toast-container" class="fixed bottom-5 right-5 z-50 flex flex-col gap-3"></div>

<script>
    // --- 1. FITUR NOTIFIKASI TOAST ---
    function showToast(message, type = 'success') {
        const container = document.getElementById('toast-container');
        const toast = document.createElement('div');
        const icon = type === 'success' ? '<i class="fas fa-check-circle text-emerald-500"></i>' : '<i class="fas fa-info-circle text-blue-500"></i>';
        
        toast.className = `bg-white px-5 py-4 rounded-2xl shadow-xl border border-slate-100 flex items-center gap-3 transform translate-y-10 opacity-0 transition-all duration-300`;
        toast.innerHTML = `${icon} <span class="text-sm font-bold text-slate-700">${message}</span>`;
        
        container.appendChild(toast);
        
        setTimeout(() => { toast.classList.remove('translate-y-10', 'opacity-0'); }, 10);
        setTimeout(() => { 
            toast.classList.add('translate-y-10', 'opacity-0'); 
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }

    // --- 2. FITUR LOADING SPINNER ---
    function showLoading() {
        document.getElementById('btnText').classList.add('hidden');
        document.getElementById('btnSpinner').classList.remove('hidden');
        
        const query = document.getElementById('searchInput').value.trim();
        if(query) saveToHistory(query);
    }

    // --- 3. FITUR WISHLIST ---
    function toggleWishlist(itemId, btnElement) {
        const icon = btnElement.querySelector('i');
        const isHearted = icon.classList.contains('fas');
        
        if(isHearted) {
            icon.classList.remove('fas');
            icon.classList.add('far');
            showToast('Dihapus dari Wishlist', 'info');
        } else {
            icon.classList.remove('far');
            icon.classList.add('fas');
            btnElement.classList.add('scale-125');
            setTimeout(() => btnElement.classList.remove('scale-125'), 150);
            showToast('Ditambahkan ke Wishlist', 'success');
        }
    }

    // --- 4. RIWAYAT PENCARIAN ---
    const searchInput = document.getElementById('searchInput');
    const historyDropdown = document.getElementById('searchHistoryDropdown');
    const historyList = document.getElementById('historyList');

    searchInput.addEventListener('focus', () => {
        renderHistory();
        if(historyList.children.length > 0) historyDropdown.classList.remove('hidden');
    });

    document.addEventListener('click', (e) => {
        if (!searchInput.contains(e.target) && !historyDropdown.contains(e.target)) {
            historyDropdown.classList.add('hidden');
        }
    });

    function saveToHistory(keyword) {
        let history = JSON.parse(localStorage.getItem('jfa_search_history') || '[]');
        history = history.filter(item => item.toLowerCase() !== keyword.toLowerCase());
        history.unshift(keyword);
        if(history.length > 10) history.pop();
        localStorage.setItem('jfa_search_history', JSON.stringify(history));
    }

    function renderHistory() {
        let history = JSON.parse(localStorage.getItem('jfa_search_history') || '[]');
        historyList.innerHTML = '';
        history.forEach(keyword => {
            const li = document.createElement('li');
            li.className = "px-4 py-3 hover:bg-slate-50 cursor-pointer flex items-center gap-3 border-b border-slate-50 last:border-0 transition-colors text-sm text-slate-600 font-medium";
            li.innerHTML = `<i class="fas fa-history text-slate-300 text-xs"></i> ${keyword}`;
            li.onclick = () => {
                searchInput.value = keyword;
                historyDropdown.classList.add('hidden');
                document.getElementById('searchForm').submit();
            };
            historyList.appendChild(li);
        });
    }

    function clearHistory() {
        localStorage.removeItem('jfa_search_history');
        historyDropdown.classList.add('hidden');
        showToast('Riwayat pencarian dihapus', 'info');
    }
</script>

<style>
/* CSS untuk scrollbar dropdown */
.custom-scrollbar::-webkit-scrollbar { width: 6px; }
.custom-scrollbar::-webkit-scrollbar-track { background: #f8fafc; }
.custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
.custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
</style>