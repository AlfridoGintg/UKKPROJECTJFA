<?php
require_once BASE_PATH . '/app/helpers/auth.php';

class LoanController {
    
    /**
     * Helper untuk mengecek role admin
     */
    private function isAdmin() {
        return (check() && $_SESSION['role'] === 'admin');
    }

    /**
     * PETUGAS/ADMIN: Melihat antrean approval, peminjaman aktif, dan riwayat
     */
    public function approvals($pdo) {
        if (!check() || !in_array($_SESSION['role'], ['admin', 'petugas'])) {
            header("Location: index.php?page=dashboard");
            exit;
        }

        // 1. Antrean Approval (Status 'pending' saja)
        $stmtPending = $pdo->query("SELECT l.*, u.username, i.name as item_name 
                                    FROM loans l 
                                    LEFT JOIN users u ON l.user_id = u.id 
                                    LEFT JOIN items i ON l.item_id = i.id 
                                    WHERE l.status = 'pending' 
                                    ORDER BY l.created_at DESC");
        $pending_loans = $stmtPending->fetchAll(PDO::FETCH_ASSOC);

        // 2. Peminjaman Aktif (Sedang dibawa atau proses kembali)
        $stmtAktif = $pdo->query("SELECT l.*, u.username, i.name as item_name, i.brand 
                                  FROM loans l 
                                  LEFT JOIN users u ON l.user_id = u.id 
                                  LEFT JOIN items i ON l.item_id = i.id 
                                  WHERE l.status IN ('borrowed', 'return_pending')
                                  ORDER BY l.return_date ASC");
        $active_loans = $stmtAktif->fetchAll(PDO::FETCH_ASSOC);

        // 3. Seluruh Riwayat Peminjaman (Semua status)
        $stmtRiwayat = $pdo->query("SELECT l.*, u.username, i.name as item_name 
                                    FROM loans l 
                                    LEFT JOIN users u ON l.user_id = u.id 
                                    LEFT JOIN items i ON l.item_id = i.id 
                                    ORDER BY l.created_at DESC");
        $all_history = $stmtRiwayat->fetchAll(PDO::FETCH_ASSOC);
        
        ob_start();
        require BASE_PATH . '/app/views/admin/approvals.php';
        $content = ob_get_clean();
        require BASE_PATH . '/app/views/layouts/main.php';
    }

    /**
     * ADMIN ONLY: Log Pelanggaran & Denda
     */
    public function fines($pdo) {
        if (!$this->isAdmin()) {
            header("Location: index.php?page=dashboard");
            exit;
        }

        // Mengambil data peminjaman yang memiliki denda (Rusak/Hilang)
        $stmt = $pdo->query("SELECT l.*, u.username as student_name, i.name as item_name 
                             FROM loans l 
                             JOIN users u ON l.user_id = u.id 
                             JOIN items i ON l.item_id = i.id 
                             WHERE l.fine > 0 
                             ORDER BY l.returned_at DESC");
        $fines = $stmt->fetchAll(PDO::FETCH_ASSOC);

        ob_start();
        ?>
        <div class="max-w-7xl mx-auto px-6 py-10">
            <h1 class="text-3xl font-black text-slate-900 mb-6 uppercase tracking-tight">Log Pelanggaran & <span class="text-red-600">Denda</span></h1>
            <div class="bg-white rounded-[2.5rem] border border-slate-200 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-slate-50 border-b border-slate-100">
                            <tr class="text-[10px] font-black text-slate-400 uppercase tracking-widest">
                                <th class="px-8 py-5">Mahasiswa</th>
                                <th class="px-8 py-5">Item</th>
                                <th class="px-8 py-5">Kondisi Akhir</th>
                                <th class="px-8 py-5 text-right">Total Denda</th>
                                <th class="px-8 py-5 text-right">Tgl Kembali</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <?php if (!empty($fines)): foreach ($fines as $f): ?>
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="px-8 py-5 font-bold text-slate-800"><?= htmlspecialchars($f['student_name']) ?></td>
                                <td class="px-8 py-5 text-slate-700"><?= htmlspecialchars($f['item_name']) ?></td>
                                <td class="px-8 py-5">
                                    <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase <?= $f['condition_end'] == 'Hilang' ? 'bg-red-100 text-red-600' : 'bg-orange-100 text-orange-600' ?>">
                                        <?= htmlspecialchars($f['condition_end']) ?>
                                    </span>
                                </td>
                                <td class="px-8 py-5 text-right font-black text-red-600">Rp <?= number_format($f['fine'], 0, ',', '.') ?></td>
                                <td class="px-8 py-5 text-right text-xs text-slate-400"><?= date('d/m/Y', strtotime($f['returned_at'])) ?></td>
                            </tr>
                            <?php endforeach; else: ?>
                                <tr><td colspan="5" class="px-8 py-10 text-center text-slate-400 italic">Belum ada catatan denda.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php
        $content = ob_get_clean();
        require BASE_PATH . '/app/views/layouts/main.php';
    }

    /**
     * MAHASISWA: Proses simpan peminjaman (Store)
     */
    public function store($pdo) {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') exit;

        $user_id = $_SESSION['user_id'];
        $item_id = filter_input(INPUT_POST, 'item_id', FILTER_VALIDATE_INT);
        $condition = htmlspecialchars($_POST['initial_condition'] ?? '', ENT_QUOTES, 'UTF-8');
        $return_date = htmlspecialchars($_POST['return_date'] ?? '', ENT_QUOTES, 'UTF-8');

        $today = new DateTime(date('Y-m-d'));
        $returning = new DateTime($return_date);
        $interval = $today->diff($returning);
        $diff = $interval->days;

        if ($diff > 4 || $returning < $today || $interval->invert == 1) {
            die("<script>alert('Error: Durasi peminjaman maksimal 4 hari atau format tanggal salah.'); history.back();</script>");
        }

        $stmt = $pdo->prepare("SELECT stock FROM items WHERE id = ?");
        $stmt->execute([$item_id]);
        $item = $stmt->fetch();

        if (!$item || $item['stock'] <= 0) {
            die("<script>alert('Error: Stok barang sudah habis.'); history.back();</script>");
        }

        try {
            $stmt = $pdo->prepare("INSERT INTO loans (user_id, item_id, return_date, status, condition_start, created_at) VALUES (?, ?, ?, 'pending', ?, NOW())");
            $stmt->execute([$user_id, $item_id, $return_date, $condition]);
            header("Location: index.php?page=dashboard&status=success");
            exit;
        } catch (Exception $e) {
            die("Gagal: " . $e->getMessage());
        }
    }

    /**
     * PETUGAS/ADMIN: Approve Peminjaman
     */
    public function approve($pdo) {
        if (!in_array($_SESSION['role'], ['admin', 'petugas'])) exit;
        $loan_id = filter_input(INPUT_POST, 'loan_id', FILTER_VALIDATE_INT);

        try {
            $pdo->beginTransaction();
            $qr = "JFA-" . strtoupper(substr(md5(uniqid()), 0, 6));
            
            $stmt = $pdo->prepare("SELECT item_id FROM loans WHERE id = ? AND status = 'pending'");
            $stmt->execute([$loan_id]);
            $loan = $stmt->fetch();

            if ($loan) {
                $pdo->prepare("UPDATE loans SET status = 'approved', qr_code = ?, pickup_code = ? WHERE id = ?")
                    ->execute([$qr, $qr, $loan_id]);
                $pdo->prepare("UPDATE items SET stock = stock - 1 WHERE id = ?")
                    ->execute([$loan['item_id']]);
            }

            $pdo->commit();
            header("Location: index.php?page=approvals&status=approved");
            exit;
        } catch (Exception $e) {
            $pdo->rollBack();
            die($e->getMessage());
        }
    }

    /**
     * PETUGAS: Proses Pickup
     */
    public function pickup($pdo) {
        if (!in_array($_SESSION['role'], ['admin', 'petugas'])) exit;
        $loan_id = filter_input(INPUT_POST, 'loan_id', FILTER_VALIDATE_INT);

        $stmt = $pdo->prepare("SELECT created_at, return_date FROM loans WHERE id = ?");
        $stmt->execute([$loan_id]);
        $loan = $stmt->fetch();

        if ($loan) {
            $created = new DateTime(date('Y-m-d', strtotime($loan['created_at'])));
            $returning = new DateTime($loan['return_date']);
            $diff = $created->diff($returning)->days;
            $new_return_date = date('Y-m-d', strtotime("+$diff days"));

            $stmt = $pdo->prepare("UPDATE loans SET status = 'borrowed', start_date = NOW(), return_date = ? WHERE id = ? AND status = 'approved'");
            $stmt->execute([$new_return_date, $loan_id]);
        }
        header("Location: index.php?page=dashboard&status=picked_up");
        exit;
    }

    /**
     * PETUGAS: Verifikasi Pengembalian
     */
    public function returnItem($pdo) {
        if (!in_array($_SESSION['role'], ['admin', 'petugas'])) exit;
        
        $loan_id = filter_input(INPUT_POST, 'loan_id', FILTER_VALIDATE_INT);
        $kondisi = $_POST['condition'] ?? 'Baik';

        try {
            require_once BASE_PATH . '/app/models/Loan.php';
            $loanModel = new Loan($pdo);
            $success = $loanModel->processReturn($loan_id, $kondisi);

            if ($success) {
                header("Location: index.php?page=approvals&msg=returned_success");
                exit;
            } else {
                die("Gagal memproses pengembalian barang.");
            }
        } catch (PDOException $e) {
            die("Database Error: " . $e->getMessage());
        }
    }

    /**
     * SEMUA ROLE: Riwayat
     */
    public function history($pdo) {
        if (!check()) { header("Location: index.php?page=login"); exit; }
        $role = $_SESSION['role'];
        $user_id = $_SESSION['user_id'];

        $sql = "SELECT l.*, u.username as student_name, i.name as item_name FROM loans l JOIN users u ON l.user_id = u.id JOIN items i ON l.item_id = i.id ";
        if (!in_array($role, ['admin', 'petugas'])) { $sql .= " WHERE l.user_id = ? "; }
        $sql .= " ORDER BY l.created_at DESC";

        $stmt = $pdo->prepare($sql);
        in_array($role, ['admin', 'petugas']) ? $stmt->execute() : $stmt->execute([$user_id]);
        $history = $stmt->fetchAll(PDO::FETCH_ASSOC);

        ob_start();
        require BASE_PATH . '/app/views/history/index.php';
        $content = ob_get_clean();
        require BASE_PATH . '/app/views/layouts/main.php';
    }

    public function generateReport($pdo) {
        if (!check() || !in_array($_SESSION['role'], ['admin', 'petugas'])) {
            header("Location: index.php?page=dashboard");
            exit;
        }
        $stmt = $pdo->query("SELECT l.*, u.username, i.name as item_name, i.brand FROM loans l LEFT JOIN users u ON l.user_id = u.id LEFT JOIN items i ON l.item_id = i.id ORDER BY l.created_at DESC");
        $reportData = $stmt->fetchAll(PDO::FETCH_ASSOC);
        require BASE_PATH . '/app/views/admin/report_print.php';
    }

    /**
     * ADMIN ONLY: Menghapus item secara permanen (termasuk riwayatnya)
     */
    public function delete($pdo) {
        // Pastikan hanya admin yang bisa menghapus
        if (!$this->isAdmin()) {
            header("Location: index.php?page=items");
            exit;
        }

        $id = $_GET['id'] ?? 0;
        
        try {
            // Mulai transaksi database agar aman
            $pdo->beginTransaction();

            // 1. Hapus dulu riwayat di tabel loans yang merujuk ke item ini
            $stmtLoan = $pdo->prepare("DELETE FROM loans WHERE item_id = ?");
            $stmtLoan->execute([$id]);

            // 2. Hapus data utama di tabel items
            $stmt = $pdo->prepare("DELETE FROM items WHERE id = ?");
            $stmt->execute([$id]);

            // Simpan perubahan
            $pdo->commit();
            
            header("Location: index.php?page=items&msg=deleted");
        } catch (PDOException $e) {
            // Jika ada yang gagal, batalkan semua proses
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            die("Gagal menghapus barang: " . $e->getMessage());
        }
        exit;
    }

    /**
     * ADMIN ONLY: Menghapus record peminjaman (soft delete)
     */
    public function deleteLoan($pdo) {
        if (!$this->isAdmin()) exit;
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($id) {
            $pdo->prepare("DELETE FROM loans WHERE id = ?")->execute([$id]);
            header("Location: index.php?page=approvals&msg=deleted");
        }
        exit;
    }

    public function manage_returns($pdo) {
        if (!$this->isAdmin()) exit;

        $stmt = $pdo->query("SELECT l.*, u.username, i.name as item_name 
                             FROM loans l 
                             JOIN users u ON l.user_id = u.id 
                             JOIN items i ON l.item_id = i.id 
                             WHERE l.status = 'returned' 
                             ORDER BY l.returned_at DESC");
        $returns = $stmt->fetchAll(PDO::FETCH_ASSOC);

        ob_start();
        require BASE_PATH . '/app/views/admin/manage_returns.php';
        $content = ob_get_clean();
        require BASE_PATH . '/app/views/layouts/main.php';
    }

    public function delete_return($pdo) {
        if (!$this->isAdmin()) exit;
        $id = $_GET['id'] ?? 0;
        $pdo->prepare("DELETE FROM loans WHERE id = ?")->execute([$id]);
        header("Location: index.php?page=manage_returns&msg=deleted");
    }
}