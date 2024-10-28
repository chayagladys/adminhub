<?php
session_start();
include '../db.php';


if (!isset($_SESSION['level']) || ($_SESSION['level'] != 'admin' && $_SESSION['level'] != 'superadmin')) {
    header('Location: ../index.php');
    exit;
}

$stmt = $pdo->query("SELECT p.id_provinsi, p.nama_provinsi, n.nama_negara FROM provinsi p JOIN negara n ON p.id_negara = n.id_negara");
$provinces = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Manage Provinces</title>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Manage Provinces</h1>
        <div class="text-right mb-3">
            <a href="create.php" class="btn btn-success">Add Province</a>
            <a href="../index.php" class="btn btn-secondary">back</a>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Country</th>
                    <th>Operation</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($provinces as $province): ?>
                    <tr>
                        <td><?= $province['id_provinsi'] ?></td>
                        <td><?= htmlspecialchars($province['nama_provinsi']) ?></td>
                        <td><?= htmlspecialchars($province['nama_negara']) ?></td>
                        <td>
                            <a href="edit.php?id=<?= $province['id_provinsi'] ?>" class="btn btn-warning">Edit</a>
                            <a href="delete.php?id=<?= $province['id_provinsi'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this province?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>