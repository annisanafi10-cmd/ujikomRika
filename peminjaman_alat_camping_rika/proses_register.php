<?php
include 'koneksi.php';

if(isset($_POST['register'])){
    $nama     = mysqli_real_escape_string($conn, $_POST['nama']);
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password']; // Simpel teks biasa sesuai permintaanmu
    $role     = $_POST['role'];

    // 1. Cek dulu apakah email sudah pernah didaftarkan
    $cek_email = mysqli_query($conn, "SELECT * FROM tabel_user WHERE email='$email'");
    
    if(mysqli_num_rows($cek_email) > 0){
        echo "<script>alert('Email sudah terdaftar, pakai email lain ya!'); window.location='register.php';</script>";
    } else {
        // 2. Masukkan data ke tabel_user
        // Pastikan nama kolom (nama, email, password, role) sama dengan di DB kamu
        $input = mysqli_query($conn, "INSERT INTO tabel_user (nama, email, password, role) 
                                      VALUES ('$nama', '$email', '$password', '$role')");
        
        if($input){
            echo "<script>alert('Pendaftaran Berhasil! Silakan Login.'); window.location='index.php';</script>";
        } else {
            echo "<script>alert('Gagal daftar nih: " . mysqli_error($conn) . "'); window.location='register.php';</script>";
        }
    }
}
?>