<?php
include '../../config/koneksi.php';
session_start();
$id = $_SESSION['id'];
$username = $_SESSION['username'];

// Ambil nilai parameter dari URL
$bulanCari = $_GET['bulan'];

setlocale(LC_TIME, 'id_ID');

// Query data berdasarkan bulan, tahun, dan nama (jika dipilih)
$query = "SELECT bulan, Nama, Jadwal_Kerja, Jabatan FROM absen WHERE bulan = '$bulanCari'";


$result = mysqli_query($conn, $query);

if (!$result) {
    die("Terjadi kesalahan dalam kueri SQL: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../asset/css/cetakkLapo.css">
   
   
    <title>CETAK LAPORAN</title>
    <link rel="icon" type="image/png" href="../../asset/img/icons/logo1.jpg"/>

    <style>
        @media print {
            @page {
                size: landscape;
            }
            .test1{
                text-align: right;
            }
            .test2{
                text-align: center;
            }
        }
        
    </style>

</head>

<body onbeforeprint="window.onafterprint = function() { event.returnValue = false; }" > <!-- //Memiliki fungsi kalau menekan tombol batal tidak balik ke form sebelumnya -->
    <div class="header">   
        <img class="logo" src="../../asset/img/logo.jpg" alt="Logo Perusahaan" style="margin-left:50px;">
        <div class="info">
            <p class="title" style="margin-left:250px;">PONDOK COFFEE BU SEH</p>
            <p class="title2" style="margin-left:250px;">Daftar  Rekap Gaji Karyawan</p>
         </div>
    </div>

    <table border="1">
        <tr>
            <th width= "30px">No</th>
            <th width= "100px">Bulan</th>
            <th width= "180px">Nama Pegawai</th>
            <th width= "110px">Jadwal kerja</th>
            <th width= "100px">Jabatan</th>
            <th width= "120px">Gaji Pokok</th>
            <th width= "120px">Uang Makan</th>
            <th width= "150px">Total Potongan</th>
            <th width= "120px">Total Gaji</th>
        </tr>
        <?php
        $no = 1;
        $totalKeseluruhanGaji = 0;

        if ($result) { // Jika ada hasil pencarian, tampilkan data sesuai dengan hasil pencarian
            while ($row = mysqli_fetch_assoc($result)) {
                $bulan = $row['bulan'];
                $nama = $row['Nama'];
                $Jadwal_Kerja = $row['Jadwal_Kerja'];
                $jabatan = $row['Jabatan'];

                // Query data tidak hadir dan setengah hari dari tabel absen
                $queryAbsen = "SELECT tidak_hadir, sthari, gaji_pokok, uang_makan FROM absen WHERE bulan = '$bulan' AND Nama = '$nama' ";
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

                // Mengakumulasi nilai totalGaji untuk setiap data
                $totalKeseluruhanGaji += $totalGaji;
                

                // Tampilkan data ke dalam tabel
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

        // <!-- Tampilkan informasi total keseluruhan gaji di bawah tabel jika ada hasil pencarian -->
            if ($result ) {
                echo "<tr>";
                echo "<td Class='test1' colspan='7' align='right' height='40'><b>Total Keseluruhan Gaji Karyawan Bulan: " . date('m', strtotime($bulanCari)) ." Tahun: ". date('Y', strtotime($bulanCari))." Adalah </b> </td>";
                echo "<td Class='test2' colspan='2' align='center'><b>Rp. " . number_format($totalKeseluruhanGaji) . "</b></td>";
                echo "</tr>";
                
            } 
        ?>
         
        <?php
        // Tutup koneksi ke database
        mysqli_close($conn);
        ?>
    </table>
     <!-- Tanda tangan -->
     <div class="signature">
                    <p>Tanjung Uban, <?= strftime('%d %B %Y'); ?> </p>
                    <p class="p">Sekretaris</p>
                    <br>
                    <br>
                    <p>________________________</p>
                
                </div>
    <script>
        // Fungsi untuk mencetak data
        function printData() {
            var printArea = document.body.innerHTML;
            var printWindow = window.open('', '', 'width=600,height=600');
            printWindow.document.open();
            printWindow.document.write('<html><head><title>Cetak Data Gaji</title></head><body>');
            printWindow.document.write(printArea);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
            printWindow.close();
        }
        window.onload = function() {
            window.print(); // Otomatis tampilkan jendela cetak saat halaman kedua dimuat
            window.onafterprint = function () {
                window.close(); // Otomatis tutup jendela setelah mencetak
            };
        }
    </script>
</body>
</html>
