<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['level']) || ($_SESSION['level'] != 'admin' && $_SESSION['level'] != 'superadmin')) {
    header('Location: ../index.php');
    exit;
}

$stmt = $pdo->query("SELECT kategori.id_kategori, kategori.nama_kategori, kategori.jumlah_kategori, jenis.nama_jenis 
                     FROM kategori 
                     JOIN jenis ON kategori.id_jenis = jenis.id_jenis");
$kategoris = $stmt->fetchAll();
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
    <title>Manage Kategori</title>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Manage Kategori</h1>
        <div class="text-right mb-3">
            <a href="tambah.php" class="btn btn-success">Add Kategori</a>
            <a href="../index.php" class="btn btn-secondary">Back</a>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Jenis</th>
                    <th>Nama Kategori</th>
                    <th>Jumlah Kategori</th>
                    <th>Operations</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($kategoris as $kategori): ?>
                    <tr>
                        <td><?= $kategori['id_kategori'] ?></td>
                        <td><?= htmlspecialchars($kategori['nama_jenis']) ?></td>
                        <td><?= htmlspecialchars($kategori['nama_kategori']) ?></td>
                        <td><?= htmlspecialchars($kategori['jumlah_kategori']) ?></td>
                        <td>
                            <a href="ubah.php?id=<?= $kategori['id_kategori'] ?>" class="btn btn-warning">Edit</a>
                            <a href="hapus.php?id=<?= $kategori['id_kategori'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this kategori?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>