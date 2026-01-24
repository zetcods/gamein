<?php
session_start(); include '../config/koneksi.php';
if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') exit;

$id_adm = $_SESSION['id_user'];
$adm = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id='$id_adm'"));

if (isset($_POST['save_profile'])) {
    $user = mysqli_real_escape_string($conn, $_POST['username']);
    $sql = "UPDATE users SET username='$user' ";
    if (!empty($_FILES['foto']['name'])) {
        $foto = time() . "_" . $_FILES['foto']['name'];
        move_uploaded_file($_FILES['foto']['tmp_name'], "../assets/images/" . $foto);
        $sql .= ", foto='$foto' ";
    }
    if (!empty($_POST['pass'])) {
        $p = password_hash($_POST['pass'], PASSWORD_DEFAULT);
        $sql .= ", password='$p' ";
    }
    $sql .= "WHERE id='$id_adm'";
    if (mysqli_query($conn, $sql)) { header("Location: profile_admin.php"); }
}
?>
<!DOCTYPE html>
<html lang="en">
<head><title>Profile Settings | GameIn</title></head>
<body>
    <?php include 'header_admin.php'; ?>
    <div class="main-content">
        <h3 class="fw-bold mb-4">Account <span class="text-danger">Settings</span></h3>
        <div class="row">
            <div class="col-md-7">
                <div class="card p-4 shadow-lg">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="text-center mb-4">
                            <img src="../assets/images/<?= $adm['foto'] ?>" class="rounded-circle border border-danger p-1 mb-3" width="120" height="120" style="object-fit:cover;">
                            <div><input type="file" name="foto" class="form-control form-control-sm mx-auto" style="max-width:300px;"></div>
                        </div>
                        <div class="mb-3">
                            <label class="text-muted small fw-bold mb-2">USERNAME ADMIN</label>
                            <input type="text" name="username" class="form-control" value="<?= $adm['username'] ?>" required>
                        </div>
                        <div class="mb-4">
                            <label class="text-muted small fw-bold mb-2">NEW PASSWORD</label>
                            <input type="password" name="pass" class="form-control" placeholder="Biarkan kosong jika tidak ganti">
                        </div>
                        <button type="submit" name="save_profile" class="btn btn-danger w-100 py-2 fw-bold">UPDATE PROFILE</button>
                    </form>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card p-4" style="background: rgba(255,255,255,0.02) !important;">
                    <h6 class="text-danger fw-bold mb-3">System Information</h6>
                    <p class="small text-muted mb-1">Account ID:</p>
                    <p class="fw-bold">#<?= $adm['id'] ?></p>
                    <p class="small text-muted mb-1">Status:</p>
                    <span class="badge bg-success">Active Administrator</span>
                </div>
            </div>
        </div>
    </div>
</body>
</html>