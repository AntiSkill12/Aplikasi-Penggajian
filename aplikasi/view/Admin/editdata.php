<?php
include '../../config/auth.php'; 
include '../../config/koneksi.php';

$id = $_SESSION['id'];
$username = $_SESSION['username'];

// Query untuk mengambil username dari database
$queryUsername = mysqli_query($conn, "SELECT username FROM admin WHERE id = $id");
$dataUsername = mysqli_fetch_assoc($queryUsername);
$username = $dataUsername['username'];

// Ambil data admin dari database
$query_admin = "SELECT * FROM admin WHERE id = $id LIMIT 1";
$result_admin = mysqli_query($conn, $query_admin);
$data_admin = mysqli_fetch_assoc($result_admin);

// Proses penyimpanan perubahan profil
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_admin = $_POST['nama_admin'];
    $email = $_POST['email'];
    $username_input = $_POST['username'];
    
    // Verifikasi apakah email sudah digunakan sebelumnya
    $email_check_query = "SELECT * FROM admin WHERE email='$email' AND id != $id";
    $result_email_check = mysqli_query($conn, $email_check_query);
    if (mysqli_num_rows($result_email_check) > 0) {
        echo "<script>alert('Email sudah digunakan sebelumnya!');</script>";
    } else {
        // Verifikasi apakah username sudah digunakan sebelumnya
        $username_check_query = "SELECT * FROM admin WHERE username='$username_input' AND id != $id";
        $result_username_check = mysqli_query($conn, $username_check_query);
        if (mysqli_num_rows($result_username_check) > 0) {
            echo "<script>alert('Username sudah digunakan sebelumnya!');</script>";
        } else {
            // Update data admin
            $query_update_admin = "UPDATE admin SET nama_admin = '$nama_admin', email = '$email', username = '$username_input' WHERE id = $id";
            if (mysqli_query($conn, $query_update_admin)) {
                $pesan = 'Data berhasil di Update';
                $redirect = 'admin.php';
                echo("<script language='JavaScript'>
                window.alert('$pesan'); 
                window.location.href='$redirect';
                </script>");
            } else {
                echo "<script>alert('Gagal memperbarui profil: " . mysqli_error($conn) . "');</script>";
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../asset/css/Pradminsss.css">
    <link rel="stylesheet" href="../../asset/css/nama.css">
    <title>Edit Profil</title>
    <link rel="icon" type="image/png" href="../../asset/img/icons/logo1.jpg"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body>
<div class="p">
    <img src="../../asset/img/logo.jpg" alt="">
    <p1>PONDOK COFFEE BU SEH <p3></p3></p1>
    <p3 class="nama">Selamat Datang <?=$username;?></p3>
</div>
<p>Edit Profil Admin</p>

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
      <li><a href="http://localhost/Gaji_karyawan/aplikasi/view/login.php"><i class="bi bi-door-open-fill"></i> Logout</a></li>
    </ul>
  </div>

<!-- Form untuk mengedit profil -->
<form method="POST" action="" enctype="multipart/form-data">
    <table class="table10">
        <tr>
            <td>Nama Admin</td>
            <td>:</td>
            <td><input type="text" name="nama_admin" value="<?= $data_admin['nama_admin'] ?>" required></td>
        </tr>
        <tr>
            <td>Email</td>
            <td>:</td>
            <td><input type="email" name="email" value="<?= $data_admin['email'] ?>" required></td>
        </tr>
        <tr>
            <td>Username</td>
            <td>:</td>
            <td><input type="text" name="username" value="<?= $data_admin['username'] ?>" required></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
              <button type="submit">Simpan</button>
              <input type="button" name="kembali" value="Kembali" onclick="self.history.back()">
            </td>
        </tr>
        
    </table>
    
</form>

</body>
</html>
