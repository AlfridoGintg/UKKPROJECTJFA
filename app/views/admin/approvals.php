<div class="max-w-7xl mx-auto px-6 py-10">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
        <div>
            <h3 class="text-3xl font-black text-slate-900 uppercase tracking-tight">
                Manajemen <span class="text-blue-600">Peminjaman</span>
            </h3>
            <p class="text-slate-500 mt-2 font-medium">Verifikasi permintaan baru dan monitoring distribusi alat produksi JFA.</p>
        </div>
        
        <div class="flex flex-wrap items-center gap-4">
            <div class="flex gap-3">
                <div class="bg-white px-6 py-3 rounded-2xl border border-slate-200 shadow-sm text-center">
                    <span class="block text-[10px] font-black text-slate-400 uppercase">Antrean Baru</span>
                    <span class="text-2xl font-black text-blue-600"><?= count($pending_loans) ?></span>
                </div>
                <div class="bg-white px-6 py-3 rounded-2xl border border-slate-200 shadow-sm text-center">
                    <span class="block text-[10px] font-black text-slate-400 uppercase">Sedang Dipinjam</span>
                    <span class="text-2xl font-black text-emerald-500"><?= count($active_loans) ?></span>
                </div>
            </div>

            <a href="index.php?page=print_report" target="_blank" 
               class="bg-slate-900 hover:bg-black text-white px-6 py-4 rounded-2xl font-bold transition flex items-center gap-2 shadow-xl shadow-slate-200 text-sm group">
                <i class="fas fa-file-pdf group-hover:scale-110 transition-transform"></i> 
                UNDUH LAPORAN PDF
            </a>
        </div>
    </div>

    <section class="mb-12">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-2 h-8 bg-blue-600 rounded-full"></div>
            <h2 class="text-xl font-bold text-slate-800 tracking-tight">Perlu Persetujuan</h2>
        </div>
        <div class="bg-white rounded-[2.5rem] border border-slate-200 overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-50/50">
                        <tr>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">Mahasiswa</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">Alat & Kondisi</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">Waktu Pengajuan</th>
                            <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 text-center">Keputusan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php if (!empty($pending_loans)): foreach ($pending_loans as $loan): ?>
                            <tr class="hover:bg-slate-50/50 transition duration-200">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                                            <span class="text-blue-600 font-bold"><?= strtoupper(substr($loan['username'], 0, 1)) ?></span>
                                        </div>
                                        <div>
                                            <div class="font-black text-slate-800 tracking-tight"><?= htmlspecialchars($loan['username']) ?></div>
                                            <div class="text-[10px] text-blue-600 font-black uppercase">ID: #<?= $loan['user_id'] ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="font-bold text-slate-700"><?= htmlspecialchars($loan['item_name']) ?></div>
                                    <div class="text-xs text-slate-500 italic">"<?= htmlspecialchars($loan['condition_start'] ?? 'Baik') ?>"</div>
                                </td>
                                <td class="px-8 py-6 text-sm">
                                    <div class="font-bold text-slate-600"><?= date('H:i', strtotime($loan['created_at'])) ?></div>
                                    <div class="text-[10px] text-slate-400"><?= date('d M Y', strtotime($loan['created_at'])) ?></div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex items-center justify-center gap-2">
                                        <form action="index.php?page=approve_loan" method="POST" onsubmit="return confirm('Setujui peminjaman?')">
                                            <input type="hidden" name="loan_id" value="<?= $loan['id'] ?>">
                                            <button type="submit" class="bg-slate-900 hover:bg-blue-600 text-white px-4 py-2 rounded-xl text-[10px] font-black transition-all">APPROVE</button>
                                        </form>
                                        <form action="index.php?page=reject_loan" method="POST" onsubmit="return confirm('Tolak permintaan ini?')">
                                            <input type="hidden" name="loan_id" value="<?= $loan['id'] ?>">
                                            <button type="submit" class="bg-red-50 text-red-500 hover:bg-red-500 hover:text-white px-4 py-2 rounded-xl text-[10px] font-black transition-all">REJECT</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; else: ?>
                            <tr><td colspan="4" class="px-8 py-20 text-center text-slate-400 text-sm italic">Belum ada antrean baru.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <section class="mb-12">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-2 h-8 bg-emerald-500 rounded-full"></div>
            <h2 class="text-xl font-bold text-slate-800 tracking-tight">Sedang Berlangsung</h2>
        </div>
        <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-slate-50/50 border-b border-slate-100">
                    <tr class="text-[10px] font-black text-slate-400 uppercase tracking-widest">
                        <th class="px-8 py-4">Peminjam</th>
                        <th class="px-8 py-4">Alat & Brand</th>
                        <th class="px-8 py-4">Status</th>
                        <th class="px-8 py-4">Deadline Kembali</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php if (!empty($active_loans)): foreach ($active_loans as $loan): ?>
                        <tr class="hover:bg-slate-50/30 transition">
                            <td class="px-8 py-5">
                                <span class="font-bold text-slate-800"><?= htmlspecialchars($loan['username']) ?></span>
                            </td>
                            <td class="px-8 py-5">
                                <div class="font-bold text-blue-600 text-sm"><?= htmlspecialchars($loan['item_name']) ?></div>
                                <div class="text-[10px] text-slate-400 font-bold uppercase"><?= htmlspecialchars($loan['brand'] ?? '-') ?></div>
                            </td>
                            <td class="px-8 py-5">
                                <?php $is_pending_return = $loan['status'] === 'return_pending'; ?>
                                <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase <?= $is_pending_return ? 'bg-amber-100 text-amber-600' : 'bg-emerald-100 text-emerald-600' ?>">
                                    <?= $is_pending_return ? 'PROSES KEMBALI' : 'DIPINJAM' ?>
                                </span>
                            </td>
                            <td class="px-8 py-5">
                                <span class="px-3 py-1 bg-amber-50 text-amber-700 border border-amber-100 rounded-lg font-bold text-xs">
                                    <?= date('d M Y', strtotime($loan['return_date'])) ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; else: ?>
                        <tr><td colspan="4" class="p-10 text-center text-slate-400 italic">Tidak ada peminjaman aktif.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </section>

    <section>
        <div class="flex items-center gap-3 mb-6">
            <div class="w-2 h-8 bg-slate-800 rounded-full"></div>
            <h2 class="text-xl font-bold text-slate-800 tracking-tight">Arsip Riwayat</h2>
        </div>
        <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-slate-50/50 border-b border-slate-100">
                        <tr class="text-[10px] font-black text-slate-400 uppercase tracking-widest">
                            <th class="px-8 py-4">Tgl Pengajuan</th>
                            <th class="px-8 py-4">Mahasiswa</th>
                            <th class="px-8 py-4">Alat</th>
                            <th class="px-8 py-4">Status</th>
                            <th class="px-8 py-4 text-right">Denda</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        <?php foreach ($all_history as $row): ?>
                            <tr class="hover:bg-slate-50/30 transition">
                                <td class="px-8 py-5 text-slate-500 text-xs"><?= date('d/m/y H:i', strtotime($row['created_at'])) ?></td>
                                <td class="px-8 py-5 font-bold text-slate-700"><?= htmlspecialchars($row['username']) ?></td>
                                <td class="px-8 py-5 text-xs"><?= htmlspecialchars($row['item_name']) ?></td>
                                <td class="px-8 py-5">
                                    <?php 
                                        $statusClass = match($row['status']) {
                                            'pending' => 'bg-amber-100 text-amber-600',
                                            'approved' => 'bg-blue-100 text-blue-600',
                                            'borrowed' => 'bg-emerald-500 text-white',
                                            'returned' => 'bg-slate-100 text-slate-500',
                                            'rejected' => 'bg-red-100 text-red-600',
                                            default => 'bg-slate-100'
                                        };
                                    ?>
                                    <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase <?= $statusClass ?>">
                                        <?= str_replace('_', ' ', $row['status']) ?>
                                    </span>
                                </td>
                                <td class="px-8 py-5 text-right font-black text-red-600">
                                    <?php 
                                        $total_denda = ($row['fine'] ?? 0) + ($row['late_fine'] ?? 0);
                                        echo $total_denda > 0 ? 'Rp '.number_format($total_denda, 0, ',', '.') : '-';
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('status') === 'approved') {
        Swal.fire({
            title: 'Berhasil Disetujui!',
            text: 'Permintaan telah diterima dan stok otomatis dikurangi.',
            icon: 'success',
            timer: 2000,
            showConfirmButton: false,
            customClass: { popup: 'rounded-[2rem]' }
        }).then(() => {
            window.history.replaceState({}, document.title, "index.php?page=approvals");
        });
    }
</script>