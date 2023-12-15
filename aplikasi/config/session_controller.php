<?php
if (isset($_SESSION['timeout']) && $_SESSION['timeout'] < time()) {
    // Sesi telah timeout, lakukan logout otomatis
    session_unset(); // Menghapus semua data sesi
    session_destroy(); // Menghancurkan sesi
    echo "Sesi telah berakhir. Otomatis logout."; // Debugging statement
    header("Location: http://localhost/Gaji_karyawan/aplikasi/view/Logout.php"); // Redirect ke halaman logout atau halaman lain yang sesuai
}

// Perbarui waktu timeout saat ada aktivitas
if (isset($_SESSION['timeout'])) {
    $_SESSION['timeout'] = time() + 60; // Perbarui waktu timeout (Hitungannya detik)
    echo "Waktu sesi diperbarui."; // Debugging statement
}
?>
