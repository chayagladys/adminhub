<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['level']) || ($_SESSION['level'] != 'admin' && $_SESSION['level'] != 'superadmin')) {
    header('Location: ../index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_jenis = $_POST['id_jenis'];
    $nama_jenis = $_POST['nama_jenis'];

    $stmt = $pdo->prepare("INSERT INTO jenis (id_jenis, nama_jenis) VALUES (?, ?)");
    $stmt->execute([$id_jenis, $nama_jenis]);

    $_SESSION['success'] = "Jenis added successfully!";
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
    <style>
        body {
            background-color: #f0f8ff;
        }
        h1 {
            color: #007bff;
        }
        .table {
            background-color: #ffffff;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-warning, .btn-danger {
            color: white;
        }
    </style>
    <title>Add Jenis</title>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Add Jenis</h1>
        <form method="POST" action="">
            <div class="form-group">
                <label for="id_jenis">Id Jenis</label>
                <input type="text" class="form-control" id="id_jenis" name="id_jenis" placeholder="id_jenis" value="J" required>
                <label for="nama_jenis">Nama Jenis</label>
                <input type="text" class="form-control" id="nama_jenis" name="nama_jenis" placeholder="nama_jenis" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Jenis</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>

</html>