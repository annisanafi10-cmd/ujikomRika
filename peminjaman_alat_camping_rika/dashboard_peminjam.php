<?php
session_start();
include 'koneksi.php';

// Proteksi Halaman
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'peminjam') {
    header("location:index.php");
    exit();
}

$id_user = $_SESSION['id_user'];
$nama_user = $_SESSION['nama'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Siswa | Camping Rika</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body { background: #f0f4f1; font-family: 'Segoe UI', sans-serif; }
        .navbar-custom { background: #2e7d32; color: white; }
        .card-alat { border: none; border-radius: 15px; transition: 0.3s; height: 100%; }
        .card-alat:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
        .sidebar-box { background: white; border-radius: 15px; padding: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        .badge-status { font-size: 0.7rem; padding: 5px 10px; border-radius: 50px; }
    </style>
</head>
<body>

<nav class="navbar navbar-custom shadow-sm p-3 mb-4">
    <div class="container">
        <span class="navbar-brand fw-bold text-white"><i class="bi bi-tent me-2"></i>CAMPING RIKA</span>
        <div class="d-flex align-items-center">
            <span class="me-3 d-none d-md-inline small text-white">Halo, <strong><?= $nama_user; ?></strong></span>
            <a href="logout.php" class="btn btn-outline-light btn-sm rounded-pill px-3 fw-bold">Keluar</a>
        </div>
    </div>
</nav>

<div class="container">
    <div class="row g-4">
        
        <div class="col-md-8">
            <h4 class="fw-bold text-dark mb-3">Alat Camping Tersedia</h4>
            <div class="row g-3">
                <?php
                $query_alat = mysqli_query($conn, "SELECT * FROM tabel_alat WHERE stok > 0");
                while($alat = mysqli_fetch_array($query_alat)) {
                ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card card-alat shadow-sm">
                        <div class="card-body d-flex flex-column">
                            <h6 class="fw-bold text-success mb-1"><?= $alat['nama_alat']; ?></h6>
                            <p class="text-muted mb-3" style="font-size: 0.85rem;">Stok: <?= $alat['stok']; ?> unit</p>
                            <div class="mt-auto">
                                <p class="fw-bold mb-2 small text-dark">Rp <?= number_format($alat['harga_sewa_perhari'], 0, ',', '.'); ?></p>
                                <a href="form_pinjam.php?id=<?= $alat['id_alat']; ?>" class="btn btn-success btn-sm w-100 rounded-pill fw-bold">Pinjam</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>

        <div class="col-md-4">
            <div class="sidebar-box shadow-sm mb-4">
                <h6 class="fw-bold mb-3"><i class="bi bi-activity me-2 text-success"></i>Status Pinjaman</h6>
                <hr>
                <?php
                $sql_status = "SELECT p.*, a.nama_alat FROM tabel_peminjaman p 
                               JOIN tabel_alat a ON p.id_alat = a.id_alat 
                               WHERE p.id_user = '$id_user' 
                               ORDER BY p.id_peminjaman DESC LIMIT 3";
                $query_status = mysqli_query($conn, $sql_status);

                if(mysqli_num_rows($query_status) == 0) {
                    echo "<div class='text-center py-3'><i class='bi bi-inbox text-muted fs-2'></i><p class='text-muted small mt-2'>Belum ada pinjaman.</p></div>";
                } else {
                    while($s = mysqli_fetch_array($query_status)) {
                        $bg = ($s['status'] == 'dipinjam') ? 'bg-primary text-white' : 'bg-warning text-dark';
                        if($s['status'] == 'kembali' || $s['status'] == 'dikembalikan') $bg = 'bg-success text-white';
                ?>
                <div class="mb-3 pb-2 border-bottom border-light">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <div class="fw-bold small"><?= $s['nama_alat']; ?></div>
                            <small class="text-muted" style="font-size: 10px;"><?= $s['tanggal_pinjam']; ?></small>
                        </div>
                        <span class="badge <?= $bg ?> badge-status"><?= strtoupper($s['status']); ?></span>
                    </div>
                </div>
                <?php } } ?>
                <a href="histori_pinjam.php" class="btn btn-light btn-sm w-100 mt-2 text-muted fw-bold">Lihat Semua Riwayat</a>
            </div>

            <div class="sidebar-box shadow-sm bg-success text-white">
                <h6 class="fw-bold"><i class="bi bi-info-circle me-2"></i>Informasi Rika</h6>
                <p class="small mb-0" style="font-size: 11px; opacity: 0.9;">
                    Pastikan cek kondisi barang sebelum dibawa keluar gudang ya. Hubungi petugas Rika jika ada kendala.
                </p>
            </div>
        </div>
    </div>
</div>

<footer class="text-center text-muted mt-5 py-4 border-top">
    <small>&copy; 2026 Camping Rika - Official Project</small>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>