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
    $id_museum = $_GET['id'];

    // Prepare and execute delete statement
    $stmt = $pdo->prepare("DELETE FROM museum WHERE id_museum = ?");
    $stmt->execute([$id_museum]);

    $_SESSION['success'] = "Museum deleted successfully!";
    header('Location: index.php'); // Redirect to manage museums page
    exit;
} else {
    $_SESSION['error'] = "Museum ID not found!";
    header('Location: index.php');
    exit;
}
