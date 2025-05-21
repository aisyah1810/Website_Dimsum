<?php
// Menghubungkan ke database
include('koneksi.php');

// Mengambil data menu dan stok dari database
$query = "SELECT * FROM menu";
$result = mysqli_query($koneksi, $query);

// Cek koneksi database
if (!$result) {
    die("Query gagal: " . mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dimsum Gemoiii</title>

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

        form label {
            font-weight: 600;
            color: #5d4037;
        }

        form .btn {
            font-weight: bold;
            background-color: #5d4037;
            border: none;
        }

        form .btn:hover {
            background-color: #4e342e;
        }
    </style>
</head>

<body>

    <div class="pos-f-t">
        <div class="collapse" id="navbarToggleExternalContent">
            <div class="bg-dark p-4 rounded-bottom shadow-sm">
                <h5 class="h4 d-flex align-items-center">
                    <img src="asset/logoo.jpg" alt="Dimsum" style="width: 70px; height: 70px; margin-right: 10px; border-radius: 50%;">
                    <span class="text-white">Dimsum Gemoiii</span>
                </h5>
                <span>Menu spesial kami:</span>
                <a href="index.php" class="mt-3"><i class="bi bi-house-door-fill"></i> Home</a>
                <a href="menu.php"><i class="bi bi-egg-fried"></i> Menu</a>
            </div>
        </div>
        <nav class="navbar navbar-dark">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggleExternalContent"
                aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </nav>
    </div>

    <!-- Form Order Section -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-4">Formulir Pemesanan</h2>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <form action="proses_order.php" method="POST">
                        <div class="form-group">
                            <label for="nama">Nama Lengkap</label>
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama kamu..." required>
                        </div>
                        <div class="form-group">
                            <label for="no_hp">Nomor HP / WhatsApp</label>
                            <input type="tel" class="form-control" id="no_hp" name="no_hp" placeholder="08xxxxxx" required>
                        </div>
                        <div class="form-group">
                            <label for="menu">Pilih Menu</label>
                            <select class="form-control" id="menu" name="menu" required>
                                <option value="">-- Pilih Menu --</option>
                                <?php while ($menu = mysqli_fetch_assoc($result)) { ?>
                                    <option value="<?php echo $menu['id']; ?>">
                                        <?php echo $menu['nama_menu']; ?> (Rp <?php echo number_format($menu['harga'], 0, ',', '.'); ?>) - Stok: <?php echo $menu['stok']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="jumlah">Jumlah Pesanan</label>
                            <input type="number" class="form-control" id="jumlah" name="jumlah" min="1" required>
                        </div>
                        <button type="submit" class="btn btn-success btn-block">Kirim Pesanan</button>
                    </form>
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
