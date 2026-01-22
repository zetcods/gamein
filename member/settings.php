<?php
session_start();
include '../config/koneksi.php';

// Proteksi akses
if (!isset($_SESSION['login']) || $_SESSION['role'] != 'member') {
    header("Location: ../auth/login.php");
    exit;
}

$id_user = $_SESSION['id_user'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Account Settings | GameIn</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        /* CSS Sinkron dengan Dashboard & Profile */
        body { background-color: #f0f2f5; font-family: 'Segoe UI', sans-serif; }
        .sidebar { height: 100vh; background: #ffffff; color: #333; position: fixed; width: 260px; border-right: 1px solid #ddd; z-index: 1000; }
        .main-content { margin-left: 260px; padding: 30px; }
        .nav-link { color: #555; padding: 12px 20px; border-left: 4px solid transparent; }
        .nav-link:hover { background: #f8f9fa; color: #0d6efd; border-left: 4px solid #0d6efd; }
        .nav-link.active { background: #e7f1ff; color: #0d6efd; border-left: 4px solid #0d6efd; font-weight: 600; }
        .user-section { padding: 20px; text-align: center; border-bottom: 1px solid #eee; }
        .avatar { width: 60px; height: 60px; background: #0d6efd; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 10px; font-size: 24px; font-weight: bold; }
        
        .settings-card { border: none; border-radius: 12px; transition: 0.3s; }
        .settings-card:hover { background-color: #fdfdfd; }
    </style>
</head>
<body>

<?php include 'header_member.php'; ?>

<div class="main-content">
    <div class="mb-4">
        <h4 class="fw-bold mb-0">Pengaturan Akun</h4>
        <p class="text-muted small">Konfigurasi preferensi sistem lo di sini.</p>
    </div>

    <div class="row g-4">
        <div class="col-md-6">
            <div class="card settings-card shadow-sm p-4">
                <div class="d-flex align-items-center mb-3">
                    <i class="bi bi-shield-lock-fill text-danger fs-4 me-3"></i>
                    <h5 class="fw-bold mb-0">Keamanan</h5>
                </div>
                <p class="small text-muted">Kelola autentikasi dan akses login akun lo.</p>
                <hr>
                <div class="d-flex justify-content-between align-items-center">
                    <span>Ganti Password</span>
                    <a href="profile.php" class="btn btn-sm btn-outline-primary">Atur Sekarang</a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card settings-card shadow-sm p-4">
                <div class="d-flex align-items-center mb-3">
                    <i class="bi bi-palette-fill text-warning fs-4 me-3"></i>
                    <h5 class="fw-bold mb-0">Tampilan</h5>
                </div>
                <p class="small text-muted">Kustomisasi cara lo melihat dashboard ini.</p>
                <hr>
                <div class="form-check form-switch">
                    <input class="form-check-column-input me-2" type="checkbox" role="switch" id="darkMode">
                    <label class="form-check-label" for="darkMode">Mode Gelap (Coming Soon)</label>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card border-0 shadow-sm p-4 bg-light">
                <h6 class="fw-bold text-muted small mb-3">INFORMASI SISTEM</h6>
                <div class="row text-center text-md-start">
                    <div class="col-md-4">
                        <small class="d-block text-muted">ID User</small>
                        <span class="fw-mono text-primary"><?= $id_user; ?></span>
                    </div>
                    <div class="col-md-4">
                        <small class="d-block text-muted">Versi Aplikasi</small>
                        <span>v1.2.0-stable</span>
                    </div>
                    <div class="col-md-4">
                        <small class="d-block text-muted">Last Login</small>
                        <span><?= date('d M Y H:i'); ?> WIB</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>