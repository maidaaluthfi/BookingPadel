<?php
session_start();
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: login.php");
    exit;
}

$email    = strtolower(trim($_POST['email'] ?? ''));
$password = $_POST['password'] ?? '';

$stmt = $koneksi->prepare("SELECT id, nama, email, password, peran FROM pengguna WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if ($user && password_verify($password, $user['password'])) {
    session_regenerate_id(true);
    $_SESSION['id_pengguna'] = $user['id'];
    $_SESSION['nama']        = $user['nama'];
    $_SESSION['peran']       = $user['peran']; 

    if (isset($_POST['ingat'])) {
        setcookie("ingat_email", $email, [
            'expires'  => time() + (7 * 24 * 60 * 60),
            'httponly' => true,
            'samesite' => 'Lax',
        ]);
    } else {
        setcookie("ingat_email", "", time() - 3600);
    }

    if ($user['peran'] === 'admin') {
        header("Location: admin/dashboard.php");
    } else {
        header("Location: index.php");
    }
    exit;
}

$_SESSION['error_login'] = "Email atau password salah!";
header("Location: login.php");
exit;