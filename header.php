<?php 
    session_start();
    require "koneksi.php";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Packindo</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
    <!-- Material Design Icons -->
    <link href="assets/css/material-design/css/materialdesignicons.css" rel="stylesheet" />

    <!-- SweetAlert & jQuery -->
    <script src="assets/jquery/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <link rel="shortcut icon" href="assets/img/icon/logo.png" />
</head>
<body class="bg-light">

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-3 col-lg-2 d-md-block bg-white sidebar border-end min-vh-100 py-3">
            <div class="position-sticky px-3">
                <div class="text-center border-bottom pb-3 mb-4">
                    <a href="index.php" class="d-inline-block">
                        <img src="assets/img/icon/logo.png" alt="Logo" height="170" />
                    </a>
                </div>

                <?php if (isset($_SESSION["pelanggan"])): ?>
                    <div class="px-2 py-2 fs-5 fw-semibold mb-4 text-dark">
                    Selamat datang,<br />
                        <?php echo $_SESSION["pelanggan"]["username"]; ?>
                    </div>
                <?php endif; ?>

                <ul class="nav flex-column">
                    <li class="nav-item mb-3">
                        <a class="nav-link text-dark" href="index.php">
                            <i class="fas fa-box me-2"></i> Produk
                        </a>
                    </li>
                    <li class="nav-item mb-3">
                        <a class="nav-link text-dark" href="tambah-kategori.php">
                            <i class="fas fa-list me-2"></i> Kategori Produk
                        </a>
                    </li>
                    <li class="nav-item mb-3">
                        <a class="nav-link text-dark" href="shop.php">
                            <i class="fas fa-store me-2"></i> Shop
                        </a>
                    </li>
                    <?php if (isset($_SESSION["pelanggan"])): ?>
                        <li class="nav-item mb-3">
                            <a class="nav-link text-dark" href="orderan.php">
                                <i class="fas fa-clipboard-list me-2"></i> Orderan
                            </a>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item mb-3">
                        <a class="nav-link text-dark" href="profile.php">
                            <i class="fas fa-user me-2"></i> My Profile
                        </a>
                    </li>
                    <li class="nav-item mb-3">
                        <a class="nav-link d-flex justify-content-between align-items-center text-dark" href="cart.php">
                            <span><i class="mdi mdi-cart-outline text-primary me-2"></i> Keranjang</span>
                            <span class="badge bg-danger rounded-pill">
                                <?php echo isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0; ?>
                            </span>
                        </a>
                    </li>
                    <li class="nav-item mb-3">
                        <?php if (isset($_SESSION["pelanggan"])) : ?>
                            <a class="nav-link text-danger" href="logout.php">
                                <i class="mdi mdi-logout me-2"></i> Logout
                            </a>
                        <?php else: ?>
                            <a class="nav-link text-primary" href="login.php">
                                <i class="mdi mdi-login me-2"></i> Login
                            </a>
                        <?php endif ?>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main content -->
        <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
            <!-- Konten halaman dimulai di sini -->