<?php
// Menghubungkan ke database
include('koneksi.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $no_hp = $_POST['no_hp'];
    $menu_id = $_POST['menu'];
    $jumlah = $_POST['jumlah'];

    // Ambil data menu berdasarkan ID
    $query = "SELECT * FROM menu WHERE id = $menu_id";
    $result = mysqli_query($koneksi, $query);
    $menu = mysqli_fetch_assoc($result);

    // Periksa apakah stok mencukupi
    if ($menu['stok'] >= $jumlah) {
        $newStok = $menu['stok'] - $jumlah;
        $nama_menu = $menu['nama_menu']; // Ambil nama menu

        // Update stok
        $updateQuery = "UPDATE menu SET stok = $newStok WHERE id = $menu_id";
        mysqli_query($koneksi, $updateQuery);

        // Simpan pesanan ke database
        $insertQuery = "INSERT INTO pesanan (nama, no_hp, menu, jumlah) VALUES ('$nama', '$no_hp', '$nama_menu', $jumlah)";
        mysqli_query($koneksi, $insertQuery);

        // Tampilkan SweetAlert sukses
        echo "
        <html>
        <head>
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <style>
                body {
                    background-color: #795548;
                }
                .swal2-popup {
                    font-family: 'Poppins', sans-serif;
                }
                .swal2-confirm {
                    background-color: #ffeb3b !important;
                    color: #000 !important;
                }
            </style>
        </head>
        <body>
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Pesanan kamu sudah terkirim!',
                    confirmButtonText: 'Oke',
                    allowOutsideClick: false
                }).then(() => {
                    window.location.href = 'index.php';
                });
            </script>
        </body>
        </html>";
    } else {
        // Tampilkan SweetAlert gagal
        echo "
        <html>
        <head>
            <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
            <style>
                body {
                    background-color: #795548;
                }
                .swal2-popup {
                    font-family: 'Poppins', sans-serif;
                }
                .swal2-confirm {
                    background-color: #e53935 !important;
                }
            </style>
        </head>
        <body>
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Stok Tidak Cukup!',
                    text: 'Maaf, jumlah pesanan melebihi stok yang tersedia.',
                    confirmButtonText: 'Oke',
                    allowOutsideClick: false
                }).then(() => {
                    window.history.back();
                });
            </script>
        </body>
        </html>";
    }
}
?>
