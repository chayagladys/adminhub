<?php
session_start();
include '../koneksi.php';

// Periksa apakah pengguna terotorisasi
if (!isset($_SESSION['level']) || ($_SESSION['level'] != 'admin' && $_SESSION['level'] != 'superadmin')) {
    header('Location: ../index.php');
    exit;
}

// Ambil negara untuk dropdown
$stmt = $pdo->query("SELECT * FROM negara");
$negaras = $stmt->fetchAll();

$error_message = ""; // Variabel untuk menyimpan pesan kesalahan

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_provinsi = $_POST['id_provinsi'];
    $nama_provinsi = $_POST['nama_provinsi'];
    $id_negara = $_POST['id_negara'];

    // Periksa apakah ID provinsi sudah ada
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM provinsi WHERE id_provinsi = ?");
    $stmt->execute([$id_provinsi]);
    $exists_id = $stmt->fetchColumn();

    // Periksa apakah nama provinsi sudah ada
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM provinsi WHERE nama_provinsi = ?");
    $stmt->execute([$nama_provinsi]);
    $exists_name = $stmt->fetchColumn();

    if ($exists_id > 0) {
        $error_message = "ID Provinsi sudah ada. Silakan gunakan ID yang berbeda.";
    } elseif ($exists_name > 0) {
        $error_message = "Nama Provinsi sudah ada. Silakan gunakan nama yang berbeda.";
    } else {
        // Sisipkan provinsi ke dalam database
        $stmt = $pdo->prepare("INSERT INTO provinsi (id_provinsi, nama_provinsi, id_negara) VALUES (?, ?, ?)");
        $stmt->execute([$id_provinsi, $nama_provinsi, $id_negara]);

        $_SESSION['success'] = "Provinsi berhasil ditambahkan!";
        header('Location: index.php'); // Redirect ke halaman kelola provinsi
        exit;
    }
}
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
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-warning, .btn-danger {
            color: white;
        }
        .alert {
            margin-top: 20px;
        }
    </style>
    <title>Tambah Provinsi</title>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Tambah Provinsi</h1>
        <?php if ($error_message): ?>
            <div class="alert alert-danger"><?= $error_message ?></div>
            <?php endif; ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="id_provinsi">ID Provinsi</label>
                <input type="text" class="form-control" id="id_provinsi" name="id_provinsi" placeholder="ID provinsi" maxlength="4" value="P2" required>
                <label for="nama_provinsi">Nama Provinsi</label>
                <input type="text" class="form-control" id="nama_provinsi" name="nama_provinsi" placeholder="Nama provinsi" required>
            </div>
            <div class="form-group">
                <label for="id_negara">Negara</label>
                <select class="form-control" id="id_negara" name="id_negara" required>
                    <option value="">Pilih Negara</option>
                    <?php foreach ($negaras as $negara): ?>
                        <option value="<?= $negara['id_negara'] ?>"><?= htmlspecialchars($negara['nama_negara']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Tambah Provinsi</button>
            <a href="index.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</body>

</html>