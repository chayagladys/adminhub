<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['level']) || ($_SESSION['level'] != 'admin' && $_SESSION['level'] != 'superadmin')) {
    header('Location: ../index.php');
    exit;
}

// Fetch all available jenis for the dropdown
$jenis_stmt = $pdo->query("SELECT id_jenis, nama_jenis FROM jenis");
$jenis_list = $jenis_stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_jenis = $_POST['id_jenis'];
    $nama_kategori = $_POST['nama_kategori'];
    $jumlah_kategori = $_POST['jumlah_kategori'];

    $stmt = $pdo->prepare("INSERT INTO kategori (id_jenis, nama_kategori, jumlah_kategori) VALUES (?, ?, ?)");
    $stmt->execute([$id_jenis, $nama_kategori, $jumlah_kategori]);

    $_SESSION['success'] = "Kategori added successfully!";
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
    <title>Add Kategori</title>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Add Kategori</h1>
        <form method="POST" action="">
            <div class="form-group">
                <label for="id_jenis">Jenis</label>
                <select class="form-control" id="id_jenis" name="id_jenis" placeholder="id_jenis" required>
                    <?php foreach ($jenis_list as $jenis): ?>
                        <option value="<?= $jenis['id_jenis'] ?>"><?= htmlspecialchars($jenis['nama_jenis']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="id_kategori">Id Kategori</label>
                <input type="text" class="form-control" id="id_kategori" name="id_kategori" placeholder="id_kategori" value="T" required>>
                <label for="nama_kategori">Nama Kategori</label>
                <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" placeholder="nama_kategori" required>>
                <label for="jumlah_kategori">Jumlah Kategori</label>
                <input type="number" class="form-control" id="jumlah_kategori" name="jumlah_kategori" placeholder="jumlah_kategori" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Kategori</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>

</html>