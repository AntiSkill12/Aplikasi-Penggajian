<?php
include '../../../config/koneksi.php';
$pesan='';
$nama_admin = $_POST["nama_admin"];
$email = $_POST["email"];
$username = $_POST["username"];
$password = md5($_POST['password']); // Mengenkripsi kata sandi dengan MD5
$role = $_POST["role"];

// Cek apakah email sudah ada di database
$cek_email = mysqli_query($conn, "SELECT * FROM admin WHERE email = '$email'");
if (mysqli_num_rows($cek_email) > 0) {
    // Jika email sudah ada, tampilkan pesan bahwa email sudah digunakan
    echo "<script> alert('Email sudah digunakan. Silakan gunakan email lain.'); window.location.href='tambah_admin.php'; </script>";
} else {
    // Cek apakah username sudah ada di database
    $cek_username = mysqli_query($conn, "SELECT * FROM admin WHERE username = '$username'");
    if (mysqli_num_rows($cek_username) > 0) {
        // Jika username sudah ada, tampilkan pesan bahwa username sudah digunakan
        echo "<script> alert('Username sudah digunakan. Silakan gunakan username lain.'); window.location.href='tambah_admin.php'; </script>";
    } else {
        // Jika email dan username belum ada, lakukan proses penyimpanan data
        $simpan = mysqli_query($conn, "INSERT INTO `admin` (`nama_admin`, `email`, `username`, `password`, `role`) VALUES ('$nama_admin', '$email', '$username', '$password', '$role')");

        if ($simpan) {
            $pesan = 'data berhasil ditambah';
            $redirect = 'data_admin.php';
            echo ("<script language='JavaScript'>
                window.alert('$pesan');
                window.location.href='$redirect';
                </script>");
        } else {
            echo "<script> alert ('Gagal menambahkan data'); window.location.href='tambah_admin.php'; </script>";
        }
    }
}
?>
