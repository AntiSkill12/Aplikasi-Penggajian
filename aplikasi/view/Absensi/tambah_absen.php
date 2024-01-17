<?php
include '../../config/auth.php'; 
include '../../config/koneksi.php';

$id = $_SESSION['id'];
$username = $_SESSION['username'];

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
    <link rel="icon" type="image/png" href="../../asset/img/icons/logo1.jpg" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>

<body>
    <div class="p" id="header">
      <img src="../../asset/img/logo.jpg" alt="">
      <p1>PONDOK COFFEE BU SEH <p3>Selamat Datang <?=$username;?></p3></p1>
    </div>

    <p class="list">TAMBAH POTONGAN GAJI</p>

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
    
    <form action="simpandata.php" method="POST" onsubmit="return validateForm()">
        <table class="tambahdata">
            <tr >
                <th>BULAN & TAHUN</th>
            </tr>
            <tr>
                <!-- Baris formulir untuk bulan dan tahun -->
                <td >
                    <input type="month" name="bulan" required>
                </td>
            </tr>
            <tr>
                <th width="160px">NAMA</th>
                <th width="50px">JADWAL KERJA</th>
                <th width="80px">JABATAN</th>
                <th width="120px">GAJI POKOK</th>
                <th width="100px">TIDAK HADIR</th>
                <th width="100px">SETENGAH HARI</th>
            </tr>

            <div class="table1">
                <?php
                // Mengambil data karyawan dari database
                $queryKaryawan = mysqli_query($conn, "SELECT * FROM karyawan ORDER BY Jadwal_Kerja ASC, Nama ASC");

                // Loop melalui data karyawan
                while ($dataKaryawan = mysqli_fetch_assoc($queryKaryawan)) {
                    $nama = $dataKaryawan['Nama'];
                    $jenis = $dataKaryawan['Jadwal_Kerja'];
                    $jabatan = $dataKaryawan['Jabatan'];

                    // Query untuk mengambil data Gaji Pokok dan Uang Makan dari database Jabatan berdasarkan nama jabatan
                    $queryJabatan = mysqli_query($conn, "SELECT gaji_pokok FROM jabatan WHERE nama_jabatan = '$jabatan'");

                    // Set nilai default jika query tidak mengembalikan hasil
                    $dataJabatan = [
                        'gaji_pokok' => ''
                    ];

                    // Cek apakah query berhasil dan hasilnya tidak kosong
                    if ($queryJabatan && mysqli_num_rows($queryJabatan) > 0) {
                        $dataJabatan = mysqli_fetch_assoc($queryJabatan);
                    }

                    // Menampilkan baris formulir untuk setiap karyawan
                    echo "<tr>";
                    echo "<td align='center'><input type='text' name='nama[]' value='$nama' readonly></td>";
                    echo "<td><input type='text' name='jenis[]' value='$jenis' readonly></td>";
                    echo "<td><input type='text' name='jabatan[]' value='$jabatan' readonly></td>";
                    echo "<td><input type='text' name='gaji_pokok[]' value='Rp " . ($dataJabatan['gaji_pokok'] != '' ? number_format($dataJabatan['gaji_pokok']) : '') . "' readonly></td>";
                    echo "<td><input type='number' name='tidak_hadir[]' value='" . ($dataJabatan['gaji_pokok'] != 0 ? '0' : '') . "' required></td>"; // Memberikan nilai default 0 jika tidak_hadir adalah 0
                    echo "<td><input type='number' name='sthari[]' value='" . ($dataJabatan['gaji_pokok'] != 0 ? '0' : '') . "' required></td>"; // Memberikan nilai default 0 jika sthari adalah 0
                    echo "</tr>";
                }
                ?>
            </div>



            <tr>
                <td colspan="6">
                    <input type="submit" name="submit" value="Simpan">
                    <input type="button" name="kembali" value="Kembali" onclick="self.history.back()">
                </td>
            </tr>
        </table>
    </form>

    <script>
    function validateForm() {
        var gajiPokok = document.getElementsByName("gaji_pokok[]");
        var tidakHadir = document.getElementsByName("tidak_hadir[]");
        var sthari = document.getElementsByName("sthari[]");
        let tanggal = document.getElementsByName('bulan')

        

        // Validasi setiap input
        for (var i = 0; i < gajiPokok.length; i++) {
            if (gajiPokok[i].value.trim() === '' || uangMakan[i].value.trim() === '') {
                alert('Gaji Pokok dan Uang Makan harus diisi');
                return false;
            }

            if (tidakHadir[i].value.trim() === '' || sthari[i].value.trim() === '') {
                alert('Tidak Hadir dan Setengah Hari harus diisi');
                return false;
            }
        }
        return true;
    }
</script>

</body>

</html>
