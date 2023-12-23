<?php
// auth.php
session_start();


if (!isset($_SESSION['id'])) {
    // Pengguna belum login, alihkan ke halaman login
    header("Location: http://localhost/Gaji_karyawan/aplikasi/view/Login.php");
    exit;
}


?>
