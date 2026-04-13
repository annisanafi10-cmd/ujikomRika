<?php
session_start();
include 'koneksi.php';

// Ambil ID dari URL
$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM tabel_alat WHERE id_alat='$id'");
$data = mysqli_fetch_array($query);

// Kalau ID gak ada, balik ke tampil
if(mysqli_num_rows($query) < 1){
    header("location:alat_tampil.php");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Alat | Camping Rika</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow border-0 rounded-4">
                <div class="card-header bg-success text-white fw-bold">Edit Data Alat</div>
                <div class="card-body">
                    <form action="proses_edit_alat.php" method="POST">
                        <input type="hidden" name="id_alat" value="<?= $data['id_alat']; ?>">

                        <div class="mb-3">
                            <label class="form-label small fw-bold">Nama Alat</label>
                            <input type="text" name="nama_alat" class="form-control" value="<?= $data['nama_alat']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Stok</label>
                            <input type="number" name="stok" class="form-control" value="<?= $data['stok']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Harga Sewa / Hari</label>
                            <input type="number" name="harga_sewa_perhari" class="form-control" value="<?= $data['harga_sewa_perhari']; ?>" required>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" name="update" class="btn btn-success px-4 fw-bold">Simpan Perubahan</button>
                            <a href="alat_tampil.php" class="btn btn-secondary px-4">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>