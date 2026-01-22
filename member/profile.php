<?php
session_start();
include '../config/koneksi.php';
if (!isset($_SESSION['login']) || $_SESSION['role'] != 'member') { header("Location: ../auth/login.php"); exit; }

$id_user = $_SESSION['id_user'];
$u = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id='$id_user'"));

// Logic Update
if (isset($_POST['update_profile'])) {
    $new_user = mysqli_real_escape_string($conn, $_POST['username']);
    $query_up = "UPDATE users SET username='$new_user' ";
    
    if (!empty($_FILES['foto']['name'])) {
        $foto_baru = time() . "_" . $_FILES['foto']['name'];
        move_uploaded_file($_FILES['foto']['tmp_name'], "../assets/images/" . $foto_baru);
        $query_up .= ", foto='$foto_baru' ";
    }
    if (!empty($_POST['new_password'])) {
        $pass = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
        $query_up .= ", password='$pass' ";
    }
    $query_up .= "WHERE id='$id_user'";
    
    if (mysqli_query($conn, $query_up)) {
        $_SESSION['username'] = $new_user;
        echo "<script>alert('Update Berhasil!'); window.location='profile.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Profile | GameIn</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body>

    <?php include 'header_member.php'; ?>

    <div class="main-content">
        <h4 class="fw-bold mb-4">Profil Saya</h4>
        
        <div class="card border-0 shadow-sm p-4 bg-white" style="max-width: 600px; border-radius: 15px;">
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-4 d-flex align-items-center">
                    <div class="avatar-box me-3" style="width: 100px; height: 100px; margin: 0;">
                        <?php if (empty($u['foto']) || $u['foto'] == 'default_user.jpg'): ?>
                            <span><?= strtoupper(substr($u['username'], 0, 1)); ?></span>
                        <?php else: ?>
                            <img src="../assets/images/<?= $u['foto']; ?>">
                        <?php endif; ?>
                    </div>
                    <input type="file" name="foto" class="form-control form-control-sm">
                </div>

                <div class="mb-3">
                    <label class="small fw-bold text-muted">USERNAME</label>
                    <input type="text" name="username" class="form-control bg-light" value="<?= $u['username']; ?>" required>
                </div>
                <div class="mb-4">
                    <label class="small fw-bold text-muted">PASSWORD BARU</label>
                    <input type="password" name="new_password" class="form-control bg-light" placeholder="Kosongkan jika tidak ganti">
                </div>

                <button type="submit" name="update_profile" class="btn btn-primary w-100 fw-bold py-2">Save Changes</button>
            </form>
        </div>
    </div>

</body>
</html>