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
    <link rel="stylesheet" href="../../../asset/css/pimpinanno.css">
    <title>HALAMAN ABSENSI</title>
    <link rel="icon" type="image/png" href="../../../asset/img/icons/logo1.jpg"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>

<body>
  <div class="p" id="header">
      <img src="../../../asset/img/logo.jpg" alt="">
      <p1>PONDOK COFFEE BU SEH </p1>
      <p3>Selamat Datang <?=$username;?></p3>
  </div>

  <p class="list">Form Potongan Gaji</p>
  

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

  <div class="border">
    <div class="showcari">
      <!-- Formulir pencarian -->
      <form class="caribulan" action="" method="GET">
        <label for="cari">Cari Berdasarkan Bulan & Tahun:</label>
        <input type="month" name="cari" id="cari" required>
        <input type="submit" value="Cari">
      </form>

      <div class="notif">
        <!-- Tampilkan teks berdasarkan pencarian -->
        <?php
        if (isset($_GET['cari'])) {
            $bulanCari = $_GET['cari'];
            list($tahun, $bulan) = explode('-', $bulanCari); // Pisahkan tahun dan bulan

            // Query data berdasarkan bulan dan tahun pencarian
            $query = "SELECT * FROM absen WHERE bulan = '$bulanCari'";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
                echo "<p>Menampilkan Data Potongan Pegawai Bulan: $bulan Tahun: $tahun</p>";
            } else {
                echo "<p>Data Potongan tidak ditemukan untuk Bulan: $bulan Tahun: $tahun</p>";
            }
        }
        ?>
      </div>
    </div>
    
    
    
    <table class = "tablegaji" border="1" align="right" >
      <tr>
        <th width= "50px">NO</th>
        <th width= "120px">BULAN</th>
        <th width= "160px">NAMA</th>
        <th  width= "180px">JADWAL KERJA</th>
        <th  width= "110px">JABATAN</th>
        <th width= "130px">TIDAK HADIR</th>
        <th width= "160px">SETENGAH HARI</th>    
      </tr>
      
      <tr>
        <?php
        if (isset($_GET['cari'])) {
          $bulanCari = $_GET['cari'];
          list($tahun, $bulan) = explode('-', $bulanCari); // Pisahkan tahun dan bulan

          // Query data berdasarkan bulan dan tahun pencarian
          $query = "SELECT * FROM absen WHERE bulan = '$bulanCari' ORDER BY Jadwal_Kerja ASC, Nama ASC";
          $result = mysqli_query($conn, $query);

          if (mysqli_num_rows($result) > 0) {
            
            $no = 1;

            // Loop untuk menampilkan data dari hasil pencarian
            while ($data = mysqli_fetch_array($result)) {  
              echo '<tr>
                <td align="center">' . $no++ . '</td>
                <td align="center">' . $data['bulan'] . '</td>
                <td align="center">' . $data['Nama'] . '</td>
                <td align="center">' . $data['Jadwal_Kerja'] . '</td>
                <td align="center">' . $data['Jabatan'] . '</td>
                <td align="center">' . $data['tidak_hadir'] . '</td>
                <td align="center">' . $data['sthari'] . '</td>
              </tr>';
            }
          } 
        }
        ?> 
      </tr>
    </table>
  </div>

    
  
</body>
</html>
