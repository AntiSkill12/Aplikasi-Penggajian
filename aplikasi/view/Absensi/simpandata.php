<?php
include '../../config/koneksi.php';
$pesan = '';
$error = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil data dari formulir
    $bulan = $_POST["bulan"];
    $nama = $_POST["nama"];
    $Jadwal_Kerja = $_POST["jenis"];
    $jabatan = $_POST["jabatan"];
    $tidak_hadir = $_POST["tidak_hadir"];
    $sthari = $_POST["sthari"];
    $gaji_pokok = $_POST["gaji_pokok"];

    // Periksa apakah data untuk bulan dan tahun tersebut sudah ada
    $queryCekData = "SELECT COUNT(*) as total FROM absen WHERE bulan = '$bulan'";

    $resultCekData = mysqli_query($conn, $queryCekData);

    if ($resultCekData) {
        $rowCekData = mysqli_fetch_assoc($resultCekData);
        $totalData = $rowCekData['total'];

        if ($totalData > 0) {
            // Tampilkan pesan bahwa data untuk bulan dan tahun yang sama sudah ada dalam database.
            $pesan = "Data Bulan & Tahun Sudah Di Pakai.";
            $error = true;
        } else {
            // Menyimpan data untuk setiap karyawan jika data belum ada
            for ($i = 0; $i < count($nama); $i++) {
                // Validasi apakah data yang diperlukan telah diisi
                if (
                    empty(trim($gaji_pokok[$i])) ||
                    empty(trim($jabatan[$i]))
                ) {
                    $error = true; // Menandai bahwa terdapat kesalahan
                    $pesan = 'Data tidak lengkap untuk beberapa karyawan, Silakan cek Jabatan Karyawan Tersebut';
                    break; // Hentikan loop karena ada data yang tidak lengkap
                }

                // Lanjutkan penyimpanan data jika tidak ada kesalahan
                $namaKaryawan = $nama[$i];
                $jenisKaryawan = $Jadwal_Kerja[$i];
                $jabatanKaryawan = $jabatan[$i];
                $tidakHadirKaryawan = $tidak_hadir[$i];
                $setengahHariKaryawan = $sthari[$i];
                $gajiPokokKaryawan = str_replace('Rp ', '', str_replace(',', '', $gaji_pokok[$i])); // Menghapus 'Rp' dan pemisah ribuan

                // Cek jika ada data yang kosong untuk karyawan tertentu
                if ($gajiPokokKaryawan === '') {
                    $error = true;
                    $pesan = 'Gaji Pokok tidak lengkap, Silakan periksa Jabatan Karyawan.';
                    break;
                }

                // Selanjutnya, Anda bisa menyimpan data ini ke database
                // Gunakan query SQL INSERT untuk memasukkan data ke tabel absen
                $query = "INSERT INTO `absen` (`bulan`, `Nama`, `Jadwal_Kerja`, `Jabatan`, `tidak_hadir`, `sthari`, `gaji_pokok`) 
                            VALUES ('$bulan', '$namaKaryawan', '$jenisKaryawan', '$jabatanKaryawan', '$tidakHadirKaryawan', '$setengahHariKaryawan', $gajiPokokKaryawan)";

                // Eksekusi query (lakukan koneksi database terlebih dahulu)
                $result = mysqli_query($conn, $query);

                if (!$result) {
                    // Tangani kesalahan jika INSERT gagal
                    $error = true;
                    $pesan = "Gagal menyimpan data Potongan " . mysqli_error($conn);
                    break; // Hentikan loop karena ada kesalahan saat menyimpan data
                }
            }
        }
    }

    if (!$error) {
        // Jika tidak ada kesalahan, tampilkan pesan berhasil dan kembali ke halaman tertentu
        $pesan = 'Data berhasil ditambah';
        $redirect = 'absensi.php';
        echo "<script>alert('$pesan'); window.location.href='$redirect';</script>";
    } else {
        // Jika ada kesalahan, tampilkan pesan kesalahan sebagai notifikasi dan tetap di halaman yang sama
        echo "<script>alert('$pesan'); history.go(-1);</script>";
    }
}
?>
