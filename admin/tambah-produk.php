<?php include "../koneksi.php" ?>

<!-- Menampilkan Daftar Kategori Produk -->
<?php
	$query = "SELECT * FROM tbl_kat_produk";
	$result = mysqli_query($db, $query);
?>

<!-- Menambahkan Data Produk -->
<?php
if (isset($_POST['tambah'])) {
    $kategori = $_POST['id_kategori'];
    $nmProduk = $_POST['nama'];
    $berat = $_POST['berat'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $deskripsi = $_POST['deskripsi'];  // Mengambil deskripsi dari textarea
    $nmGambar = $_FILES['img']['name'];
    $lokasi = $_FILES['img']['tmp_name'];

    // Generate ID Produk Otomatis
    $query_id = "SELECT id_produk FROM tbl_produk ORDER BY id_produk DESC LIMIT 1";
    $result_id = mysqli_query($db, $query_id);
    $data_id = mysqli_fetch_array($result_id);

    if ($data_id) {
        $lastID = $data_id['id_produk']; // Contoh: PRD-005
        $num = (int)substr($lastID, 4) + 1;
        $newID = 'PRD-' . str_pad($num, 3, '0', STR_PAD_LEFT);
    } else {
        $newID = 'PRD-001'; // Jika belum ada data
    }

    if (!empty($lokasi)) { // Jika temporari tidak kosong
        // Memindah file gambar dari file temporari ke folder assets/images/foto_produk/
        move_uploaded_file($lokasi, "assets/images/foto_produk/" . $nmGambar);
        // Memasukkan data ke tabel tbl_produk
        $query_add = "INSERT INTO tbl_produk
                (id_produk, id_kategori, nm_produk, berat, harga, stok, gambar, deskripsi)
                VALUE('$newID', '$kategori', '$nmProduk', '$berat', '$harga', '$stok', '$nmGambar', '$deskripsi')";
        $exec_add = mysqli_query($db, $query_add);
        // Menampilkan pesan jika data berhasil dimasukkan
        echo "<p class='alert alert-success' role='alert'>
                Berhasil Menambahkan Data Produk.<br />
                <a href='index.php?pages=produk'>Lihat Semua Produk</a>
                </p>";
    } else { // Jika gambar belum dimasukkan
        echo "<p class='alert alert-danger' role='alert'>
                [Error] Upload Gambar Gagal.<br />
                </p>";
    }
};
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
								<input name="nama" type="text" class="form-control" required>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label">Kategori Produk</label>
								<select class="form-control select2" name="id_kategori" required>
									<option value="">Pilih Kategori</option>
									<?php while($pilih = mysqli_fetch_array($result)): ?>
										<option value="<?php echo $pilih['id_kategori']?>">
											<?php echo $pilih['nm_kategori']?>
										</option>
									<?php endwhile;?>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label>Berat Produk (gram)</label>
								<input name="berat" type="number" class="form-control" required>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label>Harga Produk</label>
								<input name="harga" type="number" class="form-control" required>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label>Stok Produk</label>
								<input name="stok" type="number" class="form-control" required>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label>Masukkan Gambar Produk</label>
								<input type="file" class="filestyle" data-buttonname="btn-secondary" name="img" required>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<label>Deskripsi Produk</label>
								<!-- Textarea biasa untuk input deskripsi -->
								<textarea name="deskripsi" class="form-control" rows="5" required></textarea>
							</div>
						</div>
					</div>
					<button type="submit" class="btn btn-success waves-effect waves-light" name="tambah">Tambah</button>
				</form>
			</div>
		</div>
	</div>
</div>
