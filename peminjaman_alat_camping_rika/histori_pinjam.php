<?php
session_start();
include 'koneksi.php';

// Proteksi: Pastikan peminjam yang login
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'peminjam') {
    header("location:index.php");
    exit();
}

$id_user_login = $_SESSION['id_user'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Peminjaman | Camping Rika</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body { background: #fdfdfd; font-family: 'Segoe UI', sans-serif; }
        .navbar-rika { background: #2e7d32; color: white; }
        .card-utama { border: none; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
        .badge-status { font-size: 0.7rem; padding: 6px 12px; font-weight: bold; }
    </style>
</head>
<body>

<nav class="navbar navbar-rika shadow-sm p-3 mb-4">
    <div class="container">
        <span class="navbar-brand fw-bold text-white"><i class="bi bi-tent-fill me-2"></i>CAMPING RIKA</span>
        <a href="dashboard_peminjam.php" class="btn btn-outline-light btn-sm rounded-pill px-4 fw-bold">
            <i class="bi bi-arrow-left me-1"></i> Dashboard
        </a>
    </div>
</nav>

<div class="container">
    <div class="card card-utama p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0 text-dark">Riwayat Peminjaman</h4>
            <span class="text-muted small">Halo, <?= $_SESSION['nama']; ?></span>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th class="py-3">No</th>
                        <th>Alat Camping</th>
                        <th>Tanggal Pinjam</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    // Ambil riwayat milik user yang sedang login saja
                    $sql = "SELECT p.*, a.nama_alat 
                            FROM tabel_peminjaman p 
                            JOIN tabel_alat a ON p.id_alat = a.id_alat 
                            WHERE p.id_user = '$id_user_login' 
                            ORDER BY p.id_peminjaman DESC";
                    
                    $query = mysqli_query($conn, $sql);

                    if(mysqli_num_rows($query) == 0) {
                        echo "<tr><td colspan='5' class='text-center py-5 text-muted'>Belum ada riwayat transaksi.</td></tr>";
                    }

                    while($row = mysqli_fetch_array($query)) {
                        $st = strtolower($row['status']);
                        $warna = ($st == 'dipinjam') ? 'bg-primary' : 'bg-success';
                    ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td class="fw-bold text-dark"><?= $row['nama_alat']; ?></td>
                        <td class="text-muted"><?= $row['tanggal_pinjam']; ?></td>
                        <td><?= $row['jumlah']; ?> Unit</td>
                        <td>
                            <span class="badge rounded-pill <?= $warna ?> badge-status">
                                <?= strtoupper($st); ?>
                            </span>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<footer class="text-center text-muted mt-5 py-4 border-top">
    <small>© 2026 Camping Rika - Official System</small>
</footer>

</body>
</html>