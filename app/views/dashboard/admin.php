<style>
    .glass-card {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(226, 232, 240, 0.7);
    }
</style>

<div class="p-4 md:p-8 lg:p-10 bg-[#f8fafc] min-h-screen text-slate-900">
    
    <header class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-6">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <span class="inline-flex w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span class="text-[10px] font-bold tracking-widest text-slate-400 uppercase">System operational</span>
            </div>
            <h1 class="text-4xl font-black text-slate-900 tracking-tight">Halaman  <span class="text-blue-600">Admin</span></h1>
            <p class="text-slate-500 mt-2 font-medium">Selamat datang kembali, <span class="text-slate-900 font-bold"><?= explode(' ', $_SESSION['name'] ?? 'Admin')[0] ?></span>. Ringkasan sistem hari ini.</p>
        </div>
        <div class="flex items-center gap-3">
            <button class="px-6 py-3 bg-white border border-slate-200 rounded-2xl text-xs font-bold text-slate-700 hover:bg-slate-50 transition-all shadow-sm flex items-center gap-2">
                <i class="fas fa-calendar-alt text-blue-500"></i>
                <?= date('d M Y') ?>
            </button>
            <a href="index.php?page=items_create" class="px-6 py-3 bg-slate-900 text-white rounded-2xl text-xs font-bold hover:bg-slate-800 transition-all shadow-xl shadow-slate-200 flex items-center gap-2">
                <i class="fas fa-plus"></i>
                Unit Baru
            </a>
        </div>
    </header>

    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
        <div class="glass-card p-6 rounded-[2.5rem] hover:shadow-xl hover:shadow-blue-500/5 transition-all duration-500 group">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-lg group-hover:scale-110 transition-transform duration-500">
                    <i class="fas fa-box"></i>
                </div>
                <span class="text-[10px] font-bold text-emerald-500 bg-emerald-50 px-2 py-1 rounded-lg">Realtime</span>
            </div>
            <h3 class="text-3xl font-black text-slate-900 leading-none"><?= number_format($stats['total_stock'] ?? 0) ?></h3>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-3">Total Unit Stok</p>
        </div>
        <div class="glass-card p-6 rounded-[2.5rem] hover:shadow-xl hover:shadow-orange-500/5 transition-all duration-500 group">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 bg-orange-50 text-orange-600 rounded-2xl flex items-center justify-center text-lg group-hover:scale-110 transition-transform duration-500">
                    <i class="fas fa-clock"></i>
                </div>
                <span class="text-[10px] font-bold text-orange-600 bg-orange-50 px-2 py-1 rounded-lg">High Priority</span>
            </div>
            <h3 class="text-3xl font-black text-slate-900 leading-none"><?= number_format($stats['pending_approval'] ?? 0) ?></h3>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-3">Menunggu Approval</p>
        </div>
        <div class="glass-card p-6 rounded-[2.5rem] hover:shadow-xl hover:shadow-rose-500/5 transition-all duration-500 group">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 bg-rose-50 text-rose-600 rounded-2xl flex items-center justify-center text-lg group-hover:scale-110 transition-transform duration-500">
                    <i class="fas fa-tools"></i>
                </div>
            </div>
            <h3 class="text-3xl font-black text-slate-900 leading-none"><?= number_format($stats['items_broken'] ?? 0) ?></h3>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-3">Kondisi Rusak</p>
        </div>
        <div class="glass-card p-6 rounded-[2.5rem] hover:shadow-xl hover:shadow-indigo-500/5 transition-all duration-500 group">
            <div class="flex justify-between items-start mb-4">
                <div class="w-12 h-12 bg-indigo-50 text-indigo-600 rounded-2xl flex items-center justify-center text-lg group-hover:scale-110 transition-transform duration-500">
                    <i class="fas fa-users"></i>
                </div>
            </div>
            <h3 class="text-3xl font-black text-slate-900 leading-none"><?= number_format($stats['total_users'] ?? 0) ?></h3>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mt-3">Total Pengguna</p>
        </div>
    </section>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
        
        <div class="lg:col-span-1 bg-slate-900 rounded-[3rem] p-8 text-white relative overflow-hidden flex flex-col shadow-2xl shadow-blue-900/20">
            <div class="relative z-10 flex flex-col h-full">
                <div class="flex items-center gap-4 mb-8 pb-6 border-b border-white/10">
                    <img src="assets/img/logo-jfa.png" alt="JFA Logo" class="h-10 bg-white/10 p-2 rounded-xl backdrop-blur-md">
                    <div>
                        <h3 class="text-lg font-bold tracking-tight">Quick Actions</h3>
                        <p class="text-[10px] text-slate-400 uppercase tracking-widest">Shortcut Menu</p>
                    </div>
                </div>
                
                <div class="space-y-3 mb-8">
                    <a href="index.php?page=items_create" class="flex items-center justify-between p-4 bg-white/5 hover:bg-white/10 rounded-2xl border border-white/10 transition-all group">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-blue-500/20 flex items-center justify-center">
                                <i class="fas fa-plus text-blue-400 text-xs"></i>
                            </div>
                            <span class="text-sm font-semibold">Input Unit Baru</span>
                        </div>
                        <i class="fas fa-chevron-right text-[10px] text-white/30 group-hover:translate-x-1 transition-transform"></i>
                    </a>
                    <a href="index.php?page=users" class="flex items-center justify-between p-4 bg-white/5 hover:bg-white/10 rounded-2xl border border-white/10 transition-all group">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-emerald-500/20 flex items-center justify-center">
                                <i class="fas fa-user-graduate text-emerald-400 text-xs"></i>
                            </div>
                            <span class="text-sm font-semibold">Data Mahasiswa</span>
                        </div>
                        <i class="fas fa-chevron-right text-[10px] text-white/30 group-hover:translate-x-1 transition-transform"></i>
                    </a>
                    <a href="index.php?page=categories" class="flex items-center justify-between p-4 bg-white/5 hover:bg-white/10 rounded-2xl border border-white/10 transition-all group">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-orange-500/20 flex items-center justify-center">
                                <i class="fas fa-tags text-orange-400 text-xs"></i>
                            </div>
                            <span class="text-sm font-semibold">Kelola Kategori</span>
                        </div>
                        <i class="fas fa-chevron-right text-[10px] text-white/30 group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>

                <a href="index.php?page=approvals" class="mt-auto block w-full py-4 bg-blue-600 hover:bg-blue-500 rounded-2xl text-center font-bold text-sm transition-all shadow-lg shadow-blue-600/30">
                    Lihat Seluruh Log Aktivitas
                </a>
            </div>
            <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-blue-600/20 rounded-full blur-[80px]"></div>
            <div class="absolute -top-10 -right-10 w-32 h-32 bg-indigo-600/10 rounded-full blur-[60px]"></div>
        </div>

        <div class="lg:col-span-2 bg-white rounded-[3rem] border border-slate-100 shadow-sm overflow-hidden flex flex-col">
            <div class="p-8 border-b border-slate-50 flex justify-between items-center bg-white/50">
                <div>
                    <h2 class="text-lg font-black text-slate-800 uppercase tracking-tight">Antrean Persetujuan</h2>
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mt-1">Pending Request</p>
                </div>
                <span class="text-[9px] font-bold text-orange-600 bg-orange-50 border border-orange-100 px-3 py-1.5 rounded-full">ACTION REQUIRED</span>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-[10px] text-slate-400 uppercase tracking-[0.15em] border-b">
                            <th class="px-8 py-5 font-bold italic">User Info</th>
                            <th class="px-8 py-5 font-bold italic">Item & Period</th>
                            <th class="px-8 py-5 font-bold italic text-right">Decisions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        <?php if(!empty($recent_activities)): foreach($recent_activities as $loan): ?>
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-full bg-slate-100 text-slate-600 flex items-center justify-center font-black text-xs group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                                        <?= strtoupper(substr($loan['student_name'], 0, 2)) ?>
                                    </div>
                                    <div>
                                        <p class="font-bold text-slate-800 text-sm"><?= htmlspecialchars($loan['student_name']) ?></p>
                                        <p class="text-[10px] text-slate-400 font-medium italic">"<?= htmlspecialchars($loan['condition_start']) ?>"</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                <p class="font-bold text-slate-700 text-sm"><?= htmlspecialchars($loan['item_name']) ?></p>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="text-[10px] font-bold text-emerald-500 uppercase"><?= date('d M', strtotime($loan['created_at'])) ?></span>
                                    <span class="text-[10px] text-slate-300">→</span>
                                    <span class="text-[10px] font-bold text-rose-500 uppercase"><?= date('d M', strtotime($loan['return_date'] ?? date('Y-m-d'))) ?></span>
                                </div>
                            </td>
                            <td class="px-8 py-5">
                                <div class="flex justify-end gap-2">
                                    <form action="index.php?page=approve_loan" method="POST" class="inline">
                                        <input type="hidden" name="loan_id" value="<?= $loan['id'] ?>">
                                        <button type="submit" onclick="return confirm('Setujui permintaan ini?')" class="w-8 h-8 rounded-xl bg-emerald-50 text-emerald-600 hover:bg-emerald-500 hover:text-white transition-all flex items-center justify-center">
                                            <i class="fas fa-check text-xs"></i>
                                        </button>
                                    </form>
                                    <form action="index.php?page=reject_loan" method="POST" class="inline">
                                        <input type="hidden" name="loan_id" value="<?= $loan['id'] ?>">
                                        <button type="submit" onclick="return confirm('Tolak permintaan ini?')" class="w-8 h-8 rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-500 hover:text-white transition-all flex items-center justify-center">
                                            <i class="fas fa-times text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; else: ?>
                        <tr><td colspan="3" class="px-8 py-12 text-center text-slate-400 italic font-medium">Belum ada antrean persetujuan.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-[3rem] border border-slate-100 shadow-sm overflow-hidden mb-12">
        <div class="p-8 border-b border-slate-50 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-lg font-black text-slate-800 uppercase tracking-tight">Katalog Inventaris</h2>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mt-1">Asset Monitoring</p>
            </div>
            <div class="flex gap-2">
                <a href="index.php?page=items" class="px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-600 hover:bg-slate-100 transition-all flex items-center">
                    Lihat Katalog Penuh &rarr;
                </a>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50 text-[10px] uppercase text-slate-400 font-bold tracking-[0.15em] border-b">
                        <th class="px-8 py-5">Informasi Asset</th>
                        <th class="px-8 py-5">Stok Tersedia</th>
                        <th class="px-8 py-5">Kondisi Fisik</th>
                        <th class="px-8 py-5">Proyeksi Denda</th>
                        <th class="px-8 py-5 text-center">Opsi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <?php if(!empty($equipments)): foreach(array_slice($equipments, 0, 10) as $item): ?>
                    <tr class="hover:bg-slate-50/30 transition-all">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-slate-100 rounded-2xl flex items-center justify-center text-slate-400">
                                    <i class="fas fa-camera"></i>
                                </div>
                                <div>
                                    <p class="font-bold text-slate-800 text-sm italic"><?= htmlspecialchars($item['name']) ?></p>
                                    <p class="text-[10px] text-slate-400 font-medium"><?= htmlspecialchars($item['brand']) ?></p>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full <?= $item['stock'] > 0 ? 'bg-emerald-500' : 'bg-rose-500' ?>"></span>
                                <span class="text-sm font-black text-slate-700"><?= $item['stock'] ?> Unit</span>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <?php if($item['condition_status'] === 'Baik'): ?>
                                <span class="px-3 py-1.5 rounded-full text-[9px] font-black bg-emerald-50 text-emerald-600 border border-emerald-100 uppercase tracking-wider">BAIK (PERFECT)</span>
                            <?php else: ?>
                                <span class="px-3 py-1.5 rounded-full text-[9px] font-black bg-rose-50 text-rose-600 border border-rose-100 uppercase tracking-wider">RUSAK (BROKEN)</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-8 py-6">
                            <div class="space-y-1">
                                <p class="text-[10px] font-bold text-orange-600 flex items-center gap-2">
                                    <span class="w-1 h-1 rounded-full bg-orange-600"></span>
                                    Rusak: Rp <?= number_format($item['purchase_price'] * 0.5, 0, ',', '.') ?>
                                </p>
                                <p class="text-[10px] font-bold text-rose-600 flex items-center gap-2">
                                    <span class="w-1 h-1 rounded-full bg-rose-600"></span>
                                    Hilang: Rp <?= number_format($item['purchase_price'], 0, ',', '.') ?>
                                </p>
                            </div>
                        </td>
                        <td class="px-8 py-6 text-center">
                            <a href="index.php?page=items_edit&id=<?= $item['id'] ?>" class="text-slate-400 hover:text-blue-600 transition-colors">
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr><td colspan="5" class="px-8 py-10 text-center text-slate-400 italic">Katalog inventaris kosong.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>