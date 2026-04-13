<?php
include 'koneksi.php';

if(isset($_POST['update'])){
    $id = $_POST['id_alat'];
    $nama = $_POST['nama_alat'];
    $stok = $_POST['stok'];
    $harga = $_POST['harga_sewa_perhari'];

    // Query Update ke tabel_alat
    $sql = "UPDATE tabel_alat SET 
            nama_alat='$nama', 
            stok='$stok', 
            harga_sewa_perhari='$harga' 
            WHERE id_alat='$id'";

    $query = mysqli_query($conn, $sql);

    if($query){
        header("location:alat_tampil.php?pesan=berhasil_update");
    } else {
        echo "Gagal mengupdate data: " . mysqli_error($conn);
    }
} else {
    header("location:alat_tampil.php");
}
?>