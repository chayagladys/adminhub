<?php
session_start();
include '../db.php';

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
</body>

</html>