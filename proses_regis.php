<?php
session_start();
require_once 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_lengkap = trim($_POST['nama_lengkap'] ?? '');
    $username     = trim($_POST['username'] ?? '');
    $password     = $_POST['password'] ?? '';

    // Simpan data input lama jika gagal
    $_SESSION['old_register'] = [
        'nama_lengkap' => $nama_lengkap,
        'username'     => $username
    ];

    // Validasi input kosong
    if (empty($nama_lengkap) || empty($username) || empty($password)) {
        $_SESSION['error_register'] = "Semua kolom wajib diisi!";
        header("Location: register.php");
        exit();
    }

    // Validasi password minimal 6 karakter
    if (strlen($password) < 6) {
        $_SESSION['error_register'] = "Password minimal harus 6 karakter!";
        header("Location: register.php");
        exit();
    }

    // Cek ketersediaan username (harus unik)
    $stmt = $mysqli->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $_SESSION['error_register'] = "Username sudah digunakan, silakan pilih yang lain!";
        $stmt->close();
        header("Location: register.php");
        exit();
    }
    $stmt->close();

    // Hash password & simpan ke database
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $mysqli->prepare("INSERT INTO users (nama_lengkap, username, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nama_lengkap, $username, $hashed_password);

    if ($stmt->execute()) {
        $_SESSION['sukses_login'] = "Registrasi berhasil! Silakan login di bawah.";
        unset($_SESSION['old_register']);
        $stmt->close();
        header("Location: login.php");
        exit();
    } else {
        $_SESSION['error_register'] = "Gagal melakukan registrasi, silakan coba lagi.";
        $stmt->close();
        header("Location: register.php");
        exit();
    }
} else {
    header("Location: register.php");
    exit();
}