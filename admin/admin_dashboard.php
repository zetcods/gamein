<?php
session_start();
include '../config/koneksi.php';
if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') { header("Location: ../auth/login.php"); exit; }

// Hitung data untuk statistik
$count_users = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM users WHERE role='member'"));
$count_admins = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM users WHERE role='admin'"));
$count_games = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM games"));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Dashboard Admin | GameIn</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body>

<?php include 'header_admin.php'; ?>

<div class="main-content">
    <div class="mb-4">
        <h2 class="fw-bold text-dark">System Overview</h2>
        <p class="text-muted small">Pantau statistik platform GameIn secara real-time.</p>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-4 bg-white" style="border-radius: 15px;">
                <div class="d-flex align-items-center">
                    <div class="icon-box bg-primary text-white rounded-3 p-3 me-3">
                        <i class="bi bi-people-fill fs-4"></i>
                    </div>
                    <div>
                        <h6 class="text-muted small fw-bold mb-0">TOTAL MEMBERS</h6>
                        <h2 class="fw-bold mb-0"><?= $count_users; ?></h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-4 bg-white" style="border-radius: 15px;">
                <div class="d-flex align-items-center">
                    <div class="icon-box bg-success text-white rounded-3 p-3 me-3">
                        <i class="bi bi-controller fs-4"></i>
                    </div>
                    <div>
                        <h6 class="text-muted small fw-bold mb-0">TOTAL GAMES</h6>
                        <h2 class="fw-bold mb-0"><?= $count_games; ?></h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-4 bg-white" style="border-radius: 15px;">
                <div class="d-flex align-items-center">
                    <div class="icon-box bg-warning text-dark rounded-3 p-3 me-3">
                        <i class="bi bi-shield-lock-fill fs-4"></i>
                    </div>
                    <div>
                        <h6 class="text-muted small fw-bold mb-0">ADMINISTRATORS</h6>
                        <h2 class="fw-bold mb-0"><?= $count_admins; ?></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm p-4 bg-white" style="border-radius: 15px;">
        <h5 class="fw-bold mb-3">Sistem Status</h5>
        <table class="table table-borderless small mb-0">
            <tr>
                <td class="text-muted" width="200">Versi PHP</td>
                <td>: <?= phpversion(); ?></td>
            </tr>
            <tr>
                <td class="text-muted">Server Database</td>
                <td>: MySQL / MariaDB (Connected)</td>
            </tr>
            <tr>
                <td class="text-muted">Waktu Server</td>
                <td>: <?= date('Y-m-d H:i:s'); ?></td>
            </tr>
        </table>
    </div>
</div>

</body>
</html>