<?php
include '../../config/koneksi.php';
$pesan='';
$Nama = $_POST ["Nama"];
$Jabatan = $_POST ["Jabatan"];
$Jenis_Kelamin = $_POST ["Jenis_Kelamin"];
$Jadwal_Kerja = $_POST ["Jadwal_Kerja"];
$Tanggal_Masuk = $_POST ["Tanggal_Masuk"];


$simpan = mysqli_query ($conn, " INSERT INTO `karyawan` (`Nama`, `Jabatan`, `Jenis_Kelamin`, `Jadwal_Kerja`, `Tanggal_Masuk`) VALUES ( '$Nama', '$Jabatan', '$Jenis_Kelamin', '$Jadwal_Kerja', '$Tanggal_Masuk');");
          
if ($simpan){
    $pesan = 'data berhasil ditambah';
    $redirect = 'data_karyawan.php';
    echo("<script language='JavaScript'>
    window.alert('$pesan'); 
    window.location.href='$redirect';
    </script>");
}else{
    echo "<script> alert ('ID TIDAK BOLEH SAMA/ID SUDAH ADA')
    window.location.href='tambah_karyawan.php'; </script>";
   
}
?>