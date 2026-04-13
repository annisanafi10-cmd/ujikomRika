<?php
session_start();
include 'koneksi.php';

// SATPAM: Khusus role peminjam (siswa)
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'peminjam') {
    header("location:index.php");
    exit();
}

$id_user = $_SESSION['id_user'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Siswa | Camping Rika</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body { background: #f0f4f1; font-family: 'Segoe UI', sans-serif; }
        .navbar-custom { background: #2e7d32; color: white; }
        .card-alat { border: none; border-radius: 15px; transition: 0.3s; overflow: hidden; height: 100%; }
        .card-alat:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
        .sidebar-box { background: white; border-radius: 15px; padding: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
    </style>
</head>
<body>

<nav class="navbar navbar-custom shadow-sm p-3 mb-4">
    <div class="container">
        <span class="navbar-brand fw-bold text-white">🏕️ CAMPING RIKA</span>
        <div class="d-flex align-items-center">
            <span class="me-3 d-none d-md-inline small">Halo, <strong><?= $_SESSION['nama']; ?></strong></span>
            <a href="logout.php" class="btn btn-outline-light btn-sm rounded-pill px-3">Logout</a>
        </div>
    </div>
</nav>

<div class="container">
    <div class="row g-4">
        
        <div class="col-md-8">
            <h4 class="fw-bold mb-3 text-dark">Alat Tersedia</h4>
            <div class="row g-3">
                <?php
                $query_alat = mysqli_query($conn, "SELECT * FROM tabel_alat WHERE stok > 0");
                if(mysqli_num_rows($query_alat) == 0) {
                    echo "<div class='alert alert-warning'>Maaf, saat ini belum ada alat yang tersedia.</div>";
                }
                while($alat = mysqli_fetch_array($query_alat)) {
                ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card card-alat shadow-sm">
                        <div class="card-body d-flex flex-column">
                            <h6 class="fw-bold text-success mb-1"><?= $alat['nama_alat']; ?></h6>
                            <p class="text-muted small mb-3">Stok: <strong><?= $alat['stok']; ?></strong></p>
                            
                            <div class="mt-auto">
                                <p class="fw-bold mb-2 small text-dark">Rp <?= number_format($alat['harga_sewa_perhari'], 0, ',', '.'); ?>/hari</p>
                                
                                <a href="form_pinjam.php?id=<?= $alat['id_alat']; ?>" class="btn btn-success btn-sm w-100 rounded-pill fw-bold">Pinjam Sekarang</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>

        <div class="col-md-4">
            <div class="sidebar-box">
                <h6 class="fw-bold mb-3"><i class="bi bi-clock-history me-2"></i>Status Pinjaman</h6>
                <hr>

                <?php
                $query_histori = mysqli_query($conn, "SELECT p.*, a.nama_alat FROM tabel_peminjaman p 
                                                      JOIN tabel_alat a ON p.id_alat = a.id_alat 
                                                      WHERE p.id_user = '$id_user' 
                                                      ORDER BY p.id_peminjaman DESC LIMIT 3");

                if(mysqli_num_rows($query_histori) == 0) {
                    echo "<p class='text-muted small text-center py-3'>Belum ada aktivitas pinjam.</p>";
                } else {
                    while($h = mysqli_fetch_array($query_histori)) {
                        $warna = "bg-warning text-dark";
                        if($h['status'] == 'dipinjam') $warna = "bg-primary";
                        if($h['status'] == 'kembali') $warna = "bg-success";
                ?>
                    <div class="mb-3 border-bottom pb-2">
                        <div class="d-flex justify-content-between">
                            <span class="small fw-bold text-dark"><?= $h['nama_alat']; ?></span>
                            <span class="badge <?= $warna ?>" style="font-size: 10px;"><?= strtoupper($h['status']); ?></span>
                        </div>
                        <div class="text-muted" style="font-size: 11px;"><?= $h['tanggal_pinjam'] ?? '-'; ?> | Jml: <?= $h['jumlah']; ?></div>
                    </div>
                <?php 
                    }
                } 
                ?>
                <a href="histori_pinjam.php" class="btn btn-light btn-sm w-100 mt-2 text-muted">Lihat Semua Riwayat</a>
            </div>
        </div>

    </div>
</div>

<footer class="text-center text-muted mt-5 py-4">
    <small>&copy; 2026 Camping Rika - UKK RPL</small>
</footer>

</body>
</html>