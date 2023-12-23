<?php
if (isset($_POST['login'])){
    include '../config/koneksi.php';
    $pesan='';
    $redirect='';
    $un=$_POST['username'];
    $ps=$_POST['password'];

    $q = $conn->query("SELECT * FROM admin WHERE username='$un'");
    if ($q && $q->num_rows > 0) { // Periksa apakah query mengembalikan hasil
        $get_data = mysqli_fetch_array($q);
        $passwordbaru = $get_data['password'];

        // Validasi password
        $ps_md5 = md5($ps);

        if ($ps_md5 === $passwordbaru) {
            $role = $get_data['role'];

            session_start();
            $_SESSION['id'] = $get_data['id'];
            $_SESSION['username'] = $un;
            $_SESSION['role'] = $role;

            // Tentukan halaman redirect berdasarkan peran
            if ($role === 'pimpinan') {
                $redirect = 'http://localhost/Gaji_Karyawan/aplikasi/app/pimpinan/dashboard.php';
            } elseif ($role === 'admin') {
                $redirect = 'dashboard.php';
            } else {
                // Peran lain bisa ditambahkan di sini
            }

            $pesan = 'Login Sukses';
        } else {
            $pesan = 'Password salah!';
        }
    } else {
        $pesan = 'Username & Password tidak terdaftar!';
    }
    echo("<script language='JavaScript'>
    window.alert('$pesan'); 
    window.location.href='$redirect';
    </script>");
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HALAMAN LOGIN</title>
    
    <!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="../asset/img/icons/logo1.jpg"/>

    <link rel="stylesheet" type="text/css" href="../asset/Linearicons-Free-v1.0.0/icon-font.min.css">

    <link rel="stylesheet"  href="../asset/Css/util.css">
    <link rel="stylesheet"  href="../asset/Css/login.css">
    <!--===============================================================================================-->
</head>
<body>
    <div class="limiter">
		<div class="container-login100" style="background-image: url('../asset/img/bg-01.jpg');">
			<div class="wrap-login100 p-t-30 p-b-50">
				<span class="login100-form-title p-b-41">
                    PONDOK COFFE BU SEH
				</span>
				<form class="login100-form validate-form p-b-33 p-t-5" method="post">
                    <h3>Silahkan Login</h3>
					<div class="wrap-input100 validate-input" data-validate = "Enter username">
						<input class="input100" type="text" name="username" placeholder="User name" required>
						<span class="focus-input100" data-placeholder="&#xe82a;"></span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Enter password">
						<input class="input100" type="password" name="password" placeholder="Password" required>
						<span class="focus-input100" data-placeholder="&#xe80f;"></span>
					</div>

					<div class="container-login100-form-btn m-t-32">
						<button class="login100-form-btn" type="submit" name="login" value="Log In">
							Login
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</body>