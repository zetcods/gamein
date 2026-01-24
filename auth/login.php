<?php
session_start();
include '../config/koneksi.php';

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];
    $query = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
    
    if (mysqli_num_rows($query) === 1) {
        $row = mysqli_fetch_assoc($query);
        if (password_verify($password, $row['password'])) {
            $_SESSION['login']    = true;
            $_SESSION['id_user']  = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['role']     = $row['role'];

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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | GameIn</title>
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
            height: 100vh; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            color: white; 
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
        }

        .login-card { 
            background: var(--bg-card); 
            border: 1px solid var(--border-ui); 
            border-radius: 15px; 
            width: 100%;
            max-width: 400px; 
            padding: 40px; 
            box-shadow: 0 20px 50px rgba(0,0,0,0.4);
        }

        .brand-logo { 
            font-size: 2.2rem; 
            font-weight: 800; 
            letter-spacing: -1px; 
            text-decoration: none; 
            color: white;
            display: block;
        }
        .brand-logo span { color: var(--accent); }

        .form-label { 
            font-size: 12px; 
            font-weight: 700; 
            text-transform: uppercase; 
            letter-spacing: 1px; 
            color: var(--text-muted);
        }

        .input-group {
            background: #16102b;
            border: 1px solid var(--border-ui);
            border-radius: 8px;
            overflow: hidden;
            transition: 0.3s;
        }
        .input-group:focus-within {
            border-color: var(--accent);
        }

        .input-group-text {
            background: transparent;
            border: none;
            color: var(--text-muted);
            padding-right: 0;
            padding-left: 15px;
        }

        .form-control { 
            background: transparent; 
            border: none; 
            color: white; 
            padding: 12px 15px; 
            font-size: 14px;
        }
        .form-control:focus { 
            background: transparent; 
            color: white; 
            box-shadow: none; 
        }
        .form-control::placeholder { color: #5a5475; }

        .btn-login { 
            background: var(--accent); 
            border: none; 
            font-weight: 800; 
            border-radius: 8px; 
            padding: 14px; 
            letter-spacing: 1px;
            transition: 0.3s;
            margin-top: 10px;
        }
        .btn-login:hover { 
            background: #e63535; 
            transform: translateY(-2px); 
            box-shadow: 0 8px 20px rgba(255, 62, 62, 0.3); 
        }

        .alert-custom {
            background: rgba(255, 62, 62, 0.1);
            border: 1px solid rgba(255, 62, 62, 0.2);
            color: var(--accent);
            font-size: 13px;
            font-weight: 600;
            border-radius: 8px;
        }

        .footer-link {
            font-size: 13px;
            color: var(--text-muted);
        }
        .footer-link a {
            color: var(--accent);
            text-decoration: none;
            font-weight: 700;
        }
        .footer-link a:hover { text-decoration: underline; }
    </style>
</head>
<body>

<div class="login-card">
    <div class="text-center mb-5">
        <a href="../index.php" class="brand-logo">GAME<span>IN</span></a>
        <div style="width: 30px; height: 3px; background: var(--accent); margin: 10px auto;"></div>
    </div>

    <?php if(isset($error)): ?>
        <div class="alert alert-custom py-2 text-center mb-4">
            <i class="bi bi-exclamation-circle me-2"></i><?= $error; ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Username</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-person"></i></span>
                <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
            </div>
        </div>
        
        <div class="mb-4">
            <label class="form-label">Password</label>
            <div class="input-group">
                <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>
        </div>

        <div class="d-grid mb-4">
            <button type="submit" name="login" class="btn btn-danger btn-login">SIGN IN</button>
        </div>
    </form>
    
    <div class="text-center footer-link">
        Belum punya akun? <a href="register.php">Daftar sekarang</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>