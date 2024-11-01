<?php
session_start();
include '../koneksi.php';

// Check if the user is authorized
if (!isset($_SESSION['level']) || ($_SESSION['level'] != 'admin' && $_SESSION['level'] != 'superadmin')) {
    header('Location: ../index.php');
    exit;
}

// Fetch provinces for the dropdown
$stmt = $pdo->query("SELECT * FROM provinsi");
$provinces = $stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_kota = $_POST['id_kota'];
    $nama_kota = $_POST['nama_kota'];
    $id_provinsi = $_POST['id_provinsi'];

    // Insert city into database
    $stmt = $pdo->prepare("INSERT INTO kota (id_kota, nama_kota, id_provinsi) VALUES (?, ?, ?)");
    $stmt->execute([$id_kota, $nama_kota, $id_provinsi]);

    $_SESSION['success'] = "City added successfully!";
    header('Location: index.php'); // Redirect to manage cities page
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
    <title>Add City</title>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Add City</h1>
        <form method="POST" action="">
            <div class="form-group">
                <label for="id_kota">City Id</label>
                <input type="text" class="form-control" id="id_kota" name="id_kota"  placeholder="id_kota" value="K1" required>
                <label for="nama_kota">City Name</label>
                <input type="text" class="form-control" id="nama_kota" name="nama_kota" placeholder="nama_kota" required>
            </div>
            <div class="form-group">
                <label for="id_provinsi">Province</label>
                <select class="form-control" id="id_provinsi" name="id_provinsi" placeholder="id_provinsi" required>
                    <option value="">Select Province</option>
                    <?php foreach ($provinces as $province): ?>
                        <option value="<?= $province['id_provinsi'] ?>"><?= htmlspecialchars($province['nama_provinsi']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Add City</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>

</html>