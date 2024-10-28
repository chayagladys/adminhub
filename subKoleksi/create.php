<?php
session_start();
include '../db.php';

if (!isset($_SESSION['level']) || ($_SESSION['level'] != 'admin' && $_SESSION['level'] != 'superadmin')) {
    header('Location: ../index.php');
    exit;
}

// Fetch all koleksi for dropdown
$koleksiList = $pdo->query("SELECT id_koleksi, nama_koleksi FROM koleksi")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_koleksi = $_POST['id_koleksi'];
    $nama_sub_koleksi = $_POST['nama_sub_koleksi'];
    $deskripsi = $_POST['deskripsi'];

    $stmt = $pdo->prepare("INSERT INTO sub_koleksi (id_koleksi, nama_sub_koleksi, deskripsi) VALUES (?, ?, ?)");
    $stmt->execute([$id_koleksi, $nama_sub_koleksi, $deskripsi]);

    $_SESSION['success'] = "Sub Koleksi added successfully!";
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
    <title>Add Sub Koleksi</title>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Add Sub Koleksi</h1>
        <form method="POST" action="">
            <div class="form-group">
                <label for="id_koleksi">Koleksi</label>
                <select class="form-control" id="id_koleksi" name="id_koleksi" required>
                    <?php foreach ($koleksiList as $koleksi): ?>
                        <option value="<?= $koleksi['id_koleksi'] ?>"><?= htmlspecialchars($koleksi['nama_koleksi']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="nama_sub_koleksi">Nama Sub Koleksi</label>
                <input type="text" class="form-control" id="nama_sub_koleksi" name="nama_sub_koleksi" required>
            </div>
            <div class="form-group">
                <label for="deskripsi">Deskripsi</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Add Sub Koleksi</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>

</html>