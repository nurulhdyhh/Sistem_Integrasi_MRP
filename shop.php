<?php require "header.php"; ?>
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

    .atas .card {
        padding: 1px;
        border: 1px solid silver;
    }

    .item .card {
        width: 100%;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease-in-out;
    }

    .item .card:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    .card-body {
        padding: 1rem;
    }

    .item:hover {
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.5), 0 6px 20px 0 rgba(0, 0, 0, 0.4);
    }

    @media (min-width: 992px) {
        .col-lg-custom {
            flex: 0 0 20%;
            max-width: 20%;
        }
    }

    .btn-kategori {
        padding: 8px 16px;
        border-radius: 20px;
        color: white;
        text-decoration: none;
        font-size: 0.9rem;
        display: block;
        width: 100%;
        text-align: center;
        margin-bottom: 8px;
        transition: 0.3s ease;
    }

    .btn-kategori:hover {
        opacity: 0.9;
    }

    .btn-1 { background-color: #007bff; }
    .btn-2 { background-color: #28a745; }
    .btn-3 { background-color: #dc3545; }
    .btn-4 { background-color: #ffc107; color: black; }
    .btn-5 { background-color: #17a2b8; }
    .btn-6 { background-color: #6f42c1; }
</style>

<div class="banner mb-5">
    <div class="container-fluid img">
        <div class="container-fluid box">
            <h3>PRODUK PAGE</h3>
        </div>
    </div>
</div>

<div class="container-fluid px-4">
    <?php 
    if (isset($_GET['kategori'])) {
        $kategori = $_GET['kategori'];
        $query = "SELECT * FROM tbl_produk WHERE id_kategori='$kategori'";
    } elseif (isset($_GET['select'])) {
        $cari = $_GET['select'];
        $query = "SELECT * FROM tbl_produk WHERE nm_produk LIKE '%$cari%' ORDER BY id_produk asc";
    } else {
        $query = "SELECT * FROM tbl_produk p JOIN tbl_kat_produk k ON p.id_kategori=k.id_kategori ORDER BY id_produk asc";
    }
    ?>

    <div class="row">
        <!-- Sidebar Kategori di KIRI -->
        <div class="col-md-12 col-lg-4 col-xl-3">
            <div class="card pb-3" style="min-height: 500px;">
                <div class="card-body">
                    <h5>Nama Supplier:</h5>
                    <div class="kategori-wrapper">
                        <?php
                        $colors = ['btn-1', 'btn-2', 'btn-3', 'btn-4', 'btn-5', 'btn-6'];
                        $qkat = "SELECT * FROM tbl_kat_produk";
                        $reskat = mysqli_query($db, $qkat);
                        $i = 0;
                        while ($dat = mysqli_fetch_assoc($reskat)) {
                            $btnClass = $colors[$i % count($colors)];
                        ?>
                        <a href="shop.php?kategori=<?php echo $dat['id_kategori'] ?>" 
                            class="btn-kategori <?php echo $btnClass; ?>">
                            <?php echo $dat['nm_kategori']; ?>
                        </a>
                        <?php $i++; } ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Konten Produk di KANAN -->
        <div class="col-md-12 col-lg-8 col-xl-9">
            <div class="row">
                <div class="col-md-12 pl-5 text-secondary">
                    <?php 
                    if (isset($_GET['select'])) {
                        echo "<h4><i>Hasil pencarian : ".$_GET['select']."</i></h4>";
                    } elseif (isset($_GET['kategori'])) {
                        $kategori = $_GET['kategori'];
                        $query2 = "SELECT * FROM tbl_kat_produk WHERE id_kategori='$kategori'";
                        $results = mysqli_query($db, $query2);
                        $data = mysqli_fetch_assoc($results);
                        echo "<h4><i>Kategori : ".$data['nm_kategori']."</i></h4>";
                    }
                    ?>
                </div>
            </div>
            <div class="row">
                <?php
                $result = mysqli_query($db, $query);
                while ($produk = mysqli_fetch_assoc($result)) {
                ?>
                <div class="mb-3 px-2 col-6 col-md-4 col-lg-custom">
                    <div class="item card h-100 d-flex flex-column justify-content-between">
                        <div class="thumnail position-relative">
                            <img src="admin/assets/images/foto_produk/<?php echo $produk['gambar']; ?>" alt="img"
                                class="card-img-top pt-4">
                        </div>
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div class="mb-2">
                                <strong><?php echo $produk['nm_produk']; ?></strong><br>
                                <h6 class="text-danger">Rp. <?php echo number_format($produk['harga']); ?></h6>
                            </div>
                            <div class="row">
                                <!-- Tombol Lihat -->
                                <div class="col-6 mb-2">
                                    <a href="detail-produk.php?id=<?php echo $produk['id_produk']; ?>" class="btn btn-sm btn-info btn-block">
                                        <i class="fa fa-eye"></i> Lihat
                                    </a>
                                </div>
                                <!-- Tombol Beli -->
                                <div class="col-6 mb-2">
                                    <form method="post" action="cart.php" onsubmit="return checkLogin();">
                                        <input type="hidden" name="id_produk" value="<?php echo $produk['id_produk']; ?>">
                                        <button class="btn btn-sm btn-primary btn-block" name="beli">
                                            <i class="fa fa-cart-plus" aria-hidden="true"></i> Beli
                                        </button>
                                    </form>
                                </div>
                                <script type="text/javascript">
                                    function checkLogin() {
                                        <?php if (!isset($_SESSION["pelanggan"])) { ?>
                                            swal({
                                                title: 'Anda Belum Melakukan Register',
                                                text: 'Silahkan Melakukan Register Terlebih Dahulu!',
                                                icon: 'info',
                                                button: 'Register Sekarang',
                                            }).then(okay => {
                                                if (okay) {
                                                    window.location.href = 'signup.php';
                                                }
                                            });
                                            return false;
                                        <?php } else { ?>
                                            return true;
                                        <?php } ?>
                                    }
                                </script>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<?php require "footer.php"; ?>
