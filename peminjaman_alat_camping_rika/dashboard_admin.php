<?php
session_start();
include 'koneksi.php';

// Proteksi: Hanya Admin dan Petugas yang boleh masuk
if (!isset($_SESSION['role']) || ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'petugas')) {
    header("location:index.php");
    exit();
}

// Ambil data session
$role_user = $_SESSION['role'];
$nama_user = $_SESSION['nama'];

// Ambil Statistik
$jml_alat = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tabel_alat"));
$jml_pinjam = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tabel_peminjaman WHERE status='dipinjam'"));
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard <?= ucfirst($role_user); ?> | Camping Rika</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body { background: #f4f7f6; font-family: 'Segoe UI', sans-serif; }
        .navbar-rika { background: <?= ($role_user == 'admin') ? '#1b5e20' : '#0d47a1'; ?>; color: white; }
        .card-menu { border: none; border-radius: 20px; transition: 0.3s; cursor: pointer; height: 100%; }
        .card-menu:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
    </style>
</head>
<body>

<nav class="navbar navbar-rika shadow-sm p-3 mb-5">
    <div class="container">
        <span class="navbar-brand fw-bold text-white">
            <i class="bi bi-person-badge me-2"></i> 
            PANEL <?= strtoupper($role_user); ?> 
        </span>
        <div class="d-flex align-items-center text-white">
            <span class="me-3 small">Halo, <strong><?= $nama_user; ?></strong></span>
            <a href="logout.php" class="btn btn-light btn-sm rounded-pill px-3 fw-bold text-dark">Logout</a>
        </div>
    </div>
</nav>

<div class="container">
    <div class="row mb-4">
        <div class="col-12 text-center">
            <h3 class="fw-bold">Selamat Datang, <?= $nama_user; ?>!</h3>
            <p class="text-muted">Silakan pilih menu aktivitas kamu hari ini.</p>
        </div>
    </div>

    <div class="row g-4 justify-content-center">
        
        <div class="col-md-4">
            <div class="card card-menu p-4 shadow-sm" onclick="location.href='data_peminjaman_admin.php'">
                <div class="text-primary mb-3"><i class="bi bi-cart-check-fill fs-1"></i></div>
                <h5 class="fw-bold">Kelola Peminjaman</h5>
                <p class="small text-muted">Update status pinjam dan pengembalian alat.</p>
                <span class="badge bg-primary rounded-pill"><?= $jml_pinjam; ?> Aktif</span>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card card-menu p-4 shadow-sm" onclick="location.href='daftar_alat.php'">
                <div class="text-success mb-3"><i class="bi bi-box-seam-fill fs-1"></i></div>
                <h5 class="fw-bold">Cek Stok Alat</h5>
                <p class="small text-muted">Melihat ketersediaan alat di gudang secara real-time.</p>
                <span class="badge bg-success rounded-pill"><?= $jml_alat; ?> Jenis Alat</span>
            </div>
        </div>

        <?php if($role_user == 'admin') : ?>
        <div class="col-md-4">
            <div class="card card-menu p-4 shadow-sm" onclick="location.href='alat_tampil.php'">
                <div class="text-warning mb-3"><i class="bi bi-gear-wide-connected fs-1"></i></div>
                <h5 class="fw-bold">Master Data Alat</h5>
                <p class="small text-muted">Khusus Admin: Tambah, Edit, dan Hapus data alat.</p>
                <span class="badge bg-warning text-dark rounded-pill">Akses Terbatas</span>
            </div>
        </div>
        <?php endif; ?>

    </div>
</div>

<footer class="text-center text-muted mt-5 py-4">
    <small>&copy; 2026 Camping Rika - Dashboard Management System</small>
</footer>

</body>
</html>