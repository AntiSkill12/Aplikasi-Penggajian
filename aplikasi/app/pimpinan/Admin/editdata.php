<?php
include '../../../config/auth.php'; 
include '../../../config/koneksi.php';

$id = $_SESSION['id'];
$username = $_SESSION['username'];

// Query untuk mengambil username dari database
$queryUsername = mysqli_query($conn, "SELECT username FROM admin WHERE id = $id");
$dataUsername = mysqli_fetch_assoc($queryUsername);
$username = $dataUsername['username'];

// Periksa apakah ada parameter 'id' dalam URL
if (isset($_GET['id'])) {
    // Ambil ID karyawan dari URL
    $admin_id = $_GET['id'];
    // Query basis data untuk mengambil data karyawan berdasarkan ID
    $query = mysqli_query($conn, "SELECT * FROM admin WHERE id = $admin_id");
    $data = mysqli_fetch_array($query);
} else {
    // Jika tidak ada ID yang valid, mungkin Anda ingin mengarahkan pengguna ke halaman lain atau menampilkan pesan kesalahan.
    echo "ID admin tidak valid.";
    exit;
}

if (isset($_POST["submit"])) {
    $nama_admin = $_POST ["nama_admin"];
    $email = $_POST ["email"];
    $username = $_POST ["username"];
    $role = $_POST ["role"];

    $sql = "UPDATE `admin` SET `nama_admin` = '$nama_admin', `email` = '$email', `username` = '$username', `role` = '$role' WHERE `admin`.`id` = $admin_id ";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        $pesan = 'Data berhasil di Update';
        $redirect = "data_admin.php";
        echo("<script language='JavaScript'>
            window.alert('$pesan'); 
            window.location.href='$redirect';
            </script>");
    } else {
        echo "Failed: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../asset/css/tambahhPoGa.css">
    <link rel="icon" type="image/png" href="../../../asset/img/icons/logo1.jpg"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <title>HALAMAN UPDATE DATA</title>
</head>

<body>
    <div class="container">
        <div class="p" id="header">
            <img src="../../../asset/img/logo.jpg" alt="">
            <p1>PONDOK COFFEE BU SEH <p3>Selamat Datang <?=$username;?></p3></p1>
        </div>

         <p class="list">Update Data Admin</p>
    
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

        <form method="post">
            <table class="tambahdata">
                <tr>
                    <td><h2>MASUKAN DATA</h2></td>
                </tr> 
                <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td><input type="text" name="nama_admin" value="<?php echo $data['nama_admin'] ?>" required></td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td>:</td>
                    <td><input type="text" name="email" value="<?php echo $data['email'] ?>" required></td>
                </tr>
                <tr>
                    <td>Username</td>
                    <td>:</td>
                    <td><input type="text" name="username" value="<?php echo $data['username'] ?>" required></td>
                </tr>
                <tr>
                    <td>Role</td>
                    <td>:</td>
                    <td><select name="role" required>
                        <selected>
                        <option value="">--Pilih Role--</option>
                        <option value="admin" <?php if ($data['role'] == 'admin') echo 'selected'; ?>>ADMIN</option>
                        </td>
                    </selected>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td><br>
                        <button type="submit" name="submit">Update</button>
                        <input type="button" name="kembali" value="Kembali" onclick="self.history.back()">
                    </td>
                </tr>
            </table>
        </form>

        
    </div>
</body>

</html>
