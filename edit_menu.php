<?php
session_start();  // Memulai sesi

// Mengecek apakah admin sudah login
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');  // Jika belum login, arahkan ke halaman login
    exit;
}
include 'koneksi.php'; // Pastikan file koneksi ini sudah ada dan sesuai

// Ambil ID dari query string
$id = $_GET['id'];

// Ambil data menu berdasarkan ID
$query = "SELECT * FROM menu WHERE id = $id";
$result = mysqli_query($koneksi, $query);
$menu = mysqli_fetch_assoc($result);

// Menyimpan pesan status
$status_message = "";

// Proses saat form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_menu = $_POST['nama_menu'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok']; // Menangkap data stok
    $gambar = $_FILES['gambar']['name'];

    // Jika gambar diubah, upload gambar baru
    if ($gambar) {
        $tmp_name = $_FILES['gambar']['tmp_name'];
        $upload_dir = 'asset/';
        move_uploaded_file($tmp_name, $upload_dir . $gambar);

        // Hapus gambar lama jika ada
        unlink($upload_dir . $menu['gambar']);
    } else {
        // Jika tidak diubah, gunakan gambar lama
        $gambar = $menu['gambar'];
    }

    // Update menu di database
    $query = "UPDATE menu SET nama_menu = '$nama_menu', deskripsi = '$deskripsi', harga = '$harga', stok = '$stok', gambar = '$gambar' WHERE id = $id";
    if (mysqli_query($koneksi, $query)) {
        // Jika update berhasil
        echo "
        <html>
        <head>
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <style>
                body {
                    background: #fdf6ee;
                    font-family: 'Poppins', sans-serif;
                }
                .swal2-popup {
                    background: #3e2723;
                    color: #fff;
                    font-size: 18px;
                    border-radius: 8px;
                    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
                }
                .swal2-title {
                    font-size: 24px;
                    font-weight: 600;
                    color: #d4af37;
                }
                .swal2-confirm {
                    background-color: #d4af37 !important;
                    border: none;
                    color: white;
                    font-weight: bold;
                    border-radius: 5px;
                    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
                }
                .swal2-confirm:hover {
                    background-color: #f9d200 !important;
                }
            </style>
        </head>
        <body>
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Menu Berhasil Diperbarui!',
                    text: 'Terima kasih sudah memperbarui menu. Perubahan sudah disimpan.',
                    confirmButtonColor: '#3e2723',
                    confirmButtonText: 'Oke!'
                }).then(() => {
                    window.location.href = 'menu_admin.php';
                });
            </script>
        </body>
        </html>
        ";
    } else {
        // Jika ada error
        echo "
        <html>
        <head>
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <style>
                body {
                    background: #fdf6ee;
                    font-family: 'Poppins', sans-serif;
                }
                .swal2-popup {
                    background: #e53935;
                    color: #fff;
                    font-size: 18px;
                    border-radius: 8px;
                    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
                }
                .swal2-title {
                    font-size: 24px;
                    font-weight: 600;
                }
                .swal2-confirm {
                    background-color: #d33 !important;
                    border: none;
                    color: white;
                    font-weight: bold;
                    border-radius: 5px;
                    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
                }
                .swal2-confirm:hover {
                    background-color: #f44336 !important;
                }
            </style>
        </head>
        <body>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Memperbarui Menu!',
                    text: 'Ada kesalahan saat memperbarui menu. Coba lagi nanti.',
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Oke'
                }).then(() => {
                    window.history.back();
                });
            </script>
        </body>
        </html>
        ";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Menu - Dimsum Nduts</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #fdf6ee;
        }

        .container {
            max-width: 800px;
            margin-top: 50px;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-control {
            border-radius: 5px;
            padding: 12px;
        }

        .btn-primary {
            background-color: #d4af37;
            border: none;
            padding: 10px 20px;
            font-size: 1.1rem;
            width: 100%;
            border-radius: 5px;
        }

        .btn-primary:hover {
            background-color: #bfa334;
            transform: scale(1.05);
            transition: all 0.3s ease-in-out;
        }

        .card {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            padding: 25px;
            background-color: #fff;
            margin-bottom: 30px;
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: bold;
            color: #5d4037;
        }

        .img-thumbnail {
            max-width: 150px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <h2 class="card-title text-center">Edit Menu</h2>

            <form method="POST" enctype="multipart/form-data">
                <!-- Nama Menu -->
                <div class="form-group">
                    <label for="nama_menu">Nama Menu</label>
                    <input type="text" class="form-control" name="nama_menu" value="<?= $menu['nama_menu'] ?>" required>
                </div>

                <!-- Deskripsi -->
                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <input type="text" class="form-control" name="deskripsi" value="<?= $menu['deskripsi'] ?>" required>
                </div>

                <!-- Harga -->
                <div class="form-group">
                    <label for="harga">Harga</label>
                    <input type="text" class="form-control" name="harga" value="<?= $menu['harga'] ?>" required>
                </div>

                <!-- Stok -->
                <div class="form-group">
                    <label for="stok">Stok</label>
                    <input type="number" class="form-control" name="stok" value="<?= $menu['stok'] ?>" required>
                </div>

                <!-- Gambar -->
                <div class="form-group">
                    <label for="gambar">Gambar</label>
                    <input type="file" class="form-control" name="gambar" accept="image/*">
                    <img src="asset/<?= $menu['gambar'] ?>" class="img-thumbnail" alt="Gambar Menu">
                </div>

                <button type="submit" class="btn btn-primary">Update Menu</button>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
