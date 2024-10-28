<?php
session_start();
include '../db.php';

// Check if the user is authorized
if (!isset($_SESSION['level']) || ($_SESSION['level'] != 'admin' && $_SESSION['level'] != 'superadmin')) {
    header('Location: ../index.php');
    exit;
}

// Fetch countries for the dropdown
$stmt = $pdo->query("SELECT * FROM negara");
$negaras = $stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_provinsi = $_POST['nama_provinsi'];
    $id_negara = $_POST['id_negara'];

    // Insert province into database
    $stmt = $pdo->prepare("INSERT INTO provinsi (nama_provinsi, id_negara) VALUES (?, ?)");
    $stmt->execute([$nama_provinsi, $id_negara]);

    $_SESSION['success'] = "Province added successfully!";
    header('Location: index.php'); // Redirect to manage provinces page
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Add Province</title>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Add Province</h1>
        <form method="POST" action="">
            <div class="form-group">
                <label for="nama_provinsi">Province Name</label>
                <input type="text" class="form-control" id="nama_provinsi" name="nama_provinsi" required>
            </div>
            <div class="form-group">
                <label for="id_negara">Country</label>
                <select class="form-control" id="id_negara" name="id_negara" required>
                    <option value="">Select Country</option>
                    <?php foreach ($negaras as $negara): ?>
                        <option value="<?= $negara['id_negara'] ?>"><?= htmlspecialchars($negara['nama_negara']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Add Province</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>

</html>