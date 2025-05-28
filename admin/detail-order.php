<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require "../koneksi.php";

// Validasi ID Order
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<div class='alert alert-danger'>ID order tidak ditemukan.</div>";
    exit;
}

$id_order = mysqli_real_escape_string($db, $_GET['id']);

// Ambil data order dan pelanggan
$query = "SELECT * FROM tbl_order o JOIN tbl_pelanggan p ON o.id_pelanggan = p.id_pelanggan WHERE id_order = '$id_order'";
$result = mysqli_query($db, $query);
if (!$result) {
    echo "<div class='alert alert-danger'>Query gagal: " . mysqli_error($db) . "</div>";
    exit;
}
$data = mysqli_fetch_assoc($result);
if (!$data) {
    echo "<div class='alert alert-warning'>Data tidak ditemukan.</div>";
    exit;
}

$tgl = $data['tgl_order'];
$status = $data['status'];
?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">

                <!-- Info Pelanggan dan Order -->
                <div class="info-section d-flex justify-content-between">
                    <div>
                        <p><strong>User ID:</strong> <?= $data['id_pelanggan'] ?></p>
                        <p><strong>Nama:</strong> <?= $data['nm_penerima'] ?></p>
                        <p><strong>Alamat:</strong> <?= $data['alamat'] ?></p>
                        <p><strong>No HP:</strong> <?= $data['telp'] ?></p>
                    </div>
                    <div>
                        <p><strong>Tanggal:</strong> <?= date("d-m-Y", strtotime($tgl)) ?></p>
                        <p><strong>ID Paypal:</strong> <?= $data['paypal_id'] ?? '-' ?></p>
                        <p><strong>Nama Bank:</strong> <?= $data['nama_bank'] ?? '-' ?></p>
                        <p><strong>Cara Bayar:</strong> <?= $data['metode_bayar'] ?? 'Prepaid' ?></p>
                    </div>
                </div>

                <!-- Status -->
                <div class="mt-4">
                    <address>
                        <strong>Status:</strong><br>
                        <?php 
                            switch ($status) {
                                case 'Belum Dibayar':
                                    echo "<span class='badge badge-warning'>$status</span>";
                                    break;
                                case 'Sudah Dibayar':
                                    echo "<span class='badge badge-secondary'>$status</span>";
                                    break;
                                case 'Menyiapkan Produk':
                                    echo "<span class='badge badge-info'>$status</span>";
                                    break;
                                case 'Produk Dikirim':
                                    echo "<span class='badge badge-danger'>$status</span><br>";
                                    echo "<small>Resi: {$data['no_resi']}</small>";
                                    break;
                                case 'Produk Diterima':
                                    echo "<span class='badge badge-success'>$status</span>";
                                    break;
                                default:
                                    echo $status;
                            }
                        ?>
                    </address>
                </div>

                <!-- Tabel Produk -->
                <table class="table mt-4">
                    <thead>
                        <tr>
                            <th scope="col">Gambar</th>
                            <th scope="col">Nama Produk</th>
                            <th scope="col">Harga</th>
                            <th scope="col" class="text-center">Jumlah</th>
                            <th scope="col" class="text-right">Subharga</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $subtotal = 0;
                        $qproduk = "SELECT * FROM tbl_detail_order d 
                                    JOIN tbl_produk p ON d.id_produk = p.id_produk 
                                    WHERE d.id_order = '$id_order'";
                        $rproduk = mysqli_query($db, $qproduk);
                        if (!$rproduk) {
                            echo "<tr><td colspan='5'>Gagal mengambil data produk: " . mysqli_error($db) . "</td></tr>";
                        } else {
                            while ($produk = mysqli_fetch_assoc($rproduk)) {
                                $gambar = !empty($produk['gambar']) && file_exists("assets/images/foto_produk/" . $produk['gambar']) ? $produk['gambar'] : "default.jpg";
                                $subtotal += $produk['subharga'];
                        ?>
                        <tr>
                            <td><img width="40" src="assets/images/foto_produk/<?= $gambar ?>" alt="produk" class="img-fluid"></td>
                            <td><?= $produk['nm_produk'] ?></td>
                            <td>Rp. <?= number_format($produk['harga']) ?></td>
                            <td class="text-center"><?= $produk['jml_order'] ?></td>
                            <td class="text-right">Rp. <?= number_format($produk['subharga']) ?></td>
                        </tr>
                        <?php
                            }
                        }
                        $pajak = $subtotal * 0.10;
                        $total_belanja = $subtotal + $pajak;
                        ?>
                        <tr>
                            <td colspan="3"></td>
                            <td class="text-center"><strong>Subtotal</strong></td>
                            <td class="text-right">Rp. <?= number_format($subtotal) ?></td>
                        </tr>
                        <tr>
                            <td colspan="3"></td>
                            <td class="text-center"><strong>Pajak (10%)</strong></td>
                            <td class="text-right">Rp. <?= number_format($pajak) ?></td>
                        </tr>
                        <tr>
                            <td colspan="3"></td>
                            <td class="text-center"><strong>Total Belanja</strong></td>
                            <td class="text-right">Rp. <?= number_format($total_belanja) ?></td>
                        </tr>
                    </tbody>
                </table>

                <a href="index.php?pages=order" class="btn btn-secondary">Kembali</a>
            </div>
        </div>
    </div>
</div>
