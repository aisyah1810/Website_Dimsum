<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background-color: #3e2723;
        }
        .swal2-popup {
            font-family: 'Poppins', sans-serif;
            background-color: #3e2723;
            color: #fff;
        }
        .swal2-title {
            color: #ffeb3b;
        }
        .swal2-confirm {
            background-color: #ffeb3b !important;
            color: #000 !important;
        }
        .swal2-cancel {
            background-color: #e53935 !important;
            color: #fff !important;
        }
    </style>
</head>
<body>
<script>
    Swal.fire({
        title: 'Yakin mau logout?',
        text: 'Kamu akan keluar dari halaman admin.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, logout',
        cancelButtonText: 'Batal',
        reverseButtons: true,
    }).then((result) => {
        if (result.isConfirmed) {
            // Redirect ke logout handler untuk destroy session
            window.location.href = 'logout_process.php';
        } else {
            // Balik ke dashboard atau halaman sebelumnya
            window.history.back();
        }
    });
</script>
</body>
</html>
