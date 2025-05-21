<?php
// Menghubungkan ke database
include('koneksi.php');

// Mengambil data menu dari database
$query = "SELECT * FROM menu";
$result = mysqli_query($koneksi, $query);

// Cek koneksi database
if (!$result) {
    die("Query gagal: " . mysqli_error($koneksi));
}

// Menangani aksi hapus
if (isset($_GET['id']) && isset($_GET['action']) && $_GET['action'] == 'delete') {
    $id = $_GET['id'];
    $deleteQuery = "DELETE FROM menu WHERE id = $id";
    mysqli_query($koneksi, $deleteQuery);
    header("Location: menu_admin.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Menu Management - Dimsum Nduts</title>

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

        .card {
            border-radius: 15px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-bottom: 30px;
        }

        .card-img-top {
            height: 250px;
            object-fit: cover;
        }

        .card-body {
            background-color: #fff;
            padding: 15px;
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #5d4037;
        }

        .card-text {
            font-size: 1rem;
            color: #6b4f3c;
            margin-bottom: 15px;
        }

        .card-price {
            font-size: 1.2rem;
            font-weight: bold;
            color: #d4af37;
            margin-bottom: 20px;
        }

        .card-stock {
            font-size: 1rem;
            color: #ff5722;
            font-weight: bold;
            margin-bottom: 15px;
        }

        .card-footer {
            text-align: center;
            background-color: #fff;
        }

        .btn-custom {
            background-color: #d4af37;
            border: none;
            color: white;
            padding: 10px 20px;
            font-size: 1rem;
            border-radius: 5px;
            width: 100%;
        }

        .btn-custom:hover {
            background-color: #bfa334;
            transform: scale(1.05);
            transition: all 0.3s ease-in-out;
        }

        h2 {
            font-weight: 700;
            color: #5d4037;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

    <div class="pos-f-t">
        <div class="collapse" id="navbarToggleExternalContent">
            <div class="bg-dark p-4 rounded-bottom shadow-sm">
                <h5 class="h4 d-flex align-items-center">
                    <img src="asset/logoo.jpg" alt="Dimsum" style="width: 70px; height: 70px; margin-right: 10px; border-radius: 50%;">
                    <span class="text-white">Dimsum Nduts</span>
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

    <div class="container my-5">
        <h2>Menu Dimsum Nduts</h2>

       <div class="row justify-content-center">
            <?php
            $no = 1;
            while ($menu = mysqli_fetch_assoc($result)) {
            ?>
                <div class="col-md-4">
                    <div class="card">
                        <img src="asset/<?php echo $menu['gambar']; ?>" class="card-img-top" alt="Dimsum">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $menu['nama_menu']; ?></h5>
                            <p class="card-text"><?php echo $menu['deskripsi']; ?></p>
                            <p class="card-price">Rp <?php echo number_format($menu['harga'], 0, ',', '.'); ?></p>
                            <p class="card-stock">Stok: <?php echo $menu['stok']; ?></p> <!-- Menambahkan stok -->
                        </div>
                        <div class="card-footer">
                            <a href="from_order.php" class="btn btn-custom"><i class="bi bi-cart-fill"></i> Pesan</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
     <!-- Footer -->
      <footer class="bg-dark text-white text-center py-4">
        <p>&copy; 2025 Dimsum Nduts. All Rights Reserved.</p>
        <p>Follow us on <a href="https://www.instagram.com/dimsum.nduts_/?utm_source=ig_web_button_share_sheet" class="text-warning">Instagram</a></p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
