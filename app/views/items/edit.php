<div class="max-w-3xl mx-auto px-6 py-10">
    <a href="index.php?page=items" class="text-slate-400 hover:text-slate-600 text-sm flex items-center gap-2 mb-4 transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        Kembali ke Katalog
    </a>

    <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-xl overflow-hidden">
        <div class="bg-slate-900 px-10 py-8">
            <h1 class="text-2xl font-bold text-white">Update Kondisi Barang</h1>
            <p class="text-slate-400 text-sm mt-1">Kelola status kelayakan alat produksi JFA secara manual.</p>
        </div>

        <form action="index.php?page=items_update" method="POST" class="p-10 space-y-6">
            
            <input type="hidden" name="id" value="<?= $item['id'] ?>">
            
            <input type="hidden" name="name" value="<?= htmlspecialchars($item['name']) ?>">
            <input type="hidden" name="brand" value="<?= htmlspecialchars($item['brand']) ?>">
            <input type="hidden" name="category_id" value="<?= $item['category_id'] ?>">
            <input type="hidden" name="purchase_price" value="<?= $item['purchase_price'] ?>">

            <div class="grid grid-cols-2 gap-4 p-5 bg-slate-50 rounded-2xl border border-slate-100">
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest">Nama Barang</label>
                    <p class="font-bold text-slate-700 text-lg"><?= htmlspecialchars($item['name']) ?></p>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest">Brand</label>
                    <p class="font-bold text-slate-700 text-lg"><?= htmlspecialchars($item['brand']) ?></p>
                </div>
            </div>

            <div>
                <label for="condition_status" class="block text-sm font-bold text-slate-700 mb-2">Status Kondisi</label>
                <select name="condition_status" id="condition_status" 
                    class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-blue-500 block p-4 outline-none transition appearance-none">
                    <option value="Baik" <?= $item['condition_status'] === 'Baik' ? 'selected' : '' ?>>✅ Baik (Siap Digunakan)</option>
                    <option value="Rusak" <?= $item['condition_status'] === 'Rusak' ? 'selected' : '' ?>>⚠️ Rusak (Butuh Perbaikan)</option>
                </select>
                <p class="mt-2 text-[11px] text-slate-400 italic">
                    *Status ini akan menentukan apakah mahasiswa dikenakan denda jika mengembalikan dalam kondisi berbeda.
                </p>
            </div>

            <div>
                <label for="stock" class="block text-sm font-bold text-slate-700 mb-2">Update Stok Gudang</label>
                <input type="number" name="stock" id="stock" value="<?= $item['stock'] ?>"
                    class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-blue-500 block p-4 outline-none transition">
            </div>

            <div class="pt-6 border-t border-slate-100 flex gap-4">
                <button type="submit" class="flex-1 bg-blue-600 text-white py-4 rounded-2xl font-bold hover:bg-blue-700 shadow-lg shadow-blue-100 transition-all">
                    Simpan Perubahan
                </button>
                <a href="index.php?page=items" class="flex-1 text-center bg-slate-100 text-slate-600 py-4 rounded-2xl font-bold hover:bg-slate-200 transition-all">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>