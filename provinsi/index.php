<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['level']) || ($_SESSION['level'] != 'admin' && $_SESSION['level'] != 'superadmin')) {
    header('Location: ../index.php');
    exit;
}

$stmt = $pdo->query("SELECT p.id_provinsi, p.nama_provinsi, n.nama_negara FROM provinsi p JOIN negara n ON p.id_negara = n.id_negara");
$provinces = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="id">

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
            border: 1px solid #dee2e6; /* Tambahkan border pada tabel */
        }
        .table th, .table td {
            border: 1px solid #dee2e6; /* Tambahkan border pada sel tabel */
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-warning, .btn-danger {
            color: white;
        }
    </style>
    <title>Kelola Provinsi</title>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Kelola Provinsi</h1>
        <div class="text-right mb-3">
            <a href="tambah.php" class="btn btn-success">Tambah Provinsi</a>
            <a href="../index.php" class="btn btn-secondary">Kembali</a>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>No</th> <!-- Kolom baru untuk nomor urut -->
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Negara</th>
                    <th>Operasi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($provinces as $index => $province): ?>
                    <tr>
                        <td><?= $index + 1 ?></td> <!-- Nomor urut mulai dari 1 -->
                        <td><?= $province['id_provinsi'] ?></td>
                        <td><?= htmlspecialchars($province['nama_provinsi']) ?></td>
                        <td><?= htmlspecialchars($province['nama_negara']) ?></td>
                        <td>
                            <a href="ubah.php?id=<?= $province['id_provinsi'] ?>" class="btn btn-warning">Edit</a>
                            <a href="hapus.php?id=<?= $province['id_provinsi'] ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus provinsi ini?');">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>