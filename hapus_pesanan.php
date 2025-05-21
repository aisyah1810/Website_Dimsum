<?php
session_start();  // Memulai sesi

// Mengecek apakah admin sudah login
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');  // Jika belum login, arahkan ke halaman login
    exit;
}
include 'koneksi.php'; // Pastikan file koneksi ini sudah ada dan sesuai

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = "DELETE FROM pesanan WHERE id = $id";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        echo "
        <html>
        <head>
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        </head>
        <body>
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Pesanan berhasil dihapus!',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = 'daftar_pesanan_admin.php';
                });
            </script>
        </body>
        </html>";
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
                    title: 'Gagal menghapus!',
                    text: '" . mysqli_error($koneksi) . "',
                    confirmButtonText: 'Kembali'
                }).then(() => {
                    window.location.href = 'daftar_pesanan_admin.php';
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
                icon: 'warning',
                title: 'ID tidak ditemukan!',
                confirmButtonText: 'Kembali'
            }).then(() => {
                window.location.href = 'daftar_pesanan_admin.php';
            });
        </script>
    </body>
    </html>";
}
?>
