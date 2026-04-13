<?php
session_start();
include 'koneksi.php';

// Cek apakah sudah login
if (!isset($_SESSION['id_user'])) { 
    header("location:index.php"); 
    exit(); 
}

// Ambil ID Alat dari URL (biar otomatis terpilih)
$id_pilihan = isset($_GET['id']) ? $_GET['id'] : '';

// PROSES LOGIN SIMPAN DATA
if (isset($_POST['gas_pinjam'])) {
    $id_user = $_SESSION['id_user'];
    $id_alat = $_POST['id_alat'];
    $jumlah  = $_POST['jumlah'];
    $tgl_pinjam = date('Y-m-d');
    
    // SOLUSI ERROR: Karena database kamu minta tanggal_kembali diisi (NOT NULL)
    // Kita isi sama dengan tanggal pinjam dulu sebagai tanda belum balik.
    $tgl_kembali_dummy = $tgl_pinjam; 

    // Ambil data alat untuk hitung harga & cek stok
    $res = mysqli_query($conn, "SELECT * FROM tabel_alat WHERE id_alat = '$id_alat'");
    $data_alat = mysqli_fetch_array($res);
    
    if ($jumlah > $data_alat['stok']) {
        echo "<script>alert('Stok sisa ".$data_alat['stok']." bebs, jangan banyak-banyak!'); window.history.back();</script>";
    } else {
        $total_bayar = $data_alat['harga_sewa_perhari'] * $jumlah;
        
        // Query Simpan - Sesuaikan urutan kolom tabel kamu
        $sql = "INSERT INTO tabel_peminjaman (id_alat, id_user, tanggal_pinjam, tanggal_kembali, total_harga, status, jumlah) 
                VALUES ('$id_alat', '$id_user', '$tgl_pinjam', '$tgl_kembali_dummy', '$total_bayar', 'dipinjam', '$jumlah')";
        
        if (mysqli_query($conn, $sql)) {
            // Potong Stok
            mysqli_query($conn, "UPDATE tabel_alat SET stok = stok - $jumlah WHERE id_alat = '$id_alat'");
            echo "<script>alert('Berhasil Pinjam! Total: Rp ".number_format($total_bayar,0,',','.')."'); window.location='dashboard_peminjam.php';</script>";
        } else {
            echo "Aduh Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Isi Form Pinjam | Camping Rika</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f0f4f1; min-height: 100vh; display: flex; align-items: center; justify-content: center; }
        .card-form { border: none; border-radius: 20px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); width: 100%; max-width: 450px; }
    </style>
</head>
<body>

<div class="card card-form p-4">
    <h4 class="text-center fw-bold text-success mb-4">📝 FORM PINJAM ALAT</h4>
    
    <form method="POST">
        <div class="mb-3">
            <label class="form-label small fw-bold">Alat yang Kamu Pilih</label>
            <select name="id_alat" class="form-select" required>
                <?php
                $tampil = mysqli_query($conn, "SELECT * FROM tabel_alat WHERE stok > 0");
                while($a = mysqli_fetch_array($tampil)){
                    $selected = ($a['id_alat'] == $id_pilihan) ? "selected" : "";
                    echo "<option value='".$a['id_alat']."' $selected>".$a['nama_alat']." (Stok: ".$a['stok'].")</option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label small fw-bold">Mau Pinjam Berapa?</label>
            <input type="number" name="jumlah" class="form-control" value="1" min="1" required>
        </div>

        <div class="p-3 bg-light rounded mb-4">
            <small class="text-muted d-block">Penting:</small>
            <small class="text-dark">• Total harga otomatis dihitung</small><br>
            <small class="text-dark">• Stok gudang otomatis berkurang</small>
        </div>

        <button type="submit" name="gas_pinjam" class="btn btn-success w-100 fw-bold py-2 mb-2">KONFIRMASI PINJAM</button>
        <a href="dashboard_peminjam.php" class="btn btn-link w-100 text-muted text-decoration-none small">Batal</a>
    </form>
</div>

</body>
</html>