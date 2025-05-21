<?php
session_start();
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = htmlspecialchars($_POST['username']);
    $password = $_POST['password'];

    $query = mysqli_query($koneksi, "SELECT * FROM admin WHERE username='$username'");
    $data = mysqli_fetch_assoc($query);

    if ($data && password_verify($password, $data['password'])) {
        $_SESSION['admin'] = $data['username'];
        echo "
        <html>
        <head>
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <style>
                body {
                    background-color: #795548;
                }
                .swal2-popup {
                    font-family: 'Poppins', sans-serif;
                    background-color: #3e2723;
                    color: #fff;
                }
                .swal2-title {
                    color: #ffeb3b;
                }
                .swal2-confirm {
                    background-color: #ffeb3b !important;
                    color: #000 !important;
                }
            </style>
        </head>
        <body>
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil Login!',
                    text: 'Selamat datang di halaman admin.',
                    confirmButtonText: 'Masuk',
                    confirmButtonColor: '#ffeb3b'
                }).then(() => {
                    window.location = 'index_admin.php'; // Redirect ke halaman admin
                });
            </script>
        </body>
        </html>";
        exit;
    } else {
        echo "
        <html>
        <head>
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <style>
                body {
                    background-color: #795548;
                }
                .swal2-popup {
                    font-family: 'Poppins', sans-serif;
                    background-color: #3e2723;
                    color: #fff;
                }
                .swal2-title {
                    color: #ffeb3b;
                }
                .swal2-confirm {
                    background-color: #ffeb3b !important;
                    color: #000 !important;
                }
                .swal2-cancel {
                    background-color: #e53935 !important;
                    color: #fff !important;
                }
            </style>
        </head>
        <body>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Username atau Password salah!',
                    text: 'Periksa kembali kredensial Anda.',
                    confirmButtonText: 'Coba Lagi',
                    confirmButtonColor: '#ffeb3b'
                }).then(() => {
                    window.location = 'login.php'; // Redirect ke login.php
                });
            </script>
        </body>
        </html>";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - Dimsum Nduts</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to right, #fdf6ee, #fff8f2);
        }
        .login-container {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .login-card {
            background: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
            width: 100%;
            max-width: 400px;
        }
        .login-card h2 {
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
    <div class="login-container">
    <div class="login-card">
        <h2 class="text-center">Login</h2>
        <form action="" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" class="form-control" id="username" required autofocus>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control" id="password" required>
            </div>
            <button type="submit" class="btn btn-warning mt-3">Login</button>
        </form>

        <!-- Link ke register -->
        <div class="text-center mt-3">
            <small>Belum punya akun? <a href="register.php">Daftar di sini</a></small>
        </div>
    </div>
</div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
