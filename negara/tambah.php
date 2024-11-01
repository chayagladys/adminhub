<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['level']) || ($_SESSION['level'] != 'admin' && $_SESSION['level'] != 'superadmin')) {
    header('Location: ../index.php');
    exit;
}

// Inisialisasi variabel error_message
$error_id = '';
$error_nama = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_negara = $_POST['id_negara'];
    $nama_negara = $_POST['nama_negara'];

    // Cek apakah ID sudah ada
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM negara WHERE id_negara = ?");
    $stmt->execute([$id_negara]);
    $count_id = $stmt->fetchColumn();

    // Cek apakah nama sudah ada
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM negara WHERE nama_negara = ?");
    $stmt->execute([$nama_negara]);
    $count_nama = $stmt->fetchColumn();

    if ($count_id > 0) {
        $error_id = "ID Negara sudah ada.";
    } elseif (strlen($id_negara) > 4) {
        $error_id = "ID Negara harus 4 karakter atau kurang.";
    }

    if ($count_nama > 0) {
        $error_nama = "Nama Negara sudah ada.";
    }

    // Jika tidak ada kesalahan, masukkan ke dalam database
    if (empty($error_id) && empty($error_nama)) {
        $stmt = $pdo->prepare("INSERT INTO negara (id_negara, nama_negara) VALUES (?, ?)");
        $stmt->execute([$id_negara, $nama_negara]);
        header('Location: index.php');
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
    </style>
    <title>Tambah Negara</title>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Tambah Negara</h1>
        <?php if ($error_id): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error_id) ?></div>
        <?php endif; ?>
        <?php if ($error_nama): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error_nama) ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="id_negara">ID Negara</label>
                <input type="text" class="form-control" id="id_negara" name="id_negara" placeholder="ID Negara" maxlength="4" value="N3" required>
                <label for="nama_negara">Nama Negara</label>
                <input type="text" class="form-control" id="nama_negara" name="nama_negara" placeholder="Nama Negara" required>
            </div>
            <button type="submit" class="btn btn-primary">Tambah Negara</button>
            <a href="index.php" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</body>
</html>