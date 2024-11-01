<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['level']) || ($_SESSION['level'] != 'admin' && $_SESSION['level'] != 'superadmin')) {
    header('Location: ../index.php');
    exit;
}

$id_kategori = $_GET['id'] ?? null;

if ($id_kategori) {
    $stmt = $pdo->prepare("DELETE FROM kategori WHERE id_kategori = ?");
    $stmt->execute([$id_kategori]);

    $_SESSION['success'] = "Kategori deleted successfully!";
}

header('Location: index.php');
exit;
