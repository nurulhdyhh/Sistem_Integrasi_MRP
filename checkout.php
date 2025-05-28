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
                            <div class="form-group mb-3">
                                <label>Provinsi</label>
                                <select class="form-control" name="provinsi" id="provinsi" required onchange="updateOngkir()">
                                    <option value="">-- Pilih Provinsi --</option>
                                    <option value="Jawa Timur">Jawa Timur</option>
                                    <option value="Jawa Tengah">Jawa Tengah</option>
                                    <option value="Jawa Barat">Jawa Barat</option>
                                    <option value="DKI Jakarta">DKI Jakarta</option>
                                    <option value="Bali">Bali</option>
                                    <option value="Luar Jawa">Luar Jawa</option>
                                </select>
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
                $ongkir = 10000;
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
function toggleCustomUpload(show) {
    const divUpload = document.getElementById('uploadCustomDiv');
    divUpload.style.display = show ? 'block' : 'none';
}

function toggleBankSelection() {
    const pembayaran = document.getElementById('pembayaran').value;
    const bankDiv = document.getElementById('bankDiv');
    const namaBank = document.getElementById('nama_bank');
    const btnPesan = document.getElementById('btnPesan');
    const dpInfo = document.getElementById('dpInfo');

    if (pembayaran === 'lunas' || pembayaran === 'dp') {
        bankDiv.style.display = 'block';
        namaBank.required = true;
    } else {
        bankDiv.style.display = 'none';
        namaBank.required = false;
        namaBank.value = '';
    }

    if (pembayaran === 'dp') {
        dpInfo.style.display = 'block';
    } else {
        dpInfo.style.display = 'none';
    }

    // Aktifkan tombol hanya jika metode pembayaran sudah dipilih dan bank sudah diisi jika diperlukan
    if (pembayaran === '') {
        btnPesan.disabled = true;
    } else if ((pembayaran === 'lunas' || pembayaran === 'dp') && namaBank.value === '') {
        btnPesan.disabled = true;
    } else {
        btnPesan.disabled = false;
    }
}

document.getElementById('nama_bank').addEventListener('change', toggleBankSelection);
window.onload = function() {
    toggleBankSelection();
};
</script>

<?php 
if (isset($_POST['pesan'])) {
    $alamat = mysqli_real_escape_string($db, $_POST['alamat']);
    $paypal_id = mysqli_real_escape_string($db, $_POST['paypal_id']);
    $nama = mysqli_real_escape_string($db, $_POST['nama']);
    $no_telp = mysqli_real_escape_string($db, $_POST['no_telp']);
    $pembayaran = $_POST['pembayaran'];
    $provinsi = $_POST['provinsi'];
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
