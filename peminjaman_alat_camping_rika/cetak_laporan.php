<?php
session_start();
include 'koneksi.php';

// Tes sederhana: Kalau ini muncul, berarti koneksi aman
if (!$conn) { die("Koneksi ke database gagal!"); }

$sql = "SELECT p.*, u.nama, a.nama_alat 
        FROM tabel_peminjaman p
        JOIN tabel_user u ON p.id_user = u.id_user
        JOIN tabel_alat a ON p.id_alat = a.id_alat";
$query = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html>
<head><title>Tes Cetak</title></head>
<body>
    <h1>Laporan Peminjaman</h1>
    <table border="1" cellpadding="10" cellspacing="0" width="100%">
        <tr>
            <th>No</th>
            <th>Peminjam</th>
            <th>Alat</th>
            <th>Status</th>
        </tr>
        <?php $no=1; while($d = mysqli_fetch_array($query)) { ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= $d['nama']; ?></td>
            <td><?= $d['nama_alat']; ?></td>
            <td><?= $d['status']; ?></td>
        </tr>
        <?php } ?>
    </table>
    <script>window.print();</script>
</body>
</html>