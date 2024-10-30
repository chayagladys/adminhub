<?php
session_start();
if (!isset($_SESSION['id_admin'])) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Dasboard admin</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="./index.php">Museum</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <!-- Museum Management Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="museumDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        museum
                    </a>
                    <div class="dropdown-menu" aria-labelledby="museumDropdown">
                        <a class="dropdown-item" href="museum/index.php">Museum</a>
                        <a class="dropdown-item" href="pameran/index.php">Pameran</a>
                        <a class="dropdown-item" href="jenis_kunjungan/index.php">Jenis kunjungan</a>
                    </div>
                </li>
                <!-- Payment Management Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="paymentDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Payment Management
                    </a>
                    <div class="dropdown-menu" aria-labelledby="paymentDropdown">
                        <a class="dropdown-item" href="statusBayar/index.php">Status Bayar</a>
                        <a class="dropdown-item" href="jenisBayar/index.php">Jenis Bayar</a>
                        <a class="dropdown-item" href="metodePembayaran/index.php">Metode Pembayaran</a>
                        <a class="dropdown-item" href="nota/index.php">Nota</a>
                    </div>
                </li>
                <!-- Visitor Management Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="visitorDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        pengunjung
                    </a>
                    <div class="dropdown-menu" aria-labelledby="visitorDropdown">
                        <a class="dropdown-item" href="pengunjung/index.php">Visitors</a>
                    </div>
                </li>
                <!-- Location Management Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="locationDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        lokasi
                    </a>
                    <div class="dropdown-menu" aria-labelledby="locationDropdown">
                        <a class="dropdown-item" href="negara/index.php">Negara</a>
                        <a class="dropdown-item" href="provinsi/index.php">Provinsi</a>
                        <a class="dropdown-item" href="kota/index.php">Kota</a>
                    </div>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <!-- Logout Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="logoutDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Logout
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="logoutDropdown">
                        <a class="dropdown-item" href="logout.php">Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="text-center">Dashboard</h1>
        <h3 class="mt-4">manage:</h3>
        <div class="list-group">
            <?php if ($_SESSION['level'] == 'admin' || $_SESSION['level'] == 'superadmin'): ?>
                <a href="museum/index.php" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    Museum
                    <i class="fas fa-building"></i>
                </a>
                <a href="jenis_kunjungan/index.php" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                    Jenis Kunjungan
                    <i class="fas fa-eye"></i>
                </a>
                <a href="pameran/index.php" class="list-group,-item list-group-item-action d-flex justify-content-between align-items-center">
                    Pameran
                    <i class="fas fa-artstation"></i>
                </a>
            <?php endif; ?>
            <a href="#" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                pengunjung
                <i class="fas fa-users"></i>
            </a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>