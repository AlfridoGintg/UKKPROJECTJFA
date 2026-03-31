<div class="max-w-7xl mx-auto px-6 py-10">
    <div class="flex justify-between items-center mb-10">
        <div>
            <h1 class="text-3xl font-black text-slate-900 uppercase tracking-tight">Manajemen <span class="text-blue-600">User</span></h1>
            <p class="text-slate-500 mt-2">Tambah atau kelola akses Mahasiswa dan Petugas JFA.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="bg-white p-8 rounded-[2.5rem] border border-slate-200 shadow-sm h-fit">
            <h2 class="text-xl font-bold text-slate-800 mb-6">Tambah Akun Baru</h2>
            <form action="index.php?page=users_store" method="POST" class="space-y-4">
                <div>
                    <label class="block text-[10px] font-black uppercase text-slate-400 mb-2 ml-2">Nama Lengkap</label>
                    <input type="text" name="name" required placeholder="Nama Lengkap" 
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 outline-none transition bg-slate-50">
                </div>
                <div>
                    <label class="block text-[10px] font-black uppercase text-slate-400 mb-2 ml-2">Username / NIM</label>
                    <input type="text" name="username" required placeholder="Username" 
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 outline-none transition bg-slate-50">
                </div>
                <div>
                    <label class="block text-[10px] font-black uppercase text-slate-400 mb-2 ml-2">Password</label>
                    <input type="password" name="password" required placeholder="••••••••" 
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 outline-none transition bg-slate-50">
                </div>
                <div>
                    <label class="block text-[10px] font-black uppercase text-slate-400 mb-2 ml-2">Role Akses</label>
                    <select name="role" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-blue-500 outline-none transition bg-slate-50 appearance-none">
                        <option value="mahasiswa">Mahasiswa</option>
                        <option value="petugas">Petugas</option>
                    </select>
                </div>
                <button type="submit" class="w-full bg-slate-900 hover:bg-black text-white font-bold py-4 rounded-2xl transition shadow-xl shadow-slate-200 uppercase tracking-widest text-xs mt-4">
                    Simpan User Baru
                </button>
            </form>
        </div>

        <div class="lg:col-span-2 bg-white rounded-[2.5rem] border border-slate-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-slate-50/50 border-b border-slate-100">
                        <tr class="text-[10px] font-black text-slate-400 uppercase tracking-widest">
                            <th class="px-8 py-5">Info User</th>
                            <th class="px-8 py-5">Role</th>
                            <th class="px-8 py-5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <?php if (!empty($users)): foreach ($users as $user): ?>
                            <tr class="hover:bg-slate-50/30 transition">
                                <td class="px-8 py-5">
                                    <div class="font-bold text-slate-800"><?= htmlspecialchars($user['name'] ?: $user['username']) ?></div>
                                    <div class="text-[10px] text-slate-400 font-medium italic">@<?= htmlspecialchars($user['username']) ?></div>
                                </td>
                                <td class="px-8 py-5">
                                    <?php $roleColor = $user['role'] === 'petugas' ? 'bg-purple-100 text-purple-600' : 'bg-blue-100 text-blue-600'; ?>
                                    <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-tighter <?= $roleColor ?>">
                                        <?= $user['role'] ?>
                                    </span>
                                </td>
                                <td class="px-8 py-5 text-right">
                                    <a href="index.php?page=users_delete&id=<?= $user['id'] ?>" 
                                       onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')"
                                       class="text-red-500 hover:text-red-700 font-black text-[10px] uppercase tracking-widest transition">
                                        Hapus
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; else: ?>
                            <tr><td colspan="3" class="px-8 py-10 text-center text-slate-400 italic">Belum ada data user.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>