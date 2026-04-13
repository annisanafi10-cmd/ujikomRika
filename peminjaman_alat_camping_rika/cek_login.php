<?php 
session_start();
include 'koneksi.php';

// Cek apakah data sudah dikirim dari form
if(isset($_POST['email']) && isset($_POST['password'])){
    
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Query ke database
    $login = mysqli_query($conn, "SELECT * FROM tabel_user WHERE email='$email' AND password='$password'");
    $cek = mysqli_num_rows($login);

    if($cek > 0){
        $data = mysqli_fetch_assoc($login);
        
        // Simpan ke Session
        $_SESSION['id_user'] = $data['id_user'];
        $_SESSION['nama'] = $data['nama'];
        $_SESSION['role'] = $data['role'];

        // Alur Dashboard
        if($data['role'] == "admin" || $data['role'] == "petugas"){
            header("location:dashboard_admin.php");
        } else {
            header("location:dashboard_peminjam.php");
        }
    } else {
        // Kalau salah password
        header("location:index.php?pesan=gagal");
    }
} else {
    // Kalau akses file ini langsung tanpa form
    header("location:index.php");
}
?>