<?php
require "koneksi.php"; 
require "header.php";

$query = "
    SELECT 
        p.ms_id_produk AS id_produk,
        p.ms_nm_produk AS nm_produk,
        p.ms_harga AS harga,
        p.ms_stok AS stok,
        p.ms_berat AS berat,
        p.ms_gambar AS gambar,
        p.ms_deskripsi AS deskripsi,
        k.nama_kategori,
        COALESCE(SUM(d.jml_order), 0) AS total_terjual
    FROM tbl_master_produk p
    LEFT JOIN tbl_kategori k ON p.ms_id_kategori = k.id_kategori
    LEFT JOIN tbl_detail_order d ON p.ms_id_produk = d.id_produk
    LEFT JOIN tbl_order o ON d.id_order = o.id_order AND o.status = 'Produk Diterima'
    GROUP BY p.ms_id_produk
";

$result = mysqli_query($db, $query);
if (!$result) {
    die("Query Error: " . mysqli_error($db));
}
?>

<div class="container mb-5">
    <h3 class="text-primary mt-5 mb-4"><strong>Data Produk</strong></h3>

    <div class="mb-3">
        <a href="tambah-produk-packindo.php" class="btn btn-success">
            <i class="fas fa-plus"></i> Tambah Produk
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped text-center">
            <thead class="bg-primary text-white">
                <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th>Image</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Berat</th>
                    <th>Terjual (Diterima)</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; while ($row = mysqli_fetch_assoc($result)) : ?>
                <tr>
                    <td><?= $no++; ?></td>
                    <td><?= htmlspecialchars($row['nm_produk']); ?></td>
                    <td><?= htmlspecialchars($row['nama_kategori']); ?></td>
                    <td>
                        <img src="assets/images/foto_produk/<?= htmlspecialchars($row['gambar']); ?>" width="70" height="70" alt="<?= htmlspecialchars($row['nm_produk']); ?>">
                    </td>
                    <td>Rp. <?= number_format($row['harga'], 0, ',', '.'); ?></td>
                    <td><?= (int)$row['stok']; ?></td>
                    <td><?= (int)$row['berat']; ?> gr</td>
                    <td class="text-success"><?= (int)$row['total_terjual']; ?> pcs</td>
                    <td><?= nl2br(htmlspecialchars($row['deskripsi'])); ?></td>
                    <td>
                        <a href="edit_produk.php?id=<?= htmlspecialchars($row['id_produk']); ?>" class="btn btn-warning btn-sm mb-1">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="hapus_produk.php?id=<?= htmlspecialchars($row['id_produk']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus produk ini?');">
                            <i class="fas fa-trash-alt"></i> Hapus
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require "footer.php"; ?>