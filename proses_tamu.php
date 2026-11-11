<?php
session_start();

$_SESSION['is_guest']     = true;
$_SESSION['nama_lengkap'] = 'Tamu';
$_SESSION['role']         = 'guest';

header("Location: dashboard.php");
exit();