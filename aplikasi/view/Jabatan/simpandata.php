<?php
include '../../config/koneksi.php';
$pesan='';
$nama_jabatan = $_POST ["nama_jabatan"];
$gaji_pokok = $_POST ["gaji_pokok"];
$uang_makan = $_POST ["uang_makan"];


$simpan = mysqli_query ($conn, " INSERT INTO `jabatan` (`nama_jabatan`, `gaji_pokok`, `uang_makan`) VALUES ( '$nama_jabatan', '$gaji_pokok', '$uang_makan');");
          
if ($simpan){
    $pesan = 'data berhasil ditambah';
    $redirect = 'data_jabatan.php';
    echo("<script language='JavaScript'>
    window.alert('$pesan'); 
    window.location.href='$redirect';
    </script>");
}else{
    echo "<script> alert ('ID TIDAK BOLEH SAMA/ID SUDAH ADA')
    window.location.href='tambah_jabatan.php'; </script>";
}
?>