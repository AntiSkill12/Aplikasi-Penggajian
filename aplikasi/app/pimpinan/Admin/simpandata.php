<?php
include '../../../config/koneksi.php';
$pesan='';
$nama_admin = $_POST ["nama_admin"];
$email = $_POST ["email"];
$username = $_POST ["username"];
$password = md5($_POST['password']); // Mengenkripsi kata sandi dengan MD5
$role = $_POST ["role"];


$simpan = mysqli_query ($conn, " INSERT INTO `admin` (`nama_admin`, `email`, `username`, `password`, `role`) VALUES ( '$nama_admin', '$email', '$username', '$password', '$role');");

if ($simpan){
    $pesan = 'data berhasil ditambah';
    $redirect = 'data_admin.php';
    echo("<script language='JavaScript'>
    window.alert('$pesan'); 
    window.location.href='$redirect';
    </script>");
}else{
    echo "<script> alert ('ID TIDAK BOLEH SAMA/ID SUDAH ADA')
    window.location.href='tambah_admin.php'; </script>";
   
}
?>