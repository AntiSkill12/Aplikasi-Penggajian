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
    <link rel="stylesheet" href="../../asset/css/laporanSlipg.css">
    <title>HALAMAN LAPORAN</title>
    <link rel="icon" type="image/png" href="../../asset/img/icons/logo1.jpg"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body>
    <div class="p" id="header">
        <img src="../../asset/img/logo.jpg" alt="">
        <p1>PONDOK COFFEE BU SEH <p3>Selamat Datang <?=$username;?></p3></p1>
    </div>

    <p class="list">Form Laporan Gaji</p>

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

    <div class="tambah">
        <form class="cari1" action="" method="GET">
            <label for="cari">Cari Berdasarkan Bulan & Tahun:</label>
            <input type="month" name="cari" id="cari" required>
            <label for="nama">Pilih Nama Karyawan:</label>
            <select name="nama" id="nama">
                <option value="">Semua Karyawan</option>
                <!-- Isi dropdown dengan data nama karyawan dari database -->
                <?php
                $queryKaryawan = "SELECT Nama FROM karyawan ORDER BY Nama ASC";
                $resultKaryawan = mysqli_query($conn, $queryKaryawan);
                while ($rowKaryawan = mysqli_fetch_assoc($resultKaryawan)) {
                    echo "<option value='" . $rowKaryawan['Nama'] . "'>" . $rowKaryawan['Nama'] . "</option>";
                }
                ?>
            </select>
            <input type="submit" value="Cari">
        </form>

        <?php 
            // Fungsi untuk memecah bulan dan tahun dari input bulan
            function splitMonthYear($bulanCari) {
                list($tahun, $bulan) = explode('-', $bulanCari);
                return array('tahun' => $tahun, 'bulan' => $bulan);
            }

            // Variabel untuk menyimpan pesan hasil pencarian
            $cariMessage = "";

            // Variabel untuk menyimpan hasil query
            $queryResult = null;

            if (isset($_GET['cari'])) {
                $bulanCari = $_GET['cari'];
                $namaCari = $_GET['nama']; // Ambil nama karyawan dari dropdown

                list($tahun, $bulan) = explode('-', $bulanCari); // Pisahkan tahun dan bulan

                // Query data berdasarkan bulan, tahun, dan nama (jika dipilih)
                $query = "SELECT bulan, Nama, Jadwal_Kerja, Jabatan FROM absen WHERE bulan = '$bulanCari' ";
                
                // Tambahkan filter berdasarkan nama karyawan jika dipilih
                if (!empty($namaCari)) {
                    $query .= " AND Nama = '$namaCari'";
                }

                $result = mysqli_query($conn, $query);

                if ($result) { // Periksa apakah kueri berhasil dieksekusi
                    if (mysqli_num_rows($result) > 0) {
                        echo "<p>Menampilkan Data Gaji $namaCari pada Bulan: $bulan Tahun: $tahun</p>";
                        $queryResult = $result;
                    } else {
                        echo "<p>Data tidak ditemukan untuk Bulan: $bulan Tahun: $tahun</p>";
                    }
                } else {
                    echo "<p>Terjadi kesalahan dalam kueri SQL: " . mysqli_error($conn) . "</p>";
                }
            }    
        ?>
    </div>

    <?php echo "<p>$cariMessage</p>"; ?>
    
    

    <div id="printArea">
        <table border="1">
            <tr>
                <th width= "30px">No</th>
                <th width= "100px">Bulan</th>
                <th width= "180px">Nama Pegawai</th>
                <th width= "110px">Jadwal Kerja</th>
                <th width= "100px">Jabatan</th>
                <th width= "120px">Gaji Pokok</th>
                <th width= "120px">Uang Makan</th>
                <th width= "150px">Total Potongan</th>
                <th width= "120px">Total Gaji</th>
            </tr>
            <?php
            $no = 1;

            if ($queryResult) { // Jika ada hasil pencarian, tampilkan data sesuai dengan hasil pencarian
                while ($row = mysqli_fetch_assoc($queryResult)) {
                    $bulan = $row['bulan'];
                    $nama = $row['Nama'];
                    $Jadwal_Kerja = $row['Jadwal_Kerja'];
                    $jabatan = $row['Jabatan'];


                    // Query data tidak hadir dan setengah hari dari tabel absen
                    $queryAbsen = "SELECT tidak_hadir, sthari, gaji_pokok, uang_makan FROM absen WHERE bulan = '$bulan' AND Nama = '$nama'";
                    $resultAbsen = mysqli_query($conn, $queryAbsen);
                    $rowAbsen = mysqli_fetch_assoc($resultAbsen);
                    $tidakHadir = $rowAbsen['tidak_hadir'];
                    $setengahHari = $rowAbsen['sthari'];
                    $gajiPokok = $rowAbsen['gaji_pokok'];
                    $uangMakan = $rowAbsen['uang_makan'];

                    // Hitung potongan gaji Tidak Hadir
                    $potonganTidakHadir = ($tidakHadir * $gajiPokok) / 30;

                    // Hitung potongan gaji Setengah Hari
                    $potonganSetengahHari = ($setengahHari * $gajiPokok) / 30 / 2;

                    // Hitung potongan uang makan
                    $potonganuangmakan = $uangMakan;

                    // Hitung Total Potongan
                    $totalPotongan = $potonganuangmakan + $potonganTidakHadir + $potonganSetengahHari;

                    // Hitung Total Gaji
                    $totalGaji = $gajiPokok + $uangMakan - $totalPotongan;

                    echo "<tr>";
                    echo "<td align='center'>$no</td>";
                    echo "<td align='center'>$bulan</td>";
                    echo "<td align='center'>$nama</td>";
                    echo "<td align='center'>$Jadwal_Kerja</td>";
                    echo "<td align='center'>$jabatan</td>";
                    echo "<td align='center'>Rp " . number_format($gajiPokok) . "</td>";
                    echo "<td align='center'>Rp " . number_format($uangMakan) . "</td>";
                    echo "<td align='center'>Rp " . number_format($totalPotongan) . "</td>";
                    echo "<td align='center'>Rp " . number_format($totalGaji) . "</td>";
                    echo "</tr>";

                    $no++;
                }
            }

            // Tutup koneksi ke database
            mysqli_close($conn);
            ?>
        </table>
        <div class="butten1">
            <button><a href="cetak_laporan.php?bulan=<?= $bulanCari ?>&nama=<?= $namaCari ?>" target="_blank"><i class="bi bi-printer-fill"></i> Cetak Slip Gaji</a></button>
        </div>
    </div>

</body>
</html>
