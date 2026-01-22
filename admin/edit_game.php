<?php
session_start();
include '../config/koneksi.php';
if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') exit;

$id = $_GET['id'];
$g = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM games WHERE id='$id'"));

if (isset($_POST['update'])) {
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $genre = mysqli_real_escape_string($conn, $_POST['genre']);
    $url = mysqli_real_escape_string($conn, $_POST['download_url']);
    $desk = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $req = mysqli_real_escape_string($conn, $_POST['requirements']);
    
    $sql = "UPDATE games SET judul='$judul', genre='$genre', download_url='$url', deskripsi='$desk', requirements='$req' ";
    
    if (!empty($_FILES['gambar']['name'])) {
        $img = "game_" . time() . "." . pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
        move_uploaded_file($_FILES['gambar']['tmp_name'], "../assets/images/" . $img);
        $sql .= ", gambar='$img' ";
    }
    
    $sql .= "WHERE id='$id'";
    mysqli_query($conn, $sql);
    header("Location: games_manage.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Game | Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <?php include 'header_admin.php'; ?>
    <div class="main-content">
        <h4 class="fw-bold mb-4">Edit Game Detail</h4>
        <div class="card border-0 shadow-sm p-4" style="max-width: 800px; border-radius: 15px;">
            <form method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="small fw-bold">Judul</label>
                        <input type="text" name="judul" class="form-control" value="<?= $g['judul']; ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="small fw-bold">Genre</label>
                        <input type="text" name="genre" class="form-control" value="<?= $g['genre']; ?>">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="small fw-bold">URL Download</label>
                    <input type="url" name="download_url" class="form-control" value="<?= $g['download_url']; ?>">
                </div>
                <div class="mb-3">
                    <label class="small fw-bold">Deskripsi</label>
                    <textarea name="deskripsi" class="form-control" rows="4"><?= $g['deskripsi']; ?></textarea>
                </div>
                <div class="mb-3">
                    <label class="small fw-bold">Requirements</label>
                    <textarea name="requirements" class="form-control" rows="3"><?= $g['requirements']; ?></textarea>
                </div>
                <div class="mb-4">
                    <label class="small fw-bold">Ganti Cover (Kosongkan jika tetap)</label>
                    <input type="file" name="gambar" class="form-control">
                </div>
                <button type="submit" name="update" class="btn btn-primary px-5 fw-bold">Simpan Perubahan</button>
                <a href="games_manage.php" class="btn btn-light px-4">Batal</a>
            </form>
        </div>
    </div>
</body>
</html>