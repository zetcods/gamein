<?php
session_start();
include 'config/koneksi.php';

// Logic Filter & Search
$genre_filter = isset($_GET['genre']) ? mysqli_real_escape_string($conn, $_GET['genre']) : '';
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

$query_str = "SELECT * FROM games WHERE 1=1";
if ($genre_filter) $query_str .= " AND genre='$genre_filter'";
if ($search) $query_str .= " AND judul LIKE '%$search%'";
$query_str .= " ORDER BY id DESC";

$query_game = mysqli_query($conn, $query_str);

// Ambil 1 game terbaru buat Hero besar
$hero_main = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM games ORDER BY id DESC LIMIT 1"));
// Ambil 2 game setelahnya buat Hero kecil di samping
$hero_side = mysqli_query($conn, "SELECT * FROM games ORDER BY id DESC LIMIT 1, 2");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>GameIn - Download Indie Games</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root {
            --bg-dark: #120b29;
            --card-dark: #1d1536;
            --text-gray: #b5b3bc;
            --accent: #ff3e3e;
        }
        body { background-color: var(--bg-dark); color: white; font-family: 'Segoe UI', sans-serif; }
        
        .navbar { background-color: var(--bg-dark) !important; padding: 20px 0; border-bottom: 1px solid #2b214a; }
        .nav-link { color: white !important; font-size: 0.95rem; }
        .nav-link:hover, .nav-link i { color: var(--accent) !important; }
        .search-bar { background: #fff; border-radius: 20px; padding: 5px 20px; display: flex; align-items: center; width: 280px; }
        .search-bar input { border: none; outline: none; width: 100%; font-size: 0.85rem; color: #333; }

        .game-card { background: var(--card-dark); border: none; border-radius: 8px; transition: 0.3s; height: 100%; overflow: hidden; }
        .game-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(255, 62, 62, 0.1); }
        .game-card img { height: 260px; object-fit: cover; width: 100%; border-bottom: 3px solid var(--accent); }
        
        .card-info { padding: 15px; }
        .game-title { font-size: 0.9rem; font-weight: 600; color: white; text-decoration: none; display: block; height: 40px; overflow: hidden; }
        .game-version { color: var(--accent); font-size: 0.75rem; font-weight: bold; margin-top: 8px; display: block; }
        
        .section-title { background: #1d1536; padding: 12px 20px; border-radius: 5px; font-weight: bold; margin-bottom: 25px; border-left: 4px solid var(--accent); }
        
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
                    <input type="text" name="search" placeholder="Search games..." value="<?= $search ?>">
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

<div class="container mt-4">
    <div class="row g-3 mb-5">
        <?php if($hero_main): ?>
        <div class="col-md-7">
            <a href="detail.php?id=<?= $hero_main['id'] ?>" class="text-decoration-none">
                <div class="position-relative h-100 rounded overflow-hidden shadow">
                    <img src="assets/images/<?= $hero_main['gambar'] ?>" class="w-100 h-100" style="object-fit:cover; min-height:350px;">
                    <div class="position-absolute bottom-0 start-0 w-100 p-4" style="background: linear-gradient(transparent, rgba(0,0,0,0.9));">
                        <h4 class="fw-bold text-white"><?= $hero_main['judul'] ?></h4>
                    </div>
                </div>
            </a>
        </div>
        <?php endif; ?>

        <div class="col-md-5">
            <div class="row g-3">
                <?php while($side = mysqli_fetch_assoc($hero_side)): ?>
                <div class="col-6">
                    <div class="game-card">
                        <img src="assets/images/<?= $side['gambar'] ?>" style="height: 150px;">
                        <div class="card-info text-center">
                            <a href="detail.php?id=<?= $side['id'] ?>" class="game-title"><?= $side['judul'] ?></a>
                            <span class="game-version">Featured</span>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>

    <div class="section-title">LATEST GAMES</div>

    <div class="row row-cols-2 row-cols-md-5 g-3">
        <?php while($row = mysqli_fetch_assoc($query_game)): ?>
        <div class="col">
            <div class="game-card shadow-sm text-center">
                <img src="assets/images/<?= $row['gambar']; ?>">
                <div class="card-info">
                    <a href="detail.php?id=<?= $row['id']; ?>" class="game-title">
                        <?= $row['judul']; ?>
                    </a>
                    <span class="game-version">Updated</span>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</div>

<footer class="mt-5 py-5 border-top border-secondary text-center text-muted">
    <p>&copy; 2026 GameIn. All rights reserved.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>