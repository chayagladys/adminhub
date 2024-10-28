<?php
session_start();
include '../db.php';

// Check if the user is authorized
if (!isset($_SESSION['level']) || ($_SESSION['level'] != 'admin' && $_SESSION['level'] != 'superadmin')) {
    header('Location: ../index.php');
    exit;
}

// Fetch the visitor details
if (isset($_GET['id'])) {
    $id_pengunjung = $_GET['id'];

    // Fetch the current visitor data
    $stmt = $pdo->prepare("SELECT * FROM pengunjung WHERE id_pengunjung = ?");
    $stmt->execute([$id_pengunjung]);
    $visitor = $stmt->fetch();

    // Check if the visitor exists
    if (!$visitor) {
        $_SESSION['error'] = "Visitor not found!";
        header('Location: index.php');
        exit;
    }

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = $_POST['email'];
        $no_telp = $_POST['no_telp'];
        $nama = $_POST['nama'];

        $stmt = $pdo->prepare("UPDATE pengunjung SET email = ?, no_telp = ?, nama = ? WHERE id_pengunjung = ?");
        $stmt->execute([$email, $no_telp, $nama, $id_pengunjung]);

        $_SESSION['success'] = "Visitor updated successfully!";
        header('Location: index.php');
        exit;
    }
} else {
    $_SESSION['error'] = "Visitor ID not found!";
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
    <title>Edit Visitor</title>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Edit Visitor</h1>
        <form method="POST" action="">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($visitor['email']) ?>" required>
            </div>
            <div class="form-group">
                <label for="no_telp">Contact Number</label>
                <input type="text" class="form-control" id="no_telp" name="no_telp" value="<?= htmlspecialchars($visitor['no_telp']) ?>" required>
            </div>
            <div class="form-group">
                <label for="nama">Name</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?= htmlspecialchars($visitor['nama']) ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Visitor</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>

</html>