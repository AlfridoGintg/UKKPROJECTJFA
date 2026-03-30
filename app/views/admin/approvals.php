<div class="max-w-7xl mx-auto px-6 py-10">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10">
        <div>
            <h3 class="text-3xl font-black text-slate-900 uppercase tracking-tight">
                Persetujuan <span class="text-blue-600">Peminjaman</span>
            </h3>
            <p class="text-slate-500 mt-2 font-medium">Verifikasi permintaan mahasiswa dan generate QR Code pengambilan.</p>
        </div>
        <div class="flex gap-3">
            <div class="bg-white px-6 py-3 rounded-2xl border border-slate-200 shadow-sm">
                <span class="block text-[10px] font-black text-slate-400 uppercase">Total Antrean</span>
                <span class="text-2xl font-black text-slate-900"><?= count($pending_loans) ?></span>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-[2.5rem] border border-slate-200 overflow-hidden shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50/50">
                    <tr>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">Mahasiswa</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">Alat & Kondisi Awal</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100">Waktu Pengajuan</th>
                        <th class="px-8 py-5 text-[10px] font-black text-slate-400 uppercase tracking-widest border-b border-slate-100 text-center">Keputusan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php if (!empty($pending_loans)): ?>
                        <?php foreach ($pending_loans as $loan): ?>
                            <tr class="hover:bg-slate-50/50 transition duration-200">
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-100">
                                            <span class="text-lg font-bold text-white"><?= strtoupper(substr($loan['username'], 0, 1)) ?></span>
                                        </div>
                                        <div>
                                            <div class="font-black text-slate-800 tracking-tight"><?= htmlspecialchars($loan['username']) ?></div>
                                            <div class="text-[10px] text-blue-600 font-black uppercase">ID: #<?= $loan['user_id'] ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="font-bold text-slate-700"><?= htmlspecialchars($loan['item_name']) ?></div>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                                        <div class="text-xs text-slate-500 italic">"<?= htmlspecialchars($loan['initial_condition']) ?>"</div>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="text-sm font-bold text-slate-600"><?= date('H:i', strtotime($loan['created_at'])) ?></div>
                                    <div class="text-[10px] text-slate-400 font-medium"><?= date('d M Y', strtotime($loan['created_at'])) ?></div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex items-center justify-center gap-3">
                                        <form action="index.php?page=approve_loan" method="POST" onsubmit="return confirm('Setujui peminjaman? QR Code akan langsung terkirim ke mahasiswa.')">
                                            <input type="hidden" name="loan_id" value="<?= $loan['id'] ?>">
                                            <button type="submit" class="group relative bg-slate-900 hover:bg-blue-600 text-white px-6 py-2.5 rounded-xl text-xs font-black transition-all duration-300 flex items-center gap-2 overflow-hidden">
                                                <span class="relative z-10">APPROVE</span>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 relative z-10 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </button>
                                        </form>

                                        <form action="index.php?page=reject_loan" method="POST" onsubmit="return confirm('Tolak permintaan ini?')">
                                            <input type="hidden" name="loan_id" value="<?= $loan['id'] ?>">
                                            <button type="submit" class="bg-red-50 text-red-500 hover:bg-red-500 hover:text-white px-6 py-2.5 rounded-xl text-xs font-black transition-all duration-300">
                                                REJECT
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="px-8 py-32 text-center">
                                <div class="flex flex-col items-center">
                                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mb-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-slate-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <h4 class="text-slate-900 font-black uppercase tracking-widest text-sm">Semua Beres!</h4>
                                    <p class="text-slate-400 text-xs mt-1">Tidak ada permintaan peminjaman yang perlu diperiksa saat ini.</p>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <div class="p-6 bg-slate-50/50 border-t border-slate-100">
            <div class="flex items-center gap-2 justify-center text-[10px] font-black text-slate-400 uppercase tracking-[0.3em]">
                <span class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></span>
                Monitoring Sistem Inventaris JFA Real-Time
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Cek jika ada parameter status=success di URL
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('status') === 'success') {
        Swal.fire({
            title: 'Berhasil Disetujui!',
            text: 'Permintaan telah diterima dan stok otomatis berkurang.',
            icon: 'success',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
            background: '#ffffff',
            iconColor: '#2563eb', // Warna biru JFA
            customClass: {
                title: 'font-black text-slate-900',
                popup: 'rounded-[2rem]'
            }
        }).then(() => {
            // Bersihkan URL dari parameter status agar tidak muncul lagi saat refresh
            window.history.replaceState({}, document.title, "index.php?page=approvals");
        });
    }
</script>