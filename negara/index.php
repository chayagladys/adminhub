<?php
session_start();
include '../koneksi.php';

// Periksa apakah pengguna terotorisasi
if (!isset($_SESSION['level']) || ($_SESSION['level'] != 'admin' && $_SESSION['level'] != 'superadmin')) {
    header('Location: ../index.php');
    exit;
}

// Ambil negara dari database
$stmt = $pdo->query("SELECT * FROM negara");
$negaras = $stmt->fetchAll();
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
            border: 1px solid #dee2e6; /* Border pada tabel */
        }
        .table th, .table td {
            border: 1px solid #dee2e6; /* Border pada sel tabel */
        }
    </style>
    <title>Kelola Negara</title>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Kelola Negara</h1>
        <div class="text-right mb-3">
            <a href="tambah.php" class="btn btn-success">Tambah Negara</a>
            <a href="../index.php" class="btn btn-secondary">Kembali</a>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>No</th> <!-- Kolom untuk nomor urut -->
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Operasi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($negaras as $index => $negara): ?>
                    <tr>
                        <td><?= $index + 1 ?></td> <!-- Nomor urut mulai dari 1 -->
                        <td><?= $negara['id_negara'] ?></td>
                        <td><?= htmlspecialchars($negara['nama_negara']) ?></td>
                        <td>
                            <a href="ubah.php?id=<?= $negara['id_negara'] ?>" class="btn btn-warning">Edit</a>
                            <a href="hapus.php?id=<?= $negara['id_negara'] ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus negara ini?');">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>