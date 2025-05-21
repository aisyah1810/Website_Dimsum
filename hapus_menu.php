<?php
session_start();  // Memulai sesi

// Mengecek apakah admin sudah login
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');  // Jika belum login, arahkan ke halaman login
    exit;
}
include 'koneksi.php'; // Pastikan file koneksi ini sudah ada dan sesuai

// Validasi ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "
    <html><head><script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script></head>
    <body><script>
        Swal.fire({
            icon: 'error',
            title: 'ID tidak valid!',
            text: 'ID menu tidak ditemukan.',
            confirmButtonColor: '#d33'
        }).then(() => {
            window.location.href = 'menu_admin.php';
        });
    </script></body></html>";
    exit;
}

$id = $_GET['id'];

// Ambil data menu berdasarkan ID
$query = "SELECT * FROM menu WHERE id = $id";
$result = mysqli_query($koneksi, $query);
$menu = mysqli_fetch_assoc($result);

// Jika data tidak ditemukan
if (!$menu) {
    echo "
    <html><head><script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script></head>
    <body><script>
        Swal.fire({
            icon: 'error',
            title: 'Menu tidak ditemukan!',
            confirmButtonColor: '#d33'
        }).then(() => {
            window.location.href = 'menu_admin.php';
        });
    </script></body></html>";
    exit;
}

// Hapus gambar dari folder jika ada
$gambarPath = 'asset/' . $menu['gambar'];
if (file_exists($gambarPath) && is_file($gambarPath)) {
    unlink($gambarPath);
}

// Hapus data dari database
$query = "DELETE FROM menu WHERE id = $id";
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
                color: white;
                font-weight: bold;
                border-radius: 5px;
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
                title: 'Menu berhasil dihapus!',
                confirmButtonText: 'Oke!',
                confirmButtonColor: '#6b4f3b'
            }).then(() => {
                window.location.href = 'menu_admin.php';
            });
        </script>
    </body>
    </html>";
} else {
    $error = mysqli_error($koneksi);
    echo "
    <html><head><script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script></head>
    <body><script>
        Swal.fire({
            icon: 'error',
            title: 'Gagal menghapus!',
            text: '$error',
            confirmButtonColor: '#d33'
        }).then(() => {
            window.location.href = 'menu_admin.php';
        });
    </script></body></html>";
}
?>
