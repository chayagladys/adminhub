<?php
session_start();
include '../db.php';

// Check if the user is authorized
if (!isset($_SESSION['level']) || ($_SESSION['level'] != 'admin' && $_SESSION['level'] != 'superadmin')) {
    header('Location: ../index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $status = $_POST['status'];

    $stmt = $pdo->prepare("INSERT INTO status_bayar (status) VALUES (?)");
    $stmt->execute([$status]);

    $_SESSION['success'] = "Payment status added successfully!";
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Add Payment Status</title>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Add Payment Status</h1>
        <form method="POST" action="">
            <div class="form-group">
                <label for="status">Status</label>
                <input type="text" class="form-control" id="status" name="status" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Payment Status</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>

</html>