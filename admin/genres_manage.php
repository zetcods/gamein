<?php
session_start();
include '../config/koneksi.php';
if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') exit;

if (isset($_POST['add_genre'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama_genre']);
    mysqli_query($conn, "INSERT INTO genres (nama_genre) VALUES ('$nama')");
}
if (isset($_GET['del'])) {
    $id = $_GET['del'];
    mysqli_query($conn, "DELETE FROM genres WHERE id='$id'");
    header("Location: genres_manage.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Genre | GameIn</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'header_admin.php'; ?>
    <div class="main-content">
        <h4 class="fw-bold mb-4">Genre Management</h4>
        <div class="row">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm p-4"><form method="POST">
                    <label class="small fw-bold mb-2">Nama Genre Baru</label>
                    <input type="text" name="nama_genre" class="form-control mb-3" required>
                    <button type="submit" name="add_genre" class="btn btn-primary w-100 fw-bold">Simpan Genre</button>
                </form></div>
            </div>
            <div class="col-md-8">
                <div class="card border-0 shadow-sm overflow-hidden"><table class="table table-hover align-middle mb-0">
                    <thead class="bg-light"><tr><th>Nama Genre</th><th class="text-end">Aksi</th></tr></thead>
                    <tbody>
                        <?php $qg = mysqli_query($conn, "SELECT * FROM genres ORDER BY nama_genre ASC");
                        while($g = mysqli_fetch_assoc($qg)): ?>
                        <tr><td class="fw-bold"><?= $g['nama_genre']; ?></td>
                        <td class="text-end pe-3"><a href="?del=<?= $g['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus?')"><i class="bi bi-trash"></i></a></td></tr>
                        <?php endwhile; ?>
                    </tbody>
                </table></div>
            </div>
        </div>
    </div>
</body>
</html>