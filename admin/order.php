<?php
require "../koneksi.php";

// PROSES TERIMA / TOLAK / CANCEL / UPDATE STATUS

if (isset($_POST['kirim_produk'])) {
    $id_order = $_POST['id_order'];
    $no_resi = mysqli_real_escape_string($db, $_POST['no_resi']);

    $query = "UPDATE tbl_order SET status='Produk Dikirim', no_resi='$no_resi' WHERE id_order='$id_order'";
    mysqli_query($db, $query);

    header("Location: index.php?pages=order");
    exit;
}


if (isset($_GET['id']) && isset($_GET['aksi'])) {
    $id = $_GET['id'];
    $aksi = $_GET['aksi'];

    if ($aksi == 'terima') {
        $query = "UPDATE tbl_order SET status='Menyiapkan Produk' WHERE id_order='$id'";
    } elseif ($aksi == 'tolak') {
        $query = "UPDATE tbl_order SET status='Pesanan Ditolak' WHERE id_order='$id'";
    } elseif ($aksi == 'cancel') {  // Menambahkan aksi cancel
        $query = "UPDATE tbl_order SET status='Pesanan Dibatalkan' WHERE id_order='$id'";
    } elseif ($aksi == 'update_status' && isset($_GET['status'])) {  // Mengubah status dari Edit Orderan
        $status = $_GET['status'];
        if ($status == 'menyiapkan') {
            $query = "UPDATE tbl_order SET status='Menyiapkan Produk' WHERE id_order='$id'";
        } elseif ($status == 'dikirm') {
            $query = "UPDATE tbl_order SET status='Produk Dikirim' WHERE id_order='$id'";
        }
    }

    if (isset($query)) {
        mysqli_query($db, $query);
    }

    header("Location: index.php?pages=order");
    exit;
}

// QUERY TOTAL
$totalOrder = mysqli_fetch_assoc(mysqli_query($db, "SELECT COUNT(*) AS jml FROM tbl_order"));
$blmDibayar = mysqli_fetch_assoc(mysqli_query($db, "SELECT COUNT(*) AS jml FROM tbl_order WHERE status='Belum Dibayar'"));
$sudahDibayar = mysqli_fetch_assoc(mysqli_query($db, "SELECT COUNT(*) AS jml FROM tbl_order WHERE status='Sudah Dibayar'"));
$menyiapkanProduk = mysqli_fetch_assoc(mysqli_query($db, "SELECT COUNT(*) AS jml FROM tbl_order WHERE status='Menyiapkan Produk'"));
$produkDikirm = mysqli_fetch_assoc(mysqli_query($db, "SELECT COUNT(*) AS jml FROM tbl_order WHERE status='Produk Dikirim'"));
$diterima = mysqli_fetch_assoc(mysqli_query($db, "SELECT COUNT(*) AS jml FROM tbl_order WHERE status='Produk Diterima'"));
$dibatalkan = mysqli_fetch_assoc(mysqli_query($db, "SELECT COUNT(*) AS jml FROM tbl_order WHERE status='Pesanan Dibatalkan'"));
?>

<div class="row">
    <!-- Menampilkan Statistik -->
    <div class="col-md-6 col-lg-4 col-xl-2">
        <div class="mini-stat clearfix bg-white">
            <span class="font-40 text-primary mr-0 float-right"><i class="mdi mdi-cart-outline"></i></span>
            <div class="mini-stat-info">
                <h3 class="counter font-light mt-0"><?php echo number_format($totalOrder['jml']); ?></h3>
            </div>
            <p class=" mb-0 m-t-10 text-muted" style="font-size: small;">Total Order</p>
        </div>
    </div>
    <div class="col-md-6 col-lg-4 col-xl-2">
        <div class="mini-stat clearfix bg-white">
            <span class="font-40 text-success mr-0 float-right"><i class="mdi mdi-coin"></i></span>
            <div class="mini-stat-info">
                <h3 class="counter font-light mt-0"><?php echo number_format($blmDibayar['jml']); ?></h3>
            </div>
            <p class=" mb-0 m-t-10 text-muted" style="font-size: small;">Belum Dibayar</p>
        </div>
    </div>
    <div class="col-md-6 col-lg-4 col-xl-2">
        <div class="mini-stat clearfix bg-white">
            <span class="font-40 text-warning mr-0 float-right"><i class="mdi mdi-currency-usd"></i></span>
            <div class="mini-stat-info">
                <h3 class="counter font-light mt-0"><?php echo number_format($sudahDibayar['jml']); ?></h3>
            </div>
            <p class=" mb-0 m-t-10 text-muted" style="font-size: small;">Sudah Dibayar</p>
        </div>
    </div>
    <div class="col-md-6 col-lg-4 col-xl-2">
        <div class="mini-stat clearfix bg-white">
            <span class="font-40 text-info mr-0 float-right"><i class="mdi mdi-gift"></i></span>
            <div class="mini-stat-info">
                <h3 class="counter font-light mt-0"><?php echo number_format($menyiapkanProduk['jml']); ?></h3>
            </div>
            <p class=" mb-0 m-t-10 text-muted" style="font-size: small;">Menyiapkan Produk</p>
        </div>
    </div>
    <div class="col-md-6 col-lg-4 col-xl-2">
        <div class="mini-stat clearfix bg-white">
            <span class="font-40 text-danger mr-0 float-right"><i class="mdi mdi-airplane-takeoff"></i></span>
            <div class="mini-stat-info">
                <h3 class="counter font-light mt-0"><?php echo number_format($produkDikirm['jml']); ?></h3>
            </div>
            <p class=" mb-0 m-t-10 text-muted" style="font-size: small;">Produk Dikirim</p>
        </div>
    </div>
    <div class="col-md-6 col-lg-4 col-xl-2">
        <div class="mini-stat clearfix bg-white">
            <span class="font-40 text-success mr-0 float-right"><i class="mdi mdi-home"></i></span>
            <div class="mini-stat-info">
                <h3 class="counter font-light mt-0"><?php echo number_format($diterima['jml']); ?></h3>
            </div>
            <p class=" mb-0 m-t-10 text-muted" style="font-size: small;">Produk Diterima</p>
        </div>
    </div>
</div>

<!-- TABLE -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table id="datatable" class="table table-striped dt-responsive nowrap table-vertical" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Penerima</th>
                            <th>Tanggal Order</th>
                            <th>Status</th>
                            <th>Metode Bayar</th> 
                            <th>Nama Bank</th>     
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $query = "SELECT * FROM tbl_order ORDER BY id_order DESC";
                        $result = mysqli_query($db, $query);
                        while ($data = mysqli_fetch_assoc($result)) {
                            $tgl = $data['tgl_order'];
                            $status = $data['status'];
                        ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo $data['nm_penerima']; ?></td>
                                <td><?php echo date("d/m/Y", strtotime($tgl)); ?></td>
                                <td>
                                    <?php
                                    $badgeClass = [
                                        'Belum Dibayar' => 'badge-warning',
                                        'Sudah Dibayar' => 'badge-secondary',
                                        'Menyiapkan Produk' => 'badge-info',
                                        'Produk Dikirim' => 'badge-danger',
                                        'Produk Diterima' => 'badge-success',
                                        'Pesanan Ditolak' => 'badge-dark',
                                        'Pesanan Dibatalkan' => 'badge-danger'  // Menambahkan class untuk pesanan dibatalkan
                                    ];
                                    $class = $badgeClass[$status] ?? 'badge-light';
                                    echo "<span class='badge $class'>$status</span>";
                                    ?>
                                </td>
                                <td><?php echo $data['metode_bayar']; ?></td> 
                                <td><?php echo $data['nama_bank']; ?></td>    
                                <td>
                                    <?php
                                    $totalDenganPajak = $data['total_order'] + $data['pajak'];
                                    echo "Rp. " . number_format($totalDenganPajak);
                                    ?>
                                </td>

                               <td>
                                    <a href="index.php?pages=detail-order&id=<?php echo $data['id_order']; ?>" class="m-r-15 text-muted" data-toggle="tooltip" title="Detail">
                                        <i class="mdi mdi-buffer font-18"></i>
                                    </a>

                                    <?php if ($status == 'Sudah Dibayar' || $status == 'Belum Dibayar') { ?>
                                        <a href="order.php?id=<?php echo $data['id_order']; ?>&aksi=terima" class="btn btn-success btn-sm" onclick="return confirm('Yakin ingin menerima pesanan ini?')">Terima</a>
                                        <a href="order.php?id=<?php echo $data['id_order']; ?>&aksi=tolak" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menolak pesanan ini?')">Tolak</a>
                                    <?php } ?>

                                    <?php if ($status == 'Menyiapkan Produk') { ?>
                                        <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#modalResi<?php echo $data['id_order']; ?>">Produk Dikirim</button>
                                    <?php } ?>
                               </td>
                            </tr>

                            <!-- Modal Input Resi -->
                            <div class="modal fade" id="modalResi<?php echo $data['id_order']; ?>" tabindex="-1" role="dialog" aria-labelledby="modalResiLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <form action="order.php" method="POST">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title">Input Nomor Resi</h5>
                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                                    </div>
                                    <div class="modal-body">
                                    <input type="hidden" name="id_order" value="<?php echo $data['id_order']; ?>">
                                    <div class="form-group">
                                        <label>Nomor Resi</label>
                                        <input type="text" name="no_resi" class="form-control" required>
                                    </div>
                                    </div>
                                    <div class="modal-footer">
                                    <button type="submit" name="kirim_produk" class="btn btn-primary">Kirim Produk</button>
                                    </div>
                                </div>
                                </form>
                            </div>
                            </div>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
