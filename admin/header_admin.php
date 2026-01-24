<?php
$id_sess = $_SESSION['id_user'];
$adm_h = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id='$id_sess'"));
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<style>
    :root {
        --bg-body: #0f0a21;
        --bg-card: #1d1536;
        --bg-sidebar: #16102b;
        --accent: #ff3e3e;
        --text-main: #ffffff;
        --text-muted: #b5b3bc;
        --border: #2b214a;
    }

    /* Reset global font color biar gak ada yang item */
    body { background: var(--bg-body); color: var(--text-main); font-family: 'Segoe UI', sans-serif; }
    h1, h2, h3, h4, h5, h6, span, p, td, th, label { color: var(--text-main); }
    .text-muted { color: var(--text-muted) !important; }

    /* Sidebar */
    .sidebar { height: 100vh; width: 260px; background: var(--bg-sidebar); position: fixed; top: 0; left: 0; border-right: 1px solid var(--border); z-index: 1000; }
    .main-content { margin-left: 260px; padding: 40px; min-height: 100vh; }
    .nav-link { color: var(--text-muted) !important; padding: 12px 25px; transition: 0.3s; border-left: 4px solid transparent; }
    .nav-link:hover, .nav-link.active { color: white !important; background: rgba(255, 62, 62, 0.1); border-left: 4px solid var(--accent); }

    /* Cards & Tables (Anti Silau) */
    .card, .modal-content { background: var(--bg-card) !important; border: 1px solid var(--border) !important; border-radius: 12px; }
    .table { color: var(--text-main) !important; }
    .table thead th { color: var(--accent) !important; border-bottom: 2px solid var(--border) !important; background: transparent; }
    .table tbody td { border-bottom: 1px solid var(--border) !important; background: transparent; }
    .table-hover tbody tr:hover { background: rgba(255, 255, 255, 0.03) !important; }

    /* Form Inputs */
    .form-control, .form-select { background: #241b45 !important; border: 1px solid var(--border) !important; color: white !important; }
    .form-control::placeholder { color: #555; }
    .form-control:focus { border-color: var(--accent) !important; box-shadow: 0 0 0 0.25rem rgba(255, 62, 62, 0.2); color: white !important; }

    .btn-danger, .btn-primary { background: var(--accent) !important; border: none; font-weight: 600; }
</style>

<div class="sidebar shadow">
    <div class="p-4 text-center border-bottom border-secondary mb-3">
        <h4 class="fw-bold text-white mb-0">GAME<span style="color:var(--accent)">IN</span></h4>
        <small class="text-danger fw-bold" style="letter-spacing: 2px;">ADMIN PANEL</small>
    </div>
    <div class="p-3 text-center mb-3">
        <img src="../assets/images/<?= $adm_h['foto']; ?>" class="rounded-circle border border-danger mb-2" width="60" height="60" style="object-fit:cover;">
        <h6 class="fw-bold small text-white"><?= $adm_h['username']; ?></h6>
    </div>
    <nav class="nav flex-column mt-2">
        <a class="nav-link <?= (basename($_SERVER['PHP_SELF'])=='admin_dashboard.php')?'active':''; ?>" href="admin_dashboard.php"><i class="bi bi-grid-1x2 me-2"></i> Dashboard</a>
        <a class="nav-link <?= (basename($_SERVER['PHP_SELF'])=='games_manage.php')?'active':''; ?>" href="games_manage.php"><i class="bi bi-controller me-2"></i> Games</a>
        <a class="nav-link <?= (basename($_SERVER['PHP_SELF'])=='genres_manage.php')?'active':''; ?>" href="genres_manage.php"><i class="bi bi-tags me-2"></i> Genres</a>
        <a class="nav-link <?= (basename($_SERVER['PHP_SELF'])=='users_manage.php')?'active':''; ?>" href="users_manage.php"><i class="bi bi-people me-2"></i> Users</a>
        <a class="nav-link <?= (basename($_SERVER['PHP_SELF'])=='profile_admin.php')?'active':''; ?>" href="profile_admin.php"><i class="bi bi-person-gear me-2"></i> Settings</a>
        <hr class="mx-3 border-secondary">
        <a class="nav-link text-danger" href="../logout.php"><i class="bi bi-power me-2"></i> Logout</a>
    </nav>
</div>