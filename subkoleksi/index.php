<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['level']) || ($_SESSION['level'] != 'admin' && $_SESSION['level'] != 'superadmin')) {
    header('Location: ../index.php');
    exit;
}

$stmt = $pdo->query("SELECT sub_koleksi.id_sub_koleksi, sub_koleksi.nama_sub_koleksi, sub_koleksi.deskripsi, koleksi.nama_koleksi, zaman.nama_zaman
                     FROM sub_koleksi
                     JOIN koleksi ON sub_koleksi.id_koleksi = koleksi.id_koleksi
                     JOIN zaman ON sub_koleksi.id_zaman = zaman.id_zaman");
$subKoleksis = $stmt->fetchAll();
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
    <title>Manage Sub Koleksi</title>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Manage Sub Koleksi</h1>
        <div class="text-right mb-3">
            <a href="tambah.php" class="btn btn-success">Add Sub Koleksi</a>
            <a href="../index.php" class="btn btn-secondary">Back</a>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>ID Sub Koleksi</th>
                    <th>Nama Sub Koleksi</th>
                    <th>Deskripsi</th>
                    <th>Koleksi</th>
                    <th>Zaman</th>
                    <th>Operations</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($subKoleksis as $subKoleksi): ?>
                    <tr>
                        <td><?= $subKoleksi['id_sub_koleksi'] ?></td>
                        <td><?= htmlspecialchars($subKoleksi['nama_sub_koleksi']) ?></td>
                        <td><?= htmlspecialchars($subKoleksi['deskripsi']) ?></td>
                        <td><?= htmlspecialchars($subKoleksi['nama_koleksi']) ?></td>
                        <td><?= htmlspecialchars($subKoleksi['nama_zaman']) ?></td>
                        <td>
                            <a href="ubah.php?id=<?= $subKoleksi['id_sub_koleksi'] ?>" class="btn btn-warning">Edit</a>
                            <a href="hapus.php?id=<?= $subKoleksi['id_sub_koleksi'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this sub koleksi?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>