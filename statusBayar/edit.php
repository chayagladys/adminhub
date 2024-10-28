<?php
session_start();
include '../db.php';

// Check if the user is authorized
if (!isset($_SESSION['level']) || ($_SESSION['level'] != 'admin' && $_SESSION['level'] != 'superadmin')) {
    header('Location: ../index.php');
    exit;
}

// Fetch the payment status details
if (isset($_GET['id'])) {
    $id_status = $_GET['id'];

    // Fetch the current status data
    $stmt = $pdo->prepare("SELECT * FROM status_bayar WHERE id_status = ?");
    $stmt->execute([$id_status]);
    $status = $stmt->fetch();

    // Check if the status exists
    if (!$status) {
        $_SESSION['error'] = "Payment status not found!";
        header('Location: index.php');
        exit;
    }

    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $status_text = $_POST['status'];

        $stmt = $pdo->prepare("UPDATE status_bayar SET status = ? WHERE id_status = ?");
        $stmt->execute([$status_text, $id_status]);

        $_SESSION['success'] = "Payment status updated successfully!";
        header('Location: index.php');
        exit;
    }
} else {
    $_SESSION['error'] = "Payment status ID not found!";
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
    <title>Edit Payment Status</title>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Edit Payment Status</h1>
        <form method="POST" action="">
            <div class="form-group">
                <label for="status">Status</label>
                <input type="text" class="form-control" id="status" name="status" value="<?= htmlspecialchars($status['status']) ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Update Payment Status</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>

</html>