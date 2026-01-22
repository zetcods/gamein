<?php
session_start();
include '../config/koneksi.php';
if (!isset($_SESSION['login']) || $_SESSION['role'] != 'member') { header("Location: ../auth/login.php"); exit; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Member Dashboard | GameIn</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body>

<?php include 'header_member.php'; ?>

<div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Member Overview</h4>
        <span class="badge bg-white text-dark shadow-sm p-2 px-3 border">Member Level: Gold</span>
    </div>

    <div class="row g-4">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm p-5 text-center bg-white" style="border-radius: 15px;">
                <img src="https://illustrations.popsy.co/white/data-analysis.svg" style="width: 180px;" class="mb-4">
                <h5 class="fw-bold">Selamat Datang di Portal GameIn!</h5>
                <p class="text-muted">Kelola profil lo dan cari game terbaru di katalog kami.</p>
                <a href="../index.php" class="btn btn-primary px-4 fw-bold">Jelajahi Game</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-4 bg-primary text-white" style="border-radius: 15px;">
                <h6 class="fw-bold small">TIPS KEAMANAN</h6>
                <p class="small mb-0">Jangan pernah bagikan password lo kepada siapapun, termasuk admin GameIn.</p>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>