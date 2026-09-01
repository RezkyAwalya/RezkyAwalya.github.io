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

// Memeriksa apakah form registrasi telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $username = $_POST['new_username'];
    $password = $_POST['new_password'];

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Memasukkan data pengguna ke database
    $sql = "INSERT INTO user (username, password) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ss", $username, $hashed_password);

        if ($stmt->execute()) {
            // Registrasi sukses, langsung login
            $_SESSION['user_id'] = $conn->insert_id;
            $_SESSION['username'] = $username;
            header("Location: login.php");
            exit();
        } else {
            $error_message = "Terjadi kesalahan saat mendaftar!";
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
    <title>Halaman Registrasi</title>
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
    </style>
</head>
<body>
    <div class="container">
        <h2>Registrasi</h2>
        <?php if (!empty($error_message)): ?>
            <div class="error"><?php echo $error_message; ?></div>
        <?php endif; ?>
        <form action="" method="POST">
            <input type="text" name="new_username" placeholder="Username" required>
            <input type="password" name="new_password" placeholder="Password" required>
            <button type="submit" name="register">Daftar</button>
        </form>
        <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
    </div>
</body>
</html>