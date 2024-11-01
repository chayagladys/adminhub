<?php
session_start();
include '../koneksi.php';

// Check if the user is authorized
if (!isset($_SESSION['level']) || ($_SESSION['level'] != 'admin' && $_SESSION['level'] != 'superadmin')) {
    header('Location: ../index.php');
    exit;
}

// Fetch the city details
if (isset($_GET['id'])) {
    $id_kota = $_GET['id'];

    // Fetch the current city data
    $stmt = $pdo->prepare("SELECT * FROM kota WHERE id_kota = ?");
    $stmt->execute([$id_kota]);
    $kota = $stmt->fetch();

    // Check if the city exists
    if (!$kota) {
        $_SESSION['error'] = "City not found!";
        header('Location: index.php');
        exit;
    }

    // Fetch provinces for the dropdown
    $stmt = $pdo->query("SELECT * FROM provinsi");
    $provinces = $stmt->fetchAll();

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nama_kota = $_POST['nama_kota'];
        $id_provinsi = $_POST['id_provinsi'];

        // Update the city data
        $stmt = $pdo->prepare("UPDATE kota SET nama_kota = ?, id_provinsi = ? WHERE id_kota = ?");
        $stmt->execute([$nama_kota, $id_provinsi, $id_kota]);

        $_SESSION['success'] = "City updated successfully!";
        header('Location: index.php'); // Redirect to manage cities page
        exit;
    }
} else {
    $_SESSION['error'] = "City ID not found!";
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
    <title>Edit City</title>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Edit City</h1>
        <form method="POST" action="">
            <div class="form-group">
                <label for="nama_kota">City Name</label>
                <input type="text" class="form-control" id="nama_kota" name="nama_kota" value="<?= htmlspecialchars($kota['nama_kota']) ?>" required>
            </div>
            <div class="form-group">
                <label for="id_provinsi">Province</label>
                <select class="form-control" id="id_provinsi" name="id_provinsi" required>
                    <option value="">Select Province</option>
                    <?php foreach ($provinces as $province): ?>
                        <option value="<?= $province['id_provinsi'] ?>" <?= $province['id_provinsi'] == $kota['id_provinsi'] ? 'selected' : '' ?>><?= htmlspecialchars($province['nama_provinsi']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update City</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
    <?php
    if(isset($_POST['kirim'])){
        $aaaa = mysqli_query($koneksi, "UPDATE `kota`
                                        SET `nama_kota` = '$_POST[nama_kota]', `id_provinsi` = '$_POST[id_provinsi]'
                                        WHERE `id_kota` = '$_GET[id]'");
        header("Location: index.php?page=kota");
    }
    ?>
</body>

</html>