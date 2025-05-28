<?php require "header.php"; ?>

<style>
    .row {
        margin-left: 0;
        margin-right: 0;
    }

    .row>[class^="col-"] {
        padding-left: 0;
        padding-right: 0;
    }

    #containt {
        margin-top: 80px;
    }

    .itemBig,
    .item1,
    .item2,
    .item3 {
        border: none;
        background-color: silver;
    }

    .itemBig:hover,
    .item1:hover,
    .item2:hover,
    .item3:hover {
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.3), 0 6px 20px 0 rgba(0, 0, 0, 0.2);
        border: none;
    }

    .star-rating li {
        padding: 0;
        margin: 0;
    }

    .star-rating i {
        font-size: 17px;
        color: #ffc000;
    }

    #btnDesc1 {
        padding: 12px 10px;
        width: 100%;
        border-radius: 0;
        color: white;
        background-color: #3498db;
        border-top: px solid #3498db;
    }

    #btnDesc1:hover,
    #btnDesc2:hover {
        background-color: rgb(83, 83, 83);
    }

    #btnDesc2 {
        padding: 10px 10px;
        width: 100%;
        border-radius: 0;
        color: white;
        background-color: silver;
        margin-top: 4px;
    }

    .dec {
        width: 100%;
        height: auto;
        border: 2px solid #3498db;
    }
</style>

<?php
    $id = $_GET['id'];
    $query = "SELECT * FROM tbl_produk WHERE id_produk='$id'";
    $result = mysqli_query($db, $query);
    $produk = mysqli_fetch_assoc($result);
?>

<div class="container bg-white rounded pt-4 pb-4" id="containt">
    <div class="row">
        <div class="col-md-5 col-sm-12">
            <div class="itemBig">
                <a href="admin/assets/images/foto_produk/<?php echo $produk['gambar']; ?>">
                    <img src="admin/assets/images/foto_produk/<?php echo $produk['gambar']; ?>" height="400px" width="100%">
                </a>
            </div>
        </div>
        <div class="col-md-7 col-sm-12 pt-3 pl-5">
            <h3><?php echo $produk['nm_produk']; ?></h3>
            <hr>
            <h3 class="text-danger"><span class="text-secondary" style="font-size: 15px">Harga : </span>Rp. <?php echo number_format($produk['harga']); ?></h3>
            <br>
            <p class="text-secondary font-weight-bold">
                <i class="fa fa-stop-circle-o text-success" aria-hidden="true"></i>
                <?php echo $produk['stok'] > 0 ? 'Stok Tersedia' : '<span class="text-danger">Stok Habis</span>'; ?>
            </p>
            <p class="text-danger">Tersisa <?php echo number_format($produk['stok']); ?> Unit</p>

            <form method="post">
                <div class="row">
                    <div class="col-3">
                        <h3><span class="text-secondary" style="font-size: 15px">Jumlah : </span></h3>
                        <div class="input-group spinner">
                            <button type="button" class="btn btn-primary btn-number pl-2 pr-2"
                                style="border-radius: 5px 0 0 5px;" id="minus-btn">
                                <i class="fa fa-minus"></i>
                            </button>
                            <input type="text" name="stok" id="qty_input" class="form-control input-number text-center"
                                value="1" min="1" max="<?php echo $produk['stok']; ?>" <?php if ($produk['stok'] <= 0) echo 'disabled'; ?>>
                            <button type="button" class="btn btn-primary btn-number pl-2 pr-2"
                                style="border-radius: 0 5px 5px 0;" id="plus-btn"><i class="fa fa-plus"></i>
                            </button>
                            <script>
                                $(function () {
                                    $('.spinner #plus-btn').on('click', function () {
                                        var btn = $(this);
                                        var input = btn.closest('.spinner').find('input');
                                        if (input.attr('max') == undefined || parseInt(input.val()) < parseInt(input.attr('max'))) {
                                            input.val(parseInt(input.val(), 10) + 1);
                                        }
                                    });
                                    $('.spinner #minus-btn').on('click', function () {
                                        var btn = $(this);
                                        var input = btn.closest('.spinner').find('input');
                                        if (input.attr('min') == undefined || parseInt(input.val()) > parseInt(input.attr('min'))) {
                                            input.val(parseInt(input.val(), 10) - 1);
                                        }
                                    });
                                });
                            </script>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-5">
                        <button class="btn btn-primary btn-block" name="beli" <?php if ($produk['stok'] <= 0) echo 'disabled'; ?>>
                            <i class="fa fa-cart-plus" aria-hidden="true"></i> Masukkan Keranjang
                        </button>
                    </div>
                    <div class="col-md-5">
                        <button class="btn btn-primary btn-block ml-3" name="beli2" <?php if ($produk['stok'] <= 0) echo 'disabled'; ?>>
                            <i class="fa fa-shopping-cart" aria-hidden="true"></i> Beli Sekarang
                        </button>
                    </div>
                </div>
        </div>
        </form>

        <?php
            if (isset($_POST['beli'])) {
                $jumlah = $_POST['stok'];
                if ($produk['stok'] <= 0) {
                    echo "<script type='text/javascript'>swal('Oops!', 'Stok produk habis, tidak bisa dimasukkan ke keranjang.', 'warning');</script>";
                } else {
                    if (isset($_SESSION['cart'][$id])) {
                        $_SESSION['cart'][$id] += $jumlah;
                    } else {
                        $_SESSION['cart'][$id] = $jumlah;
                    }
                    echo "<script type='text/javascript'>swal('', 'Produk Sudah Masuk Ke Keranjang Belanja', 'success');</script>";
                }
            } elseif (isset($_POST['beli2'])) {
                $jumlah = $_POST['stok'];
                if ($produk['stok'] <= 0) {
                    echo "<script type='text/javascript'>swal('Oops!', 'Stok produk habis, tidak bisa melakukan pembelian.', 'warning');</script>";
                } else {
                    if (isset($_SESSION['cart'][$id])) {
                        $_SESSION['cart'][$id] += $jumlah;
                    } else {
                        $_SESSION['cart'][$id] = $jumlah;
                    }
                    echo "<script>location='cart.php';</script>";
                }
            }
        ?>
    </div>
    <br>
    <hr>
    <div class="ProdukDesc">
        <div class="row">
            <div class="col-md-2">
                <button class="btn" id="btnDesc1">DESCRIPTIONS</button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 bg-light">
                <div class="dec pt-2 pb-2 pl-5 pr-5 text-justify">
                    <?php echo $produk['deskripsi']; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require "footer.php"; ?>
