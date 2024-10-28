<?php
session_start();
include '../db.php';

// Check if the user is authorized
if (!isset($_SESSION['level']) || ($_SESSION['level'] != 'admin' && $_SESSION['level'] != 'superadmin')) {
    header('Location: ../index.php');
    exit;
}

// Fetch visitors from the database
$stmt = $pdo->query("SELECT * FROM pengunjung");
$pengunjung = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Manage Visitors</title>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Manage Visitors</h1>
        <div class="text-right mb-3">
            <a href="create.php" class="btn btn-success">Add Visitor</a>
            <a href="../index.php" class="btn btn-secondary">Back</a>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Contact Number</th>
                    <th>Operation</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pengunjung as $visitor): ?>
                    <tr>
                        <td><?= $visitor['id_pengunjung'] ?></td>
                        <td><?= htmlspecialchars($visitor['nama']) ?></td>
                        <td><?= htmlspecialchars($visitor['email']) ?></td>
                        <td><?= htmlspecialchars($visitor['no_telp']) ?></td>
                        <td>
                            <a href="edit.php?id=<?= $visitor['id_pengunjung'] ?>" class="btn btn-warning">Edit</a>
                            <a href="delete.php?id=<?= $visitor['id_pengunjung'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this visitor?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>