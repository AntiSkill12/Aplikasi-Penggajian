<?php
include '../../config/auth.php'; 
include '../../config/koneksi.php';

$id = $_SESSION['id'];
$username = $_SESSION['username'];

// Query untuk mengambil username dari database
$queryUsername = mysqli_query($conn, "SELECT username FROM admin WHERE id = $id");
$dataUsername = mysqli_fetch_assoc($queryUsername);
$username = $dataUsername['username'];

// Periksa apakah ada parameter 'id' dalam URL
if (isset($_GET['id'])) {
    // Ambil ID karyawan dari URL
    $karyawan_id = $_GET['id'];
    // Query basis data untuk mengambil data karyawan berdasarkan ID
    $query = mysqli_query($conn, "SELECT * FROM karyawan WHERE id = $karyawan_id");
    $data = mysqli_fetch_array($query);
} else {
    // Jika tidak ada ID yang valid, mungkin Anda ingin mengarahkan pengguna ke halaman lain atau menampilkan pesan kesalahan.
    echo "ID karyawan tidak valid.";
    exit;
}

if (isset($_POST["submit"])) {
    $Nama = $_POST["Nam a"];
    $Jabatan = $_POST["Jabatan"];
    $Jenis_Kelamin = $_POST["Jenis_Kelamin"];
    $Jadwal_Kerja = $_POST["Jadwal_Kerja"];
    $Tanggal_Masuk = $_POST["Tanggal_Masuk"];

    $sql = "UPDATE `karyawan` SET `Nama` = '$Nama', `Jabatan` = '$Jabatan', `Jenis_Kelamin` = '$Jenis_Kelamin', `Jadwal_Kerja` = '$Jadwal_Kerja', `Tanggal_Masuk` = '$Tanggal_Masuk' WHERE `karyawan`.`id` = $karyawan_id ";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        $pesan = 'Data berhasil di Update';
        $redirect = "data_karyawan.php";
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
    <link rel="stylesheet" href="../../asset/css/tambahhPoGa.css">
    <link rel="icon" type="image/png" href="../../asset/img/icons/logo1.jpg"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <title>HALAMAN UPDATE DATA</title>
</head>

<body>
    <div class="container">
        <div class="p" id="header">
            <img src="../../asset/img/logo.jpg" alt="">
            <p1>PONDOK COFFEE BU SEH <p3>Selamat Datang <?=$username;?></p3></p1>
        </div>

         <p class="list">Update Data Karyawan</p>
    
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

        <form method="post">
            <table class="tambahdata">
                <tr>
                    <td><h2>MASUKAN DATA</h2></td>
                </tr>
                <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td><input type="text" class="form-control" name="Nama" value="<?php echo $data['Nama'] ?>" required></td>
                </tr>
                <tr>
                    <td>Jabatan</td>
                    <td>:</td>
                    <td>
                        <select name="Jabatan" required>
                            <option value="">--Pilih Jabatan--</option>
                            <?php 
                            // Query untuk mengambil data dari tabel Jabatan
                            $query = mysqli_query($conn, "SELECT * FROM Jabatan");
                            
                            // Perulangan untuk mengisi opsi berdasarkan data dari tabel Jabatan
                            while ($row = mysqli_fetch_assoc($query)) {
                                $nama_jabatan = $row['nama_jabatan'];
                                $selected = ($data['Jabatan'] == $nama_jabatan) ? 'selected' : '';
                                echo "<option value='$nama_jabatan' $selected>$nama_jabatan</option>";
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Jenis Kelamin</td>
                    <td>:</td>
                    <td>
                        <select name="Jenis_Kelamin" required>
                            <option value="LAKI-LAKI" <?php if ($data['Jenis_Kelamin'] == 'LAKI-LAKI') echo 'selected'; ?>>LAKI-LAKI</option>
                            <option value="PEREMPUAN" <?php if ($data['Jenis_Kelamin'] == 'PEREMPUAN') echo 'selected'; ?>>PEREMPUAN</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Jadwal Kerja</td>
                    <td>:</td>
                    <td>
                        <select name="Jadwal_Kerja" required>
                            <option value="06:00 pagi - 15:00 Sore" <?php if ($data['Jadwal_Kerja'] == '06:00 pagi - 15:00 Sore') echo 'selected'; ?>>06:00 pagi - 15:00 Sore</option>
                            <option value="16:00 Sore - 24:00 Malam" <?php if ($data['Jadwal_Kerja'] == '16:00 Sore - 24:00 Malam') echo 'selected'; ?>>16:00 Sore - 24:00 Malam</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Tanggal Masuk</td>
                    <td>:</td>
                    <td><input type="date" class="form-control" name="Tanggal_Masuk" value="<?php echo $data['Tanggal_Masuk'] ?>" required></td>
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
