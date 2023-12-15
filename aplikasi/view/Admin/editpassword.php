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
    
    // Update password jika password baru diisi
    $password_lama = $_POST['password_lama'];
    $password_baru = $_POST['password_baru'];

    if (!empty($password_lama) && !empty($password_baru)) {
        // Ambil password lama dari database
        $query_password = "SELECT password FROM admin WHERE id = $id";
        $result_password = mysqli_query($conn, $query_password);
        $data_password = mysqli_fetch_assoc($result_password);
        $password_hash = $data_password['password'];

        // Verifikasi password lama dengan MD5
        $password_lama_md5 = md5($password_lama);

        if ($password_lama_md5 === $password_hash) {
            // Enkripsi password baru dengan MD5
            $password_baru_md5 = md5($password_baru);

            // Update password baru ke database
            $query_update_password = "UPDATE admin SET password = '$password_baru_md5' WHERE id = $id";
            if (mysqli_query($conn, $query_update_password)) {
                $pesan = 'Password berhasil diubah';
                $redirect = 'admin.php';
                echo("<script language='JavaScript'>
                window.alert('$pesan'); 
                window.location.href='$redirect';
                </script>");
            } else {
                echo "<script>alert('Gagal mengubah password: " . mysqli_error($conn) . "');</script>";
            }
        } else {
            echo "<script>alert('Password lama tidak sesuai');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../asset/css/Pradminss.css">
    <title>Edit Profil</title>
    <link rel="icon" type="image/png" href="../../asset/img/icons/logo1.jpg"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body>
<div class="p">
    <img src="../../asset/img/logo.jpg" alt="">
    <p1>PONDOK COFFEE BU SEH <p3>Selamat Datang <?= $username; ?></p3></p1>
</div>
<p>Edit Password</p>

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
            <td>Password Lama</td>
            <td>:</td>
            <td><input type="password" name="password_lama" required></td>
        </tr>
        <tr>
            <td>Password Baru</td>
            <td>:</td>
            <td><input type="password" name="password_baru" required></td>
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
