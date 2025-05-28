<?php
    include "../koneksi.php";
?>

<!-- Lihat Data Produk -->
<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $queryHapus = "DELETE FROM tbl_kat_produk WHERE id_kategori='$id'";
    $execHapus = mysqli_query($db, $queryHapus);

    if ($execHapus) {
        echo "<script>alert('Kategori sudah dihapus');</script>";
        echo "<script>location='index.php?pages=tambah-kategori';</script>";
    }
}
?>

<div class="row">
    <div class="col-6">
        <div class="card m-b-20">
            <div class="card-body">
                <form method="post">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="productname">Nama Kategori</label>
                                <input id="productname" name="nama" type="text" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-success waves-effect waves-light" name="tambah">Tambah</button>
                </form>

                <?php
                if (isset($_POST['tambah'])) {
                    $nama = $_POST['nama'];

                    // Ambil ID terakhir
                    $queryLastID = mysqli_query($db, "SELECT id_kategori FROM tbl_kat_produk ORDER BY id_kategori DESC LIMIT 1");
                    $dataLastID = mysqli_fetch_array($queryLastID);

                    if ($dataLastID) {
                        $lastID = $dataLastID['id_kategori']; // contoh: KTR-005
                        $num = (int)substr($lastID, 4) + 1;
                        $newID = 'KTR-' . str_pad($num, 3, '0', STR_PAD_LEFT);
                    } else {
                        $newID = 'KTR-001'; // jika belum ada data
                    }

                    // Simpan kategori baru dengan ID baru
                    $queryInsert = "INSERT INTO tbl_kat_produk (id_kategori, nm_kategori) VALUES ('$newID', '$nama')";
                    mysqli_query($db, $queryInsert);

                    echo "<script>alert('Kategori berhasil ditambahkan'); location='index.php?pages=tambah-kategori';</script>";
                }
                ?>
            </div>
        </div>
    </div>

    <div class="col-6">
        <div class="card m-b-20">
            <div class="card-body">
                <form>
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="productname">Kategori Produk</label><br>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Nama Kategori</th>
                                        <th scope="col">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    $ambil = $db->query("SELECT * FROM tbl_kat_produk");
                                    while ($pecah = $ambil->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <th scope="row"><?php echo $no; ?></th>
                                        <td><?php echo $pecah['nm_kategori'] ?></td>
                                        <td>
                                            <a href="index.php?pages=hapus-kategori&id=<?php echo $pecah['id_kategori']; ?>"
                                                class="text-muted" data-toggle="tooltip" data-placement="top"
                                                title="Hapus"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus Kategori tersebut?')">
                                                <i class="mdi mdi-close font-18"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <?php $no++; ?>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
