<?php
// Include koneksi.php dari folder yang sama
include "header.php";
include "koneksi.php";

// Pastikan koneksi berhasil
if (!isset($db)) {
    die("Koneksi database gagal. Periksa file koneksi.php dan pathnya.");
}

// Proses simpan data kategori
$message = "";
if (isset($_POST['tambah'])) {
    $namaKategori = trim($_POST['nama_kategori']);

    if ($namaKategori === "") {
        $message = "Nama kategori tidak boleh kosong.";
    } else {
        // Escape input untuk keamanan
        $namaKategoriEsc = mysqli_real_escape_string($db, $namaKategori);

        // Cek apakah nama kategori sudah ada (opsional)
        $cek = mysqli_query($db, "SELECT COUNT(*) as jumlah FROM tbl_kategori WHERE nama_kategori = '$namaKategoriEsc'");
        $dataCek = mysqli_fetch_assoc($cek);
        if ($dataCek['jumlah'] > 0) {
            $message = "Kategori sudah ada.";
        } else {
            $query = "INSERT INTO tbl_kategori (nama_kategori) VALUES ('$namaKategoriEsc')";
            if (mysqli_query($db, $query)) {
                $message = "Kategori berhasil ditambahkan.";
            } else {
                $message = "Gagal menambahkan kategori: " . mysqli_error($db);
            }
        }
    }
}

// Ambil semua kategori untuk ditampilkan
$resultKategori = mysqli_query($db, "SELECT * FROM tbl_kategori ORDER BY id_kategori ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Tambah Kategori</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Tambah Kategori</h2>

    <?php if ($message): ?>
        <div class="alert <?= strpos($message, 'berhasil') !== false ? 'alert-success' : 'alert-danger' ?>" role="alert">
            <?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>

    <form method="post" novalidate>
        <div class="mb-3">
            <label for="nama_kategori" class="form-label">Nama Kategori</label>
            <input type="text" id="nama_kategori" name="nama_kategori" class="form-control" required />
        </div>
        <button type="submit" name="tambah" class="btn btn-primary">Tambah</button>
        <a href="index.php" class="btn btn-secondary ms-2">Kembali</a>
    </form>

    <hr />

    <h3 class="mt-4">Daftar Kategori</h3>
    <table class="table table-striped mt-3">
        <thead>
            <tr>
                <th>No</th>
                <th>ID Kategori</th>
                <th>Nama Kategori</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            while ($row = mysqli_fetch_assoc($resultKategori)):
            ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= htmlspecialchars($row['id_kategori']); ?></td>
                <td><?= htmlspecialchars($row['nama_kategori']); ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>