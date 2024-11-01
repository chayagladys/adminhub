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
    $id_provinsi = $_GET['id'];

    // Prepare and execute delete statement
    $stmt = $pdo->prepare("DELETE FROM provinsi WHERE id_provinsi = ?");
    $stmt->execute([$id_provinsi]);

    // Redirect to manage provinces page with success message
    $_SESSION['success'] = "Province deleted successfully!";
    header('Location: index.php'); // Redirect to the manage provinces page
    exit;
} else {
    // Redirect to manage provinces page with error message if ID not found
    $_SESSION['error'] = "Province ID not found!";
    header('Location: index.php');
    exit;
}
