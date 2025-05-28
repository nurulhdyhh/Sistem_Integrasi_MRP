<?php
session_start();
require "koneksi.php";

// Tambah jumlah produk
if (isset($_GET['tambah'])) {
    $id = $_GET['tambah'];
    $query = mysqli_query($db, "SELECT stok FROM tbl_produk WHERE id_produk='$id'");
    $data = mysqli_fetch_assoc($query);
    $stok = $data['stok'];

    if ($_SESSION['cart'][$id] < $stok) {
        $_SESSION['cart'][$id]++;
    } else {
        $_SESSION['error_stok'] = "Stok tidak mencukupi!";
    }
    header("Location: cart.php");
    exit();
}

// Kurangi jumlah produk
if (isset($_GET['kurang'])) {
    $id = $_GET['kurang'];
    if ($_SESSION['cart'][$id] > 1) {
        $_SESSION['cart'][$id]--;
    } else {
        unset($_SESSION['cart'][$id]);
    }
    header("Location: cart.php");
    exit();
}

// Tambah produk dari halaman produk
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['beli'])) {
    $id_produk = $_POST['id_produk'];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    $query = mysqli_query($db, "SELECT stok FROM tbl_produk WHERE id_produk='$id_produk'");
    $data = mysqli_fetch_assoc($query);
    $stok = $data['stok'];

    if (isset($_SESSION['cart'][$id_produk])) {
        if ($_SESSION['cart'][$id_produk] < $stok) {
            $_SESSION['cart'][$id_produk]++;
        } else {
            $_SESSION['error_stok'] = "Stok tidak mencukupi!";
        }
    } else {
        $_SESSION['cart'][$id_produk] = 1;
    }

    header("Location: cart.php");
    exit();
}

// Hapus produk
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    unset($_SESSION["cart"][$id]);
}

require "header.php";
?>

<style>
.banner .img {
    width: 100%;
    height: 250px;
    background-image: url('assets/img/alat3.jpg');
    padding: 0px;
    margin: 0px;
}
.img .box {
    height: 250px;
    background-color: rgb(41, 41, 41, 0.7);
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
    color: white;
    padding-top: 70px;
}
.box a {
    color: #0066FF;
}
.box a:hover {
    text-decoration: none;
    color: rgb(6, 87, 209);
}
</style>

<div class="banner mb-3">
    <div class="container-fluid img">
        <div class="container-fluid box">
            <h3>KERANJANG BELANJA</h3>
        </div>
    </div>
</div>

<div class="content">
    <div class="container bg-white rounded pb-4 pt-4">
        <div class="row">
            <div class="col-12">
                <?php if (isset($_SESSION['error_stok'])): ?>
                    <div class="alert alert-warning">
                        <?= $_SESSION['error_stok']; unset($_SESSION['error_stok']); ?>
                    </div>
                <?php endif; ?>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Gambar</th>
                            <th>Nama Produk</th>
                            <th class="text-center">Jumlah</th>
                            <th>Harga Satuan</th>
                            <th>Total Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $total_belanja = 0;

                        if (!empty($_SESSION["cart"])) :
                            foreach ($_SESSION["cart"] as $id_produk => $jumlah) :
                                $query = mysqli_query($db, "SELECT * FROM tbl_produk WHERE id_produk='$id_produk'");
                                $produk = mysqli_fetch_assoc($query);

                                $subharga = $produk['harga'] * $jumlah;
                                $total_belanja += $subharga;
                        ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><img src="admin/assets/images/foto_produk/<?= $produk['gambar']; ?>" width="50"></td>
                            <td><?= $produk['nm_produk']; ?></td>
                            <td class="text-center">
                                <a href="cart.php?kurang=<?= $id_produk; ?>" class="btn btn-sm btn-danger">-</a>
                                <?= $jumlah; ?>
                                <a href="cart.php?tambah=<?= $id_produk; ?>" class="btn btn-sm btn-success">+</a>
                            </td>
                            <td>Rp. <?= number_format($produk['harga']); ?></td>
                            <td>Rp. <?= number_format($subharga); ?></td>
                            <td><a href="cart.php?id=<?= $id_produk; ?>" class="btn btn-sm btn-outline-danger">Hapus</a></td>
                        </tr>
                        <?php
                            endforeach;
                        else :
                        ?>
                        <tr>
                            <td colspan="7" class="text-center">Keranjang belanja kosong</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                    <?php if (!empty($_SESSION["cart"])) : ?>
                    <tfoot>
                        <tr>
                            <th colspan="5" class="text-right">Total Belanja :</th>
                            <th colspan="2">Rp. <?= number_format($total_belanja); ?></th>
                        </tr>
                    </tfoot>
                    <?php endif; ?>
                </table>
            </div>
        </div>


        <div class="row mt-5">
            <div class="col-md-12">
                <a href="shop.php" class="btn btn-secondary"><i class="fa fa-cart-plus"></i> Lanjut Belanja</a>
                <?php
                if (empty($_SESSION["cart"])) {
                    echo "<a href='checkout.php' class='btn btn-primary disabled'>Checkout >></a>";
                } else {
                    echo "<button class='btn btn-primary' onclick='checkout();'>Checkout >></button>";
                    if (!isset($_SESSION["pelanggan"])) {
                        echo "<script>
                            function checkout() {
                                swal({
                                    title: 'Anda Belum Login',
                                    text: 'Silahkan Login terlebih dahulu!',
                                    icon: 'info',
                                    button: 'Login Sekarang',
                                }).then(okay => {
                                    if (okay) {
                                        window.location.href ='login.php';
                                    };
                                });
                            }
                        </script>";
                    } else {
                        echo "<script>
                            function checkout() {
                                window.location.href ='checkout.php';
                            }
                        </script>";
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>
