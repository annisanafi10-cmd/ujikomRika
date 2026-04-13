<?php
$host = "localhost";
$user = "root";
$pass = "";
// Perhatikan: campingrikarpl4 (nyambung tanpa _)
$db   = "peminjaman_alat_campingrikarpl4"; 

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>