<?php
require "header.php";
if (!isset($_SESSION["pelanggan"])) {
    echo "<script>alert('Silahkan login terlebih dahulu'); location='login.php';</script>";
    exit();
}
$db = mysqli_connect("localhost", "root", "", "medistore");

$id_order = $_GET['id_order'];
$id_pelanggan = $_SESSION['pelanggan']['id_pelanggan'];

// Ambil semua produk dalam order ini
$sql_produk = "SELECT d.id_produk, p.nm_produk
               FROM tbl_detail_order d
               JOIN tbl_produk p ON d.id_produk = p.id_produk
               WHERE d.id_order = '$id_order'";
$result_produk = mysqli_query($db, $sql_produk);

// Jika form dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST['feedback'] as $id_produk => $fb) {
        $rating = $fb['rating'];
        $komentar = mysqli_real_escape_string($db, $fb['komentar']);

        // Cek apakah sudah pernah feedback
        $cek = mysqli_query($db, "SELECT * FROM tbl_feedback WHERE id_order='$id_order' AND id_produk='$id_produk'");
        if (mysqli_num_rows($cek) == 0) {
            $query = "INSERT INTO tbl_feedback (id_pelanggan, id_order, id_produk, komentar, rating)
                      VALUES ('$id_pelanggan', '$id_order', '$id_produk', '$komentar', '$rating')";
            mysqli_query($db, $query);
        }
    }

    echo "<script>alert('Terima kasih atas semua feedback Anda!'); location='orderan.php';</script>";
    exit;
}
?>

<div class="container bg-white rounded p-4 mt-5" style="margin-top: 100px;">
    <h4 class="mb-4">Berikan Feedback untuk Produk:</h4>
    <form method="POST">
        <?php while ($produk = mysqli_fetch_assoc($result_produk)): ?>
            <?php
            // Cek apakah produk sudah diberi feedback
            $id_produk = $produk['id_produk'];
            $cek_feedback = mysqli_query($db, "SELECT * FROM tbl_feedback WHERE id_order='$id_order' AND id_produk='$id_produk'");
            $sudah_feedback = mysqli_num_rows($cek_feedback) > 0;
            ?>
            <div class="border rounded p-3 mb-4">
                <h5><?= $produk['nm_produk']; ?></h5>

                <?php if ($sudah_feedback): ?>
                    <div class="alert alert-success mb-0 mt-2">
                        ✅ Feedback sudah diberikan untuk produk ini.
                    </div>
                <?php else: ?>
                    <div class="form-group mt-2">
                        <label>Rating:</label>
                        <select name="feedback[<?= $id_produk; ?>][rating]" class="form-control w-25" required>
                            <option value="">Pilih Bintang</option>
                            <option value="1">⭐</option>
                            <option value="2">⭐⭐</option>
                            <option value="3">⭐⭐⭐</option>
                            <option value="4">⭐⭐⭐⭐</option>
                            <option value="5">⭐⭐⭐⭐⭐</option>
                        </select>
                    </div>
                    <div class="form-group mt-2">
                        <label>Komentar:</label>
                        <textarea name="feedback[<?= $id_produk; ?>][komentar]" class="form-control" rows="3" required></textarea>
                    </div>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>

        <button type="submit" class="btn btn-success">Kirim Semua Feedback</button>
        <a href="orderan.php?id=<?= $id_order; ?>" class="btn btn-secondary ml-2">Kembali</a>
    </form>
</div>

<?php require "footer.php"; ?>
