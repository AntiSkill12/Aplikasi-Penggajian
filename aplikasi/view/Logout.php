<?php
ob_start();
session_start();
// Tambahkan pesan ke sesi sebelum menghancurkannya
$_SESSION['logout_message'] = "Logout berhasil. Terima kasih!";
session_destroy();
?>
<script>
alert("Logout Berhasil");
window.location.href = "Login.php";
</script>