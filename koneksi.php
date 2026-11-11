<?php

$host = "localhost";
$username = "root";
$password = "";
$database = "db_padel_booking";

$koneksi = mysqli_connection($host, $username, $password, $database);

if(!$koneksi){
    die("Koneksi ke database gagal : " . mysqli_connection_error());
}

?>