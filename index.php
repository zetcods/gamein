<?php
session_start();
include 'config/koneksi.php';

// Logic Filter & Search
$genre_filter = isset($_GET['genre']) ? mysqli_real_escape_string($conn, $_GET['genre']) : '';
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$is_update = isset($_GET['update']);

$query_str = "SELECT * FROM games WHERE 1=1";
if ($genre_filter) $query_str .= " AND genre='$genre_filter'";
if ($search) $query_str .= " AND judul LIKE '%$search%'";
$query_str .= " ORDER BY id DESC";

$query_game = mysqli_query($conn, $query_str);
$query_hero = mysqli_query($conn, "SELECT * FROM games ORDER BY id DESC LIMIT 5");
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
        body { background-color: var(--bg-dark); color: var(--text-main); font-family: 'Segoe UI', Roboto, sans-serif; overflow-x: hidden; }
        .navbar { background: rgba(15, 10, 33, 0.98) !important; border-bottom: 1px solid var(--border-ui); backdrop-filter: blur(10px); padding: 12px 0; }
        .nav-link { color: var(--text-muted) !important; font-weight: 600; font-size: 13px; letter-spacing: 0.8px; text-transform: uppercase; }
        .nav-link:hover, .nav-link.active { color: var(--accent) !important; }
        .nav-discord { color: #5865F2 !important; font-weight: 800 !important; }
        
        /* Dropdown Style */
        .dropdown-menu { background: #16102b; border: 1px solid var(--border-ui); border-radius: 8px; padding: 10px; box-shadow: 0 10px 30px rgba(0,0,0,0.5); }
        .dropdown-item { color: var(--text-muted); font-size: 12px; font-weight: 600; letter-spacing: 1px; text-transform: uppercase; padding: 8px 15px; border-radius: 4px; transition: 0.2s; }
        .dropdown-item:hover { background: var(--accent); color: white; transform: translateX(5px); }
        .dropdown-divider { border-color: var(--border-ui); }

        .showcase-scroll { display: flex; overflow-x: auto; gap: 20px; padding: 10px 0 30px 0; scrollbar-width: none; }
        .showcase-scroll::-webkit-scrollbar { display: none; }
        .showcase-item { min-width: 350px; height: 450px; border-radius: 12px; position: relative; overflow: hidden; border: 1px solid var(--border-ui); transition: 0.4s; }
        .showcase-item img { width: 100%; height: 100%; object-fit: cover; filter: brightness(0.6); }
        .showcase-info { position: absolute; bottom: 0; left: 0; right: 0; padding: 30px; background: linear-gradient(transparent, rgba(15, 10, 33, 1)); }
        
        .game-card { background: var(--bg-card); border-radius: 10px; border: 1px solid var(--border-ui); transition: 0.3s; height: 100%; overflow: hidden; }
        .game-card:hover { border-color: var(--accent); transform: translateY(-5px); }
        .search-bar { background: rgba(255,255,255,0.05); border: 1px solid var(--border-ui); color: white !important; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold text-white" href="index.php">GAME<span style="color:var(--accent)">IN</span></a>
        
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navContent">
            <span class="bi bi-list text-white fs-2"></span>
        </button>

        <div class="collapse navbar-collapse" id="navContent">
            <ul class="navbar-nav me-auto ms-4 gap-2">
                <li class="nav-item"><a class="nav-link <?= (!$genre_filter && !$is_update) ? 'active' : '' ?>" href="index.php">HOME</a></li>
                
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="genreDropdown" data-bs-toggle="dropdown">GENRES</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="index.php">All Genres</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <?php 
                        $gen_data = mysqli_query($conn, "SELECT * FROM genres ORDER BY nama_genre ASC");
                        while($g = mysqli_fetch_assoc($gen_data)) : 
                            $act = ($genre_filter == $g['nama_genre']) ? 'style="color: var(--accent);"' : '';
                        ?>
                            <li><a class="dropdown-item" <?= $act ?> href="index.php?genre=<?= $g['nama_genre'] ?>"><?= $g['nama_genre'] ?></a></li>
                        <?php endwhile; ?>
                    </ul>
                </li>

                <li class="nav-item"><a class="nav-link <?= $is_update ? 'active' : '' ?>" href="index.php?update=true">RECENTLY UPDATED</a></li>
                <li class="nav-item"><a class="nav-link nav-discord" href="https://discord.gg/link-kamu" target="_blank"><i class="bi bi-discord me-1"></i> DISCORD</a></li>
            </ul>

            <form class="d-flex me-3" action="index.php" method="GET">
                <div class="input-group">
                    <input class="form-control search-bar px-3" type="search" name="search" placeholder="Search..." value="<?= htmlspecialchars($search) ?>">
                    <button class="btn btn-danger" type="submit"><i class="bi bi-search"></i></button>
                </div>
            </form>

            <?php if(isset($_SESSION['login'])): ?>
                <div class="dropdown">
                    <button class="btn btn-sm btn-outline-light dropdown-toggle px-3 fw-bold" data-bs-toggle="dropdown" style="font-size: 11px; letter-spacing: 1px;">
                        <i class="bi bi-person-circle me-1"></i> <?= strtoupper($_SESSION['username']); ?>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="profile.php">PROFILE</a></li>
                        <?php if($_SESSION['role'] == 'admin'): ?>
                            <li><a class="dropdown-item text-warning" href="admin/games_manage.php">ADMIN PANEL</a></li>
                        <?php endif; ?>
                        <li><hr class="dropdown-divider border-secondary"></li>
                        <li><a class="dropdown-item text-danger" href="logout.php">LOGOUT</a></li>
                    </ul>
                </div>
            <?php else: ?>
                <div class="d-flex gap-2">
                    <a href="auth/login.php" class="btn btn-sm btn-danger px-4 fw-bold shadow-sm" style="font-size: 11px; letter-spacing: 1px;">LOGIN</a>
                    <a href="auth/register.php" class="btn btn-sm btn-outline-light px-4 fw-bold shadow-sm" style="font-size: 11px; letter-spacing: 1px;">REGISTER</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <?php if(!$genre_filter && !$search && !$is_update): ?>
    <div class="mb-5">
        <h6 class="text-uppercase fw-bold mb-3" style="letter-spacing: 2px; color: var(--accent); font-size: 12px;">Featured Picks</h6>
        <div class="showcase-scroll">
            <?php while($h = mysqli_fetch_assoc($query_hero)): ?>
            <div class="showcase-item">
                <img src="assets/images/<?= $h['gambar']; ?>">
                <div class="showcase-info">
                    <span class="badge bg-danger mb-2 text-uppercase"><?= $h['genre']; ?></span>
                    <h3 class="fw-bold text-white mb-2"><?= strtoupper($h['judul']); ?></h3>
                    <a href="detail.php?id=<?= $h['id']; ?>" class="btn btn-sm btn-light fw-bold px-4 rounded-pill">DETAILS</a>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
    <?php endif; ?>

    <h6 class="text-uppercase fw-bold mb-4" style="letter-spacing: 2px; font-size: 13px;">
        <i class="bi bi-grid-fill text-danger me-2"></i>
        <?= $genre_filter ? "Genre: $genre_filter" : ($is_update ? "Recently Updated" : "Library") ?>
    </h6>

    <div class="row row-cols-2 row-cols-md-4 row-cols-lg-5 g-4">
        <?php if(mysqli_num_rows($query_game) > 0): ?>
            <?php while($row = mysqli_fetch_assoc($query_game)): ?>
            <div class="col">
                <div class="game-card shadow-sm">
                    <img src="assets/images/<?= $row['gambar']; ?>" class="w-100">
                    <div class="p-3">
                        <small class="text-danger fw-bold d-block mb-1 text-uppercase" style="font-size: 9px;"><?= $row['genre']; ?></small>
                        <a href="detail.php?id=<?= $row['id']; ?>" class="text-white fw-bold text-decoration-none text-truncate d-block" style="font-size: 14px;"><?= $row['judul']; ?></a>
                        <div class="mt-3 d-flex justify-content-between align-items-center">
                            <span class="text-muted fw-bold" style="font-size: 10px;">FREE</span>
                            <a href="detail.php?id=<?= $row['id']; ?>" class="text-danger"><i class="bi bi-arrow-right-circle fs-5"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <div class="py-5" style="background: var(--bg-card); border: 2px dashed var(--border-ui); border-radius: 15px;">
                    <i class="bi bi-controller fs-1 text-muted mb-3 d-block"></i>
                    <h5 class="fw-bold text-white">Oops! No Games Found</h5>
                    <p class="text-muted small">Belum ada game untuk genre <span class="text-danger fw-bold"><?= $genre_filter ?></span> ini bro.</p>
                    <a href="index.php" class="btn btn-sm btn-outline-danger px-4 mt-2">Back to Home</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<footer class="mt-5 py-4 text-center border-top border-dark">
    <p class="text-white fw-bold mb-0" style="font-size: 10px; letter-spacing: 2px;">GAMEIN &copy; <?= date('Y') ?></p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>