<?php
session_start();
include '../db.php';

if (!isset($_SESSION['level']) || ($_SESSION['level'] != 'admin' && $_SESSION['level'] != 'superadmin')) {
    header('Location: ../index.php');
    exit;
}

$id_nota = $_GET['id'] ?? null;

if ($id_nota) {
    $stmt = $pdo->prepare("DELETE FROM nota WHERE id_nota = ?");
    $stmt->execute([$id_nota]);

    $_SESSION['success'] = "Nota deleted successfully!";
}

header('Location: index.php');
exit;
