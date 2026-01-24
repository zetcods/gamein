<?php
session_start();
include '../config/koneksi.php';

// Proteksi Admin
if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') { 
    header("Location: ../auth/login.php"); 
    exit; 
}

// Logic Tambah Genre
if (isset($_POST['add_genre'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama_genre']);
    mysqli_query($conn, "INSERT INTO genres (nama_genre) VALUES ('$nama')");
    header("Location: genres_manage.php");
}

// Logic Hapus Genre
if (isset($_GET['del'])) {
    $id = $_GET['del'];
    mysqli_query($conn, "DELETE FROM genres WHERE id='$id'");
    header("Location: genres_manage.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Genres | GameIn</title>
</head>
<body>

<?php include 'header_admin.php'; ?>

<div class="main-content">
    <div class="mb-4">
        <h3 class="fw-bold text-white">Genre <span style="color:var(--accent)">Management</span></h3>
        <p class="text-muted small">Tambah atau hapus kategori genre game di sini.</p>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card p-4 border-0 shadow-lg">
                <h6 class="fw-bold text-white mb-3">Add New Genre</h6>
                <form method="POST">
                    <div class="mb-3">
                        <label class="text-muted small fw-bold mb-2">GENRE NAME</label>
                        <input type="text" name="nama_genre" class="form-control" placeholder="e.g. Action, RPG..." required>
                    </div>
                    <button type="submit" name="add_genre" class="btn btn-danger w-100 fw-bold py-2">
                        <i class="bi bi-plus-circle me-2"></i>SAVE GENRE
                    </button>
                </form>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card border-0 shadow-lg overflow-hidden">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th class="ps-4 py-3" style="width: 80%;">Genre Name</th>
                                <th class="text-center py-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $qg = mysqli_query($conn, "SELECT * FROM genres ORDER BY nama_genre ASC");
                            if (mysqli_num_rows($qg) > 0):
                                while($g = mysqli_fetch_assoc($qg)): 
                            ?>
                            <tr>
                                <td class="ps-4">
                                    <span class="fw-bold text-white"><?= $g['nama_genre']; ?></span>
                                </td>
                                <td class="text-center">
                                    <a href="?del=<?= $g['id']; ?>" class="btn btn-sm btn-outline-danger border-0" 
                                       onclick="return confirm('Hapus genre ini?')">
                                        <i class="bi bi-trash3-fill"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php 
                                endwhile; 
                            else:
                            ?>
                            <tr>
                                <td colspan="2" class="text-center py-4 text-muted small">Belum ada genre yang terdaftar.</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>