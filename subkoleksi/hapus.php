<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['level']) || ($_SESSION['level'] != 'admin' && $_SESSION['level'] != 'superadmin')) {
    header('Location: ../index.php');
    exit;
}

$id_sub_koleksi = $_GET['id'] ?? null;

if ($id_sub_koleksi) {
    $stmt = $pdo->prepare("DELETE FROM sub_koleksi WHERE id_sub_koleksi = ?");
    $stmt->execute([$id_sub_koleksi]);
    $_SESSION['success'] = "Sub Koleksi deleted successfully!";
}

header('Location: index.php');
exit;
