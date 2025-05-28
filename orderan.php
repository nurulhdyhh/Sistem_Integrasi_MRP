<?php 
include "header.php";

if (!isset($_SESSION["pelanggan"])) {
    echo "<script>alert('Silahkan Login Dulu');</script>";
    echo "<script>location='login.php';</script>";
    exit();
}

$id = $_SESSION['pelanggan']['id_pelanggan'];
$query = "SELECT * FROM tbl_order WHERE id_pelanggan='$id' ORDER BY tgl_order DESC";
$result = mysqli_query($db, $query);

// Proses konfirmasi produk diterima
if (isset($_GET['konfirmasi'])) {
    $id_konfirmasi = $_GET['konfirmasi'];
    $query_konfirmasi = "UPDATE tbl_order SET status = 'Produk Diterima' WHERE id_order = '$id_konfirmasi'";
    $result_konfirmasi = mysqli_query($db, $query_konfirmasi);

    if ($result_konfirmasi) {
        echo "<script>
            swal({
                title: 'Terima Kasih!',
                text: 'Produk telah dikonfirmasi diterima.',
                icon: 'success',
                button: false
            });
            setTimeout(function() {
                window.location.href = 'orderan.php';
            }, 2000);
        </script>";
    } else {
        echo "<script>alert('Gagal mengkonfirmasi pesanan');</script>";
    }
}

// Memproses pembatalan pesanan jika ada parameter 'cancel'
if (isset($_GET['cancel'])) {
    $id_order = $_GET['cancel'];

    $query_cancel = "UPDATE tbl_order SET status = 'Pesanan Dibatalkan' WHERE id_order = '$id_order'";
    $result_cancel = mysqli_query($db, $query_cancel);

    if ($result_cancel) {
        echo "<script>
            swal({
                title: 'Pesanan Dibatalkan',
                text: 'Pesanan Anda telah dibatalkan.',
                icon: 'success',
                button: false
            });
            setTimeout(function() {
                window.location.href = 'orderan.php';
            }, 2000);
        </script>";
    } else {
        echo "<script>alert('Gagal membatalkan pesanan');</script>";
    }
}

// Cek apakah ada order
if (mysqli_num_rows($result) == 0) {
    echo "<script type='text/javascript'>
        swal({
            title: 'Orderan Kosong',
            text: 'Silahkan Melakukan Pembelian Dulu!',
            icon: 'warning',
            dangerMode: true,
        }).then(okay => {
            if (okay) {
                window.location.href ='shop.php';
            };
        });
    </script>";
    require "footer.php";
    exit();
}
?>

<style>
  /* Lebarkan container pembungkus dan tambahkan padding */
  .container-fluid.bg-white {
    max-width: 100% !important;
    padding-left: 20px;
    padding-right: 20px;
  }

  /* Membuat tabel bisa scroll horizontal jika kurang lebar */
  .table-responsive {
    overflow-x: auto;
  }

  /* Set minimal lebar tabel supaya kolom-kolom lega */
  #datatable {
    min-width: 1200px;
  }

  /* Minimal lebar tiap kolom penting */
  #datatable th:nth-child(3), #datatable td:nth-child(3), /* Jumlah */
  #datatable th:nth-child(4), #datatable td:nth-child(4), /* Bank */
  #datatable th:nth-child(5), #datatable td:nth-child(5), /* Metode */
  #datatable th:nth-child(6), #datatable td:nth-child(6), /* Status */
  #datatable th:nth-child(7), #datatable td:nth-child(7), /* Total Harga */
  #datatable th:nth-child(8), #datatable td:nth-child(8), /* Total DP */
  #datatable th:nth-child(9), #datatable td:nth-child(9)  /* Aksi */
  {
    min-width: 130px;
  }
</style>

<div class="banner mb-3">
    <div class="container-fluid img">
        <div class="container-fluid box">
            <h3>RIWAYAT ORDERAN</h3>
        </div>
    </div>
</div>

<div class="container-fluid bg-white rounded pb-4 pt-4">
    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
                <table id="datatable" class="table table-striped dt-responsive nowrap table-vertical" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Jumlah</th>
                            <th>Bank</th>
                            <th>Metode</th>
                            <th class="text-center">Status</th>
                            <th>Total Harga</th>
                            <th>Total DP</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                       while ($data = mysqli_fetch_assoc($result)) {
    $id_order = $data['id_order'];
    $tgl = $data['tgl_order'];
    $status = $data['status'];
    $nama_bank = $data['nama_bank'];
    $metode = $data['metode_bayar'];
    $total_order = $data['total_order']; // Total harga produk saja
    $ongkir = $data['ongkir']; // Asumsi ada kolom ongkir di tbl_order

    // Atur nama bank
    if ($metode == 'postpaid') {
        $nama_bank = 'COD';
    }

    // Hitung jumlah produk
    $query2 = "SELECT SUM(jml_order) AS jml FROM tbl_detail_order WHERE id_order='$id_order'";
    $result2 = mysqli_query($db, $query2);
    $data2 = mysqli_fetch_assoc($result2);

    // Hitung total harga (produk + ongkir)
    $total_harga = $total_order + $ongkir;

    // Hitung Total DP (50% dari total harga jika metode DP)
    $total_dp = '-';
    if (strtoupper($metode) == 'DP') {
        $total_dp = $total_harga * 0.5;
    }
?>
<tr>
    <td><?= $no++ ?></td>
    <td><?= date("d F Y", strtotime($tgl)); ?></td>
    <td>
        <?= $data2['jml'] ?> Produk | 
        <a href="rincian-produk.php?id=<?= $id_order; ?>" class="badge badge-info">Lihat</a>
    </td>
    <td><?= $nama_bank ?: '-'; ?></td>
    <td><?= $metode; ?></td>
    <td class="text-center">
        <?php 
        if ($status == 'Belum Dibayar') {
            echo "<span class='badge badge-warning'>$status</span>";
        } elseif ($status == 'Sudah Dibayar') {
            echo "<span class='badge badge-secondary'>$status</span>";
        } elseif ($status == 'Menyiapkan Produk') {
            echo "<span class='badge badge-info'>$status</span>";
        } elseif ($status == 'Produk Dikirim') {
            echo "<span class='badge badge-danger'>$status</span><br>";
            echo "<span style='font-size: small;'>Resi: ".$data['no_resi']."</span>";
        } elseif ($status == 'Produk Diterima') {
            echo "<span class='badge badge-success'>$status</span>";
        } elseif ($status == 'Pesanan Ditolak') {
            echo "<span class='badge badge-dark'>$status</span>";
        } elseif ($status == 'Pesanan Dibatalkan') {
            echo "<span class='badge badge-danger'>$status</span>";
        }
        ?>
    </td>
    <td>Rp. <?= number_format($total_harga); ?></td>
    <td>
        <?= $total_dp === '-' ? '-' : 'Rp. ' . number_format($total_dp); ?>
    </td>
    <td class="text-left">
        <?php 
        if ($status == 'Belum Dibayar') {
            if ($metode == 'postpaid') {
                echo "<a href='nota-order.php?id=$id_order' class='btn btn-secondary btn-sm'>Lihat Nota</a> ";
                echo "<a href='orderan.php?cancel=$id_order' class='btn btn-danger btn-sm'>Cancel</a>";
            } else {
                echo "<a href='konfirmasi-pembayaran.php?id=$id_order' class='btn btn-warning btn-sm'>Konfirmasi Pembayaran</a> ";
                echo "<a href='orderan.php?cancel=$id_order' class='btn btn-danger btn-sm'>Cancel</a>";
            }
        } elseif (in_array($status, ['Sudah Dibayar', 'Menyiapkan Produk'])) {
            echo "<a href='nota-order.php?id=$id_order' class='btn btn-secondary btn-sm'>Lihat Nota</a>";
        } elseif ($status == 'Produk Dikirim') {
            echo "<a href='javascript:void(0)' onclick='validate$id_order()' class='btn btn-success btn-sm'>Konfirmasi Pesanan</a>";
            ?>
            <script>
                function validate<?= $id_order ?>() {
                    swal({
                        title: "Konfirmasi Pesanan",
                        text: "Apakah Anda sudah menerima produk ini?",
                        icon: "warning",
                        buttons: true,
                        dangerMode: false,
                    }).then((willConfirm) => {
                        if (willConfirm) {
                            window.location.href = "orderan.php?konfirmasi=<?= $id_order ?>";
                        }
                    });
                }
            </script>
            <?php
        } elseif ($status == 'Produk Diterima') {
            echo "<a href='nota-order.php?id=$id_order' class='btn btn-secondary btn-sm mb-1'>Lihat Nota</a><br>";
            $feedback_ditampilkan = false;
            $produk_dalam_order = mysqli_query($db, "
                SELECT d.id_produk, p.nm_produk
                FROM tbl_detail_order d
                JOIN tbl_produk p ON d.id_produk = p.id_produk
                WHERE d.id_order = '$id_order'
            ");
            while ($produk = mysqli_fetch_assoc($produk_dalam_order)) {
                if (!$feedback_ditampilkan) {
                    echo "<div class='mb-1'>";
                    echo "<a href='feedback.php?id_order=$id_order&id_produk=" . $produk['id_produk'] . "' class='btn btn-sm btn-primary'>Feedback</a>";
                    echo "</div>";
                    $feedback_ditampilkan = true;
                }
            }
        } elseif (in_array($status, ['Pesanan Ditolak', 'Pesanan Dibatalkan'])) {
            echo "<span class='text-muted'>Tidak ada aksi</span>";
        }
        ?>
    </td>
</tr>
<?php } ?>

                    </tbody>
                </table>
            </div> <!-- /.table-responsive -->
        </div>
    </div>
</div>

<?php require "footer.php"; ?>
