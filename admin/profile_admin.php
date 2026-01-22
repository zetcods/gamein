<?php
session_start();
include '../config/koneksi.php';
if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') { header("Location: ../auth/login.php"); exit; }

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
    
    if (mysqli_query($conn, $sql)) {
        $_SESSION['username'] = $user;
        echo "<script>alert('Profile Updated!'); window.location='profile_admin.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Profile | GameIn</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body>

<?php include 'header_admin.php'; ?>

<div class="main-content">
    <h4 class="fw-bold mb-4">Account Settings</h4>
    <div class="card border-0 shadow-sm p-4 bg-white" style="max-width: 600px; border-radius: 15px;">
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-4 d-flex align-items-center">
                <div class="avatar-admin me-3" style="width: 100px; height: 100px; margin:0;">
                    <?php if (empty($adm['foto']) || $adm['foto'] == 'default_user.jpg'): ?>
                        <span><?= strtoupper(substr($adm['username'], 0, 1)); ?></span>
                    <?php else: ?>
                        <img src="../assets/images/<?= $adm['foto']; ?>">
                    <?php endif; ?>
                </div>
                <input type="file" name="foto" class="form-control form-control-sm">
            </div>
            <div class="mb-3">
                <label class="small fw-bold text-muted">USERNAME ADMIN</label>
                <input type="text" name="username" class="form-control" value="<?= $adm['username']; ?>" required>
            </div>
            <div class="mb-4">
                <label class="small fw-bold text-muted">PASSWORD BARU</label>
                <input type="password" name="pass" class="form-control" placeholder="Kosongkan jika tidak ganti">
            </div>
            <button type="submit" name="save_profile" class="btn btn-primary w-100 fw-bold">Update Admin Profile</button>
        </form>
    </div>
</div>

</body>
</html>