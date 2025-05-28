<?php 
require "header.php"; 

$id = $_GET['id'];

if (isset($id) && is_numeric($id)) {
    // Ambil data order berdasarkan id_order
    $query = "SELECT total_order, metode_bayar, konfirmasi_dp FROM tbl_order WHERE id_order='$id'";
    $result = mysqli_query($db, $query);
    if ($result && mysqli_num_rows($result) > 0) {
    $data = mysqli_fetch_assoc($result);
    $total_order = (int)$data['total_order'];
    $metode = strtolower($data['metode_bayar']);
    $konfirmasi_dp = (float)$data['konfirmasi_dp'];

    if ($metode === 'dp') {
        $jumlah_tagihan = $konfirmasi_dp > 0 ? $konfirmasi_dp : ($total_order * 0.5);
    } else {
        $jumlah_tagihan = $total_order;
    }
} else {
    echo "<p class='alert alert-danger'>Data tidak ditemukan!</p>";
    require "footer.php";
    exit;
}

} else {
    echo "<p class='alert alert-danger'>ID Pesanan Tidak Valid.</p>";
    require "footer.php";
    exit;
}
?>

<style>
.banner .img {
    width: 100%;
    height: 250px;
    background-image: url('assets/img/4.jpg');
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
</style>

<div class="banner mb-5">
    <div class="container-fluid img">
        <div class="container-fluid box">
            <h3>KONFIRMASI PEMBAYARAN</h3>
            <p>Home > <a href="#">Konfirmasi Pembayaran</a></p>
        </div>
    </div>
</div>

<div class="container mb-5">
    <div class="row">
        <!-- Form Konfirmasi -->
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-body">
                    <h4>Form Konfirmasi Pembayaran</h4>
                    <p>Silakan masukkan informasi pembayaran Anda di bawah ini.</p>

                    <?php
       if (isset($_POST['kirim'])) {
    $jml = (int)$_POST['jml_transfer'];
    $tgl = date('Y-m-d');

    if ($jml != (int)$jumlah_tagihan) {
        echo "<script type='text/javascript'>swal('Gagal', 'Jumlah yang Anda bayarkan tidak sesuai tagihan.', 'error');</script>";
    } else {
        // Simpan pembayaran & update status
        mysqli_query($db, "INSERT INTO tbl_pembayaran (id_order, jml_pembayaran, tgl_bayar)
                          VALUES('$id', '$jml', '$tgl')");

        mysqli_query($db, "UPDATE tbl_order SET status='Sudah Dibayar' WHERE id_order='$id'");

        echo "<script type='text/javascript'>
                swal({
                    title: 'Berhasil Konfirmasi',
                    text: 'Pembayaran telah dikonfirmasi.',
                    icon: 'success',
                    button: false
                });
            </script>";
        echo "<meta http-equiv='refresh' content='1.5;url=orderan.php'>";
    }
}

                    ?>

                    <form action="" method="post">
                        <div class="form-group">
                            <label class="font-weight-bold">Jumlah Transfer</label>
                            <input type="number" class="form-control" name="jml_transfer" required min="<?= (int)$jumlah_tagihan ?>">
                        </div>
                        <button class="btn btn-primary pl-5 pr-5" name="kirim">Kirim</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Info Tagihan -->
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-body alert-danger">
                    <p>Total Tagihan:</p>
                    <h1>Rp. <?= number_format($jumlah_tagihan, 0, ',', '.'); ?></h1>
                    <p class="mt-2 text-muted">Metode Pembayaran: <strong><?= strtoupper($metode); ?></strong></p>
                    <?php if ($metode === 'dp'): ?>
                        <small class="text-muted">* Tagihan ini adalah 50% dari total pembayaran Anda (DP).</small>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require "footer.php"; ?>
