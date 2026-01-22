<?php
include '../config/koneksi.php';

if (isset($_POST['register'])) {
    // 1. Generate ID Random Unik (8 karakter)
    $id_user = "user_" . substr(md5(uniqid(rand(), true)), 0, 8);
    
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = 'member'; // Default role pas daftar jadi member

    // 2. Validasi Password
    if ($password !== $confirm_password) {
        $error = "Password gak match bro, cek lagi!";
    } else {
        // Cek apakah username udah ada yang pake
        $cek_user = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
        if (mysqli_num_rows($cek_user) > 0) {
            $error = "Username udah dipake orang lain, cari yang lebih unik!";
        } else {
            // Hash Password biar aman di database
            $hashed_pass = password_hash($password, PASSWORD_DEFAULT);
            $query = "INSERT INTO users (id, username, password, role) VALUES ('$id_user', '$username', '$hashed_pass', '$role')";
            
            if (mysqli_query($conn, $query)) {
                echo "<script>alert('Registrasi Berhasil! Silakan Login.'); window.location='login.php';</script>";
            } else {
                $error = "Gagal daftar: " . mysqli_error($conn);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Join GameIn - Create Account</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #121212; color: white; height: 100vh; display: flex; align-items: center; justify-content: center; }
        .card { background: #1e1e1e; border: none; border-radius: 15px; width: 100%; max-width: 400px; }
        .form-control { background: #2c2c2c; border: none; color: white; }
        .form-control:focus { background: #333; color: white; border-color: #0d6efd; box-shadow: none; }
        .btn-primary { border-radius: 10px; font-weight: bold; }
    </style>
</head>
<body>

<div class="card shadow p-4">
    <div class="text-center mb-4">
        <h2 class="fw-bold text-primary">GameIn</h2>
        <p class="text-muted">Daftar sekarang buat download game favorit lo!</p>
    </div>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger py-2 small text-center"><?= $error; ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="small mb-1">Username</label>
            <input type="text" name="username" class="form-control" placeholder="Contoh: gamer_ganteng" required>
        </div>
        <div class="mb-3">
            <label class="small mb-1">Password</label>
            <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required>
        </div>
        <div class="mb-4">
            <label class="small mb-1">Konfirmasi Password</label>
            <input type="password" name="confirm_password" class="form-control" placeholder="Ulangi password" required>
        </div>
        <button type="submit" name="register" class="btn btn-primary w-100">Daftar Sekarang</button>
    </form>

    <div class="mt-4 text-center small">
        <span class="text-muted">Udah punya akun?</span> 
        <a href="login.php" class="text-decoration-none">Login di sini</a>
    </div>
</div>

</body>
</html>