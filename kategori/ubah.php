<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['level']) || ($_SESSION['level'] != 'admin' && $_SESSION['level'] != 'superadmin')) {
    header('Location: ../index.php');
    exit;
}

$id_kategori = $_GET['id'] ?? null;

if (!$id_kategori) {
    header('Location: index.php');
    exit;
}

$jenis_stmt = $pdo->query("SELECT id_jenis, nama_jenis FROM jenis");
$jenis_list = $jenis_stmt->fetchAll();

$stmt = $pdo->prepare("SELECT * FROM kategori WHERE id_kategori = ?");
$stmt->execute([$id_kategori]);
$kategori = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_jenis = $_POST['id_jenis'];
    $nama_kategori = $_POST['nama_kategori'];
    $jumlah_kategori = $_POST['jumlah_kategori'];

    $stmt = $pdo->prepare("UPDATE kategori SET id_jenis = ?, nama_kategori = ?, jumlah_kategori = ? WHERE id_kategori = ?");
    $stmt->execute([$id_jenis, $nama_kategori, $jumlah_kategori, $id_kategori]);

    $_SESSION['success'] = "Kategori updated successfully!";
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
    <title>Edit Kategori</title>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Edit Kategori</h1>
        <form method="POST" action="">
            <div class="form-group">
                <label for="id_jenis">Jenis</label>
                <select class="form-control" id="id_jenis" name="id_jenis" required>
                    <?php foreach ($jenis_list as $jenis): ?>
                        <option value="<?= $jenis['id_jenis'] ?>" <?= $jenis['id_jenis'] == $kategori['id_jenis'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($jenis['nama_jenis']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="nama_kategori">Nama Kategori</label>
                <input type="text" class="form-control" id="nama_kategori" name="nama_kategori" value="<?= htmlspecialchars($kategori['nama_kategori']) ?>" required>
            </div>
            <div class="form-group">
                <label for="jumlah_kategori">Jumlah Kategori</label>
                <input type="number" class="form-control" id="jumlah_kategori" name="jumlah_kategori" value="<?= htmlspecialchars($kategori['jumlah_kategori']) ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Save Changes</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
    <?php
    if(isset($_POST['kirim'])){
        $aaaa = mysqli_query($koneksi, "UPDATE `kategori`
                                        SET `nama_kategori` = '$_POST[nama_kategori]', `id_jenis` = '$_POST[id_jenis]'
                                        WHERE `id_kategori` = '$_GET[id]'");
        header("Location: index.php?page=kategori");
    }
    ?>
</body>

</html>