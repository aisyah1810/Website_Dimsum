<?php
session_start();  // Memulai sesi

// Mengecek apakah admin sudah login
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');  // Jika belum login, arahkan ke halaman login
    exit;
}
include 'koneksi.php'; // Pastikan file koneksi ini sudah ada dan sesuai

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = mysqli_query($koneksi, "SELECT * FROM pesanan WHERE id = $id");
    $data = mysqli_fetch_assoc($query);

    if ($data) {
        $menu = $data['menu'];
        $jumlah = $data['jumlah'];

        $cekHarga = mysqli_query($koneksi, "SELECT harga FROM menu WHERE nama_menu = '$menu'");
        $menuData = mysqli_fetch_assoc($cekHarga);

        if ($menuData) {
            $harga = $menuData['harga'];
            $total = $jumlah * $harga;

            mysqli_query($koneksi, "INSERT INTO laporan_penjualan 
                (nama_menu, jumlah_terjual, harga_satuan, total, tanggal) 
                VALUES ('$menu', $jumlah, $harga, $total, NOW())");

            mysqli_query($koneksi, "DELETE FROM pesanan WHERE id = $id");

            $_SESSION['alert'] = [
                'type' => 'success',
                'title' => 'Pesanan Selesai!',
                'text' => 'Pesanan berhasil dipindahkan ke laporan penjualan.'
            ];
        } else {
            $_SESSION['alert'] = [
                'type' => 'error',
                'title' => 'Menu Tidak Ditemukan!',
                'text' => 'Menu "' . $menu . '" tidak ditemukan di database menu.'
            ];
        }
    }
}

header('Location: daftar_pesanan_admin.php');
exit();
?>
