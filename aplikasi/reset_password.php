<?php
include 'config/koneksi.php';
include 'config/function.php';
if (isset($_POST['reset_password'])) {
    $password_baru = $_POST['password_baru'];
    $confirm_password = $_POST['confirm_password'];
    $reset_token = $_POST['reset_token'];

    if (!empty($password_baru) && !empty($confirm_password) && $password_baru === $confirm_password) {
        $check_token = mysqli_query($conn, "SELECT * FROM admin WHERE reset_token='$reset_token'");
        $count = mysqli_num_rows($check_token);

        if ($count > 0) {
            $user = mysqli_fetch_assoc($check_token);
            $token_expiry_time = strtotime($user['token_expiration']);// Mengonversi waktu token_expiry_time ke format timestamp

            if ($token_expiry_time > time()) {
                $password_baru_md5 = md5($password_baru);
                $update_password = mysqli_query($conn, "UPDATE admin SET password='$password_baru_md5', reset_token=NULL WHERE reset_token='$reset_token'");

                if ($update_password) {
                    $_SESSION['message'] = "Password berhasil direset!";
                    echo "<script>alert('Password berhasil direset!');window.location.href='http://localhost/Gaji_karyawan/aplikasi/view/Login.php';</script>";

                    exit();
                } else {
                    echo "<script>alert('Gagal mereset password! Silakan coba lagi nanti.');</script>";
                }
            } else {
                echo "<script>alert('Tautan reset password sudah kedaluwarsa. Silakan minta reset password kembali.');</script>";
            }
        } else {
            echo "<script>alert('Token tidak valid!');</script>";
        }
    } else {
        echo "<script>alert('Password baru dan konfirmasi password harus sama dan tidak boleh kosong.');</script>";
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HALAMAN RESET PASSWORD</title>
    
    <!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="asset/img/icons/logo1.jpg"/>

    <link rel="stylesheet" type="text/css" href="asset/Linearicons-Free-v1.0.0/icon-font.min.css">

    <link rel="stylesheet"  href="asset/Css/util.css">
    <link rel="stylesheet"  href="asset/Css/login.css">
    <!--===============================================================================================-->
</head>
<body>
    <div class="limiter">
		<div class="container-login100" style="background-image: url('asset/img/bg-01.jpg');">
			<div class="wrap-login100 p-t-30 p-b-50">
				<span class="login100-form-title p-b-41">
                    PONDOK COFFE BU SEH
				</span>
				<form class="login100-form validate-form p-b-33 p-t-5"  method="post">
                    <h3>Silahkan Masukan Password Baru</h3>
                    <input type="hidden" name="reset_token" value="<?php echo $_GET['token']; ?>">

                    <div class="wrap-input100 validate-input" data-validate="Enter password">
						<input class="input100" type="password" name="password_baru" placeholder="Masukkan password baru" required minlength="6">
						<span class="focus-input100" data-placeholder="&#xe80f;"></span>
					</div>
                    <div class="wrap-input100 validate-input" data-validate="Enter password">
						<input class="input100" type="password" name="confirm_password" placeholder="Confirm password baru" required minlength="6">
						<span class="focus-input100" data-placeholder="&#xe80f;"></span>
					</div>
					<div class="container-login100-form-btn m-t-32">
						<button class="login100-form-btn" type="submit" name="reset_password">
							Reset Password
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</body>
</html>
