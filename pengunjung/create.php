<?php
session_start();
include '../db.php';

// Check if the user is authorized
if (!isset($_SESSION['level']) || ($_SESSION['level'] != 'admin' && $_SESSION['level'] != 'superadmin')) {
    header('Location: ../index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $no_telp = $_POST['no_telp'];
    $nama = $_POST['nama'];

    $stmt = $pdo->prepare("INSERT INTO pengunjung (email, no_telp, nama) VALUES (?, ?, ?)");
    $stmt->execute([$email, $no_telp, $nama]);

    $_SESSION['success'] = "Visitor added successfully!";
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
    <title>Add Visitor</title>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Add Visitor</h1>
        <form method="POST" action="">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="no_telp">Contact Number</label>
                <input type="text" class="form-control" id="no_telp" name="no_telp" required>
            </div>
            <div class="form-group">
                <label for="nama">Name</label>
                <input type="text" class="form-control" id="nama" name="nama" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Visitor</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>

</html>