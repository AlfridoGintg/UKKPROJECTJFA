<div class="max-w-7xl mx-auto px-6 py-10">
    <div class="flex justify-between items-center mb-10">
        <div>
            <h1 class="text-3xl font-black text-slate-900 uppercase tracking-tight">Manajemen <span class="text-blue-600">User</span></h1>
            <p class="text-slate-500 mt-2">Tambah atau kelola akses Mahasiswa dan Petugas.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-200 shadow-sm h-fit">
            <h2 class="text-xl font-bold text-slate-800 mb-6">Tambah Akun Baru</h2>
            <form action="index.php?page=users_store" method="POST" class="space-y-4">
                <div>
                    <label class="block text-xs font-black uppercase text-slate-400 mb-2">Username</label>
                    <input type="text" name="username" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 outline-none transition">
                </div>
                <div>
                    <label class="block text-xs font-black uppercase text-slate-400 mb-2">Password</label>
                    <input type="password" name="password" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 outline-none transition">
                </div>
                <div>
                    <label class="block text-xs font-black uppercase text-slate-400 mb-2">Role</label>
                    <select name="role" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 outline-none transition">
                        <option value="mahasiswa">Mahasiswa</option>
                        <option value="petugas">Petugas</option>
                    </select>
                </div>
                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-xl transition shadow-lg shadow-blue-200">
                    Simpan User
                </button>
            </form>
        </div>

        <div class="lg:col-span-2 bg-white rounded-[2.5rem] border border-slate-200 shadow-sm overflow-hidden">
            <table class="w-full text-left">
                <thead class="bg-slate-50/50 border-b border-slate-100">
                    <tr class="text-[10px] font-black text-slate-400 uppercase tracking-widest">
                        <th class="px-8 py-4">Username</th>
                        <th class="px-8 py-4">Role</th>
                        <th class="px-8 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php foreach ($users as $user): ?>
                        <tr class="hover:bg-slate-50/30 transition">
                            <td class="px-8 py-5 font-bold text-slate-800"><?= htmlspecialchars($user['username']) ?></td>
                            <td class="px-8 py-5">
                                <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase <?= $user['role'] === 'petugas' ? 'bg-purple-100 text-purple-600' : 'bg-blue-100 text-blue-600' ?>">
                                    <?= $user['role'] ?>
                                </span>
                            </td>
                            <td class="px-8 py-5 text-right">
                                <a href="index.php?page=users_delete&id=<?= $user['id'] ?>" 
                                   onclick="return confirm('Hapus user ini?')"
                                   class="text-red-500 hover:text-red-700 font-bold text-xs uppercase tracking-widest">
                                    Hapus
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>