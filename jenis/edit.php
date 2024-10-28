<?php
session_start();
include '../db.php';

if (!isset($_SESSION['level']) || ($_SESSION['level'] != 'admin' && $_SESSION['level'] != 'superadmin')) {
    header('Location: ../index.php');
    exit;
}

$id_jenis = $_GET['id'] ?? null;

if (!$id_jenis) {
    header('Location: index.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM jenis WHERE id_jenis = ?");
$stmt->execute([$id_jenis]);
$item = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_jenis = $_POST['nama_jenis'];

    $stmt = $pdo->prepare("UPDATE jenis SET nama_jenis = ? WHERE id_jenis = ?");
    $stmt->execute([$nama_jenis, $id_jenis]);

    $_SESSION['success'] = "Jenis updated successfully!";
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
    <title>Edit Jenis</title>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Edit Jenis</h1>
        <form method="POST" action="">
            <div class="form-group">
                <label for="nama_jenis">Nama Jenis</label>
                <input type="text" class="form-control" id="nama_jenis" name="nama_jenis" value="<?= htmlspecialchars($item['nama_jenis']) ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Save Changes</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>

</html>