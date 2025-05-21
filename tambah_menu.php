<?php
session_start();  // Memulai sesi

// Mengecek apakah admin sudah login
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');  // Jika belum login, arahkan ke halaman login
    exit;
}
include 'koneksi.php'; // Pastikan file koneksi ini sudah ada dan sesuai

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_menu  = mysqli_real_escape_string($koneksi, $_POST['nama_menu']);
    $deskripsi  = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
    $harga      = $_POST['harga'];
    $stok       = $_POST['stok'];  // Ambil stok dari form

    $gambar         = $_FILES['gambar']['name'];
    $gambar_tmp     = $_FILES['gambar']['tmp_name'];
    $gambar_error   = $_FILES['gambar']['error'];

    if (empty($nama_menu) || empty($deskripsi) || empty($harga) || empty($stok) || empty($gambar)) {
        echo "
        <html>
        <head>
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        </head>
        <body>
            <script>
                Swal.fire({
                    icon: 'warning',
                    title: 'Form Belum Lengkap!',
                    text: 'Semua field harus diisi!',
                    confirmButtonColor: '#6b4f3b'
                }).then(() => {
                    window.history.back();
                });
            </script>
        </body>
        </html>";
        exit;
    }

    if ($gambar_error === 0) {
        $gambar_ext = strtolower(pathinfo($gambar, PATHINFO_EXTENSION));
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($gambar_ext, $allowed_ext)) {
            $gambar_new_name = uniqid('menu_', true) . '.' . $gambar_ext;
            $gambar_upload_path = 'asset/' . $gambar_new_name;

            if (move_uploaded_file($gambar_tmp, $gambar_upload_path)) {
                $query = "INSERT INTO menu (nama_menu, deskripsi, harga, stok, gambar) 
                          VALUES ('$nama_menu', '$deskripsi', '$harga', '$stok', '$gambar_new_name')";

                if (mysqli_query($koneksi, $query)) {
                    echo "
                    <html>
                    <head>
                        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                        <style>
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
                                title: 'Menu berhasil ditambahkan!',
                                confirmButtonText: 'Oke!',
                                confirmButtonColor: '#6b4f3b'
                            }).then(() => {
                                window.location.href = 'menu_admin.php';
                            });
                        </script>
                    </body>
                    </html>";
                    exit;
                } else {
                    $error_msg = mysqli_error($koneksi);
                    echo "
                    <html>
                    <head>
                        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                    </head>
                    <body>
                        <script>
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal Menyimpan!',
                                text: 'Terjadi kesalahan saat menyimpan: $error_msg',
                                confirmButtonColor: '#d33'
                            }).then(() => {
                                window.history.back();
                            });
                        </script>
                    </body>
                    </html>";
                }
            } else {
                echo "
                <html>
                <head>
                    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
                </head>
                <body>
                    <script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Upload Gagal!',
                            text: 'Gagal mengunggah gambar.',
                            confirmButtonColor: '#d33'
                        }).then(() => {
                            window.history.back();
                        });
                    </script>
                </body>
                </html>";
            }
        } else {
            echo "
            <html>
            <head>
                <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            </head>
            <body>
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Format Tidak Didukung!',
                        text: 'Format gambar harus JPG, JPEG, PNG, atau GIF.',
                        confirmButtonColor: '#d33'
                    }).then(() => {
                        window.history.back();
                    });
                </script>
            </body>
            </html>";
        }
    } else {
        echo "
        <html>
        <head>
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        </head>
        <body>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Upload Error!',
                    text: 'Terjadi kesalahan saat upload gambar.',
                    confirmButtonColor: '#d33'
                }).then(() => {
                    window.history.back();
                });
            </script>
        </body>
        </html>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Menu - Dimsum Gemoiii</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #fdf6ec;
            font-family: 'Poppins', sans-serif;
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
            color: #6b4f3b;
        }

        .card {
            background-color: #fffefc;
            border: none;
            border-radius: 20px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
        }

        .btn-coklat {
            background-color: #6b4f3b;
            color: #fff;
            border: none;
            transition: background-color 0.3s ease;
        }

        .btn-coklat:hover {
            background-color: #5a3f2f;
        }

        h3 {
            color: #6b4f3b;
            font-weight: 700;
        }

        label {
            color: #6b4f3b;
            font-weight: 500;
        }

        .form-control:focus {
            border-color: #d3b8a1;
            box-shadow: 0 0 0 0.1rem rgba(211, 184, 161, 0.25);
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .logo {
            width: 80px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

    <div class="container py-5">
        <div class="header">
            <img src="asset/logo.jpg" alt="Logo Dimsum Gemoiii" class="logo"> <!-- Ganti dengan logo kamu -->
            <h3>Tambah Menu Baru</h3>
            <p class="text-muted">Isi form di bawah untuk menambahkan menu baru ke daftar</p>
        </div>

        <div class="card p-4 mx-auto" style="max-width: 600px;">
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="nama_menu" class="form-label">Nama Menu</label>
                    <input type="text" class="form-control" id="nama_menu" name="nama_menu" placeholder="Contoh: Dimsum Ayam Original" required>
                </div>

                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" placeholder="Deskripsi singkat menu..." required></textarea>
                </div>

                <div class="mb-3">
                    <label for="harga" class="form-label">Harga (Rp)</label>
                    <input type="number" class="form-control" id="harga" name="harga" placeholder="Misal: 15000" required>
                </div>

                <div class="mb-3">
                    <label for="stok" class="form-label">Stok</label>
                    <input type="number" class="form-control" id="stok" name="stok" placeholder="Misal: 50" required>
                </div>

                <div class="mb-3">
                    <label for="gambar" class="form-label">Upload Gambar</label>
                    <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*" required>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-coklat rounded-pill">+ Tambahkan Menu</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
