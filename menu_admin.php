<?php
session_start();  // Memulai sesi

// Mengecek apakah admin sudah login
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');  // Jika belum login, arahkan ke halaman login
    exit;
}
include 'koneksi.php'; // Pastikan file koneksi ini sudah ada dan sesuai

// Mengambil data menu dari database
$query = "SELECT * FROM menu";
$result = mysqli_query($koneksi, $query);  // Ganti $conn dengan $koneksi

// Cek koneksi database
if (!$result) {
    die("Query gagal: " . mysqli_error($koneksi));  // Ganti $conn dengan $koneksi
}

// Menangani aksi hapus
if (isset($_GET['id']) && isset($_GET['action']) && $_GET['action'] == 'delete') {
    $id = $_GET['id'];
    $deleteQuery = "DELETE FROM menu WHERE id = $id";
    mysqli_query($koneksi, $deleteQuery);  // Ganti $conn dengan $koneksi
    header("Location: menu_admin.php"); // Redirect ke halaman yang sama setelah hapus
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

    .table thead {
      background-color: #5d4037;
      color: #fff8e1;
    }

    .btn-warning:hover,
    .btn-danger:hover,
    .add-btn:hover {
      transform: scale(1.05);
      transition: all 0.3s ease-in-out;
    }

    .btn-warning:hover {
      background-color: #f39c12;
    }

    .btn-danger:hover {
      background-color: #e74c3c;
    }

    .add-btn {
      background-color: #d4af37;
      border: none;
    }

    .add-btn:hover {
      background-color: #bfa334;
    }

    .card {
      border-radius: 15px;
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
      overflow: hidden;
    }

    h2 {
      font-weight: 700;
      color: #5d4037;
    }

    .nav-link {
      display: block;
      color: #fff8e1;
      margin-top: 10px;
      font-weight: 500;
    }

    .nav-link:hover {
      color: #d4af37;
      text-decoration: none;
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
        <div class="mt-3">
          <a href="index_admin.php" class="nav-link"><i class="bi bi-house-door-fill"></i> Dashboard</a>
          <a href="daftar_pesanan_admin.php" class="nav-link"><i class="bi bi-journal-text"></i> Daftar Pesanan</a>
          <a href="menu_admin.php" class="nav-link"><i class="bi bi-egg-fried"></i> Manajemen Menu</a>
          <a href="laporan_penjualan.php"><i class="bi bi-file-earmark-spreadsheet"></i> Laporan Penjualan</a>
          <a href="logout.php" class="nav-link"><i class="bi bi-door-open"></i> Logout</a>
        </div>
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
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2>Manajemen Menu</h2>
      <a href="tambah_menu.php" class="btn add-btn">
        <i class="bi bi-plus-circle"></i> Tambah Menu
      </a>
    </div>

    <div class="card p-4">
      <div class="table-responsive">
        <table class="table table-hover text-center">
          <thead>
            <tr>
              <th>No</th>
              <th>Gambar</th>
              <th>Nama Menu</th>
              <th>Deskripsi</th>
              <th>Harga</th>
              <th>Stok</th> <!-- Menambahkan kolom stok -->
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no = 1;
            while ($menu = mysqli_fetch_assoc($result)) {
            ?>
            <tr>
              <td><?php echo $no++; ?></td>
              <td><img src="asset/<?php echo $menu['gambar']; ?>" alt="Dimsum" style="width: 80px; height: 80px; border-radius: 10px;"></td>
              <td><?php echo $menu['nama_menu']; ?></td>
              <td><?php echo $menu['deskripsi']; ?></td>
              <td>Rp <?php echo number_format($menu['harga'], 0, ',', '.'); ?></td>
              <td><?php echo $menu['stok']; ?></td> <!-- Menampilkan stok -->
              <td>
                <a href="edit_menu.php?id=<?php echo $menu['id']; ?>" class="btn btn-warning btn-sm">
                  <i class="bi bi-pencil-square"></i> Edit
                </a>
                <a href="?id=<?php echo $menu['id']; ?>&action=delete" class="btn btn-danger btn-sm" onclick="return confirm('Yakin mau hapus menu ini?');">
                  <i class="bi bi-trash"></i> Hapus
                </a>
              </td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
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
