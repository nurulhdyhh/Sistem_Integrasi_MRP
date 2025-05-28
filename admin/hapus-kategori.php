<?php
include "../koneksi.php";

// Mengecek apakah ada parameter 'id' di URL
if (isset($_GET['id'])) {
    // Mengambil id produk yang akan dihapus
    $id = $_GET['id'];

    // Menggunakan prepared statement untuk menghindari SQL injection
    $queryHapus = "DELETE FROM tbl_kat_produk WHERE id_kategori = ?";
    $stmt = $db->prepare($queryHapus);

    if ($stmt) {
        // Mengikat parameter untuk prepared statement
        $stmt->bind_param("i", $id); // "i" untuk integer

        // Mengeksekusi query
        $execHapus = $stmt->execute();

        if ($execHapus) {
            // Menampilkan pesan sukses dan redirect ke halaman kategori
            echo "<script>alert('Kategori sudah dihapus');</script>";
            echo "<script>location='index.php?pages=tambah-kategori';</script>";
        } else {
            // Menampilkan pesan error jika query gagal
            echo "<script>alert('Gagal menghapus kategori');</script>";
            echo "<script>location='index.php?pages=tambah-kategori';</script>";
        }

        // Menutup prepared statement
        $stmt->close();
    } else {
        // Jika prepared statement gagal
        echo "<script>alert('Query tidak valid');</script>";
        echo "<script>location='index.php?pages=daftar-kategori';</script>";
    }
} else {
    // Jika parameter 'id' tidak ditemukan
    echo "<script>alert('ID kategori tidak ditemukan');</script>";
    echo "<script>location='index.php?pages=daftar-kategori';</script>";
}
?>
