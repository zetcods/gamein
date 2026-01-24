<?php
session_start(); 
include '../config/koneksi.php';

// Proteksi Admin
if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

// Logic Promote Member jadi Admin
if (isset($_GET['promote'])) {
    $id_promo = mysqli_real_escape_string($conn, $_GET['promote']);
    // Update role jadi admin
    mysqli_query($conn, "UPDATE users SET role='admin' WHERE id='$id_promo'");
    header("Location: users_manage.php?status=promoted");
    exit;
}

// Logic Hapus User
if (isset($_GET['hapus'])) { 
    $id = mysqli_real_escape_string($conn, $_GET['hapus']); 
    // Hapus cuma kalo bukan admin (safety)
    mysqli_query($conn, "DELETE FROM users WHERE id='$id' AND role != 'admin'"); 
    header("Location: users_manage.php?status=deleted");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Users | GameIn</title>
</head>
<body>
    <?php include 'header_admin.php'; ?>

    <div class="main-content">
        <div class="mb-4">
            <h3 class="fw-bold text-white">User <span style="color:var(--accent)">Database</span></h3>
            <p class="text-muted small">Kelola data pemain dan akses level akun mereka.</p>
        </div>

        <div class="card border-0 shadow-lg overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4 py-3">Username</th>
                            <th class="py-3">Role Status</th>
                            <th class="py-3">User ID</th>
                            <th class="text-center py-3">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        // Urutkan biar Admin di atas, Member di bawah
                        $qu = mysqli_query($conn, "SELECT * FROM users ORDER BY role ASC");
                        while($ru = mysqli_fetch_assoc($qu)): 
                        ?>
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center me-3" 
                                         style="width: 35px; height: 35px; font-size: 12px; font-weight: bold; color: white;">
                                        <?= strtoupper(substr($ru['username'], 0, 1)) ?>
                                    </div>
                                    <span class="fw-bold text-white"><?= $ru['username'] ?></span>
                                </div>
                            </td>
                            <td>
                                <?php if($ru['role'] == 'admin'): ?>
                                    <span class="badge bg-danger px-3 py-2" style="font-size: 10px; letter-spacing: 1px;">ADMINISTRATOR</span>
                                <?php else: ?>
                                    <span class="badge bg-dark border border-secondary px-3 py-2 text-muted" style="font-size: 10px; letter-spacing: 1px;">MEMBER</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <code style="color: var(--text-muted); background: rgba(255,255,255,0.05); padding: 2px 8px; border-radius: 4px;">
                                    #<?= $ru['id'] ?>
                                </code>
                            </td>
                            <td class="text-center">
                                <?php if($ru['role'] != 'admin'): ?>
                                    <a href="?promote=<?= $ru['id'] ?>" class="btn btn-sm btn-outline-success border-0 me-1" 
                                       title="Jadikan Admin"
                                       onclick="return confirm('Yakin mau angkat <?= $ru['username'] ?> jadi Admin?')">
                                        <i class="bi bi-shield-plus"></i>
                                    </a>
                                    
                                    <a href="?hapus=<?= $ru['id'] ?>" class="btn btn-sm btn-outline-danger border-0" 
                                       title="Hapus User"
                                       onclick="return confirm('Yakin mau depak user ini, bro?')">
                                        <i class="bi bi-trash3-fill"></i>
                                    </a>
                                <?php else: ?>
                                    <span class="badge bg-transparent text-muted small italic">
                                        <i class="bi bi-shield-lock me-1"></i>Protected
                                    </span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>