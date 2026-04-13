<?php
include 'koneksi.php';
session_start();

// Cek apakah yang masuk benar-benar Admin 
if($_SESSION['role'] != 'admin'){
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Manajemen Kategori - Camping Rika</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">Tambah Kategori</div>
                <div class="card-body">
                    <form action="kategori_proses.php" method="POST">
                        <div class="mb-3">
                            <label class="form-label">Nama Kategori</label>
                            <input type="text" name="nama_kategori" class="form-control" placeholder="Misal: Tenda" required>
                        </div>
                        <button type="submit" name="btn_tambah" class="btn btn-primary w-100">Simpan Kategori</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm text-center">
                <div class="card-header bg-dark text-white">Daftar Kategori Alat</div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Kategori</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            $query = mysqli_query($conn, "SELECT * FROM kategori");
                            while($d = mysqli_fetch_array($query)){
                            ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $d['nama_kategori']; ?></td>
                                <td>
                                    <a href="kategori_proses.php?hapus=<?= $d['id_kategori']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus kategori ini?')">Hapus</a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>