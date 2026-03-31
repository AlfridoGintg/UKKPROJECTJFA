<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan_Inventaris_JFA_<?= date('Y-m-d') ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            @page { margin: 1.5cm; }
            .no-print { display: none; }
            body { background: white; }
            .print-card { border: none !important; shadow: none !important; }
        }
    </style>
</head>
<body class="bg-slate-50 p-10">

    <div class="max-w-5xl mx-auto bg-white p-10 border border-slate-200 shadow-sm print-card">
        <div class="no-print mb-10 flex justify-between items-center bg-blue-50 p-4 rounded-xl border border-blue-100">
            <p class="text-blue-700 text-sm font-medium">✨ <b>Preview Laporan:</b> Klik tombol cetak dan pilih "Save as PDF" pada destinasi printer.</p>
            <div class="flex gap-2">
                <a href="index.php?page=approvals" class="bg-white px-4 py-2 rounded-lg text-sm font-bold text-slate-600 border border-slate-200">Batal</a>
                <button onclick="window.print()" class="bg-blue-600 text-white px-6 py-2 rounded-lg text-sm font-bold shadow-lg shadow-blue-200">Cetak Ke PDF</button>
            </div>
        </div>

        <div class="flex justify-between items-start border-b-4 border-slate-900 pb-6 mb-8">
            <div class="flex items-center gap-4">
                <img src="public/assets/img/logo-jfa.png" class="h-16">
                <div>
                    <h1 class="text-2xl font-black tracking-tighter">JOGJA FILM ACADEMY</h1>
                    <p class="text-xs text-slate-500 font-bold uppercase tracking-widest">Biro Sarana Prasarana & Peralatan Produksi</p>
                </div>
            </div>
            <div class="text-right text-[10px] text-slate-400 font-bold uppercase">
                <p>Dicetak Pada: <?= date('d F Y H:i') ?></p>
                <p>Oleh: <?= $_SESSION['username'] ?></p>
            </div>
        </div>

        <h2 class="text-center text-xl font-black uppercase mb-8 tracking-tighter italic">Laporan Log Aktivitas Inventaris</h2>

        <table class="w-full text-xs">
            <thead>
                <tr class="bg-slate-900 text-white uppercase font-black tracking-widest">
                    <th class="p-3 text-left border border-slate-900">Tanggal</th>
                    <th class="p-3 text-left border border-slate-900">Mahasiswa</th>
                    <th class="p-3 text-left border border-slate-900">Item</th>
                    <th class="p-3 text-left border border-slate-900">Status</th>
                    <th class="p-3 text-right border border-slate-900">Denda</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                <?php foreach ($reportData as $row): ?>
                <tr>
                    <td class="p-3 border border-slate-200"><?= date('d/m/y', strtotime($row['created_at'])) ?></td>
                    <td class="p-3 border border-slate-200 font-bold uppercase"><?= htmlspecialchars($row['username']) ?></td>
                    <td class="p-3 border border-slate-200">
                        <div class="font-bold"><?= htmlspecialchars($row['item_name']) ?></div>
                        <div class="text-[9px] text-slate-400 uppercase italic"><?= htmlspecialchars($row['brand']) ?></div>
                    </td>
                    <td class="p-3 border border-slate-200">
                        <span class="uppercase font-black text-[9px]"><?= str_replace('_', ' ', $row['status']) ?></span>
                    </td>
                    <td class="p-3 border border-slate-200 text-right font-bold">
                        <?= $row['fine'] > 0 ? 'Rp' . number_format($row['fine'], 0, ',', '.') : '-' ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="mt-20 flex justify-end">
            <div class="text-center w-64">
                <p class="text-xs font-bold text-slate-500 mb-16">Yogyakarta, <?= date('d M Y') ?></p>
                <div class="border-b border-slate-900 mb-1"></div>
                <p class="text-sm font-black uppercase tracking-tighter">Kepala Bagian Peralatan</p>
            </div>
        </div>
    </div>

</body>
</html>