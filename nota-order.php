<?php 
require "header.php"; 
include 'koneksi.php';

// Ambil ID pesanan dari URL
$id = $_GET['id']; 

// Ambil data order + email
$q  = "SELECT o.*, p.email_pelanggan 
       FROM tbl_order o
       JOIN tbl_pelanggan p ON o.id_pelanggan = p.id_pelanggan
       WHERE o.id_order = '$id'";
$res = mysqli_query($db, $q);
if (!$res || mysqli_num_rows($res) === 0) {
    die("Pesanan tidak ditemukan.");
}
$data = mysqli_fetch_assoc($res);
?>

<style>
    .nota-container {
        margin-top: 100px;
        padding: 30px;
        max-width: 800px;
        margin-left: auto;
        margin-right: auto;
        border: 2px solid black;
        background-color: white;
        position: relative;
    }

    .nota-header {
        text-align: center;
        margin-bottom: 50px;
    }

    .nota-header h3 {
        margin-bottom: 0;
    }

    .nota-header h5 {
        margin-top: 5px;
        font-weight: normal;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    table th, table td {
        border: 1px solid black;
        padding: 8px;
        text-align: center;
    }

    .info-section, .payment-section {
        display: flex;
        justify-content: space-between;
        margin-top: 15px;
    }

    .info-section div, .payment-section div {
        width: 48%;
    }

    .total {
        margin-top: 15px;
        font-weight: bold;
    }

    .text-right {
        text-align: right;
    }

    .signature-container {
        text-align: right;
        margin-top: 40px;
        display: flex;
        justify-content: flex-end;
        align-items: center;
        width: 100%;
    }

    .signature-container .signature {
        font-weight: bold;
        margin-right: 20px;
        font-size: 18px;
        max-width: 70%;
        white-space: nowrap;
    }

    .signature-container .logo-kanan-bawah img {
        width: 120px;
    }

    img.produk-img {
        max-width: 60px;
        max-height: 60px;
    }
</style>

<?php
// Menghitung total
$total = 0;
$ongkir = 10000; // Ongkir tetap atau bisa diambil dari database

$q2 = "SELECT d.*, p.nm_produk, p.harga, p.gambar
       FROM tbl_detail_order d 
       JOIN tbl_produk p ON d.id_produk = p.id_produk 
       WHERE d.id_order = '$id'";
$res2 = mysqli_query($db, $q2);
$produk_list = [];

while ($row = mysqli_fetch_assoc($res2)) {
    $subtotal = $row['harga'] * $row['jml_order'];
    $total += $subtotal;
    $produk_list[] = [
        'nama' => $row['nm_produk'],
        'jumlah' => $row['jml_order'],
        'harga' => $row['harga'],
        'gambar' => $row['gambar'],
        'subtotal' => $subtotal
    ];
}

$total_belanja = $total + $ongkir;
?>

<div class="nota-container" id="nota">
    <div class="nota-header">
        <h5>Laporan Belanja Anda</h5>
    </div>

    <div class="info-section">
        <div>
            <p>User ID: <?= $data['id_pelanggan'] ?></p>
            <p>Nama: <?= $data['nm_penerima'] ?></p>
            <p>Alamat: <?= $data['alamat'] ?></p>
            <p>No HP: <?= $data['telp'] ?></p>
        </div>
        <div>
            <p>Tanggal: <?= date("d-m-Y", strtotime($data['tgl_order'])) ?></p>
            <p>ID Paypal: <?= $data['paypal_id'] ?? '-' ?></p>
            <p>Nama Bank: <?= $data['nama_bank'] ?? '-' ?></p>
            <p>Cara Bayar: <?= $data['metode_bayar'] ?? 'Prepaid' ?></p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>Produk</th>
                <th>Gambar</th>
                <th>Harga Satuan</th>
                <th>Jumlah</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $no = 1;
                foreach ($produk_list as $p) {
            ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= $p['nama'] ?></td>
                <td><img src="assets/img/produk/<?= $p['gambar'] ?>" class="produk-img"></td>
                <td>Rp. <?= number_format($p['harga'], 0, ',', '.') ?></td>
                <td><?= $p['jumlah'] ?></td>
                <td>Rp. <?= number_format($p['subtotal'], 0, ',', '.') ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <div class="total text-left">
        Ongkir: <strong>Rp. <?= number_format($ongkir, 0, ',', '.') ?></strong><br>
        Total belanja (termasuk ongkir): <strong>Rp. <?= number_format($total_belanja, 0, ',', '.') ?></strong>
    </div>

    <div class="signature-container">
        <div style="margin-top: 4px; text-align: right;">
            <p>TANDA TANGAN TOKO</p>
            <img src="/MediStore/assets/img/icon/ttd.png" width="150">
        </div>
    </div>
</div>

<!-- Tombol Download PDF dan Kirim Email -->
<div style="text-align:center; margin-top:20px;">
    <a href="cetak_nota.php?id=<?= $id ?>" class="btn btn-primary">
        💾 Download & Kirim Nota (PDF)
    </a>
</div>
</div>
