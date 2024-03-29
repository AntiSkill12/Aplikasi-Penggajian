<?php
include '../../../config/auth.php'; 
include '../../../config/koneksi.php';

$id=$_SESSION['id'];
$username=$_SESSION['username'];

setlocale(LC_TIME, 'id_ID');

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
    <link rel="stylesheet" href="../../../asset/css/Pradminsss.css">
    <link rel="stylesheet" href="../../../asset/css/nama.css">
    <title>HALAMAN PROFIL PIMPINAN</title>
    <link rel="icon" type="image/png" href="../../../asset/img/icons/logo1.jpg"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>

<body>
  <div class="p" id="header">
      <img src="../../../asset/img/logo.jpg" alt="">
      <p1>PONDOK COFFEE BU SEH <p3></p3></p1>
      <p3 id="nama">Selamat Datang <?=$username;?></p3>
  </div>

  <p class="list">Profil Pimpinan</p>
  <p class="time">Tanggal <?= strftime('%d %B %Y'); ?></p>

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

  <form class="form10" method="get" action="">
    <?php 
    include '../../../config/koneksi.php';
    $query_mysqli = mysqli_query($conn, "SELECT * FROM admin WHERE id='$id' LIMIT 1")or die(mysqli_error());
    $nomor = 1;
    while($data = mysqli_fetch_array($query_mysqli)){
    ?>

   	<table class="tableprofil">
     
       <tr>
				<h3 class="h3profile">Profile Saya</h3>		
			</tr>
      <tr >
				<td>Nama</td>
                <td>:</td>
				<td><?php echo $data['nama_admin'] ?></td>					
			</tr>	
			<tr>
				<td>Email</td>
                <td>:</td>
				<td>
					<?php echo $data['email'] ?>
				</td>					
			</tr>	
			<tr>
				<td>Username</td>
                <td>:</td>
				<td><?php echo $data['username'];}?></td>					
			</tr>	
		</table>
    <button class="button1"><a href="editdata.php">Edit Profile</a></button>
    <button class="button2"><a href="editpassword.php">Edit Password</a></button>
  </form>

  

 
  
</body>
</html>
