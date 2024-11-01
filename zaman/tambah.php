<?php
session_start();
include '../koneksi.php';

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
    <title>Add Zaman</title>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Add Zaman</h1>
        <form method="POST" action="">
            <div class="form-group">
            <label for="id_zaman">Id Zaman</label>
            <input type="text" class="form-control" id="id_zaman" name="id_zaman" placeholder="id_zaman" value="Z" required>
                <label for="nama_zaman">Nama Zaman</label>
                <input type="text" class="form-control" id="nama_zaman" name="nama_zaman" placeholder="nama_zaman" required>
                <label for="tahun">Tahun</label>
                <input type="number" class="form-control" id="tahun" name="tahun" placeholder="tahunn" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Zaman</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>

</html>