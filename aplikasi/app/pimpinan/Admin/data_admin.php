<?php
include '../../../config/auth.php'; 
include '../../../config/koneksi.php';

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
    <link rel="stylesheet" href="../../../asset/css/pimpinanno.css">
    <title>HALAMAN DATA ADMIN</title>
    <link rel="icon" type="image/png" href="../../../asset/img/icons/logo1.jpg" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>

<body>
    <div class="p" id="header">
        <img src="../../../asset/img/logo.jpg" alt="">
        <p1>PONDOK COFFEE BU SEH </p1>
        <p3>Selamat Datang <?=$username;?></p3>
    </div>
    <p class="list">List Data Admin</p>

   
        
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
        <div class="border">
        <div class="tambah">
            <p class="tambah2"><a href="http://localhost/Gaji_Karyawan/aplikasi/app/pimpinan/Admin/tambah_admin.php">TAMBAH DATA <i class="bi bi-plus-square-fill"></i></a></p>
        </div>

        <div class="show">
          <label >Show Entries: </label>
          <select id="show-entries">
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="30">30</option>
                <option value="40">40</option>
                <option value="50">50</option>
                <option value="100">100</option>
              <!-- Tambahkan pilihan jumlah entri yang lain sesuai kebutuhan -->
          </select>
        </div>

        <table id="karyawan-table" border="1" align="right">
            <tr>
                <th width="70px">DELETE</th>
                <th width="70px">EDIT</th>
                <th width="50px">NO</th>
                <th width="150px">NAMA</th>
                <th width="200px">Email</th>
                <th width="200px">Username</th>
               
            </tr>

            <?php
            $no = 1;
            include '../../../config/koneksi.php';
            $query = mysqli_query($conn, "SELECT * FROM admin WHERE role = 'admin' ORDER BY nama_admin ASC");
            if (isset($_GET['cari'])) {
                $query = mysqli_query($conn, "SELECT * FROM admin" .
                    $_GET['cari'] . "%");
            }
            while ($data = mysqli_fetch_array($query)) {
            ?>
                <tr>
                    <td align="center">
                        <a href="http://localhost/Gaji_Karyawan/aplikasi/app/pimpinan/Admin/hapusdata.php?id=<?php echo $data['id']; ?>"><i class="bi bi-trash3-fill"></i></a>
                    </td>
                    <td align="center">
                        <a href="http://localhost/Gaji_Karyawan/aplikasi/app/pimpinan/Admin/editdata.php?id=<?php echo $data['id']; ?>"><i class="bi bi-pencil-square"></i></a>
                    </td>
                    <td align="center"><?=$no++;?></td>
                    <td align="center"><?php echo $data['nama_admin']; ?></td>
                    <td align="center"><?php echo $data['email']; ?></td>
                    <td align="center"><?php echo $data['username']; ?></td>
                </tr>
            <?php
            }
            ?>
        </table>
    </div>

   

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Dapatkan elemen drop-down Show Entries
            const showEntries = document.getElementById("show-entries");

            // Dapatkan elemen tabel
            const table = document.getElementById("karyawan-table");

            // Fungsi untuk mengatur jumlah entri yang ditampilkan
            function setEntriesPerPage() {
                const selectedEntries = showEntries.value;
                const rows = table.getElementsByTagName("tr");

                // Sembunyikan semua baris kecuali baris header
                for (let i = 1; i < rows.length; i++) {
                    rows[i].style.display = "none";
                }

                // Tampilkan jumlah entri yang sesuai
                for (let i = 1; i <= selectedEntries; i++) {
                    if (rows[i]) {
                        rows[i].style.display = "";
                    }
                }
            }

            // Panggil fungsi setEntriesPerPage() saat halaman dimuat
            setEntriesPerPage();

            // Tambahkan event listener untuk mengubah jumlah entri yang ditampilkan
            showEntries.addEventListener("change", setEntriesPerPage);
        });
    </script>
</body>

</html>
