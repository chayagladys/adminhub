<?php
session_start();
include '../db.php';

// Check user authorization
if (!isset($_SESSION['level']) || ($_SESSION['level'] != 'admin' && $_SESSION['level'] != 'superadmin')) {
    header('Location: ../index.php');
    exit;
}

// Fetch required data for dropdowns
$pengunjungs = $pdo->query("SELECT * FROM pengunjung")->fetchAll();
$metode_pembayarans = $pdo->query("SELECT * FROM metode_pembayaran")->fetchAll();
$status_bayars = $pdo->query("SELECT * FROM status_bayar")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_pengunjung = $_POST['id_pengunjung'];
    $id_metode_pembayaran = $_POST['id_metode_pembayaran'];
    $id_status_bayar = $_POST['id_status_bayar'];
    $total_bayar = $_POST['total_bayar'];
    $tanggal_pembelian = $_POST['tanggal_pembelian'];
    $total_tiket = $_POST['total_tiket'];

    $stmt = $pdo->prepare("INSERT INTO nota (id_pengunjung, id_metode_pembayaran, id_status_bayar, total_bayar, tanggal_pembelian, total_tiket) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$id_pengunjung, $id_metode_pembayaran, $id_status_bayar, $total_bayar, $tanggal_pembelian, $total_tiket]);

    $_SESSION['success'] = "Nota created successfully!";
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
    <title>Add Nota</title>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Add Nota</h1>
        <form method="POST" action="">
            <div class="form-group">
                <label for="id_pengunjung">Pengunjung</label>
                <select class="form-control" id="id_pengunjung" name="id_pengunjung" required>
                    <option value="">Select Pengunjung</option>
                    <?php foreach ($pengunjungs as $pengunjung): ?>
                        <option value="<?= $pengunjung['id_pengunjung'] ?>"><?= htmlspecialchars($pengunjung['nama']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="id_metode_pembayaran">Metode Pembayaran</label>
                <select class="form-control" id="id_metode_pembayaran" name="id_metode_pembayaran" required>
                    <option value="">Select Metode Pembayaran</option>
                    <?php foreach ($metode_pembayarans as $metode): ?>
                        <option value="<?= $metode['id_metode_pembayaran'] ?>"><?= htmlspecialchars($metode['metode_bayar']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="id_status_bayar">Status Bayar</label>
                <select class="form-control" id="id_status_bayar" name="id_status_bayar" required>
                    <option value="">Select Status Bayar</option>
                    <?php foreach ($status_bayars as $status): ?>
                        <option value="<?= $status['id_status_bayar'] ?>"><?= htmlspecialchars($status['status']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="total_bayar">Total Bayar</label>
                <input type="number" class="form-control" id="total_bayar" name="total_bayar" step="0.01" required>
            </div>
            <div class="form-group">
                <label for="tanggal_pembelian">Tanggal Pembelian</label>
                <input type="date" class="form-control" id="tanggal_pembelian" name="tanggal_pembelian" required>
            </div>
            <div class="form-group">
                <label for="total_tiket">Total Tiket</label>
                <input type="number" class="form-control" id="total_tiket" name="total_tiket" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Nota</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>

</html>