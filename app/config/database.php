<?php
$host = "localhost";
$db   = "jfa_inventory"; // Pastikan nama ini sama dengan yang dibuat di phpMyAdmin
$user = "root";          // Default XAMPP adalah root
$pass = "";              // Default XAMPP adalah kosong

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database Error: " . $e->getMessage());
}