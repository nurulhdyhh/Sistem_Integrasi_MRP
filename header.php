<?php 
    session_start();
    require "koneksi.php";
 ?>
<!DOCTYPE html>
<html lang="en" ng-app="myApp">

<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <!-- Font -->
    <link rel="stylesheet" href="assets/css/font-awesome-4.7.0/css/font-awesome.min.css">
    <!-- Owl carausel -->
    <link rel="stylesheet" href="assets/js/owl/owl.carousel.css">
    <link rel="stylesheet" href="assets/js/owl/owl.theme.css">
    <!-- Favicon -->
    <link rel="shortcut icon" href="assets/img/icon/logo.png">
    <link href="assets/css/material-design/css/materialdesignicons.css" rel="stylesheet" type="text/css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="assets/jquery/jquery.min.js"></script>
    <link rel="stylesheet" href="plugins/owlcarousel/owl.carousel.min.js">
    <link rel="stylesheet" href="plugins/owlcarousel/assets/owl.theme.default.min.css">
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-135974525-2"></script>

    <link href="plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />

<style>
    body {
        background-color: rgb(246, 245, 245);
    }

    .navbar {
        padding: 0px;
        margin: 0px;
        box-shadow: 0px 2px 5px grey;
    }

    .navbar-light .navbar-nav .nav-link {
        color: black;
        font-size: 15px;
        padding: 12px 20px;
        position: relative;
        transition: all 0.3s ease;
    }

    .navbar-light .navbar-nav .nav-link:hover {
        color: #0066FF;
        font-weight: 600;
    }

    .navbar-light .navbar-nav .nav-link::after {
        content: '';
        display: block;
        width: 0;
        height: 2px;
        background: #0066FF;
        transition: width 0.3s;
        position: absolute;
        bottom: 6px;
        left: 20%;
    }

    .navbar-light .navbar-nav .nav-link:hover::after {
        width: 60%;
    }

    .navbar .navbar-brand img {
        width: 80px;
        height: auto;
    }

    .navbar-btn {
        padding: 5px 15px;
        font-size: 14px;
    }

    /* Responsive adjustments */
    @media(max-width:1200px) {
        .navbar-nav li {
            font-size: 15px;
        }
    }

    @media(max-width:992px) {
        .navbar-toggler {
            margin: 10px 0px 10px 30px;
            border-color: #ff4f81;
        }

        .navbar-toggler:hover,
        .navbar-toggler:focus {
            background-color: white;
            border-color: #ff4f81;
        }

        .navbar-light {
            background-color: white;
        }

        .navbar-nav .nav-link {
            text-align: center;
            background-color: white;
        }

        .navbar-nav .nav-link:hover {
            background-color: #0066FF;
            color: white;
        }

        .navbar-nav .nav-link::after {
            display: none; /* hilangkan efek garis bawah di mobile */
        }
    }
</style>


    <title>Packindo</title>
</head>

<body>
    <header>
        <nav class="navbar fixed-top navbar-expand-lg navbar-light bg-white m-0 p-0">
            <div class="container pl-3 pr-3">
                <a class="navbar-brand" href="#">
                    <img src="assets/img/icon/logo.png" width="100" height="80" alt="">
                </a>

                <?php if (isset($_SESSION["pelanggan"])): ?>
                    <span class="mr-3 text-dark">
                        Selamat datang, <strong><?php echo $_SESSION["pelanggan"]["username"]; ?></strong>
                    </span>
                <?php endif; ?>

                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
                    aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-center" id="navbarNavDropdown">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Produk</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="tambah-kategori.php">Kategori Produk</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="shop.php">Shop</a>
                        </li>
                        <li class="nav-item">
                            <?php if (isset($_SESSION["pelanggan"])) {
                                echo "<a class='nav-link' href='orderan.php'>Orderan</a>";
                            } ?>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="profile.php">My Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link position-relative d-inline-block" href="cart.php" style="padding: 0 10px;">
                                <i class="mdi mdi-cart-outline text-primary" style="font-size: 20px;"></i>
                                <span id="cart-count" class="badge badge-danger position-absolute" style="top: -8px; right: -10px; font-size: 10px;">
                                    <?php echo isset($_SESSION['cart']) ? array_sum($_SESSION['cart']) : 0; ?>
                                </span>
                            </a>

                        </li>
                    </ul>
                </div>

                <?php if (isset($_SESSION["pelanggan"])) : ?>
                    <button class="btn btn-primary navbar-btn m-2" onclick="window.location.href='logout.php'">Logout</button>
                <?php else: ?>
                    <button class="btn btn-primary navbar-btn m-2" onclick="window.location.href='login.php'">Login</button>
                <?php endif ?>
            </div>
        </nav>
    </header>