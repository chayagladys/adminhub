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
    $id_negara = $_GET['id'];

    // Prepare and execute delete statement
    $stmt = $pdo->prepare("DELETE FROM negara WHERE id_negara = ?");
    $stmt->execute([$id_negara]);

    // Redirect to manage negara page with success message
    $_SESSION['success'] = "Country deleted successfully!";
    header('Location: index.php'); // Redirect to the manage negara page
    exit;
} else {
    // Redirect to manage negara page with error message if ID not found
    $_SESSION['error'] = "Country ID not found!";
    header('Location: index.php');
    exit;
}
?>
