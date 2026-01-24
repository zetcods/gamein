<?php
session_start();
include 'header.php'; 

$id = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : '';

// Query Crosscheck: Mastika JOIN id_admin (varchar) ke id users (varchar)
$q = mysqli_query($conn, "SELECT games.*, users.username as nama_admin 
                          FROM games 
                          LEFT JOIN users ON games.id_admin = users.id 
                          WHERE games.id = '$id'");
$g = mysqli_fetch_assoc($q);

if (!$g) { echo "<script>window.location='index.php';</script>"; exit; }
?>

<div class="container py-5">
    <div class="row g-4 g-lg-5">
        <div class="col-lg-5">
            <div class="sticky-top" style="top: 100px; z-index: 5;">
                <img src="assets/images/<?= $g['gambar']; ?>" class="img-fluid rounded-4 shadow-lg border border-secondary">
                <div class="mt-3 d-flex gap-2">
                    <span class="badge bg-danger px-3 py-2"><?= strtoupper($g['genre']); ?></span>
                    <span class="badge bg-dark border border-secondary px-3 py-2 text-white">#<?= $g['id']; ?></span>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-2">
                    <li class="breadcrumb-item"><a href="index.php" class="text-danger text-decoration-none small fw-bold">Home</a></li>
                    <li class="breadcrumb-item active text-white opacity-50 small"><?= $g['judul']; ?></li>
                </ol>
            </nav>

            <h2 class="fw-bold mb-3 text-white" style="letter-spacing: -1px;"><?= strtoupper($g['judul']); ?></h2>
            
            <div class="d-flex flex-wrap gap-4 mb-4 border-bottom border-dark pb-3">
                <div class="d-flex align-items-center">
                    <i class="bi bi-person-fill text-danger fs-5 me-2"></i>
                    <div>
                        <small class="d-block text-muted" style="font-size: 9px; letter-spacing: 1px;">PUBLISHED BY</small>
                        <span class="text-white fw-bold"><?= $g['nama_admin'] ? $g['nama_admin'] : 'Unknown Admin'; ?></span>
                    </div>
                </div>
                <div class="d-flex align-items-center">
                    <i class="bi bi-calendar-check text-danger fs-5 me-2"></i>
                    <div>
                        <small class="d-block text-muted" style="font-size: 9px; letter-spacing: 1px;">POSTED ON</small>
                        <span class="text-white fw-bold"><?= date('d M Y', strtotime($g['created_at'])); ?></span>
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <h6 class="fw-bold text-danger mb-2 small">ABOUT THIS GAME</h6>
                <p class="text-white lh-base" style="font-size: 0.95rem; opacity: 1 !important;">
                    <?= nl2br($g['deskripsi']); ?>
                </p>
            </div>

            <div class="mb-5">
                <h6 class="fw-bold text-danger mb-2 small">SYSTEM REQUIREMENTS</h6>
                <div class="p-3 rounded-3 border border-secondary" style="background: rgba(255,255,255,0.05);">
                    <div class="text-light small" style="opacity: 0.85;">
                        <?= nl2br($g['requirements']); ?>
                    </div>
                </div>
            </div>

            <div class="p-4 rounded-4 border border-danger" style="background: #16102b;">
                <?php if(isset($_SESSION['login'])): ?>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-white">
                            <h6 class="mb-0 fw-bold">Full Version</h6>
                            <small class="text-muted">Link Download</small>
                        </div>
                        <a href="<?= $g['download_url']; ?>" target="_blank" class="btn btn-danger px-5 fw-bold py-2">
                            <i class="bi bi-download me-2"></i>DOWNLOAD
                        </a>
                    </div>
                <?php else: ?>
                    <div class="text-center py-2">
                        <p class="text-white small mb-3">Please login to access the download link</p>
                        <a href="auth/login.php" class="btn btn-outline-danger w-100 fw-bold">LOGIN TO UNLOCK</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
    /* Paksa warna text-muted biar gak mati di background navy */
    .text-muted { color: #b5b3bc !important; }
    .breadcrumb-item + .breadcrumb-item::before { color: #555 !important; }
</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>