<?php
include '../../../config/auth.php'; 
include '../../../config/koneksi.php';

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
    $username = $_POST['username'];
    
    // Update data admin
    $query_update_admin = "UPDATE admin SET nama_admin = '$nama_admin', email = '$email', username = '$username' WHERE id = $id";
    if (mysqli_query($conn, $query_update_admin)) {
        $pesan = 'Data berhasil di Update';
        $redirect = 'profil.php';
        echo("<script language='JavaScript'>
        window.alert('$pesan'); 
        window.location.href='$redirect';
        </script>");
    } else {
        echo "<script>alert('Gagal memperbarui profil: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../asset/css/Pradminss.css">
    <link rel="stylesheet" href="../../asset/css/nama.css">
    <title>HALAMAN EDIT PROFIL</title>
    <link rel="icon" type="image/png" href="../../../asset/img/icons/logo1.jpg"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body>
<div class="p">
    <img src="../../../asset/img/logo.jpg" alt="">
    <p1>PONDOK COFFEE BU SEH <p3></p3></p1>
    <p3 id="nama">Selamat Datang <?=$username;?></p3>
</div>
<p>Edit Profil</p>

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
