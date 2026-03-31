<div class="max-w-7xl mx-auto px-6 py-10">
    <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-4">
        <div>
            <h3 class="text-3xl font-black text-midnight uppercase tracking-tighter">
                Dashboard <span class="text-gold">Mahasiswa</span>
            </h3>
            <p class="text-slate-500 mt-2 font-medium">Selamat datang kembali, <span class="text-midnight font-bold border-b-2 border-gold/30"><?= htmlspecialchars($_SESSION['username']); ?></span>. Siap berkarya hari ini?</p>
        </div>
        <div class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em] bg-white px-4 py-2 rounded-full border border-slate-100 shadow-sm">
            System Status: <span class="text-green-500">Operational</span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-[2rem] border border-slate-200 p-8 shadow-sm relative overflow-hidden">
                <div class="absolute top-0 right-0 w-24 h-24 bg-gold/5 rounded-full -mr-10 -mt-10"></div>
                
                <div class="flex flex-col items-center text-center relative z-10">
                    <div class="w-24 h-24 bg-midnight rounded-[2rem] flex items-center justify-center mb-4 shadow-xl shadow-gold/10 rotate-3 hover:rotate-0 transition-transform duration-500 border-2 border-gold/20">
                        <span class="text-4xl font-black text-gold -rotate-3 hover:rotate-0 transition-transform"><?= strtoupper(substr($_SESSION['username'], 0, 1)) ?></span>
                    </div>
                    <h2 class="text-xl font-black text-midnight uppercase tracking-tight"><?= htmlspecialchars($_SESSION['username']) ?></h2>
                    <p class="text-[9px] bg-gold/10 px-4 py-1.5 rounded-full text-bronze uppercase font-black tracking-widest mt-3"><?= $_SESSION['role'] ?></p>
                    
                    <div class="w-full mt-8 space-y-4 pt-6 border-t border-slate-100 text-left">
                        <div class="flex justify-between text-[11px] uppercase tracking-wider font-bold">
                            <span class="text-slate-400">Status Akun</span>
                            <span class="text-green-600 flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 bg-green-500 rounded-full animate-pulse"></span> Aktif
                            </span>
                        </div>
                        <div class="flex justify-between text-[11px] uppercase tracking-wider font-bold">
                            <span class="text-slate-400">ID User</span>
                            <span class="text-midnight">#<?= $_SESSION['user_id'] ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-midnight rounded-[2rem] p-8 text-white shadow-2xl shadow-midnight/20 border border-gold/10 relative overflow-hidden group">
                <div class="absolute bottom-0 right-0 opacity-10 group-hover:scale-110 transition-transform">
                     <i class="fa-solid fa-camera-retro text-7xl -mb-4 -mr-4 text-gold"></i>
                </div>
                <h4 class="font-black text-lg mb-2 uppercase tracking-tight">Butuh Alat <span class="text-gold">Produksi?</span></h4>
                <p class="text-slate-400 text-xs mb-6 leading-relaxed">Cek ketersediaan kamera, lighting, dan alat lainnya secara real-time.</p>
                <a href="index.php?page=items" class="relative z-10 block text-center w-full py-4 bg-gradient-to-r from-gold to-bronze hover:brightness-110 rounded-xl font-black text-[10px] uppercase tracking-[0.2em] transition-all shadow-lg shadow-gold/20 text-midnight">
                    Lihat Katalog Alat <i class="fa-solid fa-arrow-right ml-2"></i>
                </a>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="bg-white rounded-[2rem] border border-slate-200 overflow-hidden shadow-sm">
                <div class="p-8 border-b border-slate-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div>
                        <h3 class="font-black text-xl text-midnight uppercase tracking-tight">Riwayat Peminjaman</h3>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">Status persetujuan & kode pengambilan</p>
                    </div>
                    <a href="index.php?page=items" class="bg-midnight hover:bg-slate-800 text-gold px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all flex items-center gap-2 shadow-lg shadow-midnight/10">
                        <span>Pinjam Alat</span>
                        <i class="fa-solid fa-plus text-[12px]"></i>
                    </a>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-slate-50/80">
                            <tr>
                                <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest">Detail Alat</th>
                                <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Aksi / Informasi</th>
                                <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <?php if (!empty($history)): ?>
                                <?php foreach ($history as $row): ?>
                                    <tr class="hover:bg-slate-50/50 transition duration-300">
                                        <td class="px-8 py-6">
                                            <div class="font-black text-midnight uppercase text-sm tracking-tight"><?= htmlspecialchars($row['item_name'] ?? 'Item Tidak Dikenal') ?></div>
                                            <div class="text-[9px] text-slate-400 uppercase font-bold tracking-widest mt-1 flex items-center gap-2">
                                                <i class="fa-regular fa-calendar text-gold"></i> <?= date('d M Y', strtotime($row['created_at'])) ?>
                                            </div>
                                        </td>
                                        
                                        <td class="px-8 py-6">
                                            <div class="flex flex-col items-center justify-center">
                                                <?php if ($row['status'] === 'approved'): ?>
                                                    <button onclick="openQrModal('https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=<?= $row['pickup_code'] ?>')" 
                                                            class="group flex flex-col items-center gap-2">
                                                        <div class="p-1 border-2 border-dashed border-gold/40 rounded-xl group-hover:border-gold transition-colors bg-white shadow-sm">
                                                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=<?= $row['pickup_code'] ?>" 
                                                                 class="w-12 h-12 grayscale group-hover:grayscale-0 transition-all" alt="QR">
                                                        </div>
                                                        <p class="text-[9px] font-black text-gold uppercase tracking-tighter">Klik QR Code</p>
                                                    </button>

                                                <?php elseif ($row['status'] === 'borrowed'): ?>
                                                    <div class="text-center bg-green-50 px-4 py-2 rounded-2xl border border-green-100">
                                                        <p class="text-[9px] text-green-700 font-black uppercase tracking-widest mb-2">Sedang Digunakan</p>
                                                        <form action="index.php?page=request_return" method="POST">
                                                            <input type="hidden" name="loan_id" value="<?= $row['id'] ?>">
                                                            <button type="submit" onclick="return confirm('Ajukan pengembalian?')" 
                                                                    class="px-4 py-1.5 bg-midnight text-gold text-[8px] font-black uppercase tracking-widest rounded-lg hover:bg-black transition-all">
                                                                Kembalikan
                                                            </button>
                                                        </form>
                                                    </div>

                                                <?php elseif ($row['status'] === 'return_pending'): ?>
                                                    <div class="text-center px-4 py-2 rounded-2xl bg-amber-50 border border-amber-100">
                                                        <p class="text-[9px] text-amber-600 font-black uppercase tracking-widest">Verifikasi Fisik</p>
                                                        <p class="text-[8px] text-slate-400 leading-tight mt-1">Bawa alat ke gudang</p>
                                                    </div>
                                                <?php elseif ($row['status'] === 'rejected'): ?>
                                                    <div class="w-8 h-8 bg-red-50 rounded-full flex items-center justify-center text-red-400">
                                                        <i class="fa-solid fa-xmark text-sm"></i>
                                                    </div>
                                                <?php else: ?>
                                                    <span class="text-[10px] text-slate-300 italic font-medium">Menunggu Antrean</span>
                                                <?php endif; ?>
                                            </div>
                                        </td>

                                        <td class="px-8 py-6 text-right">
                                            <?php 
                                                $statusColor = match($row['status']) {
                                                    'pending'        => 'bg-amber-100 text-amber-600',
                                                    'approved'       => 'bg-midnight text-gold border border-gold/30 shadow-lg shadow-gold/10',
                                                    'borrowed'       => 'bg-green-600 text-white',
                                                    'return_pending' => 'bg-amber-500 text-white animate-pulse',
                                                    'returned'       => 'bg-slate-100 text-slate-500',
                                                    'rejected'       => 'bg-red-100 text-red-600',
                                                    default          => 'bg-slate-100 text-slate-600'
                                                };
                                            ?>
                                            <span class="px-4 py-1.5 rounded-lg text-[9px] font-black <?= $statusColor ?> uppercase tracking-widest italic shadow-sm">
                                                <?= str_replace('_', ' ', $row['status']) ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3" class="px-8 py-24 text-center">
                                        <div class="flex flex-col items-center">
                                            <div class="w-20 h-20 bg-slate-50 rounded-[2rem] flex items-center justify-center mb-4 border border-slate-100">
                                                <i class="fa-solid fa-box-open text-3xl text-slate-200"></i>
                                            </div>
                                            <p class="text-slate-400 uppercase text-[10px] font-black tracking-[0.2em]">Belum ada riwayat peminjaman</p>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="p-6 bg-slate-50/50 border-t border-slate-100 text-center">
                    <p class="text-[9px] text-slate-400 uppercase tracking-[0.3em] font-black">
                         Note: <span class="text-midnight">Bawa KTM</span> untuk verifikasi pengambilan alat
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="qrModal" class="hidden fixed inset-0 bg-midnight/95 z-[100] flex items-center justify-center backdrop-blur-md transition-all duration-500">
    <div class="bg-white p-1 rounded-[3rem] max-w-sm w-full mx-6 shadow-2xl relative border-4 border-gold/20">
        <div class="bg-white p-8 rounded-[2.8rem] text-center">
            <div class="flex justify-center mb-6">
                 <div class="w-12 h-1.5 bg-slate-100 rounded-full"></div>
            </div>
            <h3 class="text-xl font-black text-midnight mb-2 uppercase tracking-tight">KODE <span class="text-gold">PICKUP</span></h3>
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-8 text-center">Tunjukkan ke petugas gudang</p>
            
            <div class="bg-slate-50 p-6 rounded-[2rem] inline-block mb-8 border border-slate-100 shadow-inner group">
                <img id="qrImage" src="" alt="QR Code" class="w-48 h-48 mx-auto group-hover:scale-105 transition-transform duration-500">
            </div>
            
            <button onclick="closeQrModal()" class="bg-midnight text-gold w-full py-5 rounded-2xl font-black text-[10px] uppercase tracking-[0.3em] hover:bg-black transition-all shadow-xl shadow-gold/5 border border-gold/20">
                TUTUP JENDELA
            </button>
        </div>
    </div>
</div>

<script>
    function openQrModal(qrUrl) {
        const modal = document.getElementById('qrModal');
        document.getElementById('qrImage').src = qrUrl;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }
    function closeQrModal() {
        const modal = document.getElementById('qrModal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }
</script>