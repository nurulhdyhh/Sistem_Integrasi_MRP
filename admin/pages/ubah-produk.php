<?php require "../koneksi.php" ?>
<!-- Lihat Data Produk -->
<?php 
$id = $_GET['id'];
$queryProduk = "SELECT * FROM tbl_produk WHERE id_produk='$id' ";
$resultProduk = mysqli_query($db, $queryProduk);
$produk = mysqli_fetch_assoc($resultProduk);

//query menampilkan list kategori
$queryKat = "SELECT * FROM tbl_kat_produk";
$resultKat = mysqli_query($db, $queryKat);
?>

<?php
if (isset($_POST['ubah'])) {
    $kategori = $_POST['id_kategori'];
    $nmProduk = $_POST['nama'];
    $berat = $_POST['berat'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $deskripsi = $_POST['deskripsi'];  // Ambil data dari textarea

    // Pastikan input aman untuk disimpan ke database (mencegah SQL Injection)
    $deskripsi = mysqli_real_escape_string($db, $deskripsi);

    $nmGambar = $_FILES['img']['name'];
    $lokasi = $_FILES['img']['tmp_name'];

    if (!empty($lokasi)) {
        move_uploaded_file($lokasi, "assets/images/foto_produk/$nmGambar");

        $queryEdit = "UPDATE tbl_produk SET id_kategori='$kategori', nm_produk='$nmProduk', berat='$berat', harga='$harga', stok='$stok', gambar='$nmGambar', deskripsi='$deskripsi' WHERE id_produk='$id'";
        $resultEdit = mysqli_query($db, $queryEdit);
    }
    else {
        $queryEdit = "UPDATE tbl_produk SET id_kategori='$kategori', nm_produk='$nmProduk', berat='$berat', harga='$harga', stok='$stok', deskripsi='$deskripsi' WHERE id_produk='$id'";
        $resultEdit = mysqli_query($db, $queryEdit);
    }
    echo "<script>alert('Data produk sudah di ubah')</script>";
    echo "<script>location='index.php?pages=produk';</script>";
}
?>

<div class="row">
    <div class="col-12">
        <div class="card m-b-20">
            <div class="card-body">
                <form method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Nama Produk</label>
                                <input name="nama" type="text" class="form-control" value="<?php echo $produk['nm_produk']; ?>">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Kategori Produk</label>
                                <select class="form-control select2" name="id_kategori">
                                    <option>-- Pilih Kategori --</option>
                                    <?php while($pilih = mysqli_fetch_array($resultKat)): ?>
                                        <?php $active = ($produk['id_kategori'] == $pilih['id_kategori']) ? "selected" : ""; ?>
                                        <option value="<?php echo $pilih['id_kategori']?>" <?php echo $active ?>>
                                            <?php echo $pilih['nm_kategori']?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Berat Produk (gram)</label>
                                <input name="berat" type="text" class="form-control" value="<?php echo $produk['berat']; ?>">
                            </div>
                            <div class="form-group">
                                <label>Stok Produk</label>
                                <input name="stok" type="text" class="form-control" value="<?php echo $produk['stok']; ?>">
                            </div>
                            <div class="form-group">
                                <label>Harga Produk</label>
                                <input name="harga" type="text" class="form-control" value="<?php echo $produk['harga']; ?>">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Gambar Sebelumnya</label><br>
                                <?php if($produk['gambar']!=null): ?>
                                    <img src="assets/images/foto_produk/<?php echo $produk['gambar']; ?>" alt="product img" class="img-fluid" style="max-height: 125px;" />
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <label>Ganti Gambar</label>
                                <input type="file" class="filestyle" data-buttonname="btn-secondary" name="img">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Deskripsi Produk</label>
                                <!-- Textarea biasa untuk input deskripsi -->
                                <textarea name="deskripsi" class="form-control" rows="5"><?php echo htmlspecialchars($produk['deskripsi']); ?></textarea>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success waves-effect waves-light" name="ubah">Ubah</button>
                    <button type="button" class="btn btn-secondary waves-effect" onclick="window.location.href='index.php?pages=produk'">Batal</button>
                </form>
            </div>
        </div>
    </div>
</div>
