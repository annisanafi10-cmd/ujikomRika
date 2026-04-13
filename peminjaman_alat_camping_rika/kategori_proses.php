<?php
include 'koneksi.php';
session_start();

// Fitur Tambah Kategori
if(isset($_POST['btn_tambah'])){
    $nama = mysqli_real_escape_string($conn, $_POST['nama_kategori']);
    
    $query = mysqli_query($conn, "INSERT INTO kategori (nama_kategori) VALUES ('$nama')");
    
    if($query){
        header("Location: kategori_tampil.php?pesan=berhasil");
    } else {
        echo "Gagal: " . mysqli_error($conn);
    }
}

// Fitur Hapus Kategori
if(isset($_GET['hapus'])){
    $id = $_GET['hapus'];
    
    $query = mysqli_query($conn, "DELETE FROM kategori WHERE id_kategori = '$id'");
    
    if($query){
        header("Location: kategori_tampil.php?pesan=terhapus");
    } else {
        echo "Gagal Hapus: " . mysqli_error($conn);
    }
}
?>