<?php
session_start();
include '../db.php';

// Check if the user is authorized
if (!isset($_SESSION['level']) || ($_SESSION['level'] != 'admin' && $_SESSION['level'] != 'superadmin')) {
    header('Location: ../index.php');
    exit;
}

// Check if ID is provided
if (isset($_GET['id'])) {
    $id_negara = $_GET['id'];

    // Fetch the current country data
    $stmt = $pdo->prepare("SELECT * FROM negara WHERE id_negara = ?");
    $stmt->execute([$id_negara]);
    $negara = $stmt->fetch();

    // Check if the country exists
    if (!$negara) {
        $_SESSION['error'] = "Country not found!";
        header('Location: index.php');
        exit;
    }

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nama_negara = $_POST['nama_negara'];

        // Update the country data
        $stmt = $pdo->prepare("UPDATE negara SET nama_negara = ? WHERE id_negara = ?");
        $stmt->execute([$nama_negara, $id_negara]);

        $_SESSION['success'] = "Country updated successfully!";
        header('Location: index.php'); // Redirect to the manage negara page
        exit;
    }
} else {
    $_SESSION['error'] = "Country ID not found!";
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
    <title>Edit Country</title>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Edit Country</h1>
        <form method="POST" action="">
            <div class="form-group">
                <label for="nama_negara">Country Name</label>
                <input type="text" class="form-control" id="nama_negara" name="nama_negara" value="<?= htmlspecialchars($negara['nama_negara']) ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Country</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>
