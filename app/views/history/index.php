<div class="max-w-7xl mx-auto px-6 py-10">
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-slate-900">Riwayat Transaksi Lengkap</h1>
        <p class="text-slate-500 text-sm mt-1">Daftar keseluruhan riwayat peminjaman barang inventaris JFA.</p>
    </div>

    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50 border-b border-slate-100 text-xs uppercase tracking-widest text-slate-500">
                    <tr>
                        <th class="p-5 font-bold">Peminjam</th>
                        <th class="p-5 font-bold">Barang</th>
                        <th class="p-5 font-bold">Waktu Pengajuan</th>
                        <th class="p-5 font-bold">Waktu Diambil</th>
                        <th class="p-5 font-bold">Status</th>
                        <th class="p-5 font-bold">Denda (Jika Ada)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    <?php if (!empty($history)): ?>
                        <?php foreach ($history as $row): ?>
                            <tr class="hover:bg-slate-50/50">
                                <td class="p-5 font-semibold text-slate-800"><?= htmlspecialchars($row['student_name']) ?></td>
                                <td class="p-5">
                                    <span class="font-bold text-slate-700"><?= htmlspecialchars($row['item_name']) ?></span><br>
                                    <span class="text-[10px] text-slate-400">Kondisi: <?= htmlspecialchars($row['condition_start']) ?></span>
                                </td>
                                <td class="p-5 text-slate-600"><?= date('d M Y H:i', strtotime($row['created_at'])) ?></td>
                                <td class="p-5 text-slate-600">
                                    <?= !empty($row['start_date']) ? date('d M Y H:i', strtotime($row['start_date'])) : '<span class="italic text-slate-400">- Belum / Batal -</span>' ?>
                                </td>
                                <td class="p-5">
                                    <?php
                                        $color = match($row['status']) {
                                            'pending' => 'bg-yellow-100 text-yellow-700',
                                            'approved' => 'bg-blue-100 text-blue-700',
                                            'on_loan' => 'bg-green-600 text-white',
                                            'returned' => 'bg-slate-200 text-slate-600',
                                            'rejected' => 'bg-red-100 text-red-600',
                                            default => 'bg-gray-100 text-gray-500'
                                        };
                                    ?>
                                    <span class="px-3 py-1 text-[10px] font-bold uppercase rounded-full <?= $color ?>">
                                        <?= htmlspecialchars($row['status']) ?>
                                    </span>
                                </td>
                                <td class="p-5 text-red-600 font-bold">
                                    <?= ($row['fine'] > 0) ? 'Rp ' . number_format($row['fine'], 0, ',', '.') : '<span class="text-slate-300">-</span>' ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="6" class="p-10 text-center text-slate-500 italic">Tidak ada riwayat transaksi.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>