<?php 
session_start(); // Mulai sesi

if (!isset($_SESSION['username'])) {
    header('Location: login.php'); // Redirect ke login jika belum masuk
    exit();
}

// Contoh data untuk demonstrasi
$total_visitors = 150; // Nilai contoh
$orders = [
    ['user_name' => 'User1', 'date_order' => '2024-10-01', 'status' => 'completed'],
    ['user_name' => 'User2', 'date_order' => '2024-10-02', 'status' => 'pending'],
    // Tambahkan lebih banyak pesanan jika perlu
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style.css">
    <title>AdminHub</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333;
        }

        /* Gaya Sidebar */
        #sidebar {
            width: 250px;
            background-color: #007aff;
            padding: 20px;
            color: #fff;
            position: fixed;
            height: 100%;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }

        /* Gaya konten */
        #content {
            margin-left: 250px; /* Sesuaikan dengan lebar sidebar */
            padding: 20px;
        }

        /* Gaya konten utama */
        main {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        /* Gaya untuk bagian box-info */
        .box-info {
            display: flex; /* Mengaktifkan layout flexbox */
            justify-content: space-between; /* Menyebar box */
            margin: 20px 0; /* Tambahkan margin untuk jarak */
            flex-wrap: wrap; /* Mengizinkan box membungkus */
        }

        .box-info li {
            flex: 1 1 calc(33.333% - 20px); /* Setiap box mengambil 1/3 ruang */
            margin: 10px; /* Tambahkan margin di sekitar setiap box */
            background: #e6f7ff; /* Latar belakang ringan untuk box */
            border-radius: 8px; /* Sudut membulat */
            padding: 20px; /* Padding internal */
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1); /* Tambahkan bayangan */
            text-align: center; /* Rata tengah teks */
        }

        /* Gaya dropdown */
        .dropdown-menu {
            display: none; /* Sembunyikan dropdown secara default */
            background-color: #005bb5;
            border-radius: 4px;
            position: absolute;
            z-index: 1000;
            margin-top: 5px; /* Jarak antara tombol dan dropdown */
            padding: 0; /* Menghapus padding dari dropdown */
            width: 100%; /* Lebar penuh */
        }

        .dropdown-item {
            color: #fff;
            padding: 10px 15px;
            text-decoration: none;
            display: block;
            transition: background-color 0.3s;
        }

        .dropdown-item:hover {
            background-color: #004494; /* Warna lebih gelap saat hover */
        }

        /* Penyesuaian responsif */
        @media (max-width: 768px) {
            #sidebar {
                width: 70%;
                height: auto;
            }

            #content {
                margin-left: 0; /* Reset margin */
            }

            .box-info li {
                flex: 1 1 100%; /* Membuat box lebar penuh pada layar kecil */
            }
        }
    </style>
</head>
<body>
    <section id="sidebar">
        <a href="#" class="brand">
            <i class='bx bxs-smile'></i>
            <span class="text">Museum</span>
        </a>
        <ul class="side-menu top">
            <li class="active">
                <a href="#">
                    <i class='bx bxs-dashboard'></i>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            <!-- Dropdown Museum -->
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="museumDropdown" role="button" onclick="toggleDropdown(event, 'museumDropdownMenu')">
					<i class='bx bxs-home'></i><span class="text">Museum</span>
				</a>
				<div class="dropdown-menu" id="museumDropdownMenu" aria-labelledby="museumDropdown">
					<a class="dropdown-item" href="museum/index.php">Museum</a>
					<a class="dropdown-item" href="pameran/index.php">Pameran</a>
					<a class="dropdown-item" href="jenis_kunjungan/index.php">Jenis Kunjungan</a>
				</div>
			</li>

			<!-- Dropdown Lokasi -->
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="lokasiDropdown" role="button" onclick="toggleDropdown(event, 'lokasiDropdownMenu')">
					<i class='bx bxs-map icon'></i><span class="text">Lokasi</span>
				</a>
				<div class="dropdown-menu" id="lokasiDropdownMenu" aria-labelledby="lokasiDropdown">
					<a class="dropdown-item" href="negara/index.php">Negara</a>
					<a class="dropdown-item" href="Provinsi/index.php">Provinsi</a>
					<a class="dropdown-item" href="kota/index.php">Kota</a>
				</div>
			</li>

			<!-- Dropdown Koleksi -->
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="koleksiDropdown" role="button" onclick="toggleDropdown(event, 'koleksiDropdownMenu')">
					<i class='bx bxs-collection icon'></i><span class="text">Koleksi</span>
				</a>
				<div class="dropdown-menu" id="koleksiDropdownMenu" aria-labelledby="koleksiDropdown">
					<a class="dropdown-item" href="jenis/index.php">Jenis</a>
					<a class="dropdown-item" href="kategori/index.php">Kategori</a>
					<a class="dropdown-item" href="koleksi/index.php">Koleksi</a>
					<a class="dropdown-item" href="zaman/index.php">Zaman</a>
					<a class="dropdown-item" href="subkoleksi/index.php">Subkoleksi</a>
				</div>
			</li>


        </ul>
        <ul class="side-menu">
            <li><a href="#"><i class='bx bxs-cog'></i><span class="text">Settings</span></a></li>
            <li><a href="#" class="logout"><i class='bx bxs-log-out-circle'></i><span class="text">Logout</span></a></li>
        </ul>
    </section>

    <section id="content">
        <nav>
            <i class='bx bx-menu'></i>
            <a href="#" class="nav-link">Categories</a>
            <form action="#">
                <div class="form-input">
                    <input type="search" placeholder="Search...">
                    <button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
                </div>
            </form>
            <input type="checkbox" id="switch-mode" hidden>
            <label for="switch-mode" class="switch-mode"></label>
            <a href="#" class="notification"><i class='bx bxs-bell'></i><span class="num">8</span></a>
            <a href="#" class="profile"><img src="img/people.png"></a>
        </nav>

        <main>
            <div class="head-title">
                <div class="left">
                    <div class="content">
                        <h1>Selamat datang di Museum!</h1>
                    </div>
                    <ul class="breadcrumb">
                        <li><a href="#">Dashboard</a></li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li><a class="active" href="#">Home</a></li>
                    </ul>
                </div>
                <a href="#" class="btn-download"><i class='bx bxs-cloud-download'></i><span class="text">Download PDF</span></a>
            </div>

            <ul class="box-info">
                <li>
                    <i class='bx bxs-calendar-check'></i>
                    <span class="text">
                        <h3>1020</h3>
                        <p>Pesanan Baru</p>
                    </span>
                </li>
                <li>
                    <i class='bx bxs-group'></i>
                    <span class="text">
                        <h3><?php echo htmlspecialchars($total_visitors); ?></h3>
                        <p>Pengunjung</p>
                    </span>
                </li>
                <li>
                    <i class='bx bxs-dollar-circle'></i>
                    <span class="text">
                        <h3>$2543</h3>
                        <p>Total Penjualan</p>
                    </span>
                </li>
            </ul>

            <div class="table-data">
                <div class="order">
                    <div class="head">
                        <h3>Pesanan Terbaru</h3>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Pengguna</th>
                                <th>Tanggal Pesanan</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $order): ?>
                            <tr>
                                <td><p><?php echo htmlspecialchars($order['user_name']); ?></p></td>
                                <td><?php echo htmlspecialchars($order['date_order']); ?></td>
                                <td><span class="status <?php echo strtolower($order['status']); ?>"><?php echo htmlspecialchars($order['status']); ?></span></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="todo">
                    <div class="head">
                        <h3>Todos</h3>
                    </div>
                    <ul class="todo-list">
                        <li class="not-completed">
                            <p>Daftar Todo</p>
                            <i class='bx bx-dots-vertical-rounded'></i>
                        </li>
                    </ul>
                </div>
            </div>
        </main>
    </section>

	<script>
    function toggleDropdown(event, dropdownId) {
        event.preventDefault(); // Mencegah aksi default

        // Ambil semua dropdown
        const dropdownMenus = document.querySelectorAll('.dropdown-menu');
        
        dropdownMenus.forEach(menu => {
            // Menyembunyikan semua dropdown yang terbuka
            menu.style.display = 'none'; 
        });

        // Tampilkan dropdown yang sesuai
        const selectedMenu = document.getElementById(dropdownId);
        if (selectedMenu.style.display === 'block') {
            selectedMenu.style.display = 'none'; // Sembunyikan jika sudah terbuka
        } else {
            selectedMenu.style.display = 'block'; // Tampilkan dropdown
        }
    }

    // Tutup dropdown jika diklik di luar
    window.onclick = function(event) {
        const dropdownMenus = document.querySelectorAll('.dropdown-menu');
        dropdownMenus.forEach(menu => {
            if (!event.target.matches('.nav-link') && menu.style.display === 'block') {
                menu.style.display = 'none'; // Tutup dropdown
            }
        });
    };
</script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


</body>
</html>
