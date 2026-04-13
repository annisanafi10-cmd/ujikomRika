<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login | Camping Rika</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f4f7f6; font-family: 'Segoe UI', sans-serif; display: flex; align-items: center; height: 100vh; }
        .login-card { border: none; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card login-card p-4">
                <div class="text-center mb-4">
                    <h4 class="fw-bold text-success">CAMPING RIKA</h4>
                    <p class="text-muted small">Silakan login untuk memulainya</p>
                </div>

                <?php if(isset($_GET['pesan'])): ?>
                    <?php if($_GET['pesan'] == "berhasil_daftar"): ?>
                        <div class="alert alert-success small text-center py-2">
                            Akun berhasil dibuat! <br> Silakan login sekarang.
                        </div>
                    <?php elseif($_GET['pesan'] == "gagal"): ?>
                        <div class="alert alert-danger small text-center py-2">
                            Login gagal! Email atau password salah.
                        </div>
                    <?php endif; ?>
                <?php endif; ?>

                <form action="cek_login.php" method="POST">
                    <div class="mb-3">
                        <label class="small fw-bold">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="small fw-bold">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" name="login" class="btn btn-success w-100 fw-bold">Login</button>
                </form>

                <div class="text-center mt-3">
                    <span class="small text-muted">Belum punya akun? </span>
                    <a href="register.php" class="small text-success fw-bold text-decoration-none">Daftar</a>
                </div>
            </div>
            <p class="text-center text-muted mt-4 small">© 2026 Camping Rika - Official System</p>
        </div>
    </div>
</div>

</body>
</html>