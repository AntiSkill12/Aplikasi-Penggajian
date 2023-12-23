<?php
include '../../../config/auth.php'; 
include '../../../config/koneksi.php';

$id=$_SESSION['id'];
$username=$_SESSION['username'];

// Query untuk mengambil username dari database
$queryUsername = mysqli_query($conn, "SELECT username FROM admin WHERE id = $id");
$dataUsername = mysqli_fetch_assoc($queryUsername);
$username = $dataUsername['username'];
?>
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../asset/css/tambahhPoGa.css">
    <link rel="stylesheet" href="../../../asset/css/nama.css">
    <title>HALAMAN TAMBAH DATA</title>
    <link rel="icon" type="image/png" href="../../../asset/img/icons/logo1.jpg"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>

<body>
  <div class="p" id="header">
    <img src="../../../asset/img/logo.jpg" alt="">
    <p1>PONDOK COFFEE BU SEH <p3></p3></p1>
    <p3 class="nama">Selamat Datang <?=$username;?></p3>
  </div>

  <p class="list">Tambah Data Admin</p>
  
  <div class="menu">
        <br><h1>PENGGAJIAN <br> KARYAWAN <br></h1>
        <ul>
        <li><a href="http://localhost/Gaji_Karyawan/aplikasi/app/pimpinan/dashboard.php"><i class="bi bi-house-fill"></i> Dashboard</a></li>
        <li class="dropdown-trigger">
        <a href="#"><i class="bi bi-database-fill-add"></i> Karyawan <i class="bi bi-node-plus"></i></a>
            <ul class="dropdown">
            <li><a href="http://localhost/Gaji_Karyawan/aplikasi/app/pimpinan/karyawan/data_karyawan.php"><i class="bi bi-person-lines-fill"></i>Data Karyawan</a></li>
            <li><a href="http://localhost/Gaji_Karyawan/aplikasi/app/pimpinan/Jabatan/data_jabatan.php"><i class="bi bi-file-person-fill"></i> Data Jabatan</a></li>
            </ul>
        </li>
        <li class="dropdown-trigger">
            <a href="#"><i class="bi bi-credit-card-fill"></i> Transaksi <i class="bi bi-node-plus"></i></a>
            <ul class="dropdown">
            <li><a href="http://localhost/Gaji_Karyawan/aplikasi/app/pimpinan/Absensi/absensi.php"><i class="bi bi-scissors"></i> Potongan Gaji</a></li>
            <li><a href="http://localhost/Gaji_Karyawan/aplikasi/app/pimpinan/Gaji/gaji.php"><i class="bi bi-cash-stack"></i> Gaji</a></li>
            </ul>
        </li>
        <li><a href="http://localhost/Gaji_Karyawan/aplikasi/app/pimpinan/Admin/data_admin.php"><i class="bi bi-file-earmark-medical-fill"></i> Data Admin</a></li>
        <li><a href="http://localhost/Gaji_Karyawan/aplikasi/app/pimpinan/Pimpinan/profil.php"><i class="bi bi-person-fill-lock"></i> Pimpinan</a></li>
        <li><a href="http://localhost/Gaji_karyawan/aplikasi/view/Logout.php"><i class="bi bi-door-open-fill"></i> Logout</a></li>
        </ul>
    </div>

  <form action="simpandata.php" method="POST" >
    <table class="tambahdata">
        <tr>
          <td><h2>MASUKAN DATA</h2></td>
        </tr>
        <tr>
          <td>Nama</td>
          <td>:</td>
          <td><input type="text" name="nama_admin" placeholder="" required></td>
        </tr>
        <tr>
          <td>Email</td>
          <td>:</td>
          <td><input type="text" name="email" placeholder="" required></td>
        </tr>
        <tr>
          <td>Username</td>
          <td>:</td>
          <td><input type="text" name="username" placeholder="" required></td>
        </tr>
        <tr>
          <td>Password</td>
          <td>:</td>
          <td><input type="password" name="password" placeholder="" required></td>
        </tr>
        <tr>
          <td>Role</td>
          <td>:</td>
          <td><select name="role" required>
            <selected>
              <option value="">--Pilih Role--</option>
              <option value="admin">ADMIN</option>
              </td>
          </selected>
        </tr>
        <tr>
            <td><br>
              <input type="submit" name="simpan" value="Simpan">
              <input type="reset" name="hapus" value="Hapus">
              <input type="button" name="kembali" value="Kembali" onclick ="self.history.back()">
            </td>
        </tr> 
        </tr>
        </table>
    </form>
  

  
</body>