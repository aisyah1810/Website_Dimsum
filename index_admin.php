<?php
session_start();  // Memulai sesi

// Mengecek apakah admin sudah login
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');  // Jika belum login, arahkan ke halaman login
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dimsum Gemoiii</title>

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
            background-attachment: fixed;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background-color: #3e2723 !important;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        }

        .bg-dark {
            background-color: #5d4037 !important;
        }

        .navbar-toggler {
            border-color: #d4af37;
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28212,175,55, 0.9%29' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        .collapse a {
            font-size: 1.1rem;
            padding: 8px 0;
            color: #f5f5f5 !important;
            transition: all 0.3s ease;
            display: block;
            text-decoration: none;
        }

        .collapse a i {
            margin-right: 8px;
        }

        .collapse a:hover {
            color: #d4af37 !important;
            padding-left: 12px;
        }

        .bg-dark h5 {
            font-weight: 600;
            color: #fff8e1;
            margin-bottom: 10px;
        }

        .bg-dark span {
            color: #d7ccc8;
        }

        .shadow-sm {
            box-shadow: 0 6px 10px rgba(0, 0, 0, 0.15) !important;
        }

        .admin-dashboard {
            margin: 20px;
        }

        .card img {
            transition: transform 0.4s ease, box-shadow 0.4s ease;
        }

        .card:hover img {
            transform: scale(1.05) rotate(-1deg);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);
        }

        .btn-custom {
            background-color: #d4af37;
            color: #fff;
        }

        .btn-custom:hover {
            background-color: #f39c12;
        }
    </style>
</head>

<body>

    <div class="pos-f-t">
        <div class="collapse" id="navbarToggleExternalContent">
            <div class="bg-dark p-4 rounded-bottom shadow-sm">
                <h5 class="h4 d-flex align-items-center">
                    <img src="asset/logoo.jpg" alt="Dimsum" style="width: 70px; height: 70px; margin-right: 10px; border-radius: 50%;">
                    <span class="text-white">Dimsum Nduts Admin</span>
                </h5>
                <span>Menu Admin:</span>
                <a href="index_admin.php" class="mt-3"><i class="bi bi-house-door-fill"></i> Dashboard</a>
                <a href="daftar_pesanan_admin.php"><i class="bi bi-journal-text"></i> Daftar Pesanan</a>
                <a href="menu_admin.php"><i class="bi bi-egg-fried"></i> Manajemen Menu</a>
                <a href="laporan_penjualan.php"><i class="bi bi-file-earmark-spreadsheet"></i> Laporan Penjualan</a>
                <a href="logout.php"><i class="bi bi-door-open"></i> Logout</a>
            </div>
        </div>

        <nav class="navbar navbar-dark">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggleExternalContent"
                aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </nav>
    </div>

    <!-- Admin Dashboard Section -->
    <section class="admin-dashboard">
        <div class="container">
            <h2 class="text-center mb-4">Dashboard Admin</h2>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="asset/admin1.jpg" class="card-img-top" alt="Daftar Pesanan">
                        <div class="card-body text-center">
                            <h5 class="card-title">Daftar Pesanan</h5>
                            <p class="card-text">Kelola pesanan dari pelanggan dengan mudah.</p>
                            <a href="daftar_pesanan_admin.php" class="btn btn-custom">Lihat Pesanan</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="asset/admin2.jpg" class="card-img-top" alt="Manajemen Menu">
                        <div class="card-body text-center">
                            <h5 class="card-title">Manajemen Menu</h5>
                            <p class="card-text">Tambah, edit, dan hapus menu dimsum yang tersedia.</p>
                            <a href="menu_admin.php" class="btn btn-custom">Kelola Menu</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="asset/admin3.jpg" class="card-img-top" alt="Statistik Penjualan">
                        <div class="card-body text-center">
                            <h5 class="card-title">Statistik Penjualan</h5>
                            <p class="card-text">Lihat statistik dan laporan penjualan bulanan.</p>
                            <a href="laporan_penjualan.php" class="btn btn-custom">Lihat Laporan</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer Section -->
   <footer class="bg-dark text-white text-center py-4">
        <p>&copy; 2025 Dimsum Nduts. All Rights Reserved.</p>
        <p>Follow us on <a href="https://www.instagram.com/dimsum.nduts_/?utm_source=ig_web_button_share_sheet" class="text-warning">Instagram</a></p>
    </footer>
    
    <!-- Bootstrap JS + dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>
