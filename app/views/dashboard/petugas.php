<style>
    /* Tambahan custom CSS khusus untuk Dashboard */
    .step-gradient-pending { background: linear-gradient(135deg, #fffcf0 0%, #fff 100%); border-left: 4px solid #f59e0b; }
    .step-gradient-pickup { background: linear-gradient(135deg, #eff6ff 0%, #fff 100%); border-left: 4px solid #3b82f6; }
    .step-gradient-active { background: linear-gradient(135deg, #f0fdf4 0%, #fff 100%); border-left: 4px solid #22c55e; }
    
    .badge-pulse { position: relative; }
    .badge-pulse::after {
        content: '';
        position: absolute;
        width: 8px;
        height: 8px;
        background: currentColor;
        border-radius: 50%;
        right: -12px;
        top: 50%;
        transform: translateY(-50%);
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0% { transform: translateY(-50%) scale(0.95); opacity: 0.7; }
        70% { transform: translateY(-50%) scale(1.5); opacity: 0; }
        100% { transform: translateY(-50%) scale(0.95); opacity: 0; }
    }
</style>

<div class="p-6 lg:p-10 bg-[#fcfcfd] min-h-screen text-slate-900">
            
    <header class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Workstation <span class="text-blue-600">Petugas.</span></h1>
            <p class="text-slate-500 font-medium mt-1">Kelola sirkulasi barang praktikum dengan efisien.</p>
        </div>
        <div class="flex items-center gap-3 bg-white p-2 rounded-2xl shadow-sm border border-slate-100">
            <div class="px-4 py-2 text-right border-r border-slate-100">
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-none mb-1">Status Shift</p>
                <p class="text-xs font-bold text-emerald-600">Aktif - Online</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-slate-900 flex items-center justify-center text-white">
                <i class="fas fa-user-tie"></i>
            </div>
        </div>
    </header>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div class="bg-white p-7 rounded-[2rem] border border-slate-100 shadow-sm flex items-center gap-6">
            <div class="w-14 h-14 bg-blue-50 text-blue-600 rounded-2xl flex items-center justify-center text-xl shadow-inner">
                <i class="fas fa-warehouse"></i>
            </div>
            <div>
                <p class="text-2xl font-black text-slate-900"><?= htmlspecialchars($stats['total_stock'] ?? 0) ?> <span class="text-sm font-medium text-slate-400">Unit</span></p>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mt-1">Gudang Utama</p>
            </div>
        </div>
        <div class="bg-white p-7 rounded-[2rem] border border-slate-100 shadow-sm flex items-center gap-6">
            <div class="w-14 h-14 bg-amber-50 text-amber-600 rounded-2xl flex items-center justify-center text-xl shadow-inner">
                <i class="fas fa-hourglass-half"></i>
            </div>
            <div>
                <p class="text-2xl font-black text-slate-900"><?= htmlspecialchars($stats['pending_approval'] ?? 0) ?> <span class="text-sm font-medium text-slate-400">Antrean</span></p>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mt-1">Perlu Review</p>
            </div>
        </div>
        <div class="bg-white p-7 rounded-[2rem] border border-slate-100 shadow-sm flex items-center gap-6">
            <div class="w-14 h-14 bg-rose-50 text-rose-600 rounded-2xl flex items-center justify-center text-xl shadow-inner">
                <i class="fas fa-exclamation-circle"></i>
            </div>
            <div>
                <p class="text-2xl font-black text-slate-900"><?= htmlspecialchars($stats['items_broken'] ?? 0) ?> <span class="text-sm font-medium text-slate-400">Barang</span></p>
                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] mt-1">Kondisi Rusak</p>
            </div>
        </div>
    </div>

    <div class="space-y-10">

        <section>
            <div class="flex items-center gap-4 mb-4">
                <div class="w-8 h-8 rounded-full bg-amber-500 text-white flex items-center justify-center text-xs font-bold shadow-lg shadow-amber-200">1</div>
                <h2 class="text-lg font-black text-slate-800 uppercase tracking-tight italic">Tahap Persetujuan <span class="ml-2 text-[10px] font-bold text-amber-500 bg-amber-50 px-2 py-0.5 rounded italic uppercase">Menunggu Review</span></h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <?php 
                $has_pending = false;
                foreach ($recent_activities ?? [] as $loan): 
                    if ($loan['status'] === 'pending'): $has_pending = true;
                ?>
                <div class="step-gradient-pending p-5 rounded-3xl border border-amber-100 shadow-sm hover:shadow-md transition-all group">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <p class="text-sm font-bold text-slate-800"><?= htmlspecialchars($loan['student_name']) ?></p>
                            <p class="text-[10px] text-slate-500 font-medium">Diajukan: <?= date('d M Y', strtotime($loan['created_at'])) ?></p>
                        </div>
                        <span class="text-[9px] font-black text-amber-600 uppercase italic">New Request</span>
                    </div>
                    <div class="bg-white/60 p-3 rounded-2xl border border-white mb-4">
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider leading-none mb-1">Asset Target</p>
                        <p class="text-xs font-bold text-slate-700"><?= htmlspecialchars($loan['item_name']) ?></p>
                    </div>
                    <div class="flex gap-2 mt-4">
                        <form action="index.php?page=approve_loan" method="POST" class="flex-1 flex">
                            <input type="hidden" name="loan_id" value="<?= $loan['id'] ?>">
                            <button type="submit" class="w-full py-2.5 bg-emerald-500 hover:bg-emerald-600 text-white text-[10px] font-black rounded-xl shadow-lg shadow-emerald-200 transition-all uppercase tracking-widest">Setujui</button>
                        </form>
                        <form action="index.php?page=reject_loan" method="POST" class="flex-1 flex">
                            <input type="hidden" name="loan_id" value="<?= $loan['id'] ?>">
                            <button type="submit" class="w-full px-4 py-2.5 bg-white border border-rose-100 text-rose-500 hover:bg-rose-50 text-[10px] font-black rounded-xl transition-all uppercase tracking-widest text-center">Tolak</button>
                        </form>
                    </div>
                </div>
                <?php endif; endforeach; ?>

                <?php if(!$has_pending): ?>
                <div class="md:col-span-2 lg:col-span-3 py-10 flex flex-col items-center justify-center border-2 border-dashed border-slate-200 rounded-[2rem] bg-white/30">
                     <i class="fas fa-check-circle text-slate-200 text-3xl mb-2"></i>
                     <p class="text-xs font-bold text-slate-400 uppercase tracking-[0.2em]">Semua permintaan telah diproses</p>
                </div>
                <?php endif; ?>
            </div>
        </section>

        <section>
            <div class="flex items-center gap-4 mb-4">
                <div class="w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center text-xs font-bold shadow-lg shadow-blue-200">2</div>
                <h2 class="text-lg font-black text-slate-800 uppercase tracking-tight italic">Siap Diambil <span class="ml-2 text-[10px] font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded italic uppercase">Menunggu Mahasiswa</span></h2>
            </div>
            <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-blue-50/50">
                            <tr class="text-[10px] text-blue-400 font-black uppercase tracking-[0.2em]">
                                <th class="px-8 py-4">Peminjam & Barang</th>
                                <th class="px-8 py-4">Security Code</th>
                                <th class="px-8 py-4 text-right">Verifikasi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            <?php 
                            $has_approved = false;
                            foreach ($recent_activities ?? [] as $loan): 
                                if ($loan['status'] === 'approved'): 
                                    $has_approved = true;
                                    $words = explode(" ", htmlspecialchars($loan['student_name']));
                                    $initials = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
                            ?>
                            <tr class="hover:bg-blue-50/20 transition-all group">
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 bg-slate-100 rounded-full flex items-center justify-center font-bold text-xs text-slate-500 group-hover:bg-blue-600 group-hover:text-white transition-all">
                                            <?= $initials ?>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-slate-800 leading-none mb-1"><?= htmlspecialchars($loan['student_name']) ?></p>
                                            <p class="text-[10px] text-slate-400 font-medium tracking-tight italic leading-none"><?= htmlspecialchars($loan['item_name']) ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-5">
                                    <span class="px-3 py-1 bg-slate-900 text-white font-mono text-xs font-bold rounded-lg tracking-[0.3em] shadow-inner">
                                        <?= htmlspecialchars($loan['pickup_code']) ?>
                                    </span>
                                </td>
                                <td class="px-8 py-5 text-right">
                                    <div class="flex justify-end gap-2">
                                        <form action="index.php?page=confirm_pickup" method="POST">
                                            <input type="hidden" name="loan_id" value="<?= $loan['id'] ?>">
                                            <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-[10px] font-black rounded-xl shadow-lg shadow-blue-200 transition-all uppercase tracking-widest">
                                                Sudah Pickup
                                            </button>
                                        </form>
                                        <form action="index.php?page=cancel_pickup" method="POST">
                                            <input type="hidden" name="loan_id" value="<?= $loan['id'] ?>">
                                            <button type="submit" onclick="return confirm('Tolak/Batalkan pengambilan barang ini?')" class="px-4 py-2 bg-red-50 hover:bg-red-500 text-red-600 hover:text-white text-[10px] font-black rounded-xl transition-all uppercase tracking-widest">
                                                Tolak
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <?php endif; endforeach; ?>

                            <?php if(!$has_approved): ?>
                            <tr>
                                <td colspan="3" class="px-8 py-10 text-center text-slate-400 text-xs font-bold uppercase tracking-widest italic">
                                    Belum ada barang yang menunggu diambil.
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <section>
            <div class="flex items-center gap-4 mb-4">
                <div class="w-8 h-8 rounded-full bg-emerald-500 text-white flex items-center justify-center text-xs font-bold shadow-lg shadow-emerald-200">3</div>
                <h2 class="text-lg font-black text-slate-800 uppercase tracking-tight italic">Sirkulasi & Pengembalian <span class="ml-2 text-[10px] font-bold text-emerald-500 bg-emerald-50 px-2 py-0.5 rounded italic uppercase tracking-wider badge-pulse">Verifikasi Fisik</span></h2>
            </div>
            <div class="bg-white rounded-[2rem] border-2 border-emerald-50 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-emerald-50/30">
                            <tr class="text-[10px] text-emerald-600 font-black uppercase tracking-[0.2em]">
                                <th class="px-8 py-4 italic">Peminjam & Kondisi Awal</th>
                                <th class="px-8 py-4 italic">Status</th>
                                <th class="px-8 py-4 italic text-right">Verifikasi Kondisi & Selesaikan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-emerald-50">
                            <?php 
                            $has_active = false;
                            foreach ($recent_activities ?? [] as $loan): 
                                // Mendukung status 'borrowed' (sedang dipinjam) atau 'return_pending' (sudah lapor kembalikan)
                                if ($loan['status'] === 'return_pending' || $loan['status'] === 'borrowed'): 
                                    $has_active = true;
                            ?>
                            <tr class="hover:bg-emerald-50/20 transition-all">
                                <td class="px-8 py-6">
                                    <p class="text-sm font-bold text-slate-800 mb-1"><?= htmlspecialchars($loan['student_name']) ?></p>
                                    <div class="flex flex-col gap-1">
                                        <p class="text-[10px] font-bold text-slate-700 border-b pb-1"><?= htmlspecialchars($loan['item_name']) ?></p>
                                        <p class="text-[9px] text-slate-500 italic">Kondisi Awal: "<?= htmlspecialchars($loan['condition_start'] ?? 'Baik') ?>"</p>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <?php if($loan['status'] === 'return_pending'): ?>
                                        <span class="px-2 py-1 bg-amber-100 text-amber-700 text-[9px] rounded-lg font-bold">Minta Kembali</span>
                                    <?php else: ?>
                                        <span class="px-2 py-1 bg-emerald-100 text-emerald-700 text-[9px] rounded-lg font-bold">Masih Dipinjam</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <form action="index.php?page=return_item" method="POST" class="flex flex-col gap-3">
                                        <input type="hidden" name="loan_id" value="<?= $loan['id'] ?>">
                                        
                                        <div class="flex items-center justify-end gap-4 text-[10px] font-bold text-slate-600">
                                            <label class="flex items-center gap-1 cursor-pointer hover:text-emerald-600">
                                                <input type="radio" name="condition" value="Baik" required class="accent-emerald-500 w-4 h-4"> Fisik Sesuai Awal
                                            </label>
                                            <label class="flex items-center gap-1 cursor-pointer hover:text-orange-500">
                                                <input type="radio" name="condition" value="Rusak" required class="accent-orange-500 w-4 h-4"> Rusak (Denda 50%)
                                            </label>
                                            <label class="flex items-center gap-1 cursor-pointer hover:text-red-500">
                                                <input type="radio" name="condition" value="Hilang" required class="accent-red-500 w-4 h-4"> Hilang (Denda 100%)
                                            </label>
                                        </div>

                                        <button type="submit" onclick="return confirm('Verifikasi kondisi dan kembalikan barang?')" class="w-full px-5 py-2.5 bg-slate-900 hover:bg-black text-white text-[10px] font-black rounded-xl shadow-lg shadow-slate-200 transition-all uppercase tracking-widest cursor-pointer mt-2">
                                            Verifikasi & Selesaikan
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php endif; endforeach; ?>

                            <?php if(!$has_active): ?>
                            <tr>
                                <td colspan="3" class="px-8 py-10 text-center text-slate-400 text-xs font-bold uppercase tracking-widest italic">
                                    Tidak ada sirkulasi peminjaman aktif.
                                </td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <section>
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-4">
                    <div class="w-8 h-8 rounded-full bg-slate-800 text-white flex items-center justify-center text-xs font-bold shadow-lg shadow-slate-200"><i class="fas fa-list"></i></div>
                    <h2 class="text-lg font-black text-slate-800 uppercase tracking-tight italic">Monitoring Inventaris & Denda</h2>
                </div>
                <a href="index.php?page=items_create" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-900 text-[10px] font-black rounded-xl hover:bg-slate-50 transition-all shadow-sm uppercase tracking-widest">
                    + Tambah Barang Baru
                </a>
            </div>
            
            <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-slate-50/80 text-[10px] font-black text-slate-400 uppercase tracking-[0.15em]">
                                <th class="px-8 py-5">Nama Barang</th>
                                <th class="px-8 py-5">Status Stok</th>
                                <th class="px-8 py-5">Status Fisik</th>
                                <th class="px-8 py-5">Proyeksi Denda</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            <?php foreach ($equipments ?? [] as $item): ?>
                            <tr class="hover:bg-slate-50/50 transition-all">
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-slate-50 rounded-xl flex items-center justify-center text-slate-400">
                                            <i class="fas fa-box-open"></i>
                                        </div>
                                        <div>
                                            <p class="text-sm font-bold text-slate-800"><?= htmlspecialchars($item['name']) ?></p>
                                            <p class="text-[10px] text-slate-400 font-medium"><?= htmlspecialchars($item['brand'] ?? 'Tanpa Merek') ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-5">
                                    <div class="flex items-center gap-2">
                                        <span class="w-1.5 h-1.5 rounded-full <?= $item['stock'] > 0 ? 'bg-blue-500' : 'bg-red-500' ?>"></span>
                                        <p class="text-sm font-black text-slate-700"><?= htmlspecialchars($item['stock']) ?> <span class="text-[10px] font-medium text-slate-400 uppercase">Unit</span></p>
                                    </div>
                                </td>
                                <td class="px-8 py-5">
                                    <?php if(($item['condition_status'] ?? 'Baik') === 'Baik'): ?>
                                        <span class="px-3 py-1 bg-emerald-50 text-emerald-600 text-[9px] font-black rounded-full border border-emerald-100 uppercase tracking-tighter">Sempurna (Baik)</span>
                                    <?php else: ?>
                                        <span class="px-3 py-1 bg-rose-50 text-rose-600 text-[9px] font-black rounded-full border border-rose-100 uppercase tracking-tighter">Perlu Perbaikan</span>
                                    <?php endif; ?>
                                </td>
                                <td class="px-8 py-5">
                                    <div class="flex flex-col gap-1">
                                        <div class="flex items-center gap-2">
                                            <div class="w-1 h-1 rounded-full bg-orange-400"></div>
                                            <p class="text-[10px] font-bold text-orange-600 italic">Rusak: Rp <?= number_format(($item['purchase_price'] ?? 0) * 0.5, 0, ',', '.') ?></p>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <div class="w-1 h-1 rounded-full bg-rose-500"></div>
                                            <p class="text-[10px] font-bold text-rose-600 italic">Hilang: Rp <?= number_format(($item['purchase_price'] ?? 0), 0, ',', '.') ?></p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

    </div>
</div>