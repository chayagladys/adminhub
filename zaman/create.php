<?php
session_start();
include '../db.php';

if (!isset($_SESSION['level']) || ($_SESSION['level'] != 'admin' && $_SESSION['level'] != 'superadmin')) {
    header('Location: ../index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_zaman = $_POST['nama_zaman'];
    $tahun = $_POST['tahun'];

    $stmt = $pdo->prepare("INSERT INTO zaman (nama_zaman, tahun) VALUES (?, ?)");
    $stmt->execute([$nama_zaman, $tahun]);

    $_SESSION['success'] = "Zaman added successfully!";
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
    <title>Add Zaman</title>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Add Zaman</h1>
        <form method="POST" action="">
            <div class="form-group">
                <label for="nama_zaman">Nama Zaman</label>
                <input type="text" class="form-control" id="nama_zaman" name="nama_zaman" required>
            </div>
            <div class="form-group">
                <label for="tahun">Tahun</label>
                <input type="number" class="form-control" id="tahun" name="tahun" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Zaman</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>

</html>