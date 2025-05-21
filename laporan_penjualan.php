<?php
session_start();  // Memulai sesi

// Mengecek apakah admin sudah login
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');  // Jika belum login, arahkan ke halaman login
    exit;
}
include 'koneksi.php'; // Pastikan file koneksi ini sudah ada dan sesuai

$bulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('m');
$tahun = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');

$query = mysqli_query($koneksi, "SELECT * FROM laporan_penjualan 
    WHERE MONTH(tanggal) = '$bulan' AND YEAR(tanggal) = '$tahun'");

$totalPendapatan = 0;
$data = [];

while ($row = mysqli_fetch_assoc($query)) {
    $data[] = $row;
    $totalPendapatan += $row['total'];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <!-- Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

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
            margin-top: 30px;
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

    <!-- Konten Laporan -->
    <div class="container">
        <h2 class="mt-4">Laporan Penjualan Dimsum Nduts</h2>

        <form method="get" class="mb-4 d-flex">
            <select name="bulan" class="form-control me-2">
                <?php
                for ($i = 1; $i <= 12; $i++) {
                    $selected = ($i == $bulan) ? 'selected' : '';
                    echo "<option value='$i' $selected>" . date("F", mktime(0, 0, 0, $i, 1)) . "</option>";
                }
                ?>
            </select>
            <select name="tahun" class="form-control me-2">
                <?php
                for ($y = 2025; $y <= date('Y') + 5; $y++) {
                    $selected = ($y == $tahun) ? 'selected' : '';
                    echo "<option value='$y' $selected>$y</option>";
                }
                ?>
            </select>
            <button type="submit" class="btn btn-primary">Tampilkan</button>
        </form>

        <div class="table-container">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Menu</th>
                        <th>Jumlah Terjual</th>
                        <th>Harga Satuan</th>
                        <th>Total</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (count($data) > 0) {
                        $no = 1;
                        foreach ($data as $d) {
                            echo "<tr>
                                <td>{$no}</td>
                                <td>{$d['nama_menu']}</td>
                                <td>{$d['jumlah_terjual']}</td>
                                <td class='text-end'>Rp " . number_format($d['harga_satuan'], 0, ',', '.') . "</td>
                                <td class='text-end'>Rp " . number_format($d['total'], 0, ',', '.') . "</td>
                                <td>" . date('d-m-Y', strtotime($d['tanggal'])) . "</td>
                            </tr>";
                            $no++;
                        }
                    } else {
                        echo "<tr><td colspan='6' class='text-center'>Tidak ada data penjualan bulan ini</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <h4 class="mt-4">Total Pendapatan Bulan Ini: <strong>Rp <?= number_format($totalPendapatan, 0, ',', '.') ?></strong></h4>
    </div>

    <footer class="bg-dark text-white text-center py-4">
        <p>&copy; 2025 Dimsum Nduts. All Rights Reserved.</p>
        <p>Follow us on <a href="https://www.instagram.com/dimsum.nduts_/?utm_source=ig_web_button_share_sheet" class="text-warning">Instagram</a></p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
