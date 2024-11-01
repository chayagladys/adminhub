<?php
session_start();
include '../koneksi.php';

// Check if the user is authorized
if (!isset($_SESSION['level']) || ($_SESSION['level'] != 'admin' && $_SESSION['level'] != 'superadmin')) {
    header('Location: ../index.php');
    exit;
}

// Fetch the province details
if (isset($_GET['id'])) {
    $id_provinsi = $_GET['id'];

    // Fetch the current province data
    $stmt = $pdo->prepare("SELECT * FROM provinsi WHERE id_provinsi = ?");
    $stmt->execute([$id_provinsi]);
    $province = $stmt->fetch();

    // Check if the province exists
    if (!$province) {
        $_SESSION['error'] = "Province not found!";
        header('Location: index.php');
        exit;
    }

    // Fetch countries for the dropdown
    $stmt = $pdo->query("SELECT * FROM negara");
    $negaras = $stmt->fetchAll();

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nama_provinsi = $_POST['nama_provinsi'];
        $id_negara = $_POST['id_negara'];

        // Update the province data
        $stmt = $pdo->prepare("UPDATE provinsi SET nama_provinsi = ?, id_negara = ? WHERE id_provinsi = ?");
        $stmt->execute([$nama_provinsi, $id_negara, $id_provinsi]);

        $_SESSION['success'] = "Province updated successfully!";
        header('Location: index.php'); // Redirect to manage provinces page
        exit;
    }
} else {
    $_SESSION['error'] = "Province ID not found!";
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
    <title>Add Province</title>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Edit Province</h1>
        <form method="POST" action="">
            <div class="form-group">
                <label for="nama_provinsi">Province Name</label>
                <input type="text" class="form-control" id="nama_provinsi" name="nama_provinsi" value="<?= htmlspecialchars($province['nama_provinsi']) ?>" required>
            </div>
            <div class="form-group">
                <label for="id_negara">Country</label>
                <select class="form-control" id="id_negara" name="id_negara" required>
                    <option value="">Select Country</option>
                    <?php foreach ($negaras as $negara): ?>
                        <option value="<?= $negara['id_negara'] ?>" <?= $negara['id_negara'] == $province['id_negara'] ? 'selected' : '' ?>><?= htmlspecialchars($negara['nama_negara']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update Province</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
    <?php
    if(isset($_POST['kirim'])){
        $aaaa = mysqli_query($koneksi, "UPDATE `provinsi`
                                        SET `nama_provinsi` = '$_POST[nama_provinsi]', `id_negara` = '$_POST[id_negara]'
                                        WHERE `id_provinsi` = '$_GET[id]'");
        header("Location: index.php?page=provinsi");
    }
    ?>
</body>

</html>