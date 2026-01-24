<?php
include '../config/koneksi.php';

if (isset($_POST['register'])) {
    $id_user = "user_" . substr(md5(uniqid(rand(), true)), 0, 8);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = 'member';

    if ($password !== $confirm_password) {
        $error = "Password gak match bro, cek lagi!";
    } else {
        $cek_user = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
        if (mysqli_num_rows($cek_user) > 0) {
            $error = "Username udah dipake orang lain!";
        } else {
            $hashed_pass = password_hash($password, PASSWORD_DEFAULT);
            $query = "INSERT INTO users (id, username, password, role) VALUES ('$id_user', '$username', '$hashed_pass', '$role')";
            if (mysqli_query($conn, $query)) {
                echo "<script>alert('Registrasi Berhasil! Silakan Login.'); window.location='login.php';</script>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | GameIn</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root { 
            --bg-dark: #0f0a21; 
            --bg-card: #1d1536; 
            --accent: #ff3e3e; 
            --border-ui: #2b214a;
            --text-muted: #b5b3bc;
        }

        body { 
            background: var(--bg-dark); 
            min-height: 100vh; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            color: white; 
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 20px;
        }

        .reg-card { 
            background: var(--bg-card); 
            border: 1px solid var(--border-ui); 
            border-radius: 15px; 
            width: 100%;
            max-width: 420px; 
            padding: 40px; 
            box-shadow: 0 20px 50px rgba(0,0,0,0.5);
        }

        .brand-logo { 
            font-size: 2.2rem; 
            font-weight: 800; 
            text-decoration: none; 
            color: white;
            letter-spacing: -1px;
        }
        .brand-logo span { color: var(--accent); }

        .form-label { 
            font-size: 11px; 
            font-weight: 700; 
            text-transform: uppercase; 
            letter-spacing: 1.5px; 
            color: var(--text-muted);
            margin-bottom: 8px;
        }

        .input-group {
            background: #16102b;
            border: 1px solid var(--border-ui);
            border-radius: 8px;
            transition: 0.3s;
        }
        .input-group:focus-within { border-color: var(--accent); }

        .input-group-text {
            background: transparent;
            border: none;
            color: var(--text-muted);
            padding-left: 15px;
        }

        .form-control { 
            background: transparent; 
            border: none; 
            color: white; 
            padding: 12px; 
            font-size: 14px;
        }
        .form-control:focus { background: transparent; color: white; box-shadow: none; }
        .form-control::placeholder { color: #4e476d; }

        .btn-reg { 
            background: var(--accent); 
            border: none; 
            font-weight: 800; 
            border-radius: 8px; 
            padding: 14px; 
            letter-spacing: 1px;
            transition: 0.3s;
            margin-top: 10px;
        }
        .btn-reg:hover { 
            background: #e63535; 
            transform: translateY(-2px); 
            box-shadow: 0 8px 20px rgba(255, 62, 62, 0.3); 
        }

        .alert-custom {
            background: rgba(255, 62, 62, 0.1);
            border: 1px solid rgba(255, 62, 62, 0.2);
            color: var(--accent);
            font-size: 13px;
            border-radius: 8px;
        }

        .login-link { font-size: 13px; color: var(--text-muted); }
        .login-link a { color: var(--accent); text-decoration: none; font-weight: 700; }
        .login-link a:hover { text-decoration: underline; }
    </style>
</head>
<body>

<div class="reg-card">
    <div class="text-center mb-4">
        <a href="../index.php" class="brand-logo">GAME<span>IN</span></a>
        <p class="small text-muted mb-0">Create your account to start gaming</p>
    </div>

    <?php if (isset($error)): ?>
        <div class="alert alert-custom py-2 text-center mb-4">
            <i class="bi bi-exclamation-triangle me-2"></i><?= $error; ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Username</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-person"></i></span>
                <input type="text" name="username" class="form-control" placeholder="Gamer ID" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Password</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-key"></i></span>
                <input type="password" name="password" class="form-control" placeholder="Min. 6 characters" required>
            </div>
        </div>

        <div class="mb-4">
            <label class="form-label">Confirm Password</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-check2-circle"></i></span>
                <input type="password" name="confirm_password" class="form-control" placeholder="Repeat password" required>
            </div>
        </div>

        <div class="d-grid mb-4">
            <button type="submit" name="register" class="btn btn-danger btn-reg">JOIN NOW</button>
        </div>
    </form>

    <div class="text-center login-link">
        Sudah punya akun? <a href="login.php">Log In</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>