<?php
session_start();  // Memulai sesi

// Mengecek apakah admin sudah login
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');  // Jika belum login, arahkan ke halaman login
    exit;
}
include 'koneksi.php'; // Pastikan file koneksi ini sudah ada dan sesuai
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin - Daftar Pesanan</title>

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

    .table-container {
    background: #fff;
    padding: 25px;
    border-radius: 20px;
    box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
    overflow-x: auto;
}

.table {
    border-collapse: separate;
    border-spacing: 0;
    width: 100%;
    background-color: #fff8f2;
    border-radius: 15px;
    overflow: hidden;
}

.table th {
    background-color: #d7ccc8;
    color: #3e2723;
    font-weight: 600;
    text-align: center;
    vertical-align: middle;
    padding: 12px;
}

.table td {
    text-align: center;
    padding: 12px;
    vertical-align: middle;
    color: #3e2723;
}

.table-hover tbody tr:hover {
    background-color: #f3e9e4;
    transition: background-color 0.3s ease;
}

.badge-warning {
    background-color: #f39c12;
    color: white;
    padding: 6px 10px;
    border-radius: 10px;
    font-size: 0.9rem;
}

.badge-success {
    background-color: #2ecc71;
    color: white;
    padding: 6px 10px;
    border-radius: 10px;
    font-size: 0.9rem;
}

    </style>
</head>

<body>
    <!-- Navbar -->
    <div class="pos-f-t">
        <div class="collapse" id="navbarToggleExternalContent">
            <div class="bg-dark p-4 rounded-bottom shadow-sm">
                <h5 class="h4 d-flex align-items-center">
                    <img src="asset/logoo.jpg" alt="Dimsum" style="width: 70px; height: 70px; margin-right: 10px; border-radius: 50%;">
                    <span class="text-white">Dimsum Nduts - Admin</span>
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
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </nav>
    </div>

    <!-- Daftar Pesanan Section -->
    <section class="order-list py-5">
        <div class="container">
            <h2 class="text-center mb-4 font-weight-bold">Daftar Pesanan</h2>

            <div class="table-container">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pemesan</th>
                            <th>Nomer Handphone</th>
                            <th>Menu</th>
                            <th>Jumlah</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $query = "SELECT * FROM pesanan ORDER BY waktu_pesan DESC";
                        $result = mysqli_query($koneksi, $query); // Ganti conn menjadi $koneksi

                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>
                                        <td>{$no}</td>
                                        <td>{$row['nama']}</td>
                                        <td>{$row['no_hp']}</td>
                                        <td>{$row['menu']}</td>
                                        <td>{$row['jumlah']}</td>
                                        <td>
                                            <a href='hapus_pesanan.php?id={$row['id']}' class='btn btn-danger btn-sm' onclick=\"return confirm('Yakin ingin menghapus pesanan ini?');\">Hapus</a>
                                            <a href='selesaikan_pesanan.php?id={$row['id']}' class='btn btn-success btn-sm' onclick=\"return confirm('Pesanan ini akan ditandai sebagai selesai dan masuk ke laporan penjualan. Lanjutkan?');\">Selesai</a>
                                        </td>
                                    </tr>";
                                $no++;
                            }
                        } else {
                            echo "<tr><td colspan='5'>Belum ada pesanan masuk.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <!-- Footer -->
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
