<?php
session_start();
include '../db.php';

// Check if the user is authorized
if (!isset($_SESSION['level']) || ($_SESSION['level'] != 'admin' && $_SESSION['level'] != 'superadmin')) {
    header('Location: ../index.php');
    exit;
}

// Fetch payment types from the database
$stmt = $pdo->query("SELECT * FROM jenis_bayar");
$jenis_bayar_list = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Manage Payment Types</title>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Manage Payment Types</h1>
        <div class="text-right mb-3">
            <a href="../index.php" class="btn btn-secondary">Back</a>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Payment Type</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($jenis_bayar_list as $jenis): ?>
                    <tr>
                        <td><?= $jenis['id_jenis_bayar'] ?></td>
                        <td><?= htmlspecialchars($jenis['jenis_bayar']) ?></td>

                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>