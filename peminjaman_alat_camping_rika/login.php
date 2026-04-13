<?php
session_start();
include 'koneksi.php';

if(isset($_POST['login'])){
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM `tabel_user` WHERE `email` = '$email'");
    
    if(mysqli_num_rows($query) > 0){
        $user = mysqli_fetch_assoc($query);
        
        // PERBAIKAN 1: Pakai perbandingan teks biasa (karena PW kamu nggak di-hash)
        if($password == $user['password']){
            
            $_SESSION['id_user'] = $user['id_user'];
            $_SESSION['nama']    = $user['nama'];
            $_SESSION['role']    = strtolower($user['role']); // Kecilin semua biar aman

            // PERBAIKAN 2: Pengalihan sesuai file yang kita buat tadi
            if($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'petugas'){
                // Admin & Petugas ke sini
                header("Location: dashboard_admin.php");
            } elseif($_SESSION['role'] == 'peminjam'){
                // Siswa/Peminjam ke sini
                header("Location: dashboard_peminjam.php");
            } else {
                echo "<script>alert('Role tidak dikenali!'); window.location='index.php';</script>";
            }
            exit();
            
        } else { 
            echo "<script>alert('Password salah!'); window.location='index.php';</script>"; 
        }
    } else { 
        echo "<script>alert('Email tidak terdaftar!'); window.location='index.php';</script>"; 
    }
}
?>