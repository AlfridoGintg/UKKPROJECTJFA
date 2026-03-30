<div class="max-w-xl mx-auto px-6 py-10">
    <a href="index.php?page=categories" class="text-slate-400 hover:text-slate-600 text-sm flex items-center gap-2 mb-4 transition">
        &larr; Kembali
    </a>

    <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-xl overflow-hidden">
        <div class="bg-slate-900 px-10 py-6">
            <h1 class="text-xl font-bold text-white">Tambah Kategori Baru</h1>
        </div>

        <form action="index.php?page=categories_store" method="POST" class="p-10 space-y-6">
            <div>
                <label for="name" class="block text-sm font-bold text-slate-700 mb-2">Nama Kategori</label>
                <input type="text" name="name" id="name" required placeholder="Misal: Tripod, Gimbal, Memory Card"
                    class="w-full bg-slate-50 border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-blue-500 block p-4 outline-none transition">
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white py-4 rounded-2xl font-bold hover:bg-blue-700 shadow-lg shadow-blue-100 transition-all">
                Simpan Kategori
            </button>
        </form>
    </div>
</div>