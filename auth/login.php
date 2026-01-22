<?php
session_start();
include '../config/koneksi.php';

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
    
    if (mysqli_num_rows($query) === 1) {
        $row = mysqli_fetch_assoc($query);
        
        // Cek Password
        if (password_verify($password, $row['password'])) {
            // Set Session
            $_SESSION['login']    = true;
            $_SESSION['id_user']  = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['role']     = $row['role'];

            // REDIRECT BERDASARKAN ROLE (Ini kuncinya!)
            if ($row['role'] == 'admin') {
                header("Location: ../admin/admin_dashboard.php");
            } else {
                header("Location: ../index.php");
            }
            exit;
        }
    }
    $error = "Username atau Password salah bro!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login | GameIn</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #121212; height: 100vh; display: flex; align-items: center; justify-content: center; color: white; }
        .card { background: #1e1e1e; border: none; border-radius: 15px; width: 350px; }
        .form-control { background: #2c2c2c; border: none; color: white; }
        .form-control:focus { background: #333; color: white; box-shadow: none; border: 1px solid #0d6efd; }
    </style>
</head>
<body>

<div class="card shadow p-4">
    <div class="text-center mb-4">
        <h2 class="fw-bold text-primary">GameIn</h2>
        <p class="text-muted small">Masuk buat akses dashboard lo</p>
    </div>

    <?php if(isset($error)): ?>
        <div class="alert alert-danger py-2 small text-center"><?= $error; ?></div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="small mb-1">Username</label>
            <input type="text" name="username" class="form-control" required>
        </div>
        <div class="mb-4">
            <label class="small mb-1">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <button type="submit" name="login" class="btn btn-primary w-100 fw-bold">Login</button>
    </form>
    
    <div class="mt-3 text-center small text-muted">
        Belum punya akun? <a href="register.php" class="text-decoration-none">Daftar</a>
    </div>
</div>

</body>
</html>