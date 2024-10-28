<?php
session_start();
include '../db.php';


if (!isset($_SESSION['level']) || ($_SESSION['level'] != 'admin' && $_SESSION['level'] != 'superadmin')) {
    header('Location: ../index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_negara = $_POST['nama_negara'];

    $stmt = $pdo->prepare("INSERT INTO negara (nama_negara) VALUES (?)");
    $stmt->execute([$nama_negara]);

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
    <title>Add Country</title>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Add Country</h1>
        <form method="POST" action="">
            <div class="form-group">
                <label for="nama_negara">Country Name</label>
                <input type="text" class="form-control" id="nama_negara" name="nama_negara" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Country</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>

</html>