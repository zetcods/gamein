<?php
$id_sess = $_SESSION['id_user'];
$adm_h = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id='$id_sess'"));
?>
<link rel="stylesheet" href="../config/style_admin.php">
<style>
    .sidebar { height: 100vh; width: 260px; background: var(--sidebar-dark); position: fixed; top: 0; left: 0; border-right: 1px solid #2b214a; }
    .nav-link { color: var(--text-muted); padding: 12px 25px; transition: 0.3s; }
    .nav-link:hover, .nav-link.active { color: var(--accent); background: rgba(255,193,7,0.05); border-right: 3px solid var(--accent); }
    .avatar-admin { width: 60px; height: 60px; border-radius: 50%; border: 2px solid var(--accent); margin-bottom: 10px; }
</style>

<div class="sidebar shadow">
    <div class="p-4 text-center border-bottom border-secondary">
        <h4 class="fw-bold text-white">GAME<span style="color:var(--accent)">IN</span></h4>
        <small class="text-warning">ADMIN PANEL</small>
    </div>
    <div class="p-4 text-center">
        <img src="../assets/images/<?= $adm_h['foto']; ?>" class="avatar-admin shadow">
        <h6 class="mb-0 fw-bold"><?= $adm_h['username']; ?></h6>
        <a href="../index.php" class="btn btn-sm btn-outline-info mt-3 rounded-pill" style="font-size: 11px;">Visit Site</a>
    </div>
    <nav class="mt-2">
        <a class="nav-link <?= (basename($_SERVER['PHP_SELF']) == 'admin_dashboard.php') ? 'active' : ''; ?>" href="admin_dashboard.php"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
        <a class="nav-link <?= (basename($_SERVER['PHP_SELF']) == 'games_manage.php') ? 'active' : ''; ?>" href="games_manage.php"><i class="bi bi-controller me-2"></i> Library</a>
        <a class="nav-link <?= (basename($_SERVER['PHP_SELF']) == 'genres_manage.php') ? 'active' : ''; ?>" href="genres_manage.php"><i class="bi bi-tags me-2"></i> Genres</a>
        <a class="nav-link text-danger mt-5" href="../logout.php"><i class="bi bi-box-arrow-left me-2"></i> Logout</a>
    </nav>
</div>