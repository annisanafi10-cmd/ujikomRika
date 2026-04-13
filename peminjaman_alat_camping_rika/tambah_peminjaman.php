<?php
session_start();
$conn = mysqli_connect("localhost","root","","peminjaman_alat_campingrikarpl4");
if(!$conn) die("Koneksi gagal: ".mysqli_connect_error());

// Cek session & role
if(!isset($_SESSION['id_user']) || ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'petugas')){
    header("Location: index.php");
    exit;
}

$error = '';
$success = '';

if(isset($_POST['submit'])){
    $nama = trim(mysqli_real_escape_string($conn,$_POST['nama']));
    $email = trim(mysqli_real_escape_string($conn,$_POST['email']));
    $no_hp = trim(mysqli_real_escape_string($conn,$_POST['no_hp']));
    $alamat = trim(mysqli_real_escape_string($conn,$_POST['alamat']));
    $password = md5($_POST['password']); // hash MD5
    $total_bayar = floatval($_POST['total_bayar']); // jumlah transaksi awal

    // Cek email sudah ada
    $cek = mysqli_query($conn,"SELECT * FROM users WHERE LOWER(email)=LOWER('$email')");
    if(mysqli_num_rows($cek) > 0){
        $error = "Email sudah terdaftar!";
    } else {
        // 1️⃣ Tambah peminjam ke users
        $sql_user = "INSERT INTO users (nama,email,no_hp,alamat,role,password) 
                     VALUES ('$nama','$email','$no_hp','$alamat','peminjam','$password')";
        if(mysqli_query($conn,$sql_user)){
            $id_user_baru = mysqli_insert_id($conn);

            // 2️⃣ Tambah peminjaman di tabel peminjaman
            $sql_peminjaman = "INSERT INTO peminjaman (id_user, tanggal_peminjaman, total)
                               VALUES ($id_user_baru, NOW(), $total_bayar)";
            if(mysqli_query($conn, $sql_peminjaman)){
                $id_peminjaman_baru = mysqli_insert_id($conn);

                // 3️⃣ Tambah transaksi awal di tabel_transaksi
                $sql_transaksi = "INSERT INTO tabel_transaksi (id_peminjaman, jumlah_bayar, tanggal_bayar)
                                  VALUES ($id_peminjaman_baru, $total_bayar, NOW())";
                if(mysqli_query($conn, $sql_transaksi)){
                    $success = "Peminjam, peminjaman, dan transaksi berhasil ditambahkan!";
                } else {
                    $error = "Transaksi gagal: ".mysqli_error($conn);
                }

            } else {
                $error = "Peminjaman gagal: ".mysqli_error($conn);
            }

        } else {
            $error = "Gagal menambahkan peminjam: ".mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Peminjam Baru</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body { font-family: Arial; background:#eef2f3; display:flex; justify-content:center; align-items:center; height:100vh; margin:0;}
        .box { background:white; padding:30px; border-radius:8px; box-shadow:0 0 12px rgba(0,0,0,0.2); width:95%; max-width:500px; }
        h2 { text-align:center; color:#2E8B57; margin-bottom:20px; }
        input, textarea { width:100%; padding:10px; margin:8px 0; border:1px solid #ccc; border-radius:4px; }
        button { width:100%; padding:10px; background:#2E8B57; color:white; border:none; border-radius:4px; cursor:pointer; margin-top:10px; }
        button:hover { background:#246B45; }
        .error { color:red; text-align:center; }
        .success { color:green; text-align:center; }
        a { display:block; margin-top:10px; text-align:center; text-decoration:none; color:#2E8B57; }
        a:hover { text-decoration:underline; }
    </style>
</head>
<body>
    <div class="box">
        <h2>Tambah Peminjam Baru</h2>

        <?php if($error){ echo "<div class='error'>$error</div>"; } ?>
        <?php if($success){ echo "<div class='success'>$success</div>"; } ?>

        <form method="post">
            <input type="text" name="nama" placeholder="Nama Lengkap" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="no_hp" placeholder="No. HP" required>
            <textarea name="alamat" placeholder="Alamat" required></textarea>
            <input type="password" name="password" placeholder="Password" required>
            <input type="number" step="0.01" name="total_bayar" placeholder="Jumlah Bayar Awal" required>
            <button type="submit" name="submit">Tambah Peminjam</button>
        </form>

        <a href="dashboard.php">← Kembali ke Dashboard</a>
    </div>
</body>
</html>