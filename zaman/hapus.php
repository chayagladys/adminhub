<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['level']) || ($_SESSION['level'] != 'admin' && $_SESSION['level'] != 'superadmin')) {
    header('Location: ../index.php');
    exit;
}

$id_zaman = $_GET['id'] ?? null;

if ($id_zaman) {
    $stmt = $pdo->prepare("DELETE FROM zaman WHERE id_zaman = ?");
    $stmt->execute([$id_zaman]);

    $_SESSION['success'] = "Zaman deleted successfully!";
}

header('Location: index.php');
exit;
