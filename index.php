<?php
// auth.php
session_start();


if (!isset($_SESSION['id'])) {
    // Pengguna belum login, alihkan ke halaman login
    header("Location: http://localhost/Gaji_karyawan/aplikasi/view/Login.php");
    exit;
}

// Jika pengguna telah login, arahkan ke halaman dashboard sesuai peran
if ($_SESSION['role'] === 'pimpinan') {
    header("Location: http://localhost/Gaji_Karyawan/aplikasi/app/pimpinan/dashboard.php");
} elseif ($_SESSION['role'] === 'admin') {
    header("Location: http://localhost/Gaji_karyawan/aplikasi/view/dashboard.php");
} else {
    // Peran lainnya bisa ditambahkan di sini
}

?>
