<?php
session_start();
include '../koneksi.php';

// Check if the user is authorized
if (!isset($_SESSION['level']) || ($_SESSION['level'] != 'admin' && $_SESSION['level'] != 'superadmin')) {
    header('Location: ../index.php');
    exit;
}

// Fetch cities from the database, joining with provinces
$stmt = $pdo->query("SELECT k.id_kota, k.nama_kota, p.nama_provinsi FROM kota k JOIN provinsi p ON k.id_provinsi = p.id_provinsi");
$kotas = $stmt->fetchAll();
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
    <title>Manage Cities</title>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Manage Cities</h1>
        <div class="text-right mb-3">
            <a href="tambah.php" class="btn btn-success">Add City</a>
            <a href="../index.php" class="btn btn-secondary">Back</a>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Province</th>
                    <th>Operation</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($kotas as $kota): ?>
                    <tr>
                        <td><?= $kota['id_kota'] ?></td>
                        <td><?= htmlspecialchars($kota['nama_kota']) ?></td>
                        <td><?= htmlspecialchars($kota['nama_provinsi']) ?></td>
                        <td>
                            <a href="ubah.php?id=<?= $kota['id_kota'] ?>" class="btn btn-warning">Edit</a>
                            <a href="hapus.php?id=<?= $kota['id_kota'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this city?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>