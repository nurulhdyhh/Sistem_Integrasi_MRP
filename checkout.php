<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require "koneksi.php";
require "header.php";

if (!isset($_SESSION["pelanggan"]) || !isset($_SESSION["pelanggan"]['id_pelanggan'])) {
    echo "<script>location='pelanggan.php';</script>";
    exit;
} elseif (empty($_SESSION["cart"])) {
    echo "<script>location='index.php';</script>";
    exit;
}

$id_pelanggan = $_SESSION['pelanggan']['id_pelanggan'];
$ambil_user = mysqli_query($db, "SELECT * FROM tbl_pelanggan WHERE id_pelanggan = '$id_pelanggan'");
$data_user = mysqli_fetch_assoc($ambil_user);

if (!$data_user) {
    echo "<script>alert('Data pelanggan tidak ditemukan! Silakan login ulang.'); location='logout.php';</script>";
    exit;
}
?>
<style>
    .banner .img {
        width: 100%;
        height: 250px;
        background-image: url('assets/img/4.jpg');
        padding: 0px;
        margin: 0px;
        background-size: cover;
        background-position: center;
    }
    .img .box {
        height: 250px;
        background-color: rgba(41, 41, 41, 0.7);
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
    table.table-sm th, table.table-sm td {
        vertical-align: middle;
        padding: 8px 12px;
        border-top: 1px solid #dee2e6;
    }
    table.table-sm thead th {
        border-bottom: 2px solid #dee2e6;
    }
    .col-idproduk {
        width: 120px;
    }
    .col-jumlah {
        width: 80px;
        text-align: right;
    }
    .col-subharga {
        width: 140px;
        text-align: right;
    }
</style>

<div class="banner mb-3">
    <div class="container-fluid img">
        <div class="container-fluid box">
            <h3>Checkout</h3>
            <p class="text-muted m-b-30 font-14">Home > <a href="#">Checkout</a></p>
        </div>
    </div>
</div>

<div class="content">
    <div class="container">
        <div class="row mb-3">
            <!-- Form Data Pengiriman -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h4>Data Pengiriman</h4>
                        <form action="" method="post" enctype="multipart/form-data" id="formPesan" novalidate>
                            <div class="form-group mb-3">
                                <label>User ID</label>
                                <input type="text" class="form-control" value="<?= htmlspecialchars($data_user['id_pelanggan']); ?>" readonly>
                            </div>
                            <div class="form-group mb-3">
                                <label>Alamat</label>
                                <textarea class="form-control" name="alamat" required><?= htmlspecialchars($data_user['alamat_pelanggan']); ?></textarea>
                            </div>
                            <div class="form-group mb-3">
                                <label>ID Paypal</label>
                                <input type="text" class="form-control" name="paypal_id" value="<?= htmlspecialchars($data_user['paypal_id']); ?>" required>
                            </div>
                            <div class="form-group mb-3">
                                <label>Nama</label>
                                <input type="text" class="form-control" name="nama" value="<?= htmlspecialchars($data_user['username']); ?>" required>
                            </div>
                            <div class="form-group mb-3">
                                <label>No Telp</label>
                                <input type="text" class="form-control" name="no_telp" value="<?= htmlspecialchars($data_user['no_telp']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">Provinsi</label>
                                <select name="province_destination" id="province_destination"
                                     class="all_province form-control" onchange="get_city_destination(this); updateOngkir();" required>
                                    <option value="">Pilih Provinsi</option>
                                </select>
                                <input type="hidden" name="nama_provinsi" id="nama_provinsi">

                            </div>

                            <div class="form-group mb-3">
                                <label>Barang Custom?</label><br>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="custom" id="customYes" value="iya" onclick="toggleCustomUpload(true)">
                                    <label class="form-check-label" for="customYes">Iya</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="custom" id="customNo" value="tidak" onclick="toggleCustomUpload(false)" checked>
                                    <label class="form-check-label" for="customNo">Tidak</label>
                                </div>
                            </div>

                            <!-- Upload gambar custom per produk -->
                            <div id="uploadCustomDiv" style="display:none; border:1px solid #ccc; padding:10px; border-radius:5px; margin-bottom:15px;">
                                <label><strong>Upload Design Custom per Produk (opsional)</strong></label>
                                <?php foreach ($_SESSION["cart"] as $id_produk => $jumlah): 
                                    $result = mysqli_query($db, "SELECT nm_produk FROM tbl_produk WHERE id_produk='$id_produk'");
                                    $produk = mysqli_fetch_assoc($result);
                                ?>
                                    <div class="form-group mb-2">
                                        <label for="gambar_custom_<?= htmlspecialchars($id_produk) ?>">
                                            <?= htmlspecialchars($produk['nm_produk']) ?> (ID: <?= htmlspecialchars($id_produk) ?>)
                                        </label>
                                        <input type="file" class="form-control-file" name="gambar_custom[<?= htmlspecialchars($id_produk) ?>]" id="gambar_custom_<?= htmlspecialchars($id_produk) ?>" accept="image/*">
                                    </div>
                                <?php endforeach; ?>
                                <small class="text-muted">Anda dapat mengupload gambar custom untuk salah satu atau beberapa produk saja.</small>
                            </div>

                            <div class="form-group mb-3">
                                <label>Metode Pembayaran</label>
                                <select class="form-control" name="pembayaran" id="pembayaran" required onchange="toggleBankSelection()">
                                    <option value="">-- Pilih Metode Pembayaran --</option>
                                    <option value="lunas">Lunas</option>
                                    <option value="dp">DP (50%)</option>
                                </select>
                            </div>
                            <div class="form-group mb-3" id="bankDiv" style="display: none;">
                                <label>Nama Bank</label>
                                <select class="form-control" name="nama_bank" id="nama_bank">
                                    <option value="">-- Pilih Bank --</option>
                                    <option value="BRI">Bank BRI</option>
                                    <option value="BCA">Bank BCA</option>
                                    <option value="MANDIRI">Bank Mandiri</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary" name="pesan" id="btnPesan" disabled>Buat Pesanan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Keranjang & Rincian Pembayaran -->
            <div class="col-md-6">
                <div class="card mb-3">
                    <div class="card-body">
                        <h5>Keranjang Belanja</h5>
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Gambar</th>
                                    <th class="col-idproduk">ID Produk</th>
                                    <th>Nama Produk</th>
                                    <th class="col-jumlah">Jumlah</th>
                                    <th class="col-subharga">Subharga</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $subtotal = 0;
                                foreach ($_SESSION["cart"] as $id_produk => $jumlah) :
                                    $result = mysqli_query($db, "SELECT * FROM tbl_produk WHERE id_produk='$id_produk'");
                                    $produk = mysqli_fetch_array($result);
                                    $subharga = $produk['harga'] * $jumlah;
                                    $subtotal += $subharga;
                                ?>
                                <tr>
                                    <td><img src="admin/assets/images/foto_produk/<?php echo htmlspecialchars($produk['gambar']); ?>" width="40" alt="Gambar Produk"></td>
                                    <td class="col-idproduk"><?php echo htmlspecialchars($produk['id_produk']); ?></td>
                                    <td><?php echo htmlspecialchars($produk['nm_produk']); ?></td>
                                    <td class="col-jumlah"><?php echo (int)$jumlah; ?></td>
                                    <td class="col-subharga">Rp. <?php echo number_format($subharga, 0, ',', '.'); ?></td>
                                </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <?php
               $nama_provinsi = isset($_POST['nama_provinsi']) ? strtolower($_POST['nama_provinsi']) : '';
               $ongkir = ($nama_provinsi === 'jawa timur') ? 10000 : 25000;
               $total_pembayaran = $subtotal + $ongkir;
               
                $konfirmasi_dp = $total_pembayaran * 0.5;
                ?>

                <div class="card">
                    <div class="card-body">
                        <h5>Rincian Pembayaran</h5>
                        <div class="row"><div class="col-6">Subtotal Produk</div><div class="col-6 text-right">Rp. <?= number_format($subtotal, 0, ',', '.'); ?></div></div>
                        <div class="row">
                        <div class="col-6">Ongkir</div>
                        <div class="col-6 text-right" id="ongkirDisplay">Rp. <?= number_format($ongkir, 0, ',', '.'); ?></div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-6"><strong>Total</strong></div>
                        <div class="col-6 text-right"><strong class="text-danger" id="totalDisplay">Rp. <?= number_format($total_pembayaran, 0, ',', '.'); ?></strong></div>
                    </div>

                        <div class="row mt-2" id="dpInfo" style="display:none;">
                            <div class="col-12 text-warning">
                                <small>Konfirmasi pembayaran DP (50%): <strong>Rp. <?= number_format($konfirmasi_dp, 0, ',', '.'); ?></strong></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $.getJSON("assets/checkout/province.php", function (all_province) {
            if (all_province) {
                $(".all_province").html("<option value=''>Pilih Provinsi</option>");
                $.each(all_province['rajaongkir']['results'], function (key, value) {
        $(".all_province").append(
            "<option value='" + value.province_id + "' data-name='" + value.province + "'>" + value.province + "</option>"
        );
    });

            }
        });
    });

    function get_city_destination(sel) {
        $.getJSON("assets/checkout/city.php?id=" + sel.value, function (get_city) {
            if (get_city) {
                $("#city_destination").html("<option value=''>Pilih Kota</option>");
                $.each(get_city['rajaongkir']['results'], function (key, value) {
                    $("#city_destination").append(
                        "<option value='" + value.city_id + "'>" + value.type + " - " + value
                        .city_name + "</option>"
                    );
                });
            }
        });
    }
</script>

<script>
function updateOngkir() {
    const provinsiSelect = document.getElementById('province_destination');
    const selectedOption = provinsiSelect.options[provinsiSelect.selectedIndex];
    const namaProvinsi = selectedOption.getAttribute('data-name');
    document.getElementById('nama_provinsi').value = namaProvinsi;

    let ongkir = 25000;
    if (namaProvinsi && namaProvinsi.toLowerCase() === 'jawa timur') {
        ongkir = 10000;
    }

    const subtotal = <?= $subtotal ?>;
    const total = subtotal + ongkir;
    const dp = total * 0.5;

    document.getElementById('ongkirDisplay').innerText = "Rp. " + ongkir.toLocaleString('id-ID');
    document.getElementById('totalDisplay').innerText = "Rp. " + total.toLocaleString('id-ID');

    const pembayaran = document.getElementById('pembayaran').value;
    const dpInfo = document.getElementById('dpInfo');
    if (pembayaran === 'dp') {
        dpInfo.style.display = 'block';
        dpInfo.querySelector('strong').innerText = "Rp. " + dp.toLocaleString('id-ID');
    } else {
        dpInfo.style.display = 'none';
    }

    validateForm(); // Perbarui status tombol Pesan
}

function toggleBankSelection() {
    const metode = document.getElementById("pembayaran").value;
    const bankDiv = document.getElementById("bankDiv");
    const dpInfo = document.getElementById("dpInfo");
    if (metode === "lunas" || metode === "dp") {
        bankDiv.style.display = "block";
        if (metode === "dp") {
            dpInfo.style.display = "block";
        } else {
            dpInfo.style.display = "none";
        }
    } else {
        bankDiv.style.display = "none";
        dpInfo.style.display = "none";
    }
    updateOngkir();
}

function toggleCustomUpload(status) {
    document.getElementById('uploadCustomDiv').style.display = status ? 'block' : 'none';
}

function validateForm() {
    const pembayaran = document.getElementById('pembayaran').value;
    const provinsi = document.getElementById('province_destination').value;
    const btnPesan = document.getElementById('btnPesan');

    if (pembayaran !== "" && provinsi !== "") {
        btnPesan.disabled = false;
    } else {
        btnPesan.disabled = true;
    }
}

document.getElementById('province_destination').addEventListener('change', validateForm);
document.getElementById('pembayaran').addEventListener('change', validateForm);
</script>

</script>

<?php 
if (isset($_POST['pesan'])) {
    $alamat = mysqli_real_escape_string($db, $_POST['alamat']);
    $paypal_id = mysqli_real_escape_string($db, $_POST['paypal_id']);
    $nama = mysqli_real_escape_string($db, $_POST['nama']);
    $no_telp = mysqli_real_escape_string($db, $_POST['no_telp']);
    $pembayaran = $_POST['pembayaran'];
    $provinsi = $_POST['province_destination'];
    $nama_bank = isset($_POST['nama_bank']) ? $_POST['nama_bank'] : '';
    $custom = isset($_POST['custom']) ? $_POST['custom'] : 'tidak';

    $gambar_custom_names = [];

    if ($custom === 'iya' && isset($_FILES['gambar_custom'])) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        foreach ($_FILES['gambar_custom']['name'] as $id_produk => $filename) {
            if ($_FILES['gambar_custom']['error'][$id_produk] === 0 && !empty($filename)) {
                $file_type = $_FILES['gambar_custom']['type'][$id_produk];
                if (in_array($file_type, $allowed_types)) {
                    $folder = 'upload/custom/';
                    if (!is_dir($folder)) {
                        mkdir($folder, 0755, true);
                    }
                    $ext = pathinfo($filename, PATHINFO_EXTENSION);
                    $new_filename = time() . "_{$id_produk}." . $ext;
                    $tmp_name = $_FILES['gambar_custom']['tmp_name'][$id_produk];
                    if (move_uploaded_file($tmp_name, $folder . $new_filename)) {
                        $gambar_custom_names[$id_produk] = $new_filename;
                    }
                } else {
                    echo "<script>alert('File gambar custom untuk produk ID $id_produk harus berupa JPG, PNG, atau GIF');</script>";
                    exit;
                }
            }
        }
    }

    $subtotal = 0;
    foreach ($_SESSION["cart"] as $id_produk => $jumlah) {
        $result = mysqli_query($db, "SELECT harga FROM tbl_produk WHERE id_produk='$id_produk'");
        $produk = mysqli_fetch_assoc($result);
        $subtotal += $produk['harga'] * $jumlah;
    }
    $ongkir = 10000;
    $total_pembayaran = $subtotal + $ongkir;

    $tgl_pesan = date("Y-m-d");
    $status = 'Belum Dibayar';
    $query_order = "INSERT INTO tbl_order (id_pelanggan, tgl_order, alamat, paypal_id, nm_penerima, telp, total_order, status, metode_bayar, nama_bank, barang_custom, ongkir, provinsi) 
    VALUES ('$id_pelanggan', '$tgl_pesan', '$alamat', '$paypal_id', '$nama', '$no_telp', '$total_pembayaran', '$status', '$pembayaran', '$nama_bank', '$custom', '$ongkir', '$provinsi')";
    $insert_order = mysqli_query($db, $query_order);

    if ($insert_order) {
        $id_order = mysqli_insert_id($db);
        foreach ($_SESSION["cart"] as $id_produk => $jumlah) {
            $ambil_produk = mysqli_query($db, "SELECT harga FROM tbl_produk WHERE id_produk='$id_produk'");
            $data_produk = mysqli_fetch_assoc($ambil_produk);
            $harga = $data_produk['harga'];
            $subharga = $harga * $jumlah;

            $gambar_custom_produk = isset($gambar_custom_names[$id_produk]) ? $gambar_custom_names[$id_produk] : null;
            $gambar_sql = $gambar_custom_produk ? "'$gambar_custom_produk'" : "NULL";

            $produk_info = mysqli_fetch_assoc(mysqli_query($db, "SELECT * FROM tbl_produk WHERE id_produk='$id_produk'"));
            $nm_produk = $produk_info['nm_produk'];
            $berat = $produk_info['berat'];
            $subberat = $berat * $jumlah;

            mysqli_query($db, "INSERT INTO tbl_detail_order (
                id_order, id_produk, nm_produk, harga, jml_order, berat, subberat, subharga, gambar_custom
            ) VALUES (
                '$id_order', '$id_produk', '".mysqli_real_escape_string($db, $nm_produk)."', '$harga', '$jumlah', '$berat', '$subberat', '$subharga', $gambar_sql
            )");
            }

        unset($_SESSION["cart"]);

        echo "<script>alert('Pesanan berhasil dibuat!');</script>";
        echo "<script>location='nota-order.php?id=$id_order';</script>";
        exit;
    } else {
        echo "<script>alert('Gagal membuat pesanan. Coba lagi.');</script>";
    }
}

require "footer.php";
?>