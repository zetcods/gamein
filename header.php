<?php
// Cek apakah file ini dipanggil dari folder admin atau root
$path_prefix = file_exists('config/koneksi.php') ? '' : '../';
include_once $path_prefix . 'config/koneksi.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GameIn | Free Games</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root { 
            --bg-dark: #0f0a21; --bg-card: #1d1536; --accent: #ff3e3e; 
            --text-main: #ffffff; --text-muted: #b5b3bc; --border-ui: #2b214a;
        }
        body { background-color: var(--bg-dark); color: var(--text-main); font-family: 'Segoe UI', sans-serif; overflow-x: hidden; }
        
        /* Navbar Styling */
        .navbar { background: rgba(15, 10, 33, 0.98) !important; border-bottom: 1px solid var(--border-ui); backdrop-filter: blur(10px); padding: 12px 0; }
        .nav-link { color: var(--text-muted) !important; font-weight: 600; font-size: 13px; text-transform: uppercase; }
        .nav-link:hover, .nav-link.active { color: var(--accent) !important; }
        .brand-logo { font-weight: 800; font-size: 1.5rem; color: white !important; letter-spacing: -1px; }
        .brand-logo span { color: var(--accent); }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
        <a class="navbar-brand brand-logo" href="<?= $path_prefix; ?>index.php">GAME<span>IN</span></a>
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="bi bi-list text-white fs-2"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item"><a class="nav-link px-3" href="<?= $path_prefix; ?>index.php">HOME</a></li>
                
                <?php if(isset($_SESSION['login'])): ?>
                    <?php if($_SESSION['role'] == 'admin'): ?>
                        <li class="nav-item"><a class="nav-link px-3 text-info" href="<?= $path_prefix; ?>admin/games_manage.php">DASHBOARD</a></li>
                    <?php endif; ?>
                    <li class="nav-item"><a class="nav-link px-3" href="<?= $path_prefix; ?>profile.php">PROFILE</a></li>
                    <li class="nav-item ms-lg-3">
                        <a href="<?= $path_prefix; ?>logout.php" class="btn btn-outline-danger btn-sm px-4 fw-bold rounded-pill">LOGOUT</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link px-3" href="<?= $path_prefix; ?>auth/login.php">LOGIN</a></li>
                    <li class="nav-item ms-lg-2">
                        <a href="<?= $path_prefix; ?>auth/register.php" class="btn btn-danger btn-sm px-4 fw-bold rounded-pill">JOIN</a>
                    </li>
                <?php ?>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>