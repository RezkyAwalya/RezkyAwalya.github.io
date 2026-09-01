<?php
session_start(); // Memulai sesi

// Koneksi ke database
$servername = "localhost";
$db_username = "root"; // Ganti dengan username database Anda
$db_password = ""; // Ganti dengan password database Anda
$dbname = "kasir_db"; // Ganti dengan nama database Anda

// Membuat koneksi
$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

$error_message = "";

// Memeriksa apakah form login telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Mengambil data pengguna dari database
    $sql = "SELECT * FROM user WHERE username = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            
            // Memeriksa password
            if (password_verify($password, $row['password'])) {
                // Login sukses, simpan informasi sesi
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['username'] = $row['username'];
                header("Location: admin/index.php");
                exit();
            } else {
                $error_message = "Password salah!";
            }
        } else {
            $error_message = "Username tidak ditemukan!";
        }

        $stmt->close(); // Menutup statement
    } else {
        $error_message = "Terjadi kesalahan dalam query!";
    }
}

$conn->close(); // Menutup koneksi
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        h2 {
            margin-bottom: 20px;
            color: #333;
        }
        input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .error {
            color: red;
            margin-bottom: 10px;
        }
        .guest-button {
            margin-top: 10px;
            background-color: #28a745;
        }
        .guest-button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <?php if (!empty($error_message)): ?>
            <div class="error"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <form action="" method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" name="login">Login</button>
        </form>
        <p>Belum punya akun? <a href="register.php">Daftar di sini</a></p>
        <button class="guest-button" onclick="window.location.href='user/dashboard_user.php'">Masuk sebagai Tamu</button>
    </div>
</body>
</html>