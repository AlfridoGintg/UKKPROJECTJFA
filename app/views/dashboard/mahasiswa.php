<div class="max-w-7xl mx-auto px-6 py-10">
    <div class="mb-10">
        <h3 class="text-3xl font-black text-slate-900 uppercase tracking-tight">
            Dashboard Mahasiswa
        </h3>
        <p class="text-slate-500 mt-2">Selamat datang kembali, <span class="font-bold text-blue-600"><?= htmlspecialchars($_SESSION['username']); ?></span>. Siap berkarya hari ini?</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-[2.5rem] border border-slate-200 p-8 shadow-sm">
                <div class="flex flex-col items-center text-center">
                    <div class="w-24 h-24 bg-blue-100 rounded-full flex items-center justify-center mb-4 ring-8 ring-blue-50">
                        <span class="text-3xl font-bold text-blue-600"><?= strtoupper(substr($_SESSION['username'], 0, 1)) ?></span>
                    </div>
                    <h2 class="text-xl font-extrabold text-slate-900"><?= htmlspecialchars($_SESSION['username']) ?></h2>
                    <p class="text-[10px] bg-slate-100 px-3 py-1 rounded-full text-slate-500 uppercase font-black tracking-widest mt-2"><?= $_SESSION['role'] ?></p>
                    
                    <div class="w-full mt-8 space-y-4 pt-6 border-t border-slate-100 text-left">
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-400 font-medium">Status Akun</span>
                            <span class="font-bold text-green-600 flex items-center gap-1">
                                <span class="w-2 h-2 bg-green-500 rounded-full"></span> Aktif
                            </span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-400 font-medium">ID User</span>
                            <span class="font-bold text-slate-700">#<?= $_SESSION['user_id'] ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-slate-900 rounded-[2.5rem] p-8 text-white shadow-xl shadow-blue-100">
                <h4 class="font-bold text-lg mb-4">Butuh Alat Produksi?</h4>
                <p class="text-slate-400 text-sm mb-6">Cek ketersediaan kamera, lighting, dan alat lainnya secara real-time di gudang JFA.</p>
                <div class="space-y-4">
                    <a href="index.php?page=items" class="block text-center w-full py-3 bg-blue-600 hover:bg-blue-500 rounded-xl font-bold text-sm transition">
                        Lihat Katalog Alat →
                    </a>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white rounded-[2.5rem] border border-slate-200 overflow-hidden shadow-sm">
                <div class="p-8 border-b border-slate-100 flex justify-between items-center text-nowrap gap-4">
                    <div>
                        <h3 class="font-extrabold text-lg text-slate-900">Riwayat Peminjaman</h3>
                        <p class="text-xs text-slate-400">Status persetujuan dan QR pengambilan</p>
                    </div>
                    <a href="index.php?page=items" class="bg-slate-50 hover:bg-slate-100 text-blue-600 px-5 py-2 rounded-xl text-xs font-bold transition flex items-center gap-2">
                        <span>Pinjam Alat Baru</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
                        </svg>
                    </a>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-slate-50/50">
                            <tr>
                                <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Detail Alat</th>
                                <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">QR / Informasi</th>
                                <th class="px-8 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <?php if (!empty($history)): ?>
                                <?php foreach ($history as $row): ?>
                                    <tr class="hover:bg-slate-50/50 transition">
                                        <td class="px-8 py-4">
                                            <div class="font-bold text-slate-700"><?= htmlspecialchars($row['item_name'] ?? 'Item Tidak Dikenal') ?></div>
                                            <div class="text-[10px] text-slate-400 uppercase font-medium tracking-tighter">
                                                Dipesan: <?= date('d M Y', strtotime($row['created_at'])) ?>
                                            </div>
                                        </td>
                                        
                                        <td class="px-8 py-4">
                                            <div class="flex flex-col items-center justify-center">
                                                <?php if ($row['status'] === 'approved'): ?>
                                                    <div class="flex flex-col items-center gap-1">
                                                        <img onclick="openQrModal('https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=<?= $row['pickup_code'] ?>')" 
                                                             src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=<?= $row['pickup_code'] ?>" 
                                                             class="w-16 h-16 border-2 border-blue-600 p-1 rounded-lg bg-white cursor-pointer hover:scale-105 transition-transform" 
                                                             alt="QR Code">
                                                        <p class="text-[9px] font-black text-blue-600 uppercase"><?= $row['pickup_code'] ?></p>
                                                    </div>

                                                <?php elseif ($row['status'] === 'borrowed'): ?>
                                                    <div class="text-center">
                                                        <p class="text-[10px] text-green-600 font-bold italic tracking-tight uppercase">Aktif Digunakan</p>
                                                        <p class="text-[9px] text-slate-400">Batas: <span class="font-bold text-slate-700"><?= date('d M Y', strtotime($row['return_date'])) ?></span></p>
                                                        
                                                        <form action="index.php?page=request_return" method="POST" class="mt-2">
                                                            <input type="hidden" name="loan_id" value="<?= $row['id'] ?>">
                                                            <button type="submit" onclick="return confirm('Ajukan pengembalian sekarang? Petugas akan mengecek kondisi fisik alat.')" 
                                                                    class="px-4 py-1.5 bg-slate-900 text-white text-[9px] font-bold rounded-lg hover:bg-black transition-all shadow-sm">
                                                                Kembalikan Alat
                                                            </button>
                                                        </form>
                                                    </div>

                                                <?php elseif ($row['status'] === 'return_pending'): ?>
                                                    <div class="text-center bg-amber-50 p-2 rounded-xl border border-amber-100">
                                                        <p class="text-[10px] text-amber-600 font-bold italic tracking-tight">MENUNGGU PETUGAS</p>
                                                        <p class="text-[8px] text-amber-500 leading-tight">Silakan bawa barang ke<br>gudang untuk pengecekan.</p>
                                                    </div>

                                                <?php elseif ($row['status'] === 'rejected'): ?>
                                                    <div class="w-8 h-8 bg-red-50 rounded-full flex items-center justify-center text-red-400">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                        </svg>
                                                    </div>
                                                
                                                <?php else: ?>
                                                    <span class="text-[10px] text-slate-300 italic font-medium">N/A</span>
                                                <?php endif; ?>
                                            </div>
                                        </td>

                                        <td class="px-8 py-4 text-right">
                                            <?php 
                                                $statusColor = match($row['status']) {
                                                    'pending'        => 'bg-amber-100 text-amber-600',
                                                    'approved'       => 'bg-blue-100 text-blue-600 ring-1 ring-blue-200',
                                                    'borrowed'       => 'bg-green-600 text-white shadow-lg shadow-green-100',
                                                    'return_pending' => 'bg-amber-500 text-white animate-pulse',
                                                    'returned'       => 'bg-slate-100 text-slate-500',
                                                    'rejected'       => 'bg-red-100 text-red-600',
                                                    default          => 'bg-slate-100 text-slate-600'
                                                };
                                            ?>
                                            <span class="px-3 py-1 rounded-full text-[9px] font-black <?= $statusColor ?> uppercase tracking-tighter italic">
                                                <?= str_replace('_', ' ', $row['status']) ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3" class="px-8 py-20 text-center">
                                        <div class="flex flex-col items-center">
                                            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-slate-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                                </svg>
                                            </div>
                                            <p class="text-slate-400 italic text-sm font-medium">Belum ada riwayat peminjaman.</p>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="p-6 bg-slate-50 border-t border-slate-100 text-center">
                    <p class="text-[9px] text-slate-400 uppercase tracking-[0.2em] font-black">
                        Pemberitahuan: Bawa KTM saat pengambilan alat di gudang
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="qrModal" class="hidden fixed inset-0 bg-slate-900/80 z-50 flex items-center justify-center backdrop-blur-sm transition-opacity">
    <div class="bg-white p-10 rounded-[2.5rem] max-w-sm w-full text-center shadow-2xl relative">
        <h3 class="text-xl font-black text-slate-900 mb-6 uppercase tracking-tight">Kode Pengambilan</h3>
        <div class="bg-slate-50 p-4 rounded-2xl inline-block mb-6 border border-slate-100 shadow-inner">
            <img id="qrImage" src="" alt="QR Code Large" class="w-48 h-48 mx-auto">
        </div>
        <p class="text-slate-500 text-sm font-medium mb-8 leading-relaxed">
            Tunjukkan QR Code ini ke petugas gudang saat melakukan pengambilan alat.
        </p>
        <button onclick="closeQrModal()" class="bg-blue-600 text-white w-full py-4 rounded-2xl font-black hover:bg-blue-700 transition">
            TUTUP
        </button>
    </div>
</div>

<script>
    function openQrModal(qrUrl) {
        document.getElementById('qrImage').src = qrUrl;
        document.getElementById('qrModal').classList.remove('hidden');
    }
    function closeQrModal() {
        document.getElementById('qrModal').classList.add('hidden');
    }
</script>   git add .