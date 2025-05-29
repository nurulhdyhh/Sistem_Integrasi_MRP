<?php require "../koneksi.php"; ?>
<div class="row">
    <div class="col-6">
        <div class="card">
            <div class="card-body">
                <?php
                    $id_order = $_GET['id'];
                    $query = "SELECT * FROM tbl_pembayaran WHERE id_order='$id_order'";
                    $result = mysqli_query($db, $query);
                    $data = mysqli_fetch_assoc($result);
                ?>

                <table class="table">
                    <tr>
                        <th>Tanggal</th>
                        <td>
                            <?php 
                                echo isset($data['tgl_bayar']) 
                                    ? date("d/m/Y", strtotime($data['tgl_bayar'])) 
                                    : "-";
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th>Total</th>
                        <td>
                            <?php 
                                echo isset($data['jml_pembayaran']) 
                                    ? "Rp. " . number_format($data['jml_pembayaran']) 
                                    : "-";
                            ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div class="col-6">
        <div class="card">
            <div class="card-body">
                <form action="" method="post" id="form-status">
                    <div class="form-group">
                        <label class="control-label">Pilih Aksi</label>
                        <select class="form-control" name="status" id="statusSelect" required>
                            <option value="">- Pilih Aksi -</option>
                            <option value="Menyiapkan Produk">Terima Pembayaran</option>
                            <option value="Pesanan Ditolak">Tolak Pembayaran</option>
                        </select>
                    </div>

                    <div class="form-group" id="resiInput" style="display: none;">
                        <label for="resi">Masukkan Resi Pengiriman</label>
                        <input name="resi" type="text" class="form-control" placeholder="Resi Pengiriman">
                    </div>

                    <button type="submit" name="edit" class="btn btn-primary mt-3">Simpan</button>
                </form>

                <?php
                    if (isset($_POST['edit'])) {
                        $status = $_POST['status'];
                        $resi = isset($_POST['resi']) ? $_POST['resi'] : "";

                        if ($status == "Menyiapkan Produk") {
                            $queryUpdate = "UPDATE tbl_order SET status='$status', no_resi='$resi' WHERE id_order='$id_order'";
                        } else {
                            $queryUpdate = "UPDATE tbl_order SET status='$status', no_resi=NULL WHERE id_order='$id_order'";
                        }

                        if (mysqli_query($db, $queryUpdate)) {
                            echo "<script>alert('Status pesanan berhasil diubah menjadi $status');</script>";
                            echo "<script>location='index.php?pages=order';</script>";
                        } else {
                            echo "<script>alert('Terjadi kesalahan saat mengubah status.');</script>";
                        }
                    }
                ?>
            </div>
        </div>
    </div>
</div>

<!-- Script untuk toggle input resi -->
<script>
    document.getElementById("statusSelect").addEventListener("change", function () {
        var selected = this.value;
        var resiDiv = document.getElementById("resiInput");
        resiDiv.style.display = (selected === "Menyiapkan Produk") ? "block" : "none";
    });
</script>
