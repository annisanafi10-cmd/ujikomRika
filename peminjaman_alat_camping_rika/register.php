<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun | Camping Rika</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), 
                        url('https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80');
            background-size: cover;
            background-position: center;
            font-family: 'Poppins', sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
        }
        .register-card {
            background: rgba(255, 255, 255, 0.95);
            border: none;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            backdrop-filter: blur(10px);
        }
        .btn-register {
            background: #2e7d32;
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: 600;
            transition: 0.3s;
        }
        .btn-register:hover {
            background: #1b5e20;
            transform: translateY(-2px);
        }
        .form-control {
            border-radius: 10px;
            padding: 12px;
            border: 1px solid #ddd;
        }
        .form-control:focus {
            border-color: #2e7d32;
            box-shadow: 0 0 0 0.25 row rgba(46, 125, 50, 0.25);
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card register-card p-4">
                <div class="text-center mb-4">
                    <h3 class="fw-bold text-success mb-1">Buat Akun Baru</h3>
                    <p class="text-muted small">Bergabung dengan komunitas Camping Rika</p>
                </div>

                <?php if(isset($_GET['pesan']) && $_GET['pesan'] == 'gagal'): ?>
                    <div class="alert alert-danger small py-2">Pendaftaran gagal, coba lagi!</div>
                <?php endif; ?>

                <form action="cek_data.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" placeholder="Masukkan nama anda" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold">Alamat Email</label>
                        <input type="email" name="email" class="form-control" placeholder="nama@sekolah.com" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label small fw-bold">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required>
                    </div>

                    <button type="submit" name="register" class="btn btn-register btn-success w-100 mb-3 shadow">
                        Daftar Sekarang
                    </button>

                    <div class="text-center">
                        <span class="small text-muted">Sudah punya akun? </span>
                        <a href="index.php" class="small text-success fw-bold text-decoration-none">Login di sini</a>
                    </div>
                </form>
            </div>
            
            <p class="text-center text-white-50 mt-4 small">
                © 2026 Camping Rika - Official System
            </p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>