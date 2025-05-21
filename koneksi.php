<?php
// Ganti dengan informasi koneksi database kamu
$host = 'mysql-0plp.railway.internal';    // Server database (biasanya localhost)
$username = 'root';     // Username database
$password = 'YPJWZYbeEMqszvFkirRKwFjMRFAKbWgk';         // Password database (kosong jika tidak ada)
$database = 'railway'; // Nama database yang benar
$port = 3306;

// Membuat koneksi ke database
$koneksi = mysqli_connect($host, $username, $password, $database);

// Memeriksa apakah koneksi berhasil
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
