<?php
session_start();
// Proteksi: Hanya Petugas yang boleh masuk 
if($_SESSION['role'] != 'petugas') {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard Petugas - UKK 2026</title>
    <style>
        body { font-family: Arial; margin: 0; display: flex; }
        .sidebar { width: 250px; background: #27ae60; color: white; min-height: 100vh; padding: 20px; }
        .main { flex: 1; padding: 20px; }
        .menu-item { display: block; color: white; padding: 12px; text-decoration: none; margin-bottom: 5px; background: rgba(255,255,255,0.1); border-radius: 5px; }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Petugas Panel</h2>
        <hr>
        <a href="verifikasi_pinjam.php" class="menu-item">✅ Menyetujui Peminjaman</a>
        <a href="pantau_kembali.php" class="menu-item">⏳ Memantau Pengembalian</a>
        <a href="cetak_laporan.php" class="menu-item">🖨️ Mencetak Laporan</a>
        <br>
        <a href="logout.php" style="color: #f1c40f;">Logout</a>
    </div>
    <div class="main">
        <h1>Halo Petugas, <?php echo $_SESSION['nama']; ?>!</h1>
        [cite_start]<p>Tugas Anda hari ini: Verifikasi peminjaman dan pantau alat yang kembali[cite: 30].</p>
    </div>
</body>
</html>