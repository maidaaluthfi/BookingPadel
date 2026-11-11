<?php
session_start();
 
    if (isset($_SESSION['id_pengguna'])) {
        header("Location: " . ($_SESSION['peran'] === 'admin' ? "admin/dashboard.php" : "index.php"));
        exit;
    }
    
    $pesan_login    = $_SESSION['error_login'] ?? "";
    $pesan_register = $_SESSION['error_register'] ?? "";
    $sukses         = $_SESSION['sukses_login'] ?? "";
    $tab            = $_SESSION['tab'] ?? "login";
    $old            = $_SESSION['old_register'] ?? [];
    unset($_SESSION['error_login'], $_SESSION['error_register'], $_SESSION['sukses_login'], $_SESSION['tab'], $_SESSION['old_register']);
    
    $cookie_email = $_COOKIE['ingat_email'] ?? "";
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Booking Padel</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            :root { --warna-utama: #1b7a52; --warna-utama-gelap: #145c3d; --warna-kedua: #212529; }
            .btn-utama { --bs-btn-color:#fff; --bs-btn-bg:var(--warna-utama); --bs-btn-border-color:var(--warna-utama);
                        --bs-btn-hover-color:#fff; --bs-btn-hover-bg:var(--warna-utama-gelap); --bs-btn-hover-border-color:var(--warna-utama-gelap);
                        --bs-btn-active-color:#fff; --bs-btn-active-bg:var(--warna-utama-gelap); --bs-btn-active-border-color:var(--warna-utama-gelap); }
            .btn-kedua { --bs-btn-color:#fff; --bs-btn-bg:var(--warna-kedua); --bs-btn-border-color:var(--warna-kedua);
                        --bs-btn-hover-color:#fff; --bs-btn-hover-bg:#000; --bs-btn-hover-border-color:#000;
                        --bs-btn-active-color:#fff; --bs-btn-active-bg:#000; --bs-btn-active-border-color:#000; }
            .judul { color: var(--warna-utama); }
            .nav-tabs .nav-link { color: var(--warna-utama); }
            .nav-tabs .nav-link.active { color: #495057; }
            .form-control:focus { border-color: var(--warna-utama); box-shadow: 0 0 0 .25rem rgba(27,122,82,.25); }
            .form-check-input:checked { background-color: var(--warna-utama); border-color: var(--warna-utama); }
        </style>
    </head>
    <body class="bg-light">
    <div class="container mt-5" style="max-width:420px">
        <h3 class="text-center mb-3 judul">Booking Padel</h3>
        <div class="card">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs">
                    <li class="nav-item"><a class="nav-link <?php if ($tab == 'login') echo 'active'; ?>" data-bs-toggle="tab" href="#login">Login</a></li>
                    <li class="nav-item"><a class="nav-link <?php if ($tab == 'register') echo 'active'; ?>" data-bs-toggle="tab" href="#register" id="btn-tab-register">Register</a></li>
                </ul>
            </div>
            <div class="card-body tab-content">
    
                <div class="tab-pane <?php if ($tab == 'login') echo 'active'; ?>" id="login">
                    <?php if ($sukses != "") { ?><div class="alert alert-success"><?php echo htmlspecialchars($sukses); ?></div><?php } ?>
                    <?php if ($pesan_login != "") { ?><div class="alert alert-danger"><?php echo htmlspecialchars($pesan_login); ?></div><?php } ?>
                    <form action="proses_login.php" method="post">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control mb-3" value="<?php echo htmlspecialchars($cookie_email); ?>" required>
                        <label>Password</label>
                        <input type="password" name="password" class="form-control mb-3" required>
                        <div class="form-check mb-3">
                            <input type="checkbox" name="ingat" id="ingat" class="form-check-input" <?php if ($cookie_email != "") echo "checked"; ?>>
                            <label for="ingat" class="form-check-label">Ingat saya</label>
                        </div>
                       <button type="submit" class="btn btn-utama w-100">Login</button>

                        <!-- LELAKKAN LANGKAH 2 DI SINI (Baris 64.5) -->
                       
                        <!-- Didalam card-footer atau dibawah form login.php -->
                        <div class="card-footer bg-white text-center py-3">
                            <small class="text-muted d-block mb-2">Belum punya akun?</small>
                            <div class="border-top my-2"></div>
                             <button type="button" class="btn btn-outline-secondary btn-sm w-100 mt-2 mb-2" onclick="document.getElementById('btn-tab-register').click();">
                         Daftar Akun Baru
                        </button>
                            <!-- Tombol Masuk sebagai Tamu -->
                            <a href="proses_tamu.php" class="btn btn-link link-utama text-decoration-none">⚡ Lanjut Sewa sebagai Tamu</a>
                        </div>
                    </form>
                </div>
    
                <div class="tab-pane <?php if ($tab == 'register') echo 'active'; ?>" id="register">
                    <?php if ($pesan_register != "") { ?><div class="alert alert-danger"><?php echo htmlspecialchars($pesan_register); ?></div><?php } ?>
                    <form action="proses_register.php" method="post">
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control mb-3" value="<?php echo htmlspecialchars($old['nama'] ?? ''); ?>" required>
                        <label>Email</label>
                        <input type="email" name="email" class="form-control mb-3" value="<?php echo htmlspecialchars($old['email'] ?? ''); ?>" required>
                        <label>No. WhatsApp</label>
                        <input type="tel" name="whatsapp" class="form-control mb-3" placeholder="081234567890" value="<?php echo htmlspecialchars($old['whatsapp'] ?? ''); ?>" required>
                        <label>Password</label>
                        <input type="password" name="password" class="form-control mb-3" required>
                        <button type="submit" class="btn btn-kedua w-100">Register</button>
                    </form>
                </div>
    
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>