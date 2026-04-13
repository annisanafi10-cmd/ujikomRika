<?php
include 'koneksi.php';
session_start();

$id_peminjaman = $_GET['id'];
$tgl_sekarang = date('Y-m-d');

// 1. Ambil data peminjaman
$query = mysqli_query($conn, "SELECT * FROM peminjaman WHERE id_peminjaman = '$id_peminjaman'");
$data = mysqli_fetch_assoc($query);

$tgl_kembali_seharusnya = $data['tanggal_kembali'];
$id_alat = $data['id_alat'];

// 2. LOGIKA HITUNG DENDA
$denda_per_hari = 5000; 
$denda = 0;

if (strtotime($tgl_sekarang) > strtotime($tgl_kembali_seharusnya)) {
    $selisih = strtotime($tgl_sekarang) - strtotime($tgl_kembali_seharusnya);
    $hari_terlambat = floor($selisih / (60 * 60 * 24));
    $denda = $hari_terlambat * $denda_per_hari;
}

// 3. UPDATE Status Peminjaman & Stok Alat (CRUD Pengembalian)
// Mengubah status jadi 'kembali', mengisi tgl_kembali_asli, dan denda
$update_pinjam = mysqli_query($conn, "UPDATE peminjaman SET 
    status = 'kembali', 
    denda = '$denda' 
    WHERE id_peminjaman = '$id_peminjaman'");

// Kembalikan stok alat +1
$update_stok = mysqli_query($conn, "UPDATE alat SET stok = stok + 1 WHERE id_alat = '$id_alat'");

if($update_pinjam && $update_stok){
    $pesan = ($denda > 0) ? "Kembali Berhasil! Denda Terlambat: Rp " . number_format($denda, 0, ',', '.') : "Kembali Berhasil! Tepat Waktu.";
    echo "<script>alert('$pesan'); window.location='pengembalian_tampil.php';</script>";
}
?>