<?php
include '../../config/koneksi.php';
session_start();
$id = $_SESSION['id'];
$username = $_SESSION['username'];

// Ambil nilai parameter dari URL
$bulanCari = $_GET['bulan'];
$namaCari = $_GET['nama'];

setlocale(LC_TIME, 'id_ID');

// Query data berdasarkan bulan, tahun, dan nama (jika dipilih)
$query = "SELECT bulan, Nama, Jadwal_Kerja, Jabatan FROM absen WHERE bulan = '$bulanCari'";

// Tambahkan filter berdasarkan nama karyawan jika dipilih
if (!empty($namaCari)) {
    $query .= " AND Nama = '$namaCari'";
}

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
                size: portrait;
            }
        }
    </style>
</head>

<body onbeforeprint="window.onafterprint = function() { event.returnValue = false; }" > <!-- //Memiliki fungsi kalau menekan tombol batal tidak balik ke form sebelumnya -->
    <?php
    if ($result) { // Jika ada hasil pencarian, tampilkan data sesuai dengan hasil pencarian
        while ($row = mysqli_fetch_assoc($result)) {
            $bulan = $row['bulan'];
            $nama = $row['Nama'];
            $Jadwal_Kerja = $row['Jadwal_Kerja'];
            $jabatan = $row['Jabatan'];

           // Query data tidak hadir dan setengah hari dari tabel absen
           $queryAbsen = "SELECT tidak_hadir, sthari, gaji_pokok FROM absen WHERE bulan = '$bulan' AND Nama = '$nama'";
           $resultAbsen = mysqli_query($conn, $queryAbsen);
           $rowAbsen = mysqli_fetch_assoc($resultAbsen);
           $tidakHadir = $rowAbsen['tidak_hadir'];
           $setengahHari = $rowAbsen['sthari'];
           $gajiPokok = $rowAbsen['gaji_pokok'];

            // Hitung potongan gaji Tidak Hadir
            $potonganTidakHadir = ($tidakHadir * $gajiPokok) / 30;

            // Hitung potongan gaji Setengah Hari
            $potonganSetengahHari = ($setengahHari * $gajiPokok) / 30 / 2;


            // Hitung Total Potongan
            $totalPotongan = $potonganTidakHadir + $potonganSetengahHari;

            // Hitung Total Gaji
            $totalGaji = $gajiPokok - $totalPotongan;
            ?>

            <div class="page">
                <!-- Table Baru untuk Setiap Karyawan -->
                <div class="header">
                    
                    <img class="logo" src="../../asset/img/logo.jpg" alt="Logo Perusahaan">
                    <div class="info">
                        <p class="title">PONDOK COFFEE BU SEH</p>
                        <p class="title2">Daftar Gaji Karyawan</p>
                    </div>
                </div>

                <div class="detail">
                    <p>Nama     : <?= $nama; ?></p>
                    <p>Jabatan  : <?= $jabatan; ?></p>
                    <p>Jadwal Keja  : <?= $Jadwal_Kerja; ?></p>
                    <p>Bulan: <?= strftime('%B', strtotime($bulanCari)); ?></p>
                    <p>Tahun    : <?= date('Y', strtotime($bulanCari)); ?></p>
                </div>

                <!-- Tabel Data Gaji -->
                <table class="income">
                    <tr>
                        <th width="250px">PENDAPATAN</th>
                        <th width="150px">JUMLAH</th>
                    </tr>
                    <tr>
                        <td>GAJI POKOK</td>
                        <td>Rp <?= number_format($gajiPokok); ?></td>
                    </tr>
                </table>

                
                <!-- Tabel Data Potongan -->
                <table class="deductions">
                    <tr>
                        <th width="250px">POTONGAN</th>
                        <th width="150px">JUMLAH</th>
                    </tr>
                    <tr>
                        <td>TIDAK HADIR    (<?= number_format($tidakHadir); ?> Kali)</td>
                        <td>Rp <?= number_format($potonganTidakHadir); ?></td>
                    </tr>
                    <tr>
                        <td>SETENGAH HARI    (<?= number_format($setengahHari); ?> Kali)</td>
                        <td>Rp <?= number_format($potonganSetengahHari); ?></td>
                    </tr>
                    <tr>
                        <th>TOTAL POTONGAN</th>
                        <th>Rp <?= number_format($totalPotongan); ?></th>
                    </tr>
                </table>

                <!-- Total Gaji -->
                <table class="Total">
                    <tr>
                        <th width="250px">TOTAL GAJI BERSIH</th>
                        <th width="150px"> Rp <?= number_format($totalGaji); ?></th>
                    </tr>
                </table>

            
                <!-- Tanda tangan -->
                <div class="signature">
                    <p>Tanjung Uban, <?= strftime('%d %B %Y'); ?> </p>
                    <p class="p">Sekretaris</p>
                    <br>
                    <br>
                    <p>________________________</p>
                
                </div>
                
            </div>
        <?php
        }
    }

    // Tutup koneksi ke database
    mysqli_close($conn);
    ?>
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
