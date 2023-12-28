<?php

// Fungsi untuk menghasilkan token reset dan menyimpannya ke database
// session_start();
include 'config/koneksi.php'; // Sesuaikan dengan path file koneksi.php Anda

// Fungsi untuk menghasilkan token reset dan menyimpannya ke database
// function generateToken($email) {
//     global $koneksi;

//     // Batalkan token lama yang belum digunakan
//     $resetRequestTime = date('Y-m-d H:i:s');
//     $cancelQuery = $koneksi->prepare("UPDATE admin SET reset_request_time = ? WHERE email = ? AND reset_request_time IS NULL");
//     $cancelQuery->bind_param("ss", $resetRequestTime, $email);
//     $cancelQuery->execute();

//     // Generate token baru
//     $token = bin2hex(random_bytes(32));

//     // Tentukan waktu kedaluwarsa (5 menit dari sekarang)
//     $expiration = date('Y-m-d H:i:s', strtotime('+5 minutes'));

//     // Simpan waktu reset_request_time (saat permintaan reset terakhir kali)
//     $resetRequestTime = null;

//     // Ambil ID berdasarkan email
//     $getIdQuery = $koneksi->prepare("SELECT id FROM admin WHERE email = ?");
//     $getIdQuery->bind_param("s", $email);
//     $getIdQuery->execute();
//     $getIdQuery->store_result();

//     if ($getIdQuery->num_rows > 0) {
//         $getIdQuery->bind_result($userId);
//         $getIdQuery->fetch();

//         // Update database dengan token baru, waktu kedaluwarsa, dan waktu reset_request_time
//         $query = $koneksi->prepare("UPDATE admin SET reset_token = ?, token_expiration = ?, reset_request_time = ? WHERE id = ?");
//         $query->bind_param("sssi", $token, $expiration, $resetRequestTime, $userId);
//         $query->execute();

//         return $token;
//     } else {
//         // Log bahwa tidak ada pengguna dengan email yang diberikan ditemukan
//         error_log("Pengguna dengan email yang diberikan tidak ditemukan");
//         return false;
//     }
// }

// Fungsi untuk memvalidasi token reset
function validateToken($token) {
    global $koneksi;

    $currentDateTime = date('Y-m-d H:i:s');
    $query = $koneksi->prepare("SELECT id FROM admin WHERE reset_token = ? AND token_expiration > ?");
    $query->bind_param("ss", $token, $currentDateTime);
    $query->execute();
    $query->store_result();

    return $query->num_rows > 0;
}

// Fungsi untuk mereset password berdasarkan token
function resetPassword($token, $password) {
    global $koneksi;

    // Validasi token
    if (validateToken($token)) {
        $hashedPassword = md5($password);

        // Dapatkan ID pengguna berdasarkan token
        $query = $koneksi->prepare("SELECT id, reset_request_time FROM admin WHERE reset_token = ?");
        $query->bind_param("s", $token);
        $query->execute();
        $query->store_result();

        if ($query->num_rows > 0) {
            $query->bind_result($userId, $resetRequestTime);
            $query->fetch();

            // Reset password, hapus token, dan tandai token sebagai digunakan
            $updatePasswordQuery = $koneksi->prepare("UPDATE admin SET password = ?, reset_token = NULL, token_expiration = NULL, reset_request_time = NOW() WHERE id = ?");
            $updatePasswordQuery->bind_param("si", $hashedPassword, $userId);
            $updatePasswordQuery->execute();

            // Tandai token sebagai digunakan
            $markTokenUsedQuery = $koneksi->prepare("UPDATE admin SET reset_request_time = NOW() WHERE reset_token = ?");
            $markTokenUsedQuery->bind_param("s", $token);
            $markTokenUsedQuery->execute();

            return true;
        } else {
            // Log bahwa tidak ada pengguna dengan token yang diberikan ditemukan
            error_log("Token tidak ditemukan pada resetPassword");
            return false;
        }
    } else {
        // Log bahwa validasi token gagal
        error_log("Validasi token gagal pada resetPassword");
        return false;
    }
}
?>
