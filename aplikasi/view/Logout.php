<?php
session_start(); // Mulai sesi

// Hentikan sesi
session_unset();
session_destroy();

// Alihkan ke halaman login
header("Location: Login.php");
exit;
?>
