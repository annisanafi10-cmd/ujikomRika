<?php
include 'koneksi.php';
session_start();

if($_SESSION['role'] == 'peminjam'){
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Proses Pengembalian - Camping Rika</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-success text-white">Daftar Alat Belum Kembali</div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Peminjam</th>
                        <th>Alat</th>
                        <th>Batas Kembali</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT peminjaman.*, tabel_user.nama, alat.nama_alat 
                            FROM peminjaman 
                            JOIN tabel_user ON peminjaman.id_user = tabel_user.id_user 
                            JOIN alat ON peminjaman.id_alat = alat.id_alat 
                            WHERE peminjaman.status = 'dipinjam'";
                    $query = mysqli_query($conn, $sql);
                    while($d = mysqli_fetch_array($query)){
                    ?>
                    <tr>
                        <td><?= $d['nama']; ?></td>
                        <td><?= $d['nama_alat']; ?></td>
                        <td><?= date('d/m/Y', strtotime($d['tanggal_kembali'])); ?></td>
                        <td><span class="badge bg-warning">Dipinjam</span></td>
                        <td>
                            <a href="pengembalian_proses.php?id=<?= $d['id_peminjaman']; ?>" class="btn btn-primary btn-sm">Proses Kembali</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>