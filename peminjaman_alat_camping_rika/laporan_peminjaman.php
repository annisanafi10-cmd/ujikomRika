<?php
include 'koneksi.php';
session_start();

// Hanya Admin dan Petugas yang bisa cetak laporan 
if($_SESSION['role'] == 'peminjam'){
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Laporan Peminjaman Alat - Camping Rika</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {
            .no-print { display: none; }
            @page { margin: 2cm; }
        }
    </style>
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-body p-5">
            <div class="text-center mb-4">
                <h2>LAPORAN PEMINJAMAN ALAT CAMPING</h2>
                <p>Periode: <?= date('d F Y'); ?></p>
                <hr>
            </div>

            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama Peminjam</th>
                        <th>Alat</th>
                        <th>Tgl Pinjam</th>
                        <th>Tgl Kembali</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    [cite_start]// Mengambil data dengan menggabungkan tabel user dan alat [cite: 51]
                    $sql = "SELECT peminjaman.*, tabel_user.nama, alat.nama_alat 
                            FROM peminjaman 
                            JOIN tabel_user ON peminjaman.id_user = tabel_user.id_user 
                            JOIN alat ON peminjaman.id_alat = alat.id_alat 
                            ORDER BY tanggal_pinjam DESC";
                    $query = mysqli_query($conn, $sql);
                    while($row = mysqli_fetch_array($query)){
                    ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $row['nama']; ?></td>
                        <td><?= $row['nama_alat']; ?></td>
                        <td><?= date('d/m/Y', strtotime($row['tanggal_pinjam'])); ?></td>
                        <td><?= date('d/m/Y', strtotime($row['tanggal_kembali'])); ?></td>
                        <td>Rp <?= number_format($row['total_harga'], 0, ',', '.'); ?></td>
                        <td><span class="badge bg-secondary"><?= strtoupper($row['status']); ?></span></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>

            <div class="mt-5 d-flex justify-content-between">
                <div class="text-center" style="width: 200px;">
                    <p>Mengetahui,</p>
                    <br><br><br>
                    <p><strong>( Admin Toko )</strong></p>
                </div>
                <div class="no-print pt-4">
                    <button onclick="window.print()" class="btn btn-success btn-lg">🖨️ Cetak Laporan</button>
                    <a href="dashboard_admin.php" class="btn btn-outline-secondary btn-lg">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>