<?php
session_start();
include '../db.php';

// Check if the user is authorized
if (!isset($_SESSION['level']) || ($_SESSION['level'] != 'admin' && $_SESSION['level'] != 'superadmin')) {
    header('Location: ../index.php');
    exit;
}

// Fetch all nota records
$stmt = $pdo->query("
    SELECT n.*, p.nama AS pengunjung, mp.metode_bayar AS metode_pembayaran, sb.status AS status_bayar 
    FROM nota n
    JOIN pengunjung p ON n.id_pengunjung = p.id_pengunjung
    JOIN metode_pembayaran mp ON n.id_metode_pembayaran = mp.id_metode_pembayaran
    JOIN status_bayar sb ON n.id_status_bayar = sb.id_status_bayar
");
$notas = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Manage Nota</title>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Manage Nota</h1>
        <div class="text-right mb-3">
            <a href="create.php" class="btn btn-success">Add Nota</a>
            <a href="../index.php" class="btn btn-secondary">Back</a>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Pengunjung</th>
                    <th>Metode Pembayaran</th>
                    <th>Status Bayar</th>
                    <th>Total Bayar</th>
                    <th>Tanggal Pembelian</th>
                    <th>Total Tiket</th>
                    <th>Operations</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($notas as $nota): ?>
                    <tr>
                        <td><?= $nota['id_nota'] ?></td>
                        <td><?= htmlspecialchars($nota['pengunjung']) ?></td>
                        <td><?= htmlspecialchars($nota['metode_pembayaran']) ?></td>
                        <td><?= htmlspecialchars($nota['status_bayar']) ?></td>
                        <td><?= number_format($nota['total_bayar'], 2) ?></td>
                        <td><?= htmlspecialchars($nota['tanggal_pembelian']) ?></td>
                        <td><?= htmlspecialchars($nota['total_tiket']) ?></td>
                        <td>
                            <a href="edit.php?id=<?= $nota['id_nota'] ?>" class="btn btn-warning">Edit</a>
                            <a href="delete.php?id=<?= $nota['id_nota'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this nota?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>