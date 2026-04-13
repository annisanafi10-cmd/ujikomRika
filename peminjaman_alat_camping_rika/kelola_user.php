<?php
session_start();
include 'koneksi.php';

// Proteksi: Hanya Admin yang boleh masuk ke sini
if ($_SESSION['role'] != 'admin') {
    header("location:dashboard_admin.php");
    exit();
}

// LOGIKA HAPUS USER
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    mysqli_query($conn, "DELETE FROM tabel_user WHERE id_user='$id'");
    header("location:kelola_user.php");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <title>Manajemen User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light py-5">
    <div class="container">
        <div class="card shadow border-0 p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold">Daftar User Sistem</h3>
                <a href="dashboard_admin.php" class="btn btn-secondary btn-sm">Kembali</a>
            </div>

            <table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $query = mysqli_query($conn, "SELECT * FROM tabel_user");
                    while($row = mysqli_fetch_array($query)) {
                    ?>
                    <tr>
                        <td><?= $row['nama']; ?></td>
                        <td><?= $row['email']; ?></td>
                        <td><span class="badge bg-info"><?= $row['role']; ?></span></td>
                        <td>
                            <a href="?hapus=<?= $row['id_user']; ?>" 
                               class="btn btn-danger btn-sm" 
                               onclick="return confirm('Yakin hapus user ini?')">Hapus</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>