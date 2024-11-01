<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['level']) || ($_SESSION['level'] != 'admin' && $_SESSION['level'] != 'superadmin')) {
    header('Location: ../index.php');
    exit;
}

$id_jenis = $_GET['id'] ?? null;

if ($id_jenis) {
    $stmt = $pdo->prepare("DELETE FROM jenis WHERE id_jenis = ?");
    $stmt->execute([$id_jenis]);

    $_SESSION['success'] = "Jenis deleted successfully!";
}

header('Location: index.php');
exit;
