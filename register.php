<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = htmlspecialchars($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $cek = mysqli_query($koneksi, "SELECT * FROM admin WHERE username='$username'");
    if (mysqli_num_rows($cek) > 0) {
        echo "<script>alert('Username sudah terdaftar!'); window.location='register.php';</script>";
    } else {
        $query = mysqli_query($koneksi, "INSERT INTO admin (username, password) VALUES ('$username', '$password')");
        if ($query) {
            echo "<script>alert('Registrasi berhasil! Silakan login.'); window.location='login.php';</script>";
        } else {
            echo "<script>alert('Registrasi gagal!'); window.location='register.php';</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Dimsum Nduts</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to right, #fdf6ee, #fff8f2);
        }
        .register-container {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .register-card {
            background: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 400px;
        }
        .register-card h2 {
            font-weight: 600;
            margin-bottom: 20px;
            color: #5d4037;
        }
        .form-control {
            border-radius: 6px;
        }
        .btn-warning {
            width: 100%;
            background-color: #f0ad4e;
            border: none;
            transition: all 0.3s ease;
        }
        .btn-warning:hover {
            background-color: #f39c12;
            transform: scale(1.05);
        }
    </style>
</head>
<body>

    <div class="register-container">
        <div class="register-card">
            <h2 class="text-center">Register</h2>
            <form action="" method="POST">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" class="form-control" id="username" required autofocus>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" id="password" required>
                </div>
                <button type="submit" class="btn btn-warning mt-3">Daftar</button>
            </form>

            <div class="text-center mt-3">
                <small>Sudah punya akun? <a href="login.php">Login di sini</a></small>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
