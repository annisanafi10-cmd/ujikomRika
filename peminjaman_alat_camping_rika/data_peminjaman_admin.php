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
    <title>Laporan Transaksi | Camping Rika</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body { background: #f4f7f6; font-family: 'Segoe UI', sans-serif; }
        .navbar-custom { background: #1b5e20; color: white; }
        .card-table { border: none; border-radius: 15px; box-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        
        /* STYLE KHUSUS CETAK */
        @media print {
            .no-print, .btn, .navbar, .footer {
                display: none !important;
            }
            body { background: white !important; padding: 0; }
            .card-table { box-shadow: none; border: 1px solid #ddd; }
            .container { max-width: 100%; width: 100%; margin: 0; }
            .badge { color: black !important; border: 1px solid #ccc; background: none !important; }
            h4 { text-align: center; margin-bottom: 30px; }
        }
    </style>
</head>
<body>

<nav class="navbar navbar-custom p-3 mb-4 shadow-sm no-print">
    <div class="container">
        <span class="navbar-brand fw-bold text-white"><i class="bi bi-receipt-cutoff me-2"></i>ADMIN CAMPING RIKA</span>
        <a href="dashboard_admin.php" class="btn btn-outline-light btn-sm rounded-pill px-3">Dashboard</a>
    </div>
</nav>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">Laporan Transaksi Peminjaman Alat</h4>
            <p class="text-muted small no-print">Daftar semua penyewaan yang masuk ke sistem.</p>
        </div>
        
        <div class="no-print">
            <button onclick="window.print()" class="btn btn-dark rounded-pill px-4 fw-bold shadow-sm">
                <i class="bi bi-printer me-1"></i> Cetak Laporan (PDF)
            </button>
        </div>
    </div>

    <div class="card card-table overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4 py-3">No</th>
                            <th>Nama Siswa</th>
                            <th>Alat</th>
                            <th>Jumlah</th>
                            <th>Tgl Pinjam</th>
                            <th>Status</th>
                            <th class="text-center no-print">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        // Query JOIN untuk menarik data Siswa, Alat, dan Peminjaman
                        $sql = "SELECT p.*, a.nama_alat, u.nama as nama_siswa 
                                FROM tabel_peminjaman p
                                LEFT JOIN tabel_alat a ON p.id_alat = a.id_alat
                                LEFT JOIN tabel_user u ON p.id_user = u.id_user
                                ORDER BY p.id_peminjaman DESC";
                        
                        $query = mysqli_query($conn, $sql);

                        if (mysqli_num_rows($query) == 0) {
                            echo "<tr><td colspan='7' class='text-center py-5 text-muted'>Belum ada transaksi.</td></tr>";
                        }

                        while ($row = mysqli_fetch_array($query)) {
                            $st = strtolower($row['status']);
                            $badge = "bg-warning text-dark"; 
                            if ($st == 'dipinjam') $badge = "bg-primary text-white";
                            if ($st == 'kembali' || $st == 'dikembalikan') $badge = "bg-success text-white";
                        ?>
                        <tr>
                            <td class="ps-4"><?= $no++; ?></td>
                            <td>
                                <div class="fw-bold"><?= $row['nama_siswa'] ?? 'User ID: '.$row['id_user']; ?></div>
                                <small class="text-muted d-block" style="font-size: 10px;">User ID: <?= $row['id_user']; ?></small>
                            </td>
                            <td><?= $row['nama_alat'] ?? 'Alat ID: '.$row['id_alat']; ?></td>
                            <td><?= $row['jumlah']; ?> unit</td>
                            <td><?= $row['tanggal_pinjam']; ?></td>
                            <td><span class="badge <?= $badge ?> rounded-pill px-3" style="font-size: 10px;"><?= strtoupper($row['status']); ?></span></td>
                            <td class="text-center no-print">
                                <?php if ($st == 'dipinjam') : ?>
                                    <a href="proses_kembali.php?id=<?= $row['id_peminjaman']; ?>" class="btn btn-success btn-sm rounded-pill fw-bold" onclick="return confirm('Konfirmasi pengembalian?')">Selesai</a>
                                <?php else : ?>
                                    <span class="text-success small fw-bold"><i class="bi bi-check-circle"></i> Beres</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<footer class="text-center text-muted mt-5 py-4 no-print border-top">
    <small>&copy; 2026 Camping Rika - Transaction Report</small>
</footer>

</body>
</html>