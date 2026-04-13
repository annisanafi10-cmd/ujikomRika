<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['role']) || ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'petugas')) {
    header("location:index.php");
    exit();
}

// LOGIKA UPDATE STATUS
if (isset($_GET['id']) && isset($_GET['st'])) {
    $id = $_GET['id'];
    $st = $_GET['st']; // Isinya harus 'dipinjam', 'dikembalikan', atau 'dibatalkan'
    
    // Query update sesuai isi ENUM di screenshot kamu
    $update = mysqli_query($conn, "UPDATE tabel_peminjaman SET status='$st' WHERE id_peminjaman='$id'");
    
    if($update){
        header("location:konfirmasi_peminjaman.php?pesan=berhasil");
        exit();
    } else {
        die("Gagal: " . mysqli_error($conn));
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Konfirmasi Pinjam</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-5">
    <div class="container card shadow p-4 border-0 rounded-4">
        <div class="d-flex justify-content-between mb-4">
            <h3 class="fw-bold text-dark">✅ Konfirmasi Peminjaman</h3>
            <a href="dashboard_admin.php" class="btn btn-secondary px-4">Kembali</a>
        </div>

        <table class="table table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Siswa</th>
                    <th>Alat</th>
                    <th>Status Saat Ini</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Query JOIN untuk ambil data
                $sql = "SELECT p.*, u.nama, a.nama_alat 
                        FROM tabel_peminjaman p 
                        JOIN tabel_user u ON p.id_user = u.id_user 
                        JOIN tabel_alat a ON p.id_alat = a.id_alat 
                        WHERE p.status != 'dikembalikan'"; // Sembunyikan yang sudah balik
                $query = mysqli_query($conn, $sql);
                
                while($row = mysqli_fetch_array($query)) {
                ?>
                <tr>
                    <td><strong><?= $row['nama']; ?></strong></td>
                    <td><?= $row['nama_alat']; ?></td>
                    <td>
                        <span class="badge bg-info text-dark"><?= $row['status']; ?></span>
                    </td>
                    <td>
                        <a href="?id=<?= $row['id_peminjaman']; ?>&st=dipinjam" class="btn btn-success btn-sm px-3">Setujui (Dipinjam)</a>
                        
                        <a href="?id=<?= $row['id_peminjaman']; ?>&st=dikembalikan" class="btn btn-primary btn-sm px-3">Selesai (Dikembalikan)</a>
                        
                        <a href="?id=<?= $row['id_peminjaman']; ?>&st=dibatalkan" class="btn btn-danger btn-sm px-3">Batalkan</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>