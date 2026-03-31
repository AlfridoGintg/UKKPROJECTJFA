<?php

class Loan {
    private $db;

    // Tambahkan parameter $pdo di sini agar model bisa mengenali koneksi database
    public function __construct($pdo) {
        $this->db = $pdo; 
    }

    // 1. Ambil data dengan JOIN (Untuk Petugas)
    public function getAllLoansWithDetails() {
        $query = "SELECT l.*, u.username as student_name, i.name as item_name, i.purchase_price 
                  FROM loans l
                  LEFT JOIN users u ON l.user_id = u.id
                  LEFT JOIN items i ON l.item_id = i.id
                  ORDER BY l.created_at DESC";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 2. Update Status (Terima/Tolak)
    public function updateStatus($id, $status) {
        $stmt = $this->db->prepare("UPDATE loans SET status = ? WHERE id = ?");
        return $stmt->execute([$status, $id]);
    }

    // 3. Logic Buat Pinjaman (Checkout)
    public function createLoan($userId, $itemId, $initialCondition) {
        try {
            $this->db->beginTransaction();

            $stmt = $this->db->prepare("INSERT INTO loans (user_id, item_id, status, condition_start, created_at) VALUES (?, ?, 'pending', ?, NOW())");
            $stmt->execute([$userId, $itemId, $initialCondition]);
            
            $loanId = $this->db->lastInsertId();

            $this->db->commit();
            return $loanId;
        } catch (Exception $e) {
            if($this->db->inTransaction()) $this->db->rollBack();
            return false;
        }
    }

    /**
     * 4. Proses Pengembalian & Hitung Denda
     * Sinkronisasi Logika Stok Baru:
     * - Kondisi 'Baik': Stok +1
     * - Kondisi 'Rusak': Stok tetap, status item berubah 'Rusak'
     * - Kondisi 'Hilang': Stok tetap, denda 100%
     */
    public function processReturn($loanId, $finalCondition) {
        try {
            $this->db->beginTransaction();

            // Ambil harga barang untuk hitung denda
            $stmt = $this->db->prepare("SELECT i.purchase_price, i.id as item_id 
                                        FROM items i 
                                        JOIN loans l ON i.id = l.item_id 
                                        WHERE l.id = ?");
            $stmt->execute([$loanId]);
            $item = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$item) {
                throw new Exception("Data peminjaman tidak ditemukan.");
            }

            // Hitung Denda (50% rusak, 100% hilang)
            $denda = 0;
            if ($finalCondition === 'Rusak') $denda = $item['purchase_price'] * 0.5;
            if ($finalCondition === 'Hilang') $denda = $item['purchase_price'] * 1.0;

            // Simpan perubahan ke tabel loans
            $stmt = $this->db->prepare("UPDATE loans SET 
                                        status = 'returned', 
                                        condition_end = ?, 
                                        fine = ?, 
                                        returned_at = NOW() 
                                        WHERE id = ?");
            $stmt->execute([$finalCondition, $denda, $loanId]);

            // --- LOGIKA PERBAIKAN STOK ---
            
            // Tambahkan stok HANYA JIKA mahasiswa mengembalikan dengan kondisi Baik
            if ($finalCondition === 'Baik') {
                $stmt = $this->db->prepare("UPDATE items SET stock = stock + 1 WHERE id = ?");
                $stmt->execute([$item['item_id']]);
            } 
            // Jika dikembalikan Rusak, stok TIDAK NAIK, namun ubah status barang menjadi Rusak di Master Items
            elseif ($finalCondition === 'Rusak') {
                $stmt = $this->db->prepare("UPDATE items SET condition_status = 'Rusak' WHERE id = ?");
                $stmt->execute([$item['item_id']]);
            }
            // Jika Hilang, stok tidak bertambah (biarkan saja sesuai referensi)

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            if($this->db->inTransaction()) $this->db->rollBack();
            return false;
        }
    }
}