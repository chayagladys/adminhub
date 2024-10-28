<?php
session_start();
include '../db.php';

if (!isset($_SESSION['level']) || ($_SESSION['level'] != 'admin' && $_SESSION['level'] != 'superadmin')) {
    header('Location: ../index.php');
    exit;
}

$id_sub_koleksi = $_GET['id'] ?? null;

if (!$id_sub_koleksi) {
    header('Location: index.php');
    exit;
}

// Fetch current data for the sub koleksi
$stmt = $pdo->prepare("SELECT * FROM sub_koleksi WHERE id_sub_koleksi = ?");
$stmt->execute([$id_sub_koleksi]);
$subKoleksi = $stmt->fetch();

// Fetch all koleksi for dropdown
$koleksiList = $pdo->query("SELECT id_koleksi, nama_koleksi FROM koleksi")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_koleksi = $_POST['id_koleksi'];
    $nama_sub_koleksi = $_POST['nama_sub_koleksi'];
    $deskripsi = $_POST['deskripsi'];

    $stmt = $pdo->prepare("UPDATE sub_koleksi SET id_koleksi = ?, nama_sub_koleksi = ?, deskripsi = ? WHERE id_sub_koleksi = ?");
    $stmt->execute([$id_koleksi, $nama_sub_koleksi, $deskripsi, $id_sub_koleksi]);

    $_SESSION['success'] = "Sub Koleksi updated successfully!";
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
    <title>Edit Sub Koleksi</title>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Edit Sub Koleksi</h1>
        <form method="POST" action="">
            <div class="form-group">
                <label for="id_koleksi">Koleksi</label>
                <select class="form-control" id="id_koleksi" name="id_koleksi" required>
                    <?php foreach ($koleksiList as $koleksi): ?>
                        <option value="<?= $koleksi['id_koleksi'] ?>" <?= $koleksi['id_koleksi'] == $subKoleksi['id_koleksi'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($koleksi['nama_koleksi']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="nama_sub_koleksi">Nama Sub Koleksi</label>
                <input type="text" class="form-control" id="nama_sub_koleksi" name="nama_sub_koleksi" value="<?= htmlspecialchars($subKoleksi['nama_sub_koleksi']) ?>" required>
            </div>
            <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"><?= htmlspecialchars($subKoleksi['deskripsi']) ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update Sub Koleksi</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>

</html>