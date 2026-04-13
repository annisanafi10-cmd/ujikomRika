<?php
// Koneksi database
$conn = mysqli_connect("localhost","root","","peminjaman_alat_campingrikarpl4");
if(!$conn) die("Koneksi gagal: ".mysqli_connect_error());

// Password baru admin
$password_baru = "admin123"; // ganti sesuai yang kamu mau

// Hash password baru
$hash = password_hash($password_baru, PASSWORD_DEFAULT);

// Update password admin
$update = mysqli_query($conn, "UPDATE users SET password='$hash' WHERE role='admin'");

if($update){
    echo "Password admin berhasil direset menjadi: $password_baru";
} else {
    echo "Gagal reset password: " . mysqli_error($conn);
}
?>