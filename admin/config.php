<?php
$pages = [
    "dashboard", "produk", "tambah-produk", "ubah-produk",
    "hapus-produk", "tambah-kategori", "hapus-kategori",
    "pelanggan", "order", "detail-order", "pembayaran", "logout"
];

$page = $_GET['pages'] ?? 'dashboard';
$path = __DIR__ . "/pages/$page.php";

if (in_array($page, $pages) && file_exists($path)) {
    include $path;
} else {
    echo "<div class='alert alert-danger'>Halaman tidak ditemukan.</div>";
}
?>
