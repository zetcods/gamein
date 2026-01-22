<?php
session_start();
include '../config/koneksi.php';
if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') { header("Location: ../auth/login.php"); exit; }

// Logic Hapus User
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM users WHERE id='$id' AND role != 'admin'");
    header("Location: users_manage.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>User Management | GameIn</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body>

<?php include 'header_admin.php'; ?>

<div class="main-content">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">User Management</h4>
    </div>

    <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 15px;">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4">User</th>
                        <th>Role</th>
                        <th>ID User</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $q = mysqli_query($conn, "SELECT * FROM users ORDER BY role ASC");
                    while($row = mysqli_fetch_assoc($q)):
                    ?>
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm me-3 bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 35px; height: 35px; font-size: 14px;">
                                    <?= strtoupper(substr($row['username'], 0, 1)); ?>
                                </div>
                                <span class="fw-bold"><?= $row['username']; ?></span>
                            </div>
                        </td>
                        <td>
                            <span class="badge <?= $row['role'] == 'admin' ? 'bg-danger' : 'bg-primary'; ?> rounded-pill">
                                <?= strtoupper($row['role']); ?>
                            </span>
                        </td>
                        <td><code>#<?= $row['id']; ?></code></td>
                        <td class="text-center">
                            <?php if($row['role'] != 'admin'): ?>
                                <a href="?hapus=<?= $row['id']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus user ini?')">
                                    <i class="bi bi-trash"></i>
                                </a>
                            <?php else: ?>
                                <small class="text-muted italic">Protected</small>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>