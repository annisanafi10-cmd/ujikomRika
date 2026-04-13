<?php
include 'koneksi.php';
session_start();

if (isset($_POST['submit'])) {
    // Ambil data dari session dan form
    $id_user        = $_SESSION['id_user'];
    $id_alat        = $_POST['id_alat'];
    $tanggal_pinjam = $_POST['tgl_pinjam'];  // dari name="tgl_pinjam" di form
    $tanggal_kembali= $_POST['tgl_kembali']; // dari name="tgl_kembali" di form
    $jumlah         = $_POST['jumlah'];

    // 1. Hitung Lama Pinjam
    $tgl1 = new DateTime($tanggal_pinjam);
    $tgl2 = new DateTime($tanggal_kembali);
    $jarak = $tgl1->diff($tgl2);
    $lama_pinjam = $jarak->days;
    if($lama_pinjam <= 0) { $lama_pinjam = 1; } // Minimal 1 hari

    // 2. Ambil harga dari tabel_alat
    $query_alat = mysqli_query($conn, "SELECT harga_sewa_perhari FROM tabel_alat WHERE id_alat = '$id_alat'");
    $data_alat  = mysqli_fetch_array($query_alat);
    $harga      = $data_alat['harga_sewa_perhari'];
    
    // 3. Hitung Total Harga
    $total_harga = $lama_pinjam * $harga * $jumlah;

    // 4. Simpan ke tabel peminjaman
    // Note: Pastikan kamu sudah tambah kolom id_alat di phpMyAdmin tabel peminjaman ya!
    $query_simpan = mysqli_query($conn, "INSERT INTO tabel_peminjaman 
        (id_user, id_alat, tanggal_pinjam, tanggal_kembali, total_harga, status) 
        VALUES 
        ('$id_user', '$id_alat', '$tanggal_pinjam', '$tanggal_kembali', '$total_harga', 'dipinjam')");

    if ($query_simpan) {
        // 5. Update Stok Alat
        mysqli_query($conn, "UPDATE tabel_alat SET stok = stok - $jumlah WHERE id_alat = '$id_alat'");
        
        echo "<script>alert('Peminjaman Berhasil! Total Bayar: Rp " . number_format($total_harga,0,',','.') . "'); window.location='histori_pinjam.php';</script>";
    } else {
        // Menampilkan error jika query gagal
        echo "Gagal menyimpan: " . mysqli_error($conn);
    }
}
?>