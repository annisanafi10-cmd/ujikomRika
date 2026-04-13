<?php
session_start();
include 'koneksi.php';

// Proteksi Admin/Petugas
if (!isset($_SESSION['role']) || ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'petugas')) {
    header("location:index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Alat | Camping Rika</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body { background: #f8f9fa; font-family: 'Segoe UI', sans-serif; }
        .navbar-custom { background: #1b5e20; color: white; }
        .card-table { border: none; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); }
        .btn-add { background: #2e7d32; color: white; border-radius: 10px; font-weight: bold; }
        .btn-add:hover { background: #1b5e20; color: white; }
    </style>
</head>
<body>

<nav class="navbar navbar-custom p-3 mb-4 shadow-sm">
    <div class="container">
        <span class="navbar-brand fw-bold text-white">CAMPING RIKA - GUDANG</span>
        <a href="dashboard_admin.php" class="btn btn-outline-light btn-sm rounded-pill px-3">Kembali</a>
    </div>
</nav>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold"><i class="bi bi-box-seam me-2 text-success"></i>Daftar Persediaan Alat</h4>
        <a href="alat_tambah.php" class="btn btn-add shadow-sm">+ Tambah Alat Baru</a>
    </div>

    <div class="card card-table">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">ID</th>
                            <th>Nama Alat</th>
                            <th>Stok</th>
                            <th>Harga Sewa / Hari</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // PERBAIKAN: Menggunakan 'tabel_alat' (bukan 'alat')
                        $sql = "SELECT * FROM tabel_alat ORDER BY id_alat DESC";
                        $query = mysqli_query($conn, $sql);

                        if(mysqli_num_rows($query) == 0) {
                            echo "<tr><td colspan='5' class='text-center py-4 text-muted'>Data alat masih kosong.</td></tr>";
                        }

                        while($row = mysqli_fetch_array($query)) {
                        ?>
                        <tr>
                            <td class="ps-4 fw-bold text-muted"><?= $row['id_alat']; ?></td>
                            <td class="fw-bold"><?= $row['nama_alat']; ?></td>
                            <td>
                                <span class="badge <?= ($row['stok'] > 0) ? 'bg-success' : 'bg-danger'; ?> rounded-pill">
                                    <?= $row['stok']; ?> Unit
                                </span>
                            </td>
                            <td>Rp <?= number_format($row['harga_sewa_perhari'], 0, ',', '.'); ?></td>
                            <td class="text-center">
                                <a href="alat_edit.php?id=<?= $row['id_alat']; ?>" class="btn btn-warning btn-sm rounded-pill px-3 fw-bold">Edit</a>
                                <a href="alat_hapus.php?id=<?= $row['id_alat']; ?>" class="btn btn-danger btn-sm rounded-pill px-3 fw-bold" onclick="return confirm('Yakin mau hapus alat ini?')">Hapus</a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<footer class="text-center text-muted mt-5 py-4">
    <small>&copy; 2026 Camping Rika - Gudang System</small>
</footer>

</body>
</html>