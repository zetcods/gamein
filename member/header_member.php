<?php
// Logic ambil data user
$id_sess = $_SESSION['id_user'];
$user_h = mysqli_query($conn, "SELECT username, foto FROM users WHERE id='$id_sess'");
$row_h = mysqli_fetch_assoc($user_h);
$foto_db = $row_h['foto'];
$inisial = strtoupper(substr($row_h['username'], 0, 1));
?>

<style>
    body { background-color: #f0f2f5; font-family: 'Segoe UI', sans-serif; margin: 0; }
    .sidebar { 
        height: 100vh; width: 260px; background: #fff; 
        position: fixed; top: 0; left: 0; border-right: 1px solid #ddd; z-index: 1000; 
    }
    .main-content { margin-left: 260px; padding: 40px; min-height: 100vh; }
    .user-section { padding: 30px 20px; text-align: center; border-bottom: 1px solid #eee; }
    
    /* Avatar Logic */
    .avatar-box {
        width: 80px; height: 80px; margin: 0 auto 10px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        overflow: hidden; border: 3px solid #0d6efd; background: #0d6efd; color: #fff;
    }
    .avatar-box img { width: 100%; height: 100%; object-fit: cover; }
    .avatar-box span { font-size: 32px; font-weight: bold; }

    .nav-link { color: #555; padding: 12px 20px; border-left: 4px solid transparent; text-decoration: none; display: block; }
    .nav-link:hover { background: #f8f9fa; color: #0d6efd; border-left: 4px solid #0d6efd; }
    .nav-link.active { background: #e7f1ff; color: #0d6efd; border-left: 4px solid #0d6efd; font-weight: 600; }
    .label-side { font-size: 10px; font-weight: bold; color: #999; margin: 20px; display: block; }
</style>

<div class="sidebar shadow-sm">
    <div class="user-section">
        <div class="avatar-box shadow-sm">
            <?php if (empty($foto_db) || $foto_db == 'default_user.jpg'): ?>
                <span><?= $inisial; ?></span>
            <?php else: ?>
                <img src="../assets/images/<?= $foto_db; ?>">
            <?php endif; ?>
        </div>
        <div class="fw-bold text-dark"><?= $_SESSION['username']; ?></div>
        <small class="text-muted">ID: <?= $_SESSION['id_user']; ?></small>
    </div>
    
    <nav class="mt-2">
        <span class="label-side text-uppercase">Menu Utama</span>
        <?php $page = basename($_SERVER['PHP_SELF']); ?>
        <a class="nav-link <?= ($page == 'dashboard.php') ? 'active' : ''; ?>" href="dashboard.php">
            <i class="bi bi-grid-1x2-fill me-2"></i> Dashboard
        </a>
        <a class="nav-link" href="../index.php">
            <i class="bi bi-controller me-2"></i> Katalog Game
        </a>

        <span class="label-side text-uppercase">Personal</span>
        <a class="nav-link <?= ($page == 'profile.php') ? 'active' : ''; ?>" href="profile.php">
            <i class="bi bi-person-bounding-box me-2"></i> Profil Saya
        </a>
        
        <div style="margin-top: 50px; border-top: 1px solid #eee;">
            <a class="nav-link text-danger" href="../logout.php"><i class="bi bi-power me-2"></i> Logout</a>
        </div>
    </nav>
</div>