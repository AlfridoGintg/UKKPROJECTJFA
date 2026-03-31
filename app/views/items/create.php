<div class="max-w-3xl mx-auto px-6 py-10">
    <a href="index.php?page=items" class="text-slate-400 hover:text-slate-600 text-sm flex items-center gap-2 mb-4 transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Kembali ke Katalog
    </a>

    <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-xl overflow-hidden">
        <div class="bg-slate-900 px-10 py-8">
            <h1 class="text-2xl font-bold text-white">Tambah Alat Produksi Baru</h1>
            <p class="text-slate-400 text-sm mt-1">Masukkan data alat produksi JFA ke dalam sistem inventaris.</p>
        </div>

        <form action="index.php?page=items_store" method="POST" enctype="multipart/form-data" class="p-10 space-y-6">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-bold text-slate-700 mb-2">Nama Barang</label>
                    <input type="text" name="name" id="name" required placeholder="Contoh: Cinema Camera 6K Pro"
                        class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-blue-500 block p-4 outline-none transition">
                </div>
                <div>
                    <label for="brand" class="block text-sm font-bold text-slate-700 mb-2">Merek / Brand</label>
                    <input type="text" name="brand" id="brand" required placeholder="Contoh: Blackmagic"
                        class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-blue-500 block p-4 outline-none transition">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="category_id" class="block text-sm font-bold text-slate-700 mb-2">Kategori</label>
                    <select name="category_id" id="category_id" required
                        class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-blue-500 block p-4 outline-none transition appearance-none">
                        <option value="">Pilih Kategori</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label for="condition_status" class="block text-sm font-bold text-slate-700 mb-2">Kondisi Awal</label>
                    <select name="condition_status" id="condition_status" required
                        class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-blue-500 block p-4 outline-none transition appearance-none">
                        <option value="Baik">✅ Baik (Siap Digunakan)</option>
                        <option value="Rusak">⚠️ Rusak (Butuh Perbaikan)</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="stock" class="block text-sm font-bold text-slate-700 mb-2">Jumlah Stok</label>
                    <input type="number" name="stock" id="stock" required min="1" value="1"
                        class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-blue-500 block p-4 outline-none transition">
                </div>
                <div>
                    <label for="purchase_price" class="block text-sm font-bold text-slate-700 mb-2">Harga Beli (Rp) - Untuk hitung denda</label>
                    <input type="number" name="purchase_price" id="purchase_price" required min="0" placeholder="Contoh: 39000000"
                        class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-blue-500 block p-4 outline-none transition">
                </div>
            </div>

            <div>
                <label for="image" class="block text-sm font-bold text-slate-700 mb-2">Foto Barang</label>
                <input type="file" name="image" id="image" accept="image/*"
                    class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-blue-500 block p-3 outline-none transition file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            </div>

            <div class="pt-6 border-t border-slate-100 flex gap-4">
                <button type="submit" class="flex-1 bg-blue-600 text-white py-4 rounded-2xl font-bold hover:bg-blue-700 shadow-lg shadow-blue-100 transition-all">
                    Simpan Barang Baru
                </button>
            </div>
        </form>
    </div>
</div>