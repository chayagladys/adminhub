<?php
session_start();
include '../koneksi.php';

// Check if the user is authorized
if (!isset($_SESSION['level']) || ($_SESSION['level'] != 'admin' && $_SESSION['level'] != 'superadmin')) {
    header('Location: ../index.php');
    exit;
}

// Check if ID is provided
if (isset($_GET['id'])) {
    $id_kota = $_GET['id'];

    // Prepare and execute delete statement
    $stmt = $pdo->prepare("DELETE FROM kota WHERE id_kota = ?");
    $stmt->execute([$id_kota]);

    $_SESSION['success'] = "City deleted successfully!";
    header('Location: index.php'); // Redirect to manage cities page
    exit;
} else {
    $_SESSION['error'] = "City ID not found!";
    header('Location: index.php');
    exit;
}
