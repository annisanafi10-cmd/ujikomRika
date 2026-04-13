<?php
session_start();
include 'koneksi.php';

// SATPAM: Izinkan Admin DAN Petugas untuk melihat laporan
if (!isset($_SESSION['role']) || ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'petugas')) {
    header("location:index.php?pesan=no_access");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Transaksi - Camping Rika</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        .container { margin-top: 50px; }
        .card { border-radius: 15px; border: none; }
        .table thead { background-color: #343a40; color: white; }
    </style>
</head>
<body>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">📜 Laporan Peminjaman</h2>
            <p class="text-muted">Daftar seluruh riwayat peminjaman alat camping.</p>
        </div>
        <div>
            <a href="cetak_laporan.php" target="_blank" class="btn btn-danger shadow-sm">🖨️ Cetak PDF / Print</a>
            <a href="dashboard_admin.php" class="btn btn-secondary shadow-sm">Kembali</a>
        </div>
    </div>

    <div class="card shadow p-4">
        <div class="table-responsive">
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Peminjam</th>
                        <th>Alat yang Dipinjam</th>
                        <th>Tanggal Pinjam</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    // Query untuk menggabungkan data peminjaman, user, dan alat
                    $sql = "SELECT p.*, u.nama, a.nama_alat 
                            FROM tabel_peminjaman p
                            JOIN tabel_user u ON p.id_user = u.id_user
                            JOIN tabel_alat a ON p.id_alat = a.id_alat
                            ORDER BY p.id_peminjaman DESC";
                    $query = mysqli_query($conn, $sql);

                    if (mysqli_num_rows($query) == 0) {
                        echo "<tr><td colspan='5' class='text-center text-muted'>Belum ada data transaksi.</td></tr>";
                    }

                    while ($row = mysqli_fetch_array($query)) {
                        // Pastikan nama kolom tanggal di DB kamu sesuai (tgl_pinjam atau tanggal)
                        $tgl = $row['tgl_pinjam'] ?? $row['tgl_peminjaman'] ?? '-';
                    ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><strong><?= $row['nama']; ?></strong></td>
                        <td><?= $row['nama_alat']; ?></td>
                        <td><?= $tgl; ?></td>
                        <td>
                            <?php if ($row['status'] == 'pending') : ?>
                                <span class="badge bg-warning text-dark">Menunggu</span>
                            <?php elseif ($row['status'] == 'dipinjam') : ?>
                                <span class="badge bg-primary">Sedang Dipinjam</span>
                            <?php else : ?>
                                <span class="badge bg-success">Sudah Kembali</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<footer class="text-center text-muted mt-5 py-4">
    <small>&copy; 2026 - Aplikasi Camping Rika (UKK)</small>
</footer>

</body>
</html>