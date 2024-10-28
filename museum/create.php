<?php
session_start();
include '../db.php';

// Check if the user is authorized
if (!isset($_SESSION['level']) || ($_SESSION['level'] != 'admin' && $_SESSION['level'] != 'superadmin')) {
    header('Location: ../index.php');
    exit;
}

// Fetch cities for the dropdown
$stmt = $pdo->query("SELECT * FROM kota");
$kotas = $stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_museum = $_POST['nama_museum'];
    $deskripsi = $_POST['deskripsi'];
    $hari_operasional = $_POST['hari_operasional'];
    $jam_buka = $_POST['jam_buka'];
    $jam_tutup = $_POST['jam_tutup'];
    $no_telp = $_POST['no_telp'];
    $id_kota = $_POST['id_kota'];

    $stmt = $pdo->prepare("INSERT INTO museum (nama_museum, deskripsi, hari_operasional, jam_buka, jam_tutup, no_telp, id_kota) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$nama_museum, $deskripsi, $hari_operasional, $jam_buka, $jam_tutup, $no_telp, $id_kota]);

    $_SESSION['success'] = "Museum added successfully!";
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
    <title>Add Museum</title>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Add Museum</h1>
        <form method="POST" action="">
            <div class="form-group">
                <label for="nama_museum">Museum Name</label>
                <input type="text" class="form-control" id="nama_museum" name="nama_museum" required>
            </div>
            <div class="form-group">
                <label for="deskripsi">Description</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required></textarea>
            </div>
            <div class="form-group">
                <label for="hari_operasional">Operational Days</label>
                <input type="text" class="form-control" id="hari_operasional" name="hari_operasional" required>
            </div>
            <div class="form-group">
                <label for="jam_buka">Opening Time</label>
                <input type="time" class="form-control" id="jam_buka" name="jam_buka" required>
            </div>
            <div class="form-group">
                <label for="jam_tutup">Closing Time</label>
                <input type="time" class="form-control" id="jam_tutup" name="jam_tutup" required>
            </div>
            <div class="form-group">
                <label for="no_telp">Contact Number</label>
                <input type="text" class="form-control" id="no_telp" name="no_telp" required>
            </div>
            <div class="form-group">
                <label for="id_kota">City</label>
                <select class="form-control" id="id_kota" name="id_kota" required>
                    <option value="">Select City</option>
                    <?php foreach ($kotas as $kota): ?>
                        <option value="<?= $kota['id_kota'] ?>"><?= htmlspecialchars($kota['nama_kota']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Add Museum</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>

</html>