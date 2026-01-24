<?php
session_start(); 
include '../config/koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

// Logic Hapus
if (isset($_GET['hapus'])) {
    $id_hapus = mysqli_real_escape_string($conn, $_GET['hapus']);
    $cari_gambar = mysqli_query($conn, "SELECT gambar FROM games WHERE id='$id_hapus'");
    $data = mysqli_fetch_assoc($cari_gambar);
    if ($data) {
        $path = "../assets/images/" . $data['gambar'];
        if (file_exists($path)) { unlink($path); }
    }
    mysqli_query($conn, "DELETE FROM games WHERE id='$id_hapus'");
    header("Location: games_manage.php?status=deleted");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Games | GameIn</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root { 
            --bg-dark: #0f0a21; 
            --bg-card: #1d1536; 
            --accent: #ff3e3e; 
            --border-ui: #2b214a;
            --text-main: #ffffff;
            --text-dim: #b5b3bc;
            --cyan-glow: #0dcaf0;
        }
        
        body { background: var(--bg-dark); color: var(--text-main); font-family: 'Segoe UI', sans-serif; }
        .main-content { padding: 30px; }

        .card-custom { background: var(--bg-card); border: 1px solid var(--border-ui); border-radius: 12px; }
        .table { color: var(--text-main); border-color: var(--border-ui); }
        .table th { color: var(--text-dim); font-size: 11px; text-transform: uppercase; letter-spacing: 1px; border-bottom: 2px solid var(--border-ui); padding: 15px; }
        .table td { border-bottom: 1px solid var(--border-ui); padding: 15px; vertical-align: middle; }
        
        /* Icon Matching Colors */
        .btn-action { 
            background: rgba(255, 255, 255, 0.03); 
            border: 1px solid var(--border-ui); 
            border-radius: 8px; width: 35px; height: 35px; 
            display: inline-flex; align-items: center; justify-content: center;
            transition: 0.3s; text-decoration: none;
        }
        .btn-edit i { color: var(--cyan-glow); }
        .btn-edit:hover { background: var(--cyan-glow); }
        .btn-edit:hover i { color: #fff; }

        .btn-delete i { color: var(--accent); }
        .btn-delete:hover { background: var(--accent); }
        .btn-delete:hover i { color: #fff; }

        .game-img { width: 50px; height: 50px; object-fit: cover; border-radius: 6px; border: 1px solid var(--border-ui); }
        .badge-genre { background: rgba(255, 62, 62, 0.1); color: var(--accent); border: 1px solid rgba(255, 62, 62, 0.2); }

        /* Form Styling */
        .modal-content { background: var(--bg-card); border: 1px solid var(--border-ui); color: var(--text-main); }
        .form-control, .form-select { background: #16102b; border: 1px solid var(--border-ui); color: white; }
        .form-control:focus, .form-select:focus { background: #241b45; border-color: var(--accent); color: white; box-shadow: none; }
        .form-label { color: var(--text-dim); font-size: 13px; font-weight: 600; }
        option { background: var(--bg-card); color: white; }
    </style>
</head>
<body>

    <?php include 'header_admin.php'; ?>

    <div class="main-content">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold m-0"><i class="bi bi-controller me-2" style="color:var(--accent)"></i>GAME MANAGEMENT</h4>
                <button class="btn btn-danger btn-sm px-4 fw-bold shadow" data-bs-toggle="modal" data-bs-target="#addModal">
                    <i class="bi bi-plus-circle me-2"></i>NEW POST
                </button>
            </div>

            <div class="card-custom shadow-lg">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4">Game Detail</th>
                            <th>Genre</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $q = mysqli_query($conn, "SELECT * FROM games ORDER BY id DESC");
                        while($r = mysqli_fetch_assoc($q)): 
                        ?>
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <img src="../assets/images/<?= $r['gambar'] ?>" class="game-img me-3 shadow-sm">
                                    <div>
                                        <div class="fw-bold"><?= $r['judul'] ?></div>
                                        <div style="color:var(--text-dim); font-size: 11px;"><i class="bi bi-hash"></i>ID: <?= $r['id'] ?></div>
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge badge-genre"><?= strtoupper($r['genre']) ?></span></td>
                            <td class="text-center">
                                <a href="edit_game.php?id=<?= $r['id'] ?>" class="btn-action btn-edit"><i class="bi bi-pencil-fill"></i></a>
                                <a href="games_manage.php?hapus=<?= $r['id'] ?>" class="btn-action btn-delete ms-2" onclick="return confirm('Hapus game ini?')"><i class="bi bi-trash3-fill"></i></a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content shadow-lg">
                <div class="modal-header border-bottom border-dark">
                    <h5 class="modal-title fw-bold"><i class="bi bi-cloud-arrow-up-fill me-2 text-danger"></i>Post New Game</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="proses_tambah_game.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-body p-4">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Judul Game</label>
                                <input type="text" name="judul" class="form-control" placeholder="Nama game" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Genre</label>
                                <select name="genre" class="form-select" required>
                                    <option value="" selected disabled>Pilih Genre...</option>
                                    <?php 
                                    $genres = mysqli_query($conn, "SELECT * FROM genres ORDER BY nama_genre ASC");
                                    while($g = mysqli_fetch_assoc($genres)): ?>
                                        <option value="<?= $g['nama_genre']; ?>"><?= $g['nama_genre']; ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Download URL</label>
                            <input type="url" name="download_url" class="form-control" placeholder="https://link-download.com" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" rows="3" placeholder="Cerita singkat game..."></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">System Requirements</label>
                            <textarea name="requirements" class="form-control" rows="2" placeholder="OS, RAM, GPU..."></textarea>
                        </div>
                        <div class="mb-0">
                            <label class="form-label">Cover Image</label>
                            <input type="file" name="gambar" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer border-top border-dark">
                        <button type="submit" class="btn btn-danger px-5 fw-bold">PUBLISH GAME</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>