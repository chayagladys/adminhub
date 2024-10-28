<?php
session_start();
include '../db.php';

// Check if the user is authorized
if (!isset($_SESSION['level']) || ($_SESSION['level'] != 'admin' && $_SESSION['level'] != 'superadmin')) {
    header('Location: ../index.php');
    exit;
}

// Fetch payment statuses from the database
$stmt = $pdo->query("SELECT * FROM status_bayar");
$status_bayar = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Manage Payment Status</title>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Manage Payment Status</h1>
        <div class="text-right mb-3">
            <a href="create.php" class="btn btn-success">Add Payment Status</a>
            <a href="../index.php" class="btn btn-secondary">back</a>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>Status</th>
                    <th>Operation</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($status_bayar as $status): ?>
                    <tr>
                        <td><?= htmlspecialchars($status['status']) ?></td>
                        <td>
                            <a href="edit.php?id=<?= $status['id_status_bayar'] ?>" class="btn btn-warning">Edit</a>
                            <a href="delete.php?id=<?= $status['id_status_bayar'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this status?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>