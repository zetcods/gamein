<?php
session_start(); include '../config/koneksi.php';
if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') exit;

$count_users = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM users WHERE role='member'"));
$count_admins = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM users WHERE role='admin'"));
$count_games = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM games"));
?>
<!DOCTYPE html>
<html lang="en">
<head><title>Dashboard | Admin</title></head>
<body>
    <?php include 'header_admin.php'; ?>
    <div class="main-content">
        <h3 class="fw-bold mb-4">System <span class="text-danger">Overview</span></h3>
        <div class="row g-4 mb-4">
            <div class="col-md-4"><div class="card p-4 text-center"><h6>MEMBERS</h6><h2><?= $count_users ?></h2></div></div>
            <div class="col-md-4"><div class="card p-4 text-center" style="border-bottom: 3px solid var(--accent) !important;"><h6>GAMES</h6><h2><?= $count_games ?></h2></div></div>
            <div class="col-md-4"><div class="card p-4 text-center"><h6>ADMINS</h6><h2><?= $count_admins ?></h2></div></div>
        </div>
        <div class="card p-4">
            <h5 class="fw-bold mb-3">Server Status</h5>
            <div class="d-flex justify-content-between border-bottom border-secondary py-2"><span class="text-muted">PHP Version</span><span><?= phpversion() ?></span></div>
            <div class="d-flex justify-content-between py-2"><span class="text-muted">Database</span><span class="text-success">Connected</span></div>
        </div>
    </div>
</body>
</html>