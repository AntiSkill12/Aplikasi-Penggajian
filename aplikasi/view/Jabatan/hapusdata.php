<?php
include '../../config/koneksi.php';

$id=$_GET['id'];


$hapus = mysqli_query ($conn, " DELETE FROM jabatan WHERE id ='$id' ");

if ($hapus){
    echo("<script language='JavaScript'>
    window.alert('Data Berhasil Di Hapus'); 
    window.location.href='data_jabatan.php';
    </script>");
}

?>