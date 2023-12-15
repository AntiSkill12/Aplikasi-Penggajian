<?php
// include '../../config/session_controller.php';
include '../../config/auth.php'; 
include '../../config/koneksi.php';

$id=$_SESSION['id'];
$username=$_SESSION['username'];

setlocale(LC_TIME, 'id_ID');

// Query untuk mengambil username dari database
$queryUsername = mysqli_query($conn, "SELECT username FROM admin WHERE id = $id");
$dataUsername = mysqli_fetch_assoc($queryUsername);
$username = $dataUsername['username'];

//pengambilan jumlah Karyawan dari database
$queryKaryawan = mysqli_query($conn, "SELECT COUNT(*) as totalKaryawan FROM karyawan");
$dataKaryawan = mysqli_fetch_assoc($queryKaryawan);
$totalKaryawan = $dataKaryawan['totalKaryawan'];

//pengambilan jumlah Admin dari database
$queryAbsen = mysqli_query($conn, "SELECT COUNT(*) as totalAbsen FROM absen");
$dataAbsen = mysqli_fetch_assoc($queryAbsen);
$totalAbsen = $dataAbsen['totalAbsen'];

//pengambilan jumlah Admin dari database
$queryAdmin = mysqli_query($conn, "SELECT COUNT(*) as totalAdmin FROM admin WHERE role = 'admin'");
$dataAdmin = mysqli_fetch_assoc($queryAdmin);
$totalAdmin = $dataAdmin['totalAdmin'];

//Pengambilan jumlah Jabatan dari database
$queryJabatan = mysqli_query($conn, "SELECT COUNT(*) as totaljabatan FROM jabatan");
$dataJabatan = mysqli_fetch_assoc($queryJabatan);
$totalJabatan = $dataJabatan['totaljabatan'];
?>

 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../asset/css/dashborde.css">
    <title>HALAMAN DASHBOARD</title>
    <link rel="icon" type="image/png" href="../../asset/img/icons/logo1.jpg"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>

<body>
  <div class="p">
    <img src="../../asset/img/logo.jpg" alt="">
    <p1>PONDOK COFFEE BU SEH <p3>Selamat Datang <?=$username;?></p3></p1>
  </div>
  <p>Dashboard</p>
  <p class="time">Tanggal <?= strftime('%d %B %Y'); ?></p>
  
  <div class="menu">
    <br><h1>PENGGAJIAN <br> KARYAWAN <br><br></h1>
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

  <div class="dashboard-tampilan">
    <!-- Tambahkan div untuk menampilkan jumlah karyawan -->
    <div class="dashboard-box" id="box1">
        <i class="fa fa-user"></i>
        <i class="bi bi-people-fill"></i> <!-- Icon karyawan -->
        <h2>Data Karyawan</h2>
        <span id="jumlahKaryawan"><?= $totalKaryawan ?></span>
    </div>
    
    <!-- Tambahkan div untuk menampilkan jumlah admin -->
    <div class="dashboard-box" id="box2">
        <i class="bi bi-calendar-minus-fill"></i> <!-- Icon admin -->
        <h2>Data Potongan Gaji</h2>
        <span id="jumlahAdmin"><?= $totalAbsen ?></span>
    </div>

    <!-- Tambahkan div untuk menampilkan jumlah jabatan -->
    <div class="dashboard-box" id="box3">
        <i class="bi bi-briefcase-fill"></i> <!-- Icon jabatan -->
        <h2>Data Jabatan</h2>
        <span id="jumlahjabatan"><?= $totalJabatan ?></span>
    </div>
    
    <!-- Tambahkan div untuk menampilkan jumlah jabatan -->
    <div class="dashboard-box" id="box1">
        <i class="bi bi-person-lines-fill"></i><!-- Icon jabatan -->
        <h2>Data Admin</h2>
        <span id="jumlahjabatan"><?= $totalAdmin ?></span>
    </div>
  </div>

  
</body>