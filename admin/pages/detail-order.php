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

<!-- Pastikan Bootstrap 5 CSS sudah disertakan di <head> utama -->

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <!-- Informasi Pelanggan -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="fw-bold">Informasi Pelanggan</h5>
                            <div class="row mb-2">
                                <label class="col-4 fw-bold">User ID</label>
                                <div class="col-8">: <?= $data['id_pelanggan'] ?></div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-4 fw-bold">Nama</label>
                                <div class="col-8">: <?= $data['nm_penerima'] ?></div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-4 fw-bold">Alamat</label>
                                <div class="col-8">: <?= $data['alamat'] ?></div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-4 fw-bold">No HP</label>
                                <div class="col-8">: <?= $data['telp'] ?></div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <h5 class="fw-bold">Detail Order</h5>
                            <div class="row mb-2">
                                <label class="col-4 fw-bold">Tanggal</label>
                                <div class="col-8">: <?= date("d-m-Y", strtotime($tgl)) ?></div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-4 fw-bold">ID Paypal</label>
                                <div class="col-8">: <?= $data['paypal_id'] ?? '-' ?></div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-4 fw-bold">Nama Bank</label>
                                <div class="col-8">: <?= $data['nama_bank'] ?? '-' ?></div>
                            </div>
                            <div class="row mb-2">
                                <label class="col-4 fw-bold">Cara Bayar</label>
                                <div class="col-8">: <?= $data['metode_bayar'] ?? 'Prepaid' ?></div>
                            </div>
                        </div>
                    </div>


                    <!-- Status -->
                    <div class="mb-4">
                        <h6 class="fw-bold">Status:</h6>
                        <?php 
                            switch ($status) {
                                case 'Belum Dibayar':
                                    echo "<span class='badge bg-warning text-dark'>$status</span>";
                                    break;
                                case 'Sudah Dibayar':
                                    echo "<span class='badge bg-secondary'>$status</span>";
                                    break;
                                case 'Menyiapkan Produk':
                                    echo "<span class='badge bg-info text-dark'>$status</span>";
                                    break;
                                case 'Produk Dikirim':
                                    echo "<span class='badge bg-danger'>$status</span><br><small>Resi: {$data['no_resi']}</small>";
                                    break;
                                case 'Produk Diterima':
                                    echo "<span class='badge bg-success'>$status</span>";
                                    break;
                                default:
                                    echo $status;
                            }
                        ?>
                    </div>

                    <!-- Tabel Produk -->
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Gambar</th>
                                    <th>Nama Produk</th>
                                    <th>Harga</th>
                                    <th class="text-center">Jumlah</th>
                                    <th class="text-end">Subharga</th>
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
                                    <td><img src="assets/images/foto_produk/<?= $gambar ?>" width="50" class="img-thumbnail" alt="produk"></td>
                                    <td><?= $produk['nm_produk'] ?></td>
                                    <td>Rp. <?= number_format($produk['harga']) ?></td>
                                    <td class="text-center"><?= $produk['jml_order'] ?></td>
                                    <td class="text-end">Rp. <?= number_format($produk['subharga']) ?></td>
                                </tr>
                                <?php } } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="4" class="text-end">Subtotal</th>
                                    <th class="text-end">Rp. <?= number_format($subtotal) ?></th>
                                </tr>
                                <tr>
                                    <th colspan="4" class="text-end">Ongkos Kirim</th>
                                    <th class="text-end">Rp. <?= number_format($pajak = $subtotal * 0.10) ?></th>
                                </tr>
                                <tr class="table-success">
                                    <th colspan="4" class="text-end">Total Belanja</th>
                                    <th class="text-end">Rp. <?= number_format($subtotal + $pajak) ?></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <a href="index.php?pages=order" class="btn btn-outline-secondary mt-3">← Kembali</a>

                </div>
            </div>
        </div>
    </div>
</div>

