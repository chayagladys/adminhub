<?php
session_start();
include '../db.php';

// Check if the user is authorized
if (!isset($_SESSION['level']) || ($_SESSION['level'] != 'admin' && $_SESSION['level'] != 'superadmin')) {
    header('Location: ../index.php');
    exit;
}

// Fetch museums from the database, joining with cities
$stmt = $pdo->query("SELECT m.id_museum, m.nama_museum, m.deskripsi, m.hari_operasional, m.jam_buka, m.jam_tutup, m.no_telp, k.nama_kota 
                      FROM museum m 
                      JOIN kota k ON m.id_kota = k.id_kota");
$museums = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Manage Museums</title>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Manage Museums</h1>
        <div class="text-right mb-3">
            <a href="create.php" class="btn btn-success">Add Museum</a>
            <a href="../index.php" class="btn btn-secondary">Back</a>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Operational Days</th>
                    <th>Opening Time</th>
                    <th>Closing Time</th>
                    <th>Contact Number</th>
                    <th>City</th>
                    <th>Operation</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($museums as $museum): ?>
                    <tr>
                        <td><?= $museum['id_museum'] ?></td>
                        <td><?= htmlspecialchars($museum['nama_museum']) ?></td>
                        <td><?= htmlspecialchars($museum['deskripsi']) ?></td>
                        <td><?= htmlspecialchars($museum['hari_operasional']) ?></td>
                        <td><?= htmlspecialchars($museum['jam_buka']) ?></td>
                        <td><?= htmlspecialchars($museum['jam_tutup']) ?></td>
                        <td><?= htmlspecialchars($museum['no_telp']) ?></td>
                        <td><?= htmlspecialchars($museum['nama_kota']) ?></td>
                        <td>
                            <a href="edit.php?id=<?= $museum['id_museum'] ?>" class="btn btn-warning">Edit</a>
                            <a href="delete.php?id=<?= $museum['id_museum'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this museum?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>