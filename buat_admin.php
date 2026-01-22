<?php
include 'config/koneksi.php';

// Setting akun admin lo di sini
$id_admin = "admin_" . bin2hex(random_bytes(4));
$user = "ZetCods"; // Ganti sesuka lo
$pass = password_hash("ZetCodsGanteng", PASSWORD_DEFAULT); // Passwordnya: admin123
$role = "admin";

$query = "INSERT INTO users (id, username, password, role) VALUES ('$id_admin', '$user', '$pass', '$role')";

if (mysqli_query($conn, $query)) {
    echo "Akun Admin Berhasil Dibuat! <br> Username: $user <br> Password: admin123 <br><br> <b>PENTING: Segera hapus file ini dari server demi keamanan!</b>";
} else {
    echo "Gagal: " . mysqli_error($conn);
}
?>