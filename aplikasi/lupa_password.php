<?php
session_start();
include 'config/koneksi.php'; // Sesuaikan dengan path file koneksi.php Anda

function generateToken($email) {
    global $conn;

    // Batalkan token lama yang belum digunakan
    $resetRequestTime = date('Y-m-d H:i:s');
    $cancelQuery = $conn->prepare("UPDATE admin SET reset_request_time = ? WHERE email = ? AND reset_request_time IS NULL");
    $cancelQuery->bind_param("ss", $resetRequestTime, $email);
    $cancelQuery->execute();

    // Generate token baru
    $token = bin2hex(random_bytes(32));

    // Tentukan waktu kedaluwarsa (misalnya, 3 menit dari sekarang)
    $expiration = date('Y-m-d H:i:s', strtotime('+3 minutes'));

    // Simpan waktu reset_request_time (saat permintaan reset terakhir kali)
    $resetRequestTime = null;

    // Ambil ID berdasarkan email
    $getIdQuery = $conn->prepare("SELECT id FROM admin WHERE email = ?");
    $getIdQuery->bind_param("s", $email);
    $getIdQuery->execute();
    $getIdQuery->store_result();

    if ($getIdQuery->num_rows > 0) {
        $getIdQuery->bind_result($userId);
        $getIdQuery->fetch();

        // Update database dengan token baru, waktu kedaluwarsa, dan waktu reset_request_time
        $query = $conn->prepare("UPDATE admin SET reset_token = ?, token_expiration = ?, reset_request_time = ? WHERE id = ?");
        $query->bind_param("sssi", $token, $expiration, $resetRequestTime, $userId);
        $query->execute();

        return $token;
    } else {
        // Log bahwa tidak ada pengguna dengan email yang diberikan ditemukan
        error_log("Pengguna dengan email yang diberikan tidak ditemukan");
        return false;
    }
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require '../vendor/autoload.php'; // Sesuaikan dengan path vendor/autoload.php Anda

if (isset($_POST['lupa_password'])) {
    $email = $_POST['email'];

    // Lakukan sanitasi input atau gunakan prepared statement untuk mencegah SQL injection
    $email = mysqli_real_escape_string($conn, $email);

    $check_email = mysqli_query($conn, "SELECT * FROM admin WHERE email='$email'");
    $count = mysqli_num_rows($check_email);

    if ($count > 0) {
        $token = generateToken($email);

        if ($token) {
            $mail = new PHPMailer();
            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->Host = 'mail.ternakgesek.my.id'; // Ganti dengan host SMTP Anda
            $mail->SMTPAuth = true;
            $mail->Username = 'admin@ternakgesek.my.id'; // Ganti dengan username SMTP server Anda
            $mail->Password = 'ternakgesek19'; // Ganti dengan password SMTP server Anda
            $mail->Port = 587; // Sesuaikan dengan port SMTP server
            $mail->SMTPSecure = 'tls';
            $mail->setFrom('noreply@pondokcoffeebuseh.000webhostapp.com', 'Pondok Coffe Bu Seh'); // Ganti dengan alamat email pengirim dan nama Anda
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Reset Password';
            $mail->Body = "Halo! Kamu menerima email ini karena permintaan reset password. Klik tautan berikut untuk reset password kamu: <a href='http://localhost/Gaji_karyawan/aplikasi/reset_password.php?token=$token'>Reset Password</a>";

            if ($mail->send()) {
                $_SESSION['message'] = "Tautan reset password telah dikirim ke email kamu!";
                echo "<script>alert('Tautan reset password telah dikirim ke email kamu!');window.location.href='http://localhost/Gaji_karyawan/aplikasi/view/Login.php';</script>";
                exit();
            } else {
                echo "<script>alert('Email gagal dikirim. Silakan coba lagi nanti.');</script>";
            }
        } else {
            echo "<script>alert('Gagal menyimpan token reset password!');</script>";
        }
    } else {
        echo "<script>alert('Email tidak terdaftar!');</script>";
    }
}
?>



<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HALAMAN LUPA PASSWORD</title>
    
    <link rel="icon" type="image/png" href="asset/img/icons/logo1.jpg"/>
    <link rel="stylesheet" type="text/css" href="asset/Linearicons-Free-v1.0.0/icon-font.min.css">
    <link rel="stylesheet"  href="asset/Css/util.css">
    <link rel="stylesheet"  href="asset/Css/login.css">
</head>
<body>
    <div class="limiter">
		<div class="container-login100" style="background-image: url('asset/img/bg-01.jpg');">
			<div class="wrap-login100 p-t-30 p-b-50">
				<span class="login100-form-title p-b-41">
                    PONDOK COFFE BU SEH
				</span>
				<form class="login100-form validate-form p-b-33 p-t-5"  method="post">
                    <h3>Masukan Email</h3>
					<div class="wrap-input100 validate-input" data-validate = "Enter Email">
						<input class="input100" type="email" name="email" placeholder="Masukkan Email Terdaftar" required>
						<span class="focus-input100" data-placeholder="&#xe82a;"></span>
					</div>

					<div class="container-login100-form-btn m-t-32">
						<button class="login100-form-btn" type="submit" name="lupa_password">
							Kirim
						</button>
					</div>
                    <h3><a href="http://localhost/Gaji_karyawan/aplikasi/view/login.php">Kembali</a></h3>
				</form>
			</div>
		</div>
	</div>
</body>
</html>
