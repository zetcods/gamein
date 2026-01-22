<?php
session_start();
include '../config/koneksi.php';
if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') { header("Location: ../auth/login.php"); exit; }

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM games WHERE id='$id'");
    header("Location: games_manage.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Games | GameIn Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body>
<?php include 'header_admin.php'; ?>
<div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">Games Library</h4>
        <button class="btn btn-primary fw-bold" data-bs-toggle="modal" data-bs-target="#addModal"><i class="bi bi-plus-lg me-2"></i>Tambah Game</button>
    </div>
    <div class="card border-0 shadow-sm overflow-hidden" style="border-radius:15px;">
        <table class="table table-hover align-middle mb-0">
            <thead class="bg-light text-center">
                <tr>
                    <th>Cover</th>
                    <th>Detail Game</th>
                    <th>Genre</th>
                    <th>Download URL</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $q = mysqli_query($conn, "SELECT * FROM games ORDER BY id DESC");
                while($g = mysqli_fetch_assoc($q)):
                ?>
                <tr class="text-center">
                    <td><img src="../assets/images/<?= $g['gambar']; ?>" width="60" class="rounded shadow-sm"></td>
                    <td class="text-start"><strong><?= $g['judul']; ?></strong></td>
                    <td><span class="badge bg-info"><?= $g['genre']; ?></span></td>
                    <td><small class="text-muted"><?= substr($g['download_url'], 0, 20); ?>...</small></td>
                    <td>
                        <a href="edit_game.php?id=<?= $g['id']; ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                        <a href="?hapus=<?= $g['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus game ini?')"><i class="bi bi-trash"></i></a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="addModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form action="proses_tambah_game.php" method="POST" enctype="multipart/form-data" class="modal-content border-0 shadow">
      <div class="modal-header"><h5 class="fw-bold">Input Data Game Baru</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
      <div class="modal-body p-4">
        <div class="row">
            <div class="col-md-6 mb-3"><label class="small fw-bold">Judul Game</label><input type="text" name="judul" class="form-control" required></div>
            <div class="col-md-6 mb-3">
                <label class="small fw-bold">Genre</label>
                <select name="genre" class="form-select" required>
                    <?php $qg = mysqli_query($conn, "SELECT * FROM genres ORDER BY nama_genre ASC");
                    while($rg = mysqli_fetch_assoc($qg)) echo "<option value='".$rg['nama_genre']."'>".$rg['nama_genre']."</option>"; ?>
                </select>
            </div>
        </div>
        <div class="mb-3"><label class="small fw-bold">Download URL</label><input type="url" name="download_url" class="form-control" placeholder="Link Mediafire/Drive" required></div>
        <div class="mb-3"><label class="small fw-bold">Deskripsi Game</label><textarea name="deskripsi" class="form-control" rows="3" required></textarea></div>
        <div class="mb-3"><label class="small fw-bold">System Requirements</label><textarea name="requirements" class="form-control" rows="2" placeholder="OS: Win 10, RAM: 8GB..." required></textarea></div>
        <div class="mb-0"><label class="small fw-bold">Cover Gambar</label><input type="file" name="gambar" class="form-control" required></div>
      </div>
      <div class="modal-footer border-0"><button type="submit" class="btn btn-primary w-100 fw-bold">Upload Game Ke Katalog</button></div>
    </form>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>