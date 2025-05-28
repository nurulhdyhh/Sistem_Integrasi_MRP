<?php
// koneksi.php (bisa dipisah file, tapi saya sertakan di sini sederhana)
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'packindo';

$db = mysqli_connect($host, $user, $pass, $dbname);
if (!$db) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>

<?php
// Ambil data kategori untuk select option
$queryKategori = "SELECT * FROM tbl_kategori ORDER BY nama_kategori ASC";
$resultKategori = mysqli_query($db, $queryKategori);

// Proses tambah produk jika form disubmit
if (isset($_POST['tambah'])) {
    $kategori = $_POST['id_kategori'];
    $nmProduk = $_POST['nama'];
    $berat = $_POST['berat'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $deskripsi = $_POST['deskripsi'];
    $nmGambar = $_FILES['img']['name'];
    $lokasi = $_FILES['img']['tmp_name'];

    // Generate ID produk otomatis (contoh sederhana)
    $query_id = "SELECT ms_id_produk FROM tbl_master_produk ORDER BY ms_id_produk DESC LIMIT 1";
    $result_id = mysqli_query($db, $query_id);
    $data_id = mysqli_fetch_array($result_id);
    if ($data_id) {
        $lastID = $data_id['ms_id_produk']; // contoh: PRD-005
        $num = (int)substr($lastID, 4) + 1;
        $newID = 'PRD-' . str_pad($num, 3, '0', STR_PAD_LEFT);
    } else {
        $newID = 'PRD-001';
    }

    if (!empty($lokasi)) {
        $uploadDir = "assets/images/foto_produk/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        $uploadFile = $uploadDir . basename($nmGambar);
        if (move_uploaded_file($lokasi, $uploadFile)) {
            $query_add = "INSERT INTO tbl_master_produk 
                (ms_id_produk, ms_nm_produk, ms_harga, ms_stok, ms_berat, ms_gambar, ms_deskripsi, ms_id_kategori)
                VALUES ('$newID', '$nmProduk', '$harga', '$stok', '$berat', '$nmGambar', '$deskripsi', '$kategori')";
            $exec_add = mysqli_query($db, $query_add);

            if ($exec_add) {
                $message = "Berhasil menambahkan produk.";
            } else {
                $message = "Gagal menambahkan produk: " . mysqli_error($db);
            }
        } else {
            $message = "Gagal upload gambar.";
        }
    } else {
        $message = "Silakan pilih gambar produk.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Tambah Produk - Packindo</title>
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Tambah Produk</h2>

    <?php if (!empty($message)) : ?>
        <div class="alert <?= strpos($message, 'Berhasil') !== false ? 'alert-success' : 'alert-danger' ?>" role="alert">
            <?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data" novalidate>
        <div class="mb-3">
            <label for="nama" class="form-label">Nama Produk</label>
            <input id="nama" name="nama" type="text" class="form-control" required />
        </div>

        <div class="mb-3">
            <label for="id_kategori" class="form-label">Kategori Produk</label>
            <select id="id_kategori" name="id_kategori" class="form-select" required>
                <option value="">Pilih Kategori</option>
                <?php while ($row = mysqli_fetch_assoc($resultKategori)) : ?>
                    <option value="<?= htmlspecialchars($row['id_kategori']); ?>">
                        <?= htmlspecialchars($row['nama_kategori']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="berat" class="form-label">Berat Produk (gram)</label>
                <input id="berat" name="berat" type="number" min="0" class="form-control" required />
            </div>
            <div class="col-md-6 mb-3">
                <label for="harga" class="form-label">Harga Produk</label>
                <input id="harga" name="harga" type="number" min="0" class="form-control" required />
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="stok" class="form-label">Stok Produk</label>
                <input id="stok" name="stok" type="number" min="0" class="form-control" required />
            </div>
            <div class="col-md-6 mb-3">
                <label for="img" class="form-label">Gambar Produk</label>
                <input id="img" name="img" type="file" accept="image/*" class="form-control" required />
            </div>
        </div>

        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi Produk</label>
            <textarea id="deskripsi" name="deskripsi" rows="4" class="form-control" required></textarea>
        </div>

        <button type="submit" name="tambah" class="btn btn-success">Tambah</button>
        <a href="index.php" class="btn btn-secondary ms-2">Kembali</a>

    </form>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>