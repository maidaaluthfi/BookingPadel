<?php
session_start();

if (isset($_SESSION['id'])) {
    header("Location: dashboard.php");
    exit;
}

$pesan_register = $_SESSION['error_register'] ?? "";
$old            = $_SESSION['old_register'] ?? [];
unset($_SESSION['error_register'], $_SESSION['old_register']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register - Task Harian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { --warna-utama: #1b7a52; --warna-utama-gelap: #145c3d; --warna-kedua: #212529; }
        .btn-kedua { --bs-btn-color:#fff; --bs-btn-bg:var(--warna-kedua); --bs-btn-border-color:var(--warna-kedua);
                    --bs-btn-hover-color:#fff; --bs-btn-hover-bg:#000; --bs-btn-hover-border-color:#000;
                    --bs-btn-active-color:#fff; --bs-btn-active-bg:#000; --bs-btn-active-border-color:#000; }
        .judul { color: var(--warna-utama); }
        .form-control:focus { border-color: var(--warna-utama); box-shadow: 0 0 0 .25rem rgba(27,122,82,.25); }
        a.link-utama { color: var(--warna-utama); text-decoration: none; font-weight: 600; }
        a.link-utama:hover { color: var(--warna-utama-gelap); text-decoration: underline; }
    </style>
</head>
<body class="bg-light">
<div class="container mt-5" style="max-width:420px">
    <h3 class="text-center mb-3 judul fw-bold">Task Harian</h3>
    <div class="card shadow-sm">
        <div class="card-header bg-white pt-3 pb-2 text-center border-bottom-0">
            <h5 class="fw-bold m-0">Registrasi Akun</h5>
        </div>
        <div class="card-body p-4">
            <?php if ($pesan_register != ""): ?>
                <div class="alert alert-danger py-2 fs-6"><?php echo htmlspecialchars($pesan_register); ?></div>
            <?php endif; ?>
            
            <form action="proses_register.php" method="post">
                <div class="mb-3">
                    <label class="form-label">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" class="form-control" value="<?php echo htmlspecialchars($old['nama_lengkap'] ?? ''); ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" value="<?php echo htmlspecialchars($old['username'] ?? ''); ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" minlength="6" required>
                    <div class="form-text">Minimal 6 karakter.</div>
                </div>
                <button type="submit" class="btn btn-kedua w-100 py-2 fw-bold">Register</button>
            </form>
        </div>
        <div class="card-footer bg-white text-center py-3">
            <small class="text-muted">Sudah punya akun? <a href="login.php" class="link-utama">Login di sini</a></small>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>