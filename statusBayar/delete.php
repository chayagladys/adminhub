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
    $id_status = $_GET['id'];

    // Prepare and execute delete statement
    $stmt = $pdo->prepare("DELETE FROM status_bayar WHERE id_status = ?");
    $stmt->execute([$id_status]);

    $_SESSION['success'] = "Payment status deleted successfully!";
    header('Location: index.php'); // Redirect to manage payment statuses page
    exit;
} else {
    $_SESSION['error'] = "Payment status ID not found!";
    header('Location: index.php');
    exit;
}
