<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Admin</title>
    <style>
        /* Reset margin dan padding */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        /* Latar belakang halaman */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #4a90e2, #007aff);
        }

        /* Kotak form */
        .login-form {
            background-color: #fff;
            padding: 20px;
            width: 100%;
            max-width: 400px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        /* Judul form */
        .login-form h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
            text-align: center;
        }

        /* Label dan input */
        .login-form label {
            font-weight: bold;
            color: #555;
        }

        .login-form input[type="text"],
        .login-form input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0 16px 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            outline: none;
            transition: all 0.3s;
        }

        .login-form input[type="text"]:focus,
        .login-form input[type="password"]:focus {
            border-color: #007aff;
            box-shadow: 0 0 5px rgba(0, 122, 255, 0.5);
        }

        /* Tombol login */
        .login-form button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 4px;
            color: #fff;
            background-color: #007aff;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .login-form button:hover {
            background-color: #005bb5;
        }

        /* Pesan error */
        .error-message {
            color: #ff4d4d;
            font-weight: bold;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="login-form">
        <h2>Login Admin</h2>
        <form action="login.php" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            
            <button type="submit">Login</button>
        </form>

        <?php
        session_start(); // Start the session

        // Koneksi ke database
        $dsn = 'mysql:host=localhost;dbname=museum__3_';
        $username_db = 'root';
        $password_db = ''; // Sesuaikan dengan password database Anda jika ada
        try {
            $pdo = new PDO($dsn, $username_db, $password_db);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "<div class='error-message'>Koneksi gagal: " . $e->getMessage() . "</div>";
        }

        // Proses login
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            // Query untuk mencari pengguna
            $stmt = $pdo->prepare("SELECT * FROM admin WHERE username = :username");
            $stmt->execute(['username' => $username]);
            $admin= $stmt->fetch(PDO::FETCH_ASSOC);

            if ($admin && password_verify($password, $admin['password'])) {
                // Password benar, set session dan redirect
                $_SESSION['username'] = $username; // Set session variable
                header('Location: index.php'); // Redirect to index page
                exit(); // Make sure to exit after redirection
            } else {
                // Password salah
                echo "<div class='error-message'>Username atau password salah.</div>";
            }
        }
        ?>
    </div>
</body>
</html>
