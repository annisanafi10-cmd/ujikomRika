<?php
// Pastikan tidak ada spasi atau baris kosong sebelum tag PHP di atas!
include 'koneksi.php';

// Cek apakah tombol 'register' benar-benar diklik
if (isset($_POST['register'])) {
    
    // Ambil data dan bersihkan agar aman
    $nama     = mysqli_real_escape_string($conn, $_POST['nama']);
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $role     = 'peminjam'; // Otomatis jadi peminjam

    // 1. Cek apakah Email sudah pernah dipakai?
    $cek_dulu = mysqli_query($conn, "SELECT * FROM tabel_user WHERE email='$email'");
    
    if (mysqli_num_rows($cek_dulu) > 0) {
        // Kalau email sudah ada, balik ke register dengan pesan error
        header("location:register.php?pesan=email_sudah_ada");
        exit();
    } else {
        // 2. Jika email aman, baru kita INSERT
        $sql = "INSERT INTO tabel_user (nama, email, password, role) 
                VALUES ('$nama', '$email', '$password', '$role')";
        
        $simpan = mysqli_query($conn, $sql);

        if ($simpan) {
            // BERHASIL: Lempar ke index.php (Halaman Login)
            // Kasih exit() biar kodenya berhenti dan browser langsung pindah
            header("location:index.php?pesan=berhasil_daftar");
            exit(); 
        } else {
            // GAGAL INSERT: Tampilkan error biar kita tahu salahnya di mana
            echo "Gagal mendaftar: " . mysqli_error($conn);
        }
    }

} else {
    // Kalau orang iseng buka file ini tanpa ngeklik daftar, lempar balik
    header("location:register.php");
    exit();
}
?>