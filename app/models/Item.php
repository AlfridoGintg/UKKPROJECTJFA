<?php

require_once '../app/core/Model.php';

class Item extends Model {

    protected $table = "items";

    // Fungsi untuk mengambil SEMUA barang beserta nama kategorinya
    public function getAllWithCategory()
    {
        // Kita gunakan JOIN ke tabel categories untuk mengambil kolom 'name' kategori
        $sql = "SELECT items.*, categories.name as category_name 
                FROM items 
                JOIN categories ON items.category_id = categories.id 
                ORDER BY items.id DESC";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByCategory($category_id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM items WHERE category_id = ?");
        $stmt->execute([$category_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}