<?php
session_start();
include '../db.php';

if (!isset($_SESSION['level']) || ($_SESSION['level'] != 'admin' && $_SESSION['level'] != 'superadmin')) {
    header('Location: ../index.php');
    exit;
}

$stmt = $pdo->query("SELECT * FROM jenis");
$jenis = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Manage Jenis</title>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Manage Jenis</h1>
        <div class="text-right mb-3">
            <a href="create.php" class="btn btn-success">Add Jenis</a>
            <a href="../index.php" class="btn btn-secondary">Back</a>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Jenis</th>
                    <th>Operations</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($jenis as $item): ?>
                    <tr>
                        <td><?= $item['id_jenis'] ?></td>
                        <td><?= htmlspecialchars($item['nama_jenis']) ?></td>
                        <td>
                            <a href="edit.php?id=<?= $item['id_jenis'] ?>" class="btn btn-warning">Edit</a>
                            <a href="delete.php?id=<?= $item['id_jenis'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this jenis?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>