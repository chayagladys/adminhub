<?php
session_start();
include '../db.php';

// Check if the user is authorized
if (!isset($_SESSION['level']) || ($_SESSION['level'] != 'admin' && $_SESSION['level'] != 'superadmin')) {
    header('Location: ../index.php');
    exit;
}

// Check if ID is provided
if (isset($_GET['id'])) {
    $id_pengunjung = $_GET['id'];

    // Prepare and execute delete statement
    $stmt = $pdo->prepare("DELETE FROM pengunjung WHERE id_pengunjung = ?");
    $stmt->execute([$id_pengunjung]);

    $_SESSION['success'] = "Visitor deleted successfully!";
    header('Location: index.php'); // Redirect to manage visitors page
    exit;
} else {
    $_SESSION['error'] = "Visitor ID not found!";
    header('Location: index.php');
    exit;
}
