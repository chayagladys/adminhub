<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['level']) || ($_SESSION['level'] != 'admin' && $_SESSION['level'] != 'superadmin')) {
    header('Location: ../index.php');
    exit;
}

$id_koleksi = $_GET['id'] ?? null;

if ($id_koleksi) {
    $stmt = $pdo->prepare("DELETE FROM koleksi WHERE id_koleksi = ?");
    $stmt->execute([$id_koleksi]);
    $_SESSION['success'] = "Koleksi deleted successfully!";
}

header('Location: index.php');
exit;
