<?php require "../koneksi.php"; ?>

<?php
$query = "SELECT * FROM tbl_produk JOIN tbl_kat_produk ON tbl_produk.id_kategori=tbl_kat_produk.id_kategori";
$result = mysqli_query($db, $query);

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query2 = "SELECT * FROM tbl_produk Where id_produk = '$id'";
    $exec = mysqli_query($db, $query2);
    $produk2 = mysqli_fetch_array($exec);
    $gambar = $produk2['gambar'];
    if (file_exists("assets/images/foto_produk/$gambar")) {
        unlink("assets/images/foto_produk/$gambar");
    }
    $queryHapus = "DELETE FROM tbl_produk WHERE id_produk='$id'";
    $execHapus = mysqli_query($db, $queryHapus);

    if ($execHapus) {
        echo "<script>alert('Produk sudah dihapus');</script>";
        echo "<script>location='index.php?pages=produk';</script>";
    }
}
?>

<div class="row">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-bottom">
                <h5 class="mb-0">Daftar Produk</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable" class="table table-hover table-bordered align-middle">
                        <thead class="table-light">
                            <tr class="text-center">
                                <th>No</th>
                                <th>ID Produk</th>
                                <th>Gambar</th>
                                <th>Nama Produk</th>
                                <th>Berat</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php while ($produk = mysqli_fetch_array($result)) : ?>
                            <tr>
                                <td class="text-center"><?php echo $no++; ?></td>
                                <td class="text-center"><?php echo $produk['id_produk']; ?></td>
                                <td class="text-center">
                                    <?php if ($produk['gambar']): ?>
                                        <img src="assets/images/foto_produk/<?php echo $produk['gambar']; ?>" width="80" class="img-thumbnail rounded" alt="Gambar Produk">
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td><strong><?php echo $produk['nm_produk']; ?></strong></td>
                                <td class="text-center"><?php echo number_format($produk['berat']); ?> gram</td>
                                <td class="text-center">Rp. <?php echo number_format($produk['harga']); ?></td>
                                <td class="text-center"><?php echo number_format($produk['stok']); ?></td>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-warning me-1 btn-edit-produk" data-id="<?php echo $produk['id_produk']; ?>">
                                        <i class="mdi mdi-pencil"></i>
                                    </button>
                                    <a href="index.php?pages=produk&id=<?php echo $produk['id_produk']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus produk tersebut?')">
                                        <i class="mdi mdi-delete"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Produk -->
<div class="modal fade" id="modalEditProduk" tabindex="-1" aria-labelledby="editProdukLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="formEditProduk" method="POST" action="edit-produk-handler.php" enctype="multipart/form-data">
        <div class="modal-header">
          <h5 class="modal-title" id="editProdukLabel">Edit Produk</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <input type="hidden" name="id_produk" id="edit_id_produk">
            <div class="mb-3">
                <label for="edit_nama" class="form-label">Nama Produk</label>
                <input type="text" class="form-control" name="nm_produk" id="edit_nama" required>
            </div>
            <div class="mb-3">
                <label for="edit_harga" class="form-label">Harga</label>
                <input type="number" class="form-control" name="harga" id="edit_harga" required>
            </div>
            <div class="mb-3">
                <label for="edit_berat" class="form-label">Berat (gram)</label>
                <input type="number" class="form-control" name="berat" id="edit_berat" required>
            </div>
            <div class="mb-3">
                <label for="edit_stok" class="form-label">Stok</label>
                <input type="number" class="form-control" name="stok" id="edit_stok" required>
            </div>
            <div class="mb-3">
                <label for="edit_gambar" class="form-label">Ganti Gambar (opsional)</label>
                <input type="file" class="form-control" name="gambar" id="edit_gambar">
            </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
$(document).on('click', '.btn-edit-produk', function () {
    const id = $(this).data('id');
    $.ajax({
        url: 'get-produk.php',
        method: 'GET',
        data: { id: id },
        dataType: 'json',
        success: function (data) {
            $('#edit_id_produk').val(data.id_produk);
            $('#edit_nama').val(data.nm_produk);
            $('#edit_harga').val(data.harga);
            $('#edit_berat').val(data.berat);
            $('#edit_stok').val(data.stok);
            const modal = new bootstrap.Modal(document.getElementById('modalEditProduk'));
            modal.show();
        },
        error: function () {
            alert('Gagal mengambil data produk.');
        }
    });
});
</script>
