<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['level']) || ($_SESSION['level'] != 'admin' && $_SESSION['level'] != 'superadmin')) {
    header('Location: ../index.php');
    exit;
}

$stmt = $pdo->query("SELECT * FROM zaman");
$zamans = $stmt->fetchAll();
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
    <title>Manage Zaman</title>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Manage Zaman</h1>
        <div class="text-right mb-3">
            <a href="tambah.php" class="btn btn-success">Add Zaman</a>
            <a href="../index.php" class="btn btn-secondary">Back</a>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>Id Zaman</th>
                    <th>Nama Zaman</th>
                    <th>Tahun</th>
                    <th>Operations</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($zamans as $zaman): ?>
                    <tr>
                        <td><?= htmlspecialchars($zaman['id_zaman']) ?></td>
                        <td><?= htmlspecialchars($zaman['nama_zaman']) ?></td>
                        <td><?= htmlspecialchars($zaman['tahun']) ?></td>
                        <td>
                            <a href="ubah.php?id=<?= $zaman['id_zaman'] ?>" class="btn btn-warning">Edit</a>
                            <a href="hapus.php?id=<?= $zaman['id_zaman'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this zaman?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>