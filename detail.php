<?php
session_start();
include 'config/koneksi.php';

// Ambil ID game dari URL
$id = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : '';
$q = mysqli_query($conn, "SELECT * FROM games WHERE id = '$id'");
$g = mysqli_fetch_assoc($q);

// Balikin ke index kalau ID gak valid
if (!$g) { header("Location: index.php"); exit; }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $g['judul']; ?> | GameIn</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --bg-dark: #120b29;
            --card-dark: #1d1536;
            --text-gray: #b5b3bc;
            --accent: #ff3e3e; /* Skema Merah */
        }
        body { background-color: var(--bg-dark); color: white; font-family: 'Segoe UI', sans-serif; }
        
        /* Navbar Styling (Sama dengan Index) */
        .navbar { background-color: var(--bg-dark) !important; padding: 20px 0; border-bottom: 1px solid #2b214a; }
        .nav-link { color: white !important; font-size: 0.95rem; transition: 0.3s; }
        .nav-link:hover, .nav-link i { color: var(--accent) !important; }
        
        .search-bar { background: #fff; border-radius: 20px; padding: 5px 20px; display: flex; align-items: center; width: 280px; }
        .search-bar input { border: none; outline: none; width: 100%; font-size: 0.85rem; color: #333; }

        /* Detail Styling */
        .glass-card { background: var(--card-dark); border: none; border-radius: 15px; }
        .spec-item { background: #2b214a; padding: 15px; border-radius: 8px; border-left: 4px solid var(--accent); }
        .btn-download { background: var(--accent); color: white; border: none; font-weight: bold; transition: 0.3s; }
        .btn-download:hover { background: #d32f2f; transform: scale(1.02); color: white; }
        
        .dropdown-menu { background: var(--card-dark); border: 1px solid #3c325c; }
        .dropdown-item { color: white; }
        .dropdown-item:hover { background: var(--accent); color: white; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="index.php">
            <h3 class="fw-bold mb-0 text-white">GAME<span style="color:var(--accent)">IN</span></h3>
        </a>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item"><a class="nav-link" href="index.php"><i class="bi bi-house-door"></i> Home</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown"><i class="bi bi-grid"></i> Genre</a>
                    <ul class="dropdown-menu shadow">
                        <?php 
                        $qg = mysqli_query($conn, "SELECT * FROM genres ORDER BY nama_genre ASC");
                        while($rg = mysqli_fetch_assoc($qg)) : ?>
                            <li><a class="dropdown-item" href="index.php?genre=<?= urlencode($rg['nama_genre']) ?>"><?= $rg['nama_genre'] ?></a></li>
                        <?php endwhile; ?>
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link" href="#"><i class="bi bi-fire"></i> Popular</a></li>
            </ul>
            
            <div class="d-flex align-items-center gap-3">
                <form action="index.php" method="GET" class="search-bar d-none d-md-flex">
                    <input type="text" name="search" placeholder="Search games...">
                    <button type="submit" style="border:none; background:none;"><i class="bi bi-search"></i></button>
                </form>

                <?php if(isset($_SESSION['login'])): 
                    $id_user = $_SESSION['id_user'];
                    $user_data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id='$id_user'"));
                    $foto_user = (!empty($user_data['foto'])) ? $user_data['foto'] : 'default_user.jpg';
                ?>
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" data-bs-toggle="dropdown">
                            <img src="assets/images/<?= $foto_user ?>" width="35" height="35" class="rounded-circle border border-danger shadow-sm" style="object-fit: cover;">
                            <span class="ms-2 text-white small fw-bold d-none d-lg-inline"><?= $user_data['username'] ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow mt-2">
                            <li><a class="dropdown-item" href="member/profile.php">My Profile</a></li>
                            <?php if($_SESSION['role'] == 'admin'): ?>
                                <li><a class="dropdown-item text-info" href="admin/admin_dashboard.php">Admin Panel</a></li>
                            <?php endif; ?>
                            <li><hr class="dropdown-divider border-secondary"></li>
                            <li><a class="dropdown-item text-danger" href="logout.php">Logout</a></li>
                        </ul>
                    </div>
                <?php else: ?>
                    <a href="auth/login.php" class="btn btn-danger btn-sm px-4 rounded-pill fw-bold" style="background:var(--accent); border:none;">LOGIN</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<div class="container mt-5 mb-5">
    <div class="row g-5">
        <div class="col-md-5 text-center">
            <img src="assets/images/<?= $g['gambar']; ?>" class="w-100 rounded-3 shadow-lg border border-secondary">
        </div>

        <div class="col-md-7">
            <div class="glass-card p-4 shadow">
                <h1 class="fw-bold mb-1"><?= $g['judul']; ?></h1>
                <p style="color: var(--accent);" class="fw-bold mb-4"><?= $g['genre']; ?></p>
                
                <h5 class="fw-bold"><i class="bi bi-card-text me-2"></i>Description</h5>
                <p class="text-light opacity-75" style="text-align: justify; line-height: 1.6;">
                    <?= nl2br($g['deskripsi']); ?>
                </p>

                <h5 class="fw-bold mt-5 mb-3"><i class="bi bi-cpu me-2"></i>System Requirements</h5>
                <div class="spec-item">
                    <small class="text-muted d-block mb-1">Minimum Specs:</small>
                    <span class="small"><?= $g['requirements']; ?></span>
                </div>

                <div class="mt-5">
                    <?php if(isset($_SESSION['login'])): ?>
                        <a href="<?= $g['download_url']; ?>" target="_blank" class="btn btn-download btn-lg w-100 py-3 shadow">
                            <i class="bi bi-download me-2"></i> DOWNLOAD GAME
                        </a>
                    <?php else: ?>
                        <div class="bg-dark p-4 rounded text-center border border-danger">
                            <p class="mb-3 small">Kamu harus login dulu bos buat sikat link download-nya.</p>
                            <a href="auth/login.php" class="btn btn-danger w-100 fw-bold rounded-pill" style="background:var(--accent); border:none;">LOGIN TO DOWNLOAD</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<footer class="mt-5 py-5 border-top border-secondary text-center text-muted">
    <p>&copy; 2026 GameIn. All rights reserved.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>