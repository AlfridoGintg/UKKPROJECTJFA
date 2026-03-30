<div class="max-w-4xl mx-auto px-6 py-10">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900">Kelola Kategori</h1>
            <p class="text-slate-500 text-sm mt-1">Daftar kategori alat produksi JFA.</p>
        </div>
        <a href="index.php?page=categories_create" class="bg-blue-600 text-white px-6 py-3 rounded-2xl font-bold hover:bg-blue-700 shadow-lg shadow-blue-200 transition-all flex items-center gap-2">
            + Tambah Kategori
        </a>
    </div>

    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-200 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead class="bg-slate-50 border-b border-slate-100 text-xs uppercase tracking-widest text-slate-500">
                <tr>
                    <th class="p-5 font-bold w-20 text-center">ID</th>
                    <th class="p-5 font-bold">Nama Kategori</th>
                    <th class="p-5 font-bold text-center w-40">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm">
                <?php if (!empty($categories)): ?>
                    <?php foreach ($categories as $cat): ?>
                        <tr class="hover:bg-slate-50/50">
                            <td class="p-5 text-center font-bold text-slate-400">#<?= $cat['id'] ?></td>
                            <td class="p-5 font-bold text-slate-700"><?= htmlspecialchars($cat['name']) ?></td>
                            <td class="p-5 text-center">
                                <div class="flex justify-center gap-2">
                                    <a href="index.php?page=categories_edit&id=<?= $cat['id'] ?>" class="bg-yellow-100 text-yellow-700 hover:bg-yellow-200 px-3 py-1.5 rounded-lg text-[10px] font-bold uppercase transition">Edit</a>
                                    <a href="index.php?page=categories_delete&id=<?= $cat['id'] ?>" onclick="return confirm('Hapus kategori ini?')" class="bg-red-100 text-red-600 hover:bg-red-200 px-3 py-1.5 rounded-lg text-[10px] font-bold uppercase transition">Hapus</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="3" class="p-10 text-center text-slate-500 italic">Belum ada kategori.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>