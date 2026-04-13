<?php
session_start();
include 'koneksi.php';
if (!isset($_SESSION['role']) || ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'petugas')) {
    header("location:index.php"); exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Kelola Alat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-5">
    <div class="container card shadow p-4">
        <div class="d-flex justify-content-between mb-4">
            <h3>📦 Stok Peralatan</h3>
            <a href="dashboard_admin.php" class="btn btn-secondary">Kembali</a>
        </div>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Nama Alat</th>
                    <th>Harga / Hari</th>
                    <th>Stok</th>
                    <th>Kondisi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $q = mysqli_query($conn, "SELECT * FROM tabel_alat");
                while($row = mysqli_fetch_array($q)) {
                ?>
                <tr>
                    <td><?= $row['nama_alat']; ?></td>
                    <td>Rp <?= number_format($row['harga_sewa_perhari']); ?></td>
                    <td><?= $row['stok']; ?></td>
                    <td><?= $row['kondisi']; ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>