<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['level']) || ($_SESSION['level'] != 'admin' && $_SESSION['level'] != 'superadmin')) {
    header('Location: ../index.php');
    exit;
}

$id_zaman = $_GET['id'] ?? null;

if (!$id_zaman) {
    header('Location: index.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM zaman WHERE id_zaman = ?");
$stmt->execute([$id_zaman]);
$zaman = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_zaman = $_POST['nama_zaman'];
    $tahun = $_POST['tahun'];

    $stmt = $pdo->prepare("UPDATE zaman SET nama_zaman = ?, tahun = ? WHERE id_zaman = ?");
    $stmt->execute([$nama_zaman, $tahun, $id_zaman]);

    $_SESSION['success'] = "Zaman updated successfully!";
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
    <title>Edit Zaman</title>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Edit Zaman</h1>
        <form method="POST" action="">
            <div class="form-group">
                <label for="nama_zaman">Nama Zaman</label>
                <input type="text" class="form-control" id="nama_zaman" name="nama_zaman" value="<?= htmlspecialchars($zaman['nama_zaman']) ?>" required>
            </div>
            <div class="form-group">
                <label for="tahun">Tahun</label>
                <input type="number" class="form-control" id="tahun" name="tahun" value="<?= htmlspecialchars($zaman['tahun']) ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Save Changes</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
    <?php
    if(isset($_POST['kirim'])){
        $aaaa = mysqli_query($koneksi, "UPDATE `zaman`
                                        SET `nama_zaman` = '$_POST[nama_zaman]', `tahun` = '$_POST[tahun]'
                                        WHERE `id_zaman` = '$_GET[id]'");
        header("Location: index.php?page=zaman");
    }
    ?>
</body>

</html>