<?php
session_start();
include '../db.php';

if (!isset($_SESSION['level']) || ($_SESSION['level'] != 'admin' && $_SESSION['level'] != 'superadmin')) {
    header('Location: ../index.php');
    exit;
}

$id_koleksi = $_GET['id'] ?? null;

if (!$id_koleksi) {
    header('Location: index.php');
    exit;
}

// Fetch current data for the koleksi
$stmt = $pdo->prepare("SELECT * FROM koleksi WHERE id_koleksi = ?");
$stmt->execute([$id_koleksi]);
$koleksi = $stmt->fetch();

// Fetch all museums, categories, and zaman for dropdowns
$museums = $pdo->query("SELECT id_museum, nama_museum FROM museum")->fetchAll();
$categories = $pdo->query("SELECT id_kategori, nama_kategori FROM kategori")->fetchAll();
$zaman_list = $pdo->query("SELECT id_zaman, nama_zaman FROM zaman")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_koleksi = $_POST['nama_koleksi'];
    $deskripsi = $_POST['deskripsi'];
    $id_museum = $_POST['id_museum'];
    $jumlah_koleksi = $_POST['jumlah_koleksi'];
    $id_kategori = $_POST['id_kategori'];
    $id_zaman = $_POST['id_zaman'];

    $stmt = $pdo->prepare("UPDATE koleksi SET nama_koleksi = ?, deskripsi = ?, id_museum = ?, jumlah_koleksi = ?, id_kategori = ?, id_zaman = ? WHERE id_koleksi = ?");
    $stmt->execute([$nama_koleksi, $deskripsi, $id_museum, $jumlah_koleksi, $id_kategori, $id_zaman, $id_koleksi]);

    $_SESSION['success'] = "Koleksi updated successfully!";
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
    <title>Edit Koleksi</title>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Edit Koleksi</h1>
        <form method="POST" action="">
            <!-- Input fields populated with current data -->
            <div class="form-group">
                <label for="nama_koleksi">Nama Koleksi</label>
                <input type="text" class="form-control" id="nama_koleksi" name="nama_koleksi" value="<?= htmlspecialchars($koleksi['nama_koleksi']) ?>" required>
            </div>
            <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required><?= htmlspecialchars($koleksi['deskripsi']) ?></textarea>
            </div>
            <div class="form-group">
                <label for="id_museum">Museum</label>
                <select class="form-control" id="id_museum" name="id_museum" required>
                    <?php foreach ($museums as $museum): ?>
                        <option value="<?= $museum['id_museum'] ?>" <?= $museum['id_museum'] == $koleksi['id_museum'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($museum['nama_museum']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="jumlah_koleksi">Jumlah Koleksi</label>
                <input type="number" class="form-control" id="jumlah_koleksi" name="jumlah_koleksi" value="<?= htmlspecialchars($koleksi['jumlah_koleksi']) ?>" required>
            </div>
            <div class="form-group">
                <label for="id_kategori">Kategori</label>
                <select class="form-control" id="id_kategori" name="id_kategori" required>
                    <?php foreach ($categories as $kategori): ?>
                        <option value="<?= $kategori['id_kategori'] ?>" <?= $kategori['id_kategori'] == $koleksi['id_kategori'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($kategori['nama_kategori']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="id_zaman">Zaman</label>
                <select class="form-control" id="id_zaman" name="id_zaman" required>
                    <?php foreach ($zaman_list as $zaman): ?>
                        <option value="<?= $zaman['id_zaman'] ?>" <?= $zaman['id_zaman'] == $koleksi['id_zaman'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($zaman['nama_zaman']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update Koleksi</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>

</html>