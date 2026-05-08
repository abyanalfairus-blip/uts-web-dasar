<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "kampus_db";

$conn = mysqli_connect($host, $user, $pass, $db); // Pastikan namanya $conn

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>