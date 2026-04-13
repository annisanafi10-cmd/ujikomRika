<?php
session_start();
include 'koneksi.php';

// Proteksi: Hanya Admin atau Petugas yang boleh akses
if (!isset($_SESSION['role']) || ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'petugas')) {
    header("location:index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventaris Alat | Camping Rika</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body { background: #f4f7f6; font-family: 'Segoe UI', sans-serif; }
        .navbar-rika { background: #1b5e20; color: white; }
        .card-table { border: none; border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); overflow: hidden; }
        .table thead { background: #e8f5e9; color: #2e7d32; }
    </style>
</head>
<body>

<nav class="navbar navbar-rika shadow-sm p-3 mb-4">
    <div class="container">
        <span class="navbar-brand fw-bold text-white"><i class="bi bi-box-seam me-2"></i>INVENTARIS GUDANG</span>
        <a href="dashboard_admin.php" class="btn btn-outline-light btn-sm rounded-pill px-3 fw-bold">
            <i class="bi bi-house-door me-1"></i> Dashboard
        </a>
    </div>
</nav>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-0">Manajemen Alat Camping</h4>
            <p class="text-muted small">Update stok dan harga sewa harian alat.</p>
        </div>
        <a href="alat_tambah.php" class="btn btn-success rounded-pill px-4 fw-bold shadow-sm">
            <i class="bi bi-plus-lg me-1"></i> Tambah Alat
        </a>
    </div>

    <div class="card card-table">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th class="ps-4 py-3">No</th>
                            <th>Nama Alat</th>
                            <th>Stok Tersedia</th>
                            <th>Harga Sewa</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        // Pastikan Query menggunakan nama 'tabel_alat'
                        $query = mysqli_query($conn, "SELECT * FROM tabel_alat ORDER BY id_alat DESC");

                        if (!$query) {
                            // Jika tabel_alat tidak ditemukan, tampilkan pesan error yang jelas
                            echo "<tr><td colspan='5' class='text-center py-5 text-danger'>
                                    <i class='bi bi-exclamation-triangle fs-1'></i><br>
                                    Tabel 'tabel_alat' tidak ditemukan di database!
                                  </td></tr>";
                        } elseif (mysqli_num_rows($query) == 0) {
                            echo "<tr><td colspan='5' class='text-center py-5 text-muted'>Belum ada data alat.</td></tr>";
                        } else {
                            while($row = mysqli_fetch_assoc($query)) {
                        ?>
                        <tr>
                            <td class="ps-4 fw-bold text-muted"><?= $no++; ?></td>
                            <td class="fw-bold"><?= $row['nama_alat']; ?></td>
                            <td>
                                <span class="badge <?= ($row['stok'] > 0) ? 'bg-primary' : 'bg-danger'; ?> rounded-pill px-3">
                                    <?= $row['stok']; ?> Unit
                                </span>
                            </td>
                            <td class="fw-bold text-success">
                                Rp <?= number_format($row['harga_sewa_perhari'], 0, ',', '.'); ?>
                            </td>
                            <td class="text-center">
                                <div class="btn-group shadow-sm rounded-pill overflow-hidden">
                                    <a href="alat_edit.php?id=<?= $row['id_alat']; ?>" class="btn btn-warning btn-sm px-3">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>
                                    <a href="alat_hapus.php?id=<?= $row['id_alat']; ?>" class="btn btn-danger btn-sm px-3" 
                                       onclick="return confirm('Yakin ingin menghapus alat ini?')">
                                        <i class="bi bi-trash"></i> Hapus
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php 
                            } 
                        } 
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<footer class="text-center text-muted mt-5 py-4">
    <small>&copy; 2026 Camping Rika - Official System</small>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>