<?php
require "header.php";

if (!isset($_SESSION["pelanggan"])) {
    echo "<script>alert('Silahkan login terlebih dahulu'); location='login.php';</script>";
    exit();
}

$db = mysqli_connect("localhost", "root", "", "medistore");

$id_order = $_GET['id'];  // Mengambil ID Order dari URL
$id_pelanggan = $_SESSION['pelanggan']['id_pelanggan'];

// Ambil detail produk berdasarkan ID order
$sql_produk = "SELECT d.id_produk, p.nm_produk, p.gambar, d.jml_order, p.harga
               FROM tbl_detail_order d
               JOIN tbl_produk p ON d.id_produk = p.id_produk
               WHERE d.id_order = '$id_order'";
$result_produk = mysqli_query($db, $sql_produk);

// Ambil feedback yang sudah diberikan untuk produk dalam order
$sql_feedback = "SELECT f.id_produk, f.komentar, f.rating, p.nm_produk
                 FROM tbl_feedback f
                 JOIN tbl_produk p ON f.id_produk = p.id_produk
                 WHERE f.id_order = '$id_order' AND f.id_pelanggan = '$id_pelanggan'";
$result_feedback = mysqli_query($db, $sql_feedback);

if (!$result_produk) {
    echo "<div class='alert alert-danger'>Terjadi kesalahan: " . mysqli_error($db) . "</div>";
}
?>

<div class="container bg-white p-4 rounded mt-4">
    <h4>Rincian Produk - Order #<?= $id_order; ?></h4>

    <!-- Tabel Rincian Produk -->
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Gambar</th>
                <th>ID Produk</th>
                <th>Nama Produk</th>
                <th class="text-center">Jumlah</th>
                <th class="text-center">Harga per Produk</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            while ($produk = mysqli_fetch_assoc($result_produk)) {
            ?>
                <tr>
                    <td><?php echo $no; ?></td>
                    <td class="product-list-img">
                        <?php if ($produk['gambar'] != null): ?>
                            <img width="40" src="admin/assets/images/foto_produk/<?= $produk['gambar']; ?>" class="img-fluid" alt="Gambar Produk">
                        <?php endif; ?>
                    </td>
                    <td><?php echo $produk['id_produk']; ?></td>
                    <td><?php echo $produk['nm_produk']; ?></td>
                    <td class="text-center"><?php echo $produk['jml_order']; ?></td>
                    <td class="text-center"><?php echo number_format($produk['harga'], 0, ',', '.'); ?></td>
                </tr>
            <?php
                $no++;
            }
            ?>
        </tbody>
    </table>

    <hr>

    <!-- Menampilkan Feedback -->
    <h5>Feedback Produk</h5>
    <?php if (mysqli_num_rows($result_feedback) > 0): ?>
        <div class="list-group">
            <?php while ($feedback = mysqli_fetch_assoc($result_feedback)) { ?>
                <div class="list-group-item">
                    <h6><strong><?= $feedback['nm_produk']; ?></strong></h6>
                    <p><strong>Rating:</strong> <?= str_repeat("⭐", $feedback['rating']); ?> (<?= $feedback['rating']; ?>/5)</p>
                    <p><strong>Komentar:</strong></p>
                    <p><?= $feedback['komentar']; ?></p>
                </div>
            <?php } ?>
        </div>
    <?php else: ?>
        <div class="alert alert-warning">Belum ada feedback untuk produk ini.</div>
    <?php endif; ?>
</div>

<?php require "footer.php"; ?>