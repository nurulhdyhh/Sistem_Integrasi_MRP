<?php
session_start();
include "../koneksi.php";
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login - Supplier</title>
  <link rel="shortcut icon" href="assets/images/logo.png">

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
  <!-- SweetAlert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    body {
        background: #f8f9fa;
        font-family: 'Segoe UI', sans-serif;
    }
    .login-container {
        max-width: 400px;
        margin: 80px auto;
        padding: 30px;
        background-color: white;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        border-radius: 10px;
    }
    .form-control {
        background-color: #f1f1f1;
    }
    .form-control:focus {
        background-color: #fff;
        box-shadow: none;
        border-color: #0d6efd;
    }
    .login-header {
        text-align: center;
        margin-bottom: 25px;
    }
  </style>
</head>
<body>

<div class="login-container">
    <div class="login-header">
        <h3><i class="fa fa-user-circle"></i> Login Supplier</h3>
        <p class="text-muted">Masukkan username dan password Anda</p>
    </div>

    <form method="POST">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" name="u" id="username" required autofocus>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" name="p" id="password" required>
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="rememberMe">
            <label class="form-check-label" for="rememberMe">Ingat saya</label>
        </div>

        <button type="submit" name="login" class="btn btn-primary w-100">Masuk</button>
    </form>

    <?php
    if (isset($_POST['login'])) {
        $username = $_POST['u'];
        $password = $_POST['p'];

        // Sementara masih langsung query, disarankan ganti ke prepared statement
        $ambil = $db->query("SELECT * FROM tbl_admin WHERE username = '$username' AND password = '$password'");
        if ($ambil->num_rows == 1) {
            $_SESSION['tbl_admin'] = $ambil->fetch_assoc();
            echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Login berhasil!',
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = 'index.php?pages=dashboard';
                });
            </script>";
        } else {
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Username atau password salah!',
                    timer: 1800,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = 'login.php';
                });
            </script>";
        }
    }
    ?>
</div>

<!-- JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
