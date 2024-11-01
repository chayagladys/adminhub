<?php
try {
    // Sesuaikan `db_name`, `username`, dan `password` dengan pengaturan database Anda
    $pdo = new PDO('mysql:host=localhost;dbname=museum__3_', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi ke database gagal: " . $e->getMessage());
}
?>