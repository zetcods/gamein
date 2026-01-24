<?php
session_start();
include 'config/koneksi.php';

// Proteksi: Kalau belum login, tendang ke login.php
if (!isset($_SESSION['login'])) {
    header("Location: auth/login.php");
    exit;
}

$id_user = $_SESSION['id_user'];
$query = mysqli_query($conn, "SELECT * FROM users WHERE id = '$id_user'");
$user = mysqli_fetch_assoc($query);

// Logic Update Password
if (isset($_POST['update_profile'])) {
    $password_baru = $_POST['password_baru'];
    $konfirmasi = $_POST['konfirmasi_password'];

    if (!empty($password_baru)) {
        if ($password_baru === $konfirmasi) {
            $hashed_pass = password_hash($password_baru, PASSWORD_DEFAULT);
            mysqli_query($conn, "UPDATE users SET password = '$hashed_pass' WHERE id = '$id_user'");
            $success = "Password berhasil diupdate, bro!";
        } else {
            $error = "Password baru gak match!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Profile | GameIn</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root { 
            --bg-dark: #0f0a21; 
            --bg-card: #1d1536; 
            --accent: #ff3e3e; 
            --border-ui: #2b214a;
            --text-main: #ffffff;
            --text-dim: #b5b3bc;
        }

        body { 
            background-color: var(--bg-dark); 
            color: var(--text-main); 
            font-family: 'Segoe UI', sans-serif;
        }

        /* Card Profile */
        .profile-card {
            background: var(--bg-card);
            border: 1px solid var(--border-ui);
            border-radius: 20px;
            overflow: hidden;
            margin-top: 50px;
        }

        .profile-header {
            background: linear-gradient(45deg, #1d1536, #2b214a);
            padding: 40px;
            text-align: center;
            border-bottom: 1px solid var(--border-ui);
        }

        .avatar-circle {
            width: 100px;
            height: 100px;
            background: var(--accent);
            color: white;
            font-size: 40px;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin: 0 auto 15px;
            box-shadow: 0 0 20px rgba(255, 62, 62, 0.4);
        }

        /* Form Styling */
        .form-label { color: var(--text-dim); font-size: 13px; font-weight: 600; text-transform: uppercase; }
        .form-control { 
            background: #16102b; 
            border: 1px solid var(--border-ui); 
            color: white; 
            padding: 12px;
        }
        .form-control:focus { 
            background: #241b45; 
            border-color: var(--accent); 
            color: white; 
            box-shadow: none; 
        }
        .form-control:disabled { background: #0f0a21; border-color: transparent; color: var(--text-dim); }

        .btn-update { 
            background: var(--accent); 
            border: none; 
            font-weight: 700; 
            padding: 12px;
            transition: 0.3s;
        }
        .btn-update:hover { background: #e63535; transform: translateY(-2px); }

        .badge-role {
            background: rgba(255, 255, 255, 0.1);
            color: var(--text-dim);
            font-size: 11px;
            padding: 5px 15px;
            border-radius: 50px;
            letter-spacing: 1px;
        }
    </style>
</head>
<body>

<?php include 'header.php'; // Pastikan lo punya header.php atau copas nav dari index tadi ?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="profile-card shadow-lg">
                <div class="profile-header">
                    <div class="avatar-circle">
                        <?= strtoupper(substr($user['username'], 0, 1)); ?>
                    </div>
                    <h3 class="fw-bold mb-1"><?= strtoupper($user['username']); ?></h3>
                    <span class="badge-role"><i class="bi bi-shield-check me-1"></i><?= strtoupper($user['role']); ?></span>
                </div>
                
                <div class="p-4">
                    <?php if(isset($success)): ?>
                        <div class="alert alert-success bg-success text-white border-0 small py-2 text-center"><?= $success; ?></div>
                    <?php endif; ?>
                    <?php if(isset($error)): ?>
                        <div class="alert alert-danger bg-danger text-white border-0 small py-2 text-center"><?= $error; ?></div>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" class="form-control" value="<?= $user['username']; ?>" disabled>
                        </div>
                        
                        <hr class="my-4" style="border-color: var(--border-ui);">
                        <h6 class="fw-bold mb-3" style="color: var(--accent);">Ganti Password</h6>
                        
                        <div class="mb-3">
                            <label class="form-label">Password Baru</label>
                            <div class="input-group" style="background: #16102b; border: 1px solid var(--border-ui); border-radius: 6px;">
                                <span class="input-group-text bg-transparent border-0 text-muted"><i class="bi bi-key"></i></span>
                                <input type="password" name="password_baru" class="form-control border-0" placeholder="Kosongkan jika tidak diganti">
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label">Konfirmasi Password Baru</label>
                            <div class="input-group" style="background: #16102b; border: 1px solid var(--border-ui); border-radius: 6px;">
                                <span class="input-group-text bg-transparent border-0 text-muted"><i class="bi bi-check-circle"></i></span>
                                <input type="password" name="konfirmasi_password" class="form-control border-0" placeholder="Ulangi password baru">
                            </div>
                        </div>

                        <button type="submit" name="update_profile" class="btn btn-danger btn-update w-100 mb-2">UPDATE PROFILE</button>
                        <a href="index.php" class="btn btn-link w-100 text-decoration-none text-muted small">Kembali ke Home</a>
                    </form>
                </div>
            </div>
            <p class="text-center mt-4 text-muted small">User ID: #<?= $user['id']; ?></p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>