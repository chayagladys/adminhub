<?php
session_start();
include '../db.php';

// Check if the user is authorized
if (!isset($_SESSION['level']) || ($_SESSION['level'] != 'admin' && $_SESSION['level'] != 'superadmin')) {
    header('Location: ../index.php');
    exit;
}

// Fetch payment methods with their corresponding payment types
$stmt = $pdo->query("
    SELECT mp.*, jb.jenis_bayar 
    FROM metode_pembayaran mp 
    JOIN jenis_bayar jb ON mp.id_jenis_bayar = jb.id_jenis_bayar
");
$metode_bayar_list = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Manage Payment Methods</title>
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Manage Payment Methods</h1>
        <div class="text-right mb-3">
            <a href="../index.php" class="btn btn-secondary">Back</a>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>Payment Method</th>
                    <th>Payment Type</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($metode_bayar_list as $metode): ?>
                    <tr>
                        <td><?= htmlspecialchars($metode['metode_bayar']) ?></td>
                        <td><?= htmlspecialchars($metode['jenis_bayar']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>