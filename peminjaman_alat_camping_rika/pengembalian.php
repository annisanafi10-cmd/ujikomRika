<?php
include 'koneksi.php';

// Ambil ID peminjaman dari URL
if (isset($_GET['id'])) {
    $id_peminjaman = $_GET['id'];

    // 1. Cari dulu data peminjamannya buat tahu alat apa dan berapa jumlahnya
    $query_peminjaman = mysqli_query($conn, "SELECT * FROM tabel_peminjaman WHERE id_peminjaman = '$id_peminjaman'");
    $data = mysqli_fetch_array($query_peminjaman);

    if ($data) {
        $id_alat = $data['id_alat'];
        $jumlah  = $data['jumlah'];
        $tgl_kembali = date('Y-m-d');

        // 2. Update status jadi 'kembali' dan isi tanggal kembalinya
        $update_peminjaman = mysqli_query($conn, "UPDATE tabel_peminjaman SET 
                                                  status = 'kembali', 
                                                  tanggal_kembali = '$tgl_kembali' 
                                                  WHERE id_peminjaman = '$id_peminjaman'");

        if ($update_peminjaman) {
            // 3. PENTING: Tambahkan lagi stok alatnya ke tabel_alat
            mysqli_query($conn, "UPDATE tabel_alat SET stok = stok + $jumlah WHERE id_alat = '$id_alat'");

            echo "<script>alert('Alat Berhasil Dikembalikan! Stok Otomatis Bertambah.'); window.location='dashboard_admin.php';</script>";
        } else {
            echo "Gagal update status: " . mysqli_error($conn);
        }
    } else {
        echo "<script>alert('Data tidak ditemukan!'); window.location='dashboard_admin.php';</script>";
    }
} else {
    header("location:dashboard_admin.php");
}
?>