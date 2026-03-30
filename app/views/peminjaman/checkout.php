<div class="max-w-4xl mx-auto px-6 py-10">
    <div class="flex items-center justify-between mb-10">
        <div>
            <a href="index.php?page=items" class="text-blue-600 text-sm font-bold flex items-center gap-2 hover:gap-3 transition-all">
                ← Kembali ke Katalog
            </a>
            <h3 class="text-3xl font-black text-slate-900 uppercase tracking-tight mt-2">
                Checkout Peminjaman
            </h3>
        </div>
        <img src="public/assets/img/logo-jfa.png" alt="JFA Logo" class="h-12 opacity-80">
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
        <div class="lg:col-span-2">
            <div class="bg-white rounded-[2.5rem] border border-slate-200 p-8 shadow-sm sticky top-10">
                <div class="aspect-square bg-slate-100 rounded-3xl mb-6 flex items-center justify-center overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1516035069371-29a1b244cc32?q=80&w=600" class="w-full h-full object-cover">
                </div>
                <h4 class="text-xl font-black text-slate-900"><?= htmlspecialchars($item['name']) ?></h4>
                <p class="text-blue-600 font-bold text-sm"><?= htmlspecialchars($item['brand']) ?></p>
                
                <div class="mt-6 pt-6 border-t border-slate-100 space-y-3">
                    <div class="flex justify-between text-xs">
                        <span class="text-slate-400">Kategori</span>
                        <span class="font-bold text-slate-700"><?= $item['category_name'] ?? 'Alat Produksi' ?></span>
                    </div>
                    <div class="flex justify-between text-xs">
                        <span class="text-slate-400">Status Stok</span>
                        <span class="font-bold text-green-600">Tersedia (<?= $item['stock'] ?>)</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-3">
            <form id="checkoutForm" class="bg-white rounded-[2.5rem] border border-slate-200 p-8 shadow-sm">
                <input type="hidden" name="item_id" value="<?= $item['id'] ?>">

                <div class="mb-8">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Langkah 1: Test Kondisi Awal</label>
                    <p class="text-sm text-slate-500 mb-4">Silakan cek fisik alat secara detail dan tuliskan hasilnya di bawah ini.</p>
                    <textarea 
                        name="initial_condition" 
                        required
                        placeholder="Contoh: Bodi kamera mulus, sensor bersih tanpa jamur, lensa tidak ada scratch, baterai terisi 100%."
                        class="w-full h-32 p-5 bg-slate-50 border border-slate-200 rounded-3xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 outline-none transition-all text-slate-700"
                    ></textarea>
                </div>

                <div class="mb-8">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3">Langkah 2: Tanggal Pengembalian (Maks 4 Hari)</label>
                    <p class="text-sm text-slate-500 mb-4">Pilih tanggal kapan anda akan mengembalikan alat ini.</p>
                    <input 
                        type="date" 
                        name="return_date" 
                        id="return_date"
                        required
                        class="w-full p-5 bg-slate-50 border border-slate-200 rounded-3xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 outline-none transition-all text-slate-700"
                    >
                </div>

                <div class="bg-blue-50 rounded-3xl p-6 mb-8 border border-blue-100">
                    <div class="flex gap-4">
                        <div class="w-10 h-10 bg-blue-600 text-white rounded-full flex-shrink-0 flex items-center justify-center font-black">!</div>
                        <div>
                            <h5 class="font-bold text-blue-900 text-sm">Penting Sebelum Submit</h5>
                            <p class="text-xs text-blue-700 leading-relaxed mt-1">Peminjaman hanya untuk keperluan akademik. Durasi maksimal peminjaman adalah 4 hari.</p>
                        </div>
                    </div>
                </div>

                <button type="button" onclick="openModal()" class="w-full py-4 bg-slate-900 hover:bg-black text-white rounded-2xl font-black uppercase tracking-widest transition-all shadow-xl shadow-slate-200">
                    Ajukan Peminjaman
                </button>
            </form>
        </div>
    </div>
</div>

<div id="modalAgreement" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="fixed inset-0 bg-slate-900/80 backdrop-blur-md transition-opacity"></div>
    <div class="relative transform overflow-hidden rounded-[3rem] bg-white p-10 text-left shadow-2xl transition-all max-w-lg w-full z-10">
        <div id="agreementState">
            <div class="text-center">
                <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-red-50 mb-6">
                    <svg class="h-10 w-10 text-red-600 animate-pulse" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                    </svg>
                </div>
                <h3 class="text-2xl font-black text-slate-900 uppercase tracking-tight">Perjanjian JFA</h3>
                <div class="mt-6 p-6 bg-slate-50 rounded-3xl border border-slate-100">
                    <p class="text-sm text-slate-600 leading-relaxed italic">
                        "Dengan ini saya setuju jika barang <span class="font-bold text-red-600 uppercase">RUSAK</span> wajib mengganti <span class="text-slate-900 font-black">50%</span> dari harga alat, dan jika <span class="font-bold text-red-600 uppercase">HILANG</span> wajib mengganti <span class="text-slate-900 font-black">100%</span> dari harga alat."
                    </p>
                </div>
            </div>
            <div class="mt-10 flex gap-3">
                <button type="button" onclick="closeModal()" class="flex-1 py-4 bg-slate-100 hover:bg-slate-200 text-slate-500 rounded-2xl font-bold transition-all">
                    Batal
                </button>
                <button type="button" onclick="confirmSubmit()" class="flex-1 py-4 bg-blue-600 hover:bg-blue-700 text-white rounded-2xl font-black shadow-lg shadow-blue-200 transition-all">
                    SAYA SETUJU
                </button>
            </div>
        </div>

        <div id="successState" class="hidden py-10 text-center">
            <div class="checkmark-wrapper mb-6">
                <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                    <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none"/>
                    <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"/>
                </svg>
            </div>
            <h3 class="text-3xl font-black text-slate-900">BERHASIL!</h3>
            <p class="text-slate-500 mt-2">Permintaan sedang dikirim...</p>
            <div class="mt-8 flex justify-center">
                <div class="w-12 h-1 bg-slate-100 rounded-full overflow-hidden">
                    <div id="progressBar" class="h-full bg-blue-600 w-0 transition-all duration-[3000ms] ease-linear"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* CSS Animasi tetap sama */
.checkmark__circle { stroke-dasharray: 166; stroke-dashoffset: 166; stroke-width: 2; stroke-miterlimit: 10; stroke: #2563eb; fill: none; animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards; }
.checkmark { width: 80px; height: 80px; border-radius: 50%; display: block; stroke-width: 3; stroke: #fff; stroke-miterlimit: 10; margin: 0 auto; box-shadow: inset 0px 0px 0px #2563eb; animation: fill .4s ease-in-out .4s forwards, scale .3s ease-in-out .9s both; }
.checkmark__check { transform-origin: 50% 50%; stroke-dasharray: 48; stroke-dashoffset: 48; animation: stroke 0.3s cubic-bezier(0.65, 0, 0.45, 1) 0.8s forwards; }
@keyframes stroke { 100% { stroke-dashoffset: 0; } }
@keyframes scale { 0%, 100% { transform: none; } 50% { transform: scale3d(1.1, 1.1, 1); } }
@keyframes fill { 100% { box-shadow: inset 0px 0px 0px 40px #2563eb; } }
body.modal-open { overflow: hidden; }
</style>

<script>
// LOGIKA PEMBATASAN TANGGAL (4 HARI)
document.addEventListener('DOMContentLoaded', function() {
    const dateInput = document.getElementById('return_date');
    const today = new Date();
    
    // Minimal: Hari ini
    const min = today.toISOString().split('T')[0];
    
    // Maksimal: 4 hari ke depan
    const maxDate = new Date();
    maxDate.setDate(today.getDate() + 4);
    const max = maxDate.toISOString().split('T')[0];
    
    dateInput.min = min;
    dateInput.max = max;
});

function openModal() {
    const textarea = document.querySelector('textarea[name="initial_condition"]');
    const dateInput = document.querySelector('input[name="return_date"]');
    
    if(textarea.value.trim() === "" || dateInput.value === "") {
        alert("Harap isi kondisi alat dan tanggal pengembalian!");
        return;
    }
    document.getElementById('modalAgreement').classList.remove('hidden');
    document.body.classList.add('modal-open');
}

function closeModal() {
    document.getElementById('modalAgreement').classList.add('hidden');
    document.body.classList.remove('modal-open');
}

function confirmSubmit() {
    const agreementState = document.getElementById('agreementState');
    const successState = document.getElementById('successState');
    const progressBar = document.getElementById('progressBar');
    const form = document.getElementById('checkoutForm');

    agreementState.classList.add('hidden');
    successState.classList.remove('hidden');
    
    setTimeout(() => { progressBar.style.width = '100%'; }, 100);

    const formData = new FormData(form);
    
    fetch('index.php?page=process_checkout', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        setTimeout(() => {
            window.location.href = 'index.php?page=dashboard';
        }, 3000);
    })
    .catch(error => {
        alert("Terjadi kesalahan.");
        closeModal();
    });
}
</script>