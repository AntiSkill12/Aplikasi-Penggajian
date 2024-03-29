<?php
include '../../config/auth.php'; 
include '../../config/koneksi.php';

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
    <link rel="stylesheet" href="../../asset/css/tambahhPoGa.css">
    <title>HALAMAN TAMBAH DATA</title>
    <link rel="icon" type="image/png" href="../../asset/img/icons/logo1.jpg"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>

<body>
  <div class="p" id="header">
    <img src="../../asset/img/logo.jpg" alt="">
    <p1>PONDOK COFFEE BU SEH <p3>Selamat Datang <?=$username;?></p3></p1>
  </div>

  <p class="list">Tambah Data Karyawan</p>
  
  <div class="menu">
    <br><h1>PENGGAJIAN <br> KARYAWAN </h1>
    <ul>
      <li><a href="http://localhost/Gaji_karyawan/aplikasi/view/dashboard.php"><i class="bi bi-house-fill"></i> Dashboard</a></li>
      <li class="dropdown-trigger">
      <a href="#"><i class="bi bi-database-fill-add"></i> Karyawan <i class="bi bi-node-plus"></i></a>
        <ul class="dropdown">
          <li><a href="http://localhost/Gaji_karyawan/aplikasi/view/karyawan/data_karyawan.php"><i class="bi bi-person-lines-fill"></i>Data Karyawan</a></li>
          <li><a href="http://localhost/Gaji_karyawan/aplikasi/view/Jabatan/data_jabatan.php"><i class="bi bi-file-person-fill"></i> Data Jabatan</a></li>
        </ul>
      </li>
      <li class="dropdown-trigger">
        <a href="#"><i class="bi bi-credit-card-fill"></i> Transaksi <i class="bi bi-node-plus"></i></a>
        <ul class="dropdown">
          <li><a href="http://localhost/Gaji_karyawan/aplikasi/view/Absensi/absensi.php"><i class="bi bi-scissors"></i> Potongan Gaji</a></li>
          <li><a href="http://localhost/Gaji_karyawan/aplikasi/view/Gaji/gaji.php"><i class="bi bi-cash-stack"></i> Gaji</a></li>
        </ul>
      </li>
      <li><a href="http://localhost/Gaji_karyawan/aplikasi/view/Laporan/laporan.php"><i class="bi bi-file-earmark-medical-fill"></i> Laporan</a></li>
      <li><a href="http://localhost/Gaji_karyawan/aplikasi/view/Admin/admin.php"><i class="bi bi-person-fill-lock"></i> Admin</a></li>
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
          <td><input type="text" name="Nama" placeholder="" required></td>
        </tr>
        <tr>
          <td>Jabatan</td>
          <td>:</td>
          <td>
              <select name="Jabatan" required>
                  <option value="">--Pilih Jabatan--</option>
                  <?php 
                  include '../../config/koneksi.php'; // Sertakan file koneksi database
                  
                  // Query untuk mengambil data dari tabel Jabatan
                  $query = mysqli_query($conn, "SELECT * FROM Jabatan");
                  
                  // Perulangan untuk mengisi opsi berdasarkan data dari tabel Jabatan
                  while ($row = mysqli_fetch_assoc($query)) {
                      $nama_jabatan = $row['nama_jabatan'];
                      echo "<option value='$nama_jabatan'>$nama_jabatan</option>";
                  }
                  ?>
              </select>
          </td>

        </tr>
        <tr>
          <td>Jenis Kelamin</td>
          <td>:</td>
          <td><select name="Jenis_Kelamin" required>
            <selected>
              <option value="">--Pilih Jenis Kelamin--</option>
              <option value="LAKI-LAKI">LAKI-LAKI</option>
              <option value="PEREMPUAN">PEREMPUAN</option></td>
          </selected>
        </tr>
        <tr>
          <td>Jadwal Kerja</td>
          <td>:</td>
          <td><select name="Jadwal_Kerja" required>
        <selected>
          <option value=""> ----Pilih Jadwal Kerja----</option>
          <option value="06:00 pagi - 15:00 Sore">06:00 pagi - 15:00 Sore</option>
          <option value="16:00 Sore - 24:00 Malam">16:00 Sore - 24:00 Malam</option></td>
        </selected>
        </tr>
        <tr>
            <td>Tanggal Masuk</td>
            <td>:</td>
            <td><input type="date" name="Tanggal_Masuk" placeholder="" required></td>
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