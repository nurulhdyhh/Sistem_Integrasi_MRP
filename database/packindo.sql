-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 29, 2025 at 10:08 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `packindo`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin`
--

CREATE TABLE `tbl_admin` (
  `id_admin` int(10) NOT NULL,
  `nm_admin` varchar(20) NOT NULL,
  `username` varchar(10) NOT NULL,
  `email` varchar(30) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_admin`
--

INSERT INTO `tbl_admin` (`id_admin`, `nm_admin`, `username`, `email`, `password`) VALUES
(1, 'administrator', 'admin1', 'admin@gmail.com', 'admin1');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_detail_order`
--

CREATE TABLE `tbl_detail_order` (
  `id_detail_order` int(10) NOT NULL,
  `id_order` varchar(20) NOT NULL,
  `id_produk` varchar(20) NOT NULL,
  `nm_produk` varchar(50) NOT NULL,
  `harga` int(10) NOT NULL,
  `jml_order` int(3) NOT NULL,
  `berat` int(10) NOT NULL,
  `subberat` int(10) NOT NULL,
  `subharga` int(10) NOT NULL,
  `gambar_custom` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_detail_order`
--

INSERT INTO `tbl_detail_order` (`id_detail_order`, `id_order`, `id_produk`, `nm_produk`, `harga`, `jml_order`, `berat`, `subberat`, `subharga`, `gambar_custom`) VALUES
(4, '3', 'PRD-003', 'Walker Alat Bantu Jalan ', 300000, 1, 2000, 2000, 300000, NULL),
(5, '3', 'PRD-012', 'Easy Touch Asam Urat Strip ', 85000, 1, 150, 150, 85000, NULL),
(6, '4', 'PRD-020', 'Serenity ZT-150A Timbangan badan', 1500000, 1, 7000, 7000, 1500000, NULL),
(7, '5', 'PRD-007', 'Avico Tongkat Kaki Empat ', 150000, 1, 500, 500, 150000, NULL),
(8, '6', 'PRD-004', 'Gluco Dr Biosensor AGM 2100 ', 100000, 1, 250, 250, 100000, NULL),
(9, '7', 'PRD-005', 'Alat Cek Kolesterol FamilyDr', 200000, 1, 250, 250, 200000, NULL),
(10, '7', 'PRD-012', 'Easy Touch Asam Urat Strip ', 85000, 2, 150, 300, 170000, NULL),
(11, '7', 'PRD-009', 'ABN Tensimeter Premium Aneroid ', 450000, 3, 400, 1200, 1350000, NULL),
(12, '8', 'PRD-003', 'Walker Alat Bantu Jalan ', 300000, 1, 2000, 2000, 300000, NULL),
(13, '8', 'PRD-014', 'Tensimeter Aneroid Riester Risan ', 750000, 2, 350, 700, 1500000, NULL),
(14, '8', 'PRD-018', 'Autocheck Test Strip Asam Urat ', 80000, 3, 150, 450, 240000, NULL),
(15, '9', 'PRD-023', 'Paracetamol 500 mg 10 Kaplet', 5000, 10, 5, 50, 50000, NULL),
(16, '10', 'PRD-014', 'Tensimeter Aneroid Riester Risan ', 750000, 1, 350, 350, 750000, NULL),
(17, '11', 'PRD-015', 'Beurer FT 85 Infrared Non Contact Thermometer ', 800000, 1, 250, 250, 800000, NULL),
(18, '12', 'PRD-005', 'Alat Cek Kolesterol FamilyDr', 200000, 2, 250, 500, 400000, NULL),
(19, '12', 'PRD-009', 'ABN Tensimeter Premium Aneroid ', 450000, 1, 400, 400, 450000, NULL),
(20, '13', 'PRD-003', 'Walker Alat Bantu Jalan ', 300000, 5, 2000, 10000, 1500000, NULL),
(21, '14', 'PRD-024', 'Promag', 120000, 10, 20, 200, 1200000, NULL),
(22, '14', 'PRD-014', 'Tensimeter Aneroid Riester Risan ', 750000, 1, 350, 350, 750000, NULL),
(23, '14', 'PRD-005', 'Alat Cek Kolesterol FamilyDr', 200000, 1, 250, 250, 200000, NULL),
(24, '15', 'PRD-005', 'Alat Cek Kolesterol FamilyDr', 200000, 1, 250, 250, 200000, NULL),
(25, '15', 'PRD-004', 'Gluco Dr Biosensor AGM 2100 ', 100000, 1, 250, 250, 100000, NULL),
(26, '16', 'PRD-005', 'Alat Cek Kolesterol FamilyDr', 200000, 1, 250, 250, 200000, NULL),
(27, '17', 'PRD-002', 'Avico Thermometer Digital Flexible Tip - APST', 20000, 3, 100, 300, 60000, NULL),
(28, '17', 'PRD-003', 'Walker Alat Bantu Jalan ', 300000, 1, 2000, 2000, 300000, NULL),
(29, '18', 'PRD-002', 'Avico Thermometer Digital Flexible Tip - APST', 20000, 1, 100, 100, 20000, NULL),
(30, '19', 'PRD-012', 'Easy Touch Asam Urat Strip ', 85000, 1, 150, 150, 85000, NULL),
(31, '20', 'PRD-001', 'Termometer Infrared FT65 - TMR3', 1000000, 1, 250, 250, 1000000, NULL),
(32, '21', 'PRD-018', 'Autocheck Test Strip Asam Urat ', 80000, 1, 150, 150, 80000, NULL),
(33, '22', 'PRD-002', 'Avico Thermometer Digital Flexible Tip - APST', 20000, 1, 100, 100, 20000, NULL),
(34, '23', 'PRD-018', 'Autocheck Test Strip Asam Urat ', 80000, 1, 150, 150, 80000, NULL),
(35, '24', 'PRD-011', 'Autocheck Test Strip Asam Urat ', 90000, 1, 200, 200, 90000, NULL),
(36, '25', 'PRD-021', 'Easy Touch Strip Kolesterol ', 90000, 1, 250, 250, 90000, NULL),
(37, '26', 'PRD-002', 'Avico Thermometer Digital Flexible Tip - APST', 20000, 1, 100, 100, 20000, NULL),
(38, '27', 'PRD-003', 'Walker Alat Bantu Jalan ', 300000, 1, 2000, 2000, 300000, NULL),
(39, '28', 'PRD-004', 'Gluco Dr Biosensor AGM 2100 ', 100000, 1, 250, 250, 100000, NULL),
(40, '29', 'PRD-008', 'Beurer FT 85 Infrared Non Contact Thermometer - AP', 800000, 1, 300, 300, 800000, NULL),
(41, '33', 'PRD-025', 'Sleeve', 2500, 3, 2, 6, 7500, NULL),
(42, '34', 'PRD-025', 'Sleeve', 2500, 4, 2, 8, 10000, NULL),
(43, '35', 'PRD-022', 'Timbangan Digital Omron HN 289 ', 300000, 1, 500, 500, 300000, NULL),
(44, '35', 'PRD-025', 'Sleeve', 2500, 1, 2, 2, 2500, NULL),
(45, '36', 'PRD-025', 'Sleeve', 2500, 1, 2, 2, 2500, '1748267467_PRD-025.png'),
(46, '37', 'PRD-025', 'Sleeve', 2500, 1, 2, 2, 2500, NULL),
(47, '38', 'PRD-022', 'Timbangan Digital Omron HN 289 ', 300000, 1, 500, 500, 300000, NULL),
(48, '39', 'PRD-025', 'Sleeve', 2500, 7, 2, 14, 17500, NULL),
(49, '40', 'PRD-022', 'Timbangan Digital Omron HN 289 ', 300000, 1, 500, 500, 300000, NULL),
(50, '41', 'PRD-024', 'Promag', 120000, 1, 20, 20, 120000, NULL),
(51, '42', 'PRD-025', 'Sleeve', 2500, 9, 2, 18, 22500, NULL),
(52, '43', 'PRD-022', 'Timbangan Digital Omron HN 289 ', 300000, 1, 500, 500, 300000, NULL),
(53, '44', 'PRD-025', 'Sleeve', 2500, 2, 2, 4, 5000, NULL),
(54, '44', 'PRD-023', 'Paracetamol 500 mg 10 Kaplet', 5000, 1, 5, 5, 5000, NULL),
(55, '45', 'PRD-024', 'Promag', 120000, 1, 20, 20, 120000, NULL),
(56, '45', 'PRD-025', 'Sleeve', 2500, 1, 2, 2, 2500, NULL),
(57, '45', 'PRD-022', 'Timbangan Digital Omron HN 289 ', 300000, 1, 500, 500, 300000, NULL),
(58, '46', 'PRD-022', 'Timbangan Digital Omron HN 289 ', 300000, 1, 500, 500, 300000, NULL),
(59, '47', 'PRD-023', 'Paracetamol 500 mg 10 Kaplet', 5000, 1, 5, 5, 5000, NULL),
(60, '48', 'PRD-025', 'Sleeve', 2500, 10, 2, 20, 25000, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_feedback`
--

CREATE TABLE `tbl_feedback` (
  `id_feedback` int(11) NOT NULL,
  `id_pelanggan` varchar(11) DEFAULT NULL,
  `id_order` varchar(20) DEFAULT NULL,
  `id_produk` varchar(20) DEFAULT NULL,
  `komentar` text DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_feedback`
--

INSERT INTO `tbl_feedback` (`id_feedback`, `id_pelanggan`, `id_order`, `id_produk`, `komentar`, `rating`, `created_at`) VALUES
(4, 'USR-001', '3', 'PRD-003', 'produk sangat berkualitas tidak mengecewakan', 5, '2025-04-21 03:17:21'),
(5, 'USR-001', '3', 'PRD-012', 'produk sesuai pesanan', 5, '2025-04-21 03:17:21');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_kategori`
--

CREATE TABLE `tbl_kategori` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_kategori`
--

INSERT INTO `tbl_kategori` (`id_kategori`, `nama_kategori`) VALUES
(1, 'Toko Kantong Plastik');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_kat_produk`
--

CREATE TABLE `tbl_kat_produk` (
  `id_kategori` varchar(10) NOT NULL,
  `nm_kategori` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_kat_produk`
--

INSERT INTO `tbl_kat_produk` (`id_kategori`, `nm_kategori`) VALUES
('KTR-001', 'Alat Bantu Jalan'),
('KTR-002', 'Alat Pengukurn Suhu Tubuh'),
('KTR-003', 'Alat Cek Tekanan Darah'),
('KTR-004', 'Alat Cek Gula Darah'),
('KTR-005', 'Alat Cek Kolesterol'),
('KTR-006', 'Alat Cek Asam Urat'),
('KTR-007', 'Timbangan Badan'),
('KTR-008', 'Obat Pribadi'),
('KTR-009', 'Toko Gelas Cup'),
('KTR-010', 'Toko Kertas Kraft');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_master_produk`
--

CREATE TABLE `tbl_master_produk` (
  `ms_id_produk` int(11) NOT NULL,
  `ms_nm_produk` varchar(255) NOT NULL,
  `ms_harga` decimal(15,2) NOT NULL,
  `ms_stok` int(11) NOT NULL DEFAULT 0,
  `ms_berat` int(11) NOT NULL DEFAULT 0,
  `ms_gambar` varchar(255) DEFAULT NULL,
  `ms_deskripsi` text DEFAULT NULL,
  `ms_id_kategori` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_master_produk`
--

INSERT INTO `tbl_master_produk` (`ms_id_produk`, `ms_nm_produk`, `ms_harga`, `ms_stok`, `ms_berat`, `ms_gambar`, `ms_deskripsi`, `ms_id_kategori`) VALUES
(1, 'Kresek Bening', 10000.00, 24, 2, 'CLD.jpg', 'Ayo dibeli ya', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order`
--

CREATE TABLE `tbl_order` (
  `id_order` int(11) NOT NULL,
  `id_pelanggan` varchar(20) NOT NULL,
  `nm_penerima` varchar(100) NOT NULL,
  `telp` varchar(20) NOT NULL,
  `alamat` text NOT NULL,
  `metode_bayar` varchar(125) NOT NULL,
  `nama_bank` varchar(50) DEFAULT NULL,
  `paypal_id` varchar(100) DEFAULT NULL,
  `tgl_order` date NOT NULL,
  `total_order` decimal(12,2) NOT NULL,
  `ongkir` varchar(125) NOT NULL,
  `status` varchar(125) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT 'Belum Dibayar',
  `no_resi` varchar(100) DEFAULT NULL,
  `barang_custom` enum('iya','tidak') DEFAULT 'tidak',
  `gambar_custom` varchar(255) DEFAULT NULL,
  `konfirmasi_dp` decimal(15,2) DEFAULT 0.00,
  `provinsi` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_order`
--

INSERT INTO `tbl_order` (`id_order`, `id_pelanggan`, `nm_penerima`, `telp`, `alamat`, `metode_bayar`, `nama_bank`, `paypal_id`, `tgl_order`, `total_order`, `ongkir`, `status`, `no_resi`, `barang_custom`, `gambar_custom`, `konfirmasi_dp`, `provinsi`) VALUES
(27, 'USR-001', 'filda', '085232126385', 'Lamongan Jati Geger no.19', 'dp', 'BRI', '121019', '2025-05-26', 300000.00, '10000', 'Produk Diterima', '789', 'tidak', 'uploads/1748232614_order.png', 155000.00, NULL),
(28, 'USR-001', 'filda', '085232126385', 'Lamongan Jati Geger no.19', 'lunas', 'MANDIRI', '121019', '2025-05-26', 100000.00, '10000', 'Produk Diterima', '9087', 'tidak', '', 0.00, NULL),
(29, 'USR-001', 'filda', '085232126385', 'Lamongan Jati Geger no.19', 'lunas', 'BCA', '121019', '2025-05-26', 800000.00, '10000', 'Pesanan Ditolak', NULL, 'tidak', '', 0.00, NULL),
(30, 'USR-003', 'bomi', '082167553190', 'Jl Veteran No.89', 'lunas', 'BRI', '141017', '2025-05-26', 17500.00, '10000', 'pending', NULL, 'iya', NULL, 0.00, 'DKI Jakarta'),
(31, 'USR-003', 'bomi', '082167553190', 'Jl Veteran No.89', 'lunas', 'BRI', '141017', '2025-05-26', 17500.00, '10000', 'pending', NULL, 'iya', NULL, 0.00, 'DKI Jakarta'),
(32, 'USR-003', 'bomi', '082167553190', 'Jl Veteran No.89', 'dp', 'BRI', '141017', '2025-05-26', 17500.00, '10000', 'pending', NULL, 'tidak', NULL, 0.00, 'Jawa Barat'),
(33, 'USR-003', 'bomi', '082167553190', 'Jl Veteran No.89', 'dp', 'BRI', '141017', '2025-05-26', 17500.00, '10000', 'pending', NULL, 'tidak', NULL, 0.00, 'Jawa Barat'),
(34, 'USR-003', 'bomi', '082167553190', 'Jl Veteran No.89', 'lunas', 'BRI', '141017', '2025-05-26', 20000.00, '10000', 'pending', NULL, 'tidak', NULL, 0.00, 'Jawa Timur'),
(35, 'USR-003', 'bomi', '082167553190', 'Jl Veteran No.89', 'lunas', 'MANDIRI', '141017', '2025-05-26', 312500.00, '10000', 'pending', NULL, 'tidak', NULL, 0.00, 'Jawa Tengah'),
(36, 'USR-003', 'bomi', '082167553190', 'Jl Veteran No.89', 'dp', 'BRI', '141017', '2025-05-26', 12500.00, '10000', 'pending', NULL, 'iya', NULL, 0.00, 'Jawa Timur'),
(37, 'USR-003', 'bomi', '082167553190', 'Jl Veteran No.89', 'dp', 'BRI', '141017', '2025-05-26', 12500.00, '10000', 'pending', NULL, 'tidak', NULL, 0.00, 'Jawa Timur'),
(38, 'USR-003', 'bomi', '082167553190', 'Jl Veteran No.89', 'lunas', 'BCA', '141017', '2025-05-26', 310000.00, '10000', 'pending', NULL, 'tidak', NULL, 0.00, 'Jawa Timur'),
(39, 'USR-003', 'bomi', '082167553190', 'Jl Veteran No.89', 'dp', 'BRI', '141017', '2025-05-26', 27500.00, '10000', 'pending', NULL, 'tidak', NULL, 0.00, 'Jawa Tengah'),
(40, 'USR-003', 'bomi', '082167553190', 'Jl Veteran No.89', 'dp', 'BRI', '141017', '2025-05-26', 310000.00, '10000', 'Belum Dibayar', NULL, 'tidak', NULL, 0.00, 'Jawa Tengah'),
(41, 'USR-003', 'bomi', '082167553190', 'Jl Veteran No.89', 'dp', 'MANDIRI', '141017', '2025-05-26', 130000.00, '10000', 'Belum Dibayar', NULL, 'tidak', NULL, 0.00, 'Jawa Timur'),
(42, 'USR-003', 'bomi', '082167553190', 'Jl Veteran No.89', 'dp', 'BCA', '141017', '2025-05-26', 32500.00, '10000', 'Produk Diterima', '908765467', 'tidak', NULL, 0.00, 'Jawa Timur'),
(43, 'USR-001', 'filda', '085232126385', 'Lamongan Jati Geger no.19', 'dp', 'BRI', '121019', '2025-05-27', 310000.00, '10000', 'Sudah Dibayar', NULL, 'tidak', NULL, 0.00, 'Bali'),
(44, 'USR-001', 'filda', '085232126385', 'Lamongan Jati Geger no.19', 'dp', 'BRI', '121019', '2025-05-27', 20000.00, '10000', 'Produk Diterima', '09879876', 'tidak', NULL, 0.00, 'Jawa Timur'),
(45, 'USR-001', 'filda', '085232126385', 'Lamongan Jati Geger no.19', 'dp', 'BRI', '121019', '2025-05-29', 432500.00, '10000', 'Sudah Dibayar', NULL, 'tidak', NULL, 0.00, '18'),
(46, 'USR-001', 'filda', '085232126385', 'Lamongan Jati Geger no.19', 'dp', 'BRI', '121019', '2025-05-29', 310000.00, '10000', 'Sudah Dibayar', NULL, 'tidak', NULL, 0.00, '11'),
(47, 'USR-001', 'filda', '085232126385', 'Lamongan Jati Geger no.19', 'lunas', 'BRI', '121019', '2025-05-29', 15000.00, '10000', 'Sudah Dibayar', NULL, 'tidak', NULL, 0.00, '13'),
(48, 'USR-001', 'filda', '085232126385', 'Lamongan Jati Geger no.19', 'lunas', 'BRI', '121019', '2025-05-29', 35000.00, '10000', 'Produk Diterima', '98087678', 'tidak', NULL, 0.00, '11');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pelanggan`
--

CREATE TABLE `tbl_pelanggan` (
  `id_pelanggan` varchar(20) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email_pelanggan` varchar(100) NOT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `gender` enum('Laki-laki','Perempuan') NOT NULL,
  `alamat_pelanggan` text DEFAULT NULL,
  `kota_pelanggan` varchar(100) DEFAULT NULL,
  `no_telp` varchar(20) DEFAULT NULL,
  `paypal_id` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_pelanggan`
--

INSERT INTO `tbl_pelanggan` (`id_pelanggan`, `username`, `password`, `email_pelanggan`, `tanggal_lahir`, `gender`, `alamat_pelanggan`, `kota_pelanggan`, `no_telp`, `paypal_id`, `created_at`) VALUES
('USR-001', 'filda', 'filda', 'fildadwimeirina18@gmail.com', '2004-05-18', 'Perempuan', 'Lamongan Jati Geger no.19', 'Lamongan', '085232126385', '121019', '2025-04-21 02:57:47'),
('USR-002', 'ririna', 'ririna', '22082010025@student.upnjatim.ac.id', '2025-04-12', 'Perempuan', 'IKIP Gunung Anyar A-12', 'Surabaya', '085199712322', '131018', '2025-04-21 03:25:05'),
('USR-003', 'bomi', 'bomi', 'bomilucu7@gmail.com', '2022-02-07', 'Laki-laki', 'Jl Veteran No.89', 'Jakarta', '082167553190', '141017', '2025-04-21 03:54:27'),
('USR-004', 'yisti', 'yisti', 'fildadwimeirina18@gmail.com', '2025-04-04', 'Perempuan', 'Medokan Asri Barat', 'Surabaya', '085232126385', '121016', '2025-04-21 05:38:31');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_pembayaran`
--

CREATE TABLE `tbl_pembayaran` (
  `id_pembayaran` int(11) NOT NULL,
  `id_order` varchar(20) DEFAULT NULL,
  `jml_pembayaran` decimal(12,2) DEFAULT NULL,
  `tgl_bayar` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_pembayaran`
--

INSERT INTO `tbl_pembayaran` (`id_pembayaran`, `id_order`, `jml_pembayaran`, `tgl_bayar`) VALUES
(2, '3', 423500.00, '2025-04-21'),
(3, '7', 1892000.00, '2025-04-21'),
(4, '8', 2244000.00, '2025-04-21'),
(5, '12', 935000.00, '2025-05-22'),
(6, '26', 15000.00, '2025-05-26'),
(7, '27', 155000.00, '2025-05-26'),
(8, '29', 800000.00, '2025-05-26'),
(9, '42', 16250.00, '2025-05-26'),
(10, '43', 155000.00, '2025-05-27'),
(11, '44', 10000.00, '2025-05-27'),
(12, '45', 216250.00, '2025-05-29'),
(13, '46', 155000.00, '2025-05-29'),
(14, '48', 35000.00, '2025-05-29'),
(15, '47', 15000.00, '2025-05-29');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_produk`
--

CREATE TABLE `tbl_produk` (
  `id_produk` varchar(10) NOT NULL,
  `id_kategori` varchar(20) NOT NULL,
  `nm_produk` varchar(50) NOT NULL,
  `berat` int(10) NOT NULL,
  `harga` int(10) NOT NULL,
  `stok` int(3) NOT NULL,
  `gambar` varchar(50) NOT NULL,
  `deskripsi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_produk`
--

INSERT INTO `tbl_produk` (`id_produk`, `id_kategori`, `nm_produk`, `berat`, `harga`, `stok`, `gambar`, `deskripsi`) VALUES
('PRD-022', 'KTR-007', 'Timbangan Digital Omron HN 289 ', 500, 300000, 40, 'timbangan1.jpg', 'Timbangan Omron HN-289 merupakan timbangan badan digital yang menggunakan 4 sensor untuk mendapatkan hasil pengukuran berat badan yang akurat dengan tingkat presisi yang tinggi. Dengan layar LCD yang besar memudahkan untuk membaca hasil pengukuran berat badan antara 5 Kg sampai dengan 150 Kg (dengan penambahan sebesar 100g), sehingga bahkan perubahan berat yang kecil dapat terdeteksi. Timbangan Omron HN-289 merupakan alat bantu untuk memonitor berat badan secara mudah dan akurat.'),
('PRD-025', 'KTR-010', 'Sleeve', 2, 2500, 75, 'output.png', 'Bisa custom full warna. Tersedia warna coklat dan putih.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `tbl_detail_order`
--
ALTER TABLE `tbl_detail_order`
  ADD PRIMARY KEY (`id_detail_order`),
  ADD KEY `id_order` (`id_order`),
  ADD KEY `id_produk` (`id_produk`);

--
-- Indexes for table `tbl_feedback`
--
ALTER TABLE `tbl_feedback`
  ADD PRIMARY KEY (`id_feedback`),
  ADD KEY `tbl_feedback_ibfk_1` (`id_pelanggan`);

--
-- Indexes for table `tbl_kategori`
--
ALTER TABLE `tbl_kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `tbl_kat_produk`
--
ALTER TABLE `tbl_kat_produk`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `tbl_master_produk`
--
ALTER TABLE `tbl_master_produk`
  ADD PRIMARY KEY (`ms_id_produk`),
  ADD KEY `fk_kategori_idx` (`ms_id_kategori`);

--
-- Indexes for table `tbl_order`
--
ALTER TABLE `tbl_order`
  ADD PRIMARY KEY (`id_order`),
  ADD KEY `id_pelanggan` (`id_pelanggan`);

--
-- Indexes for table `tbl_pelanggan`
--
ALTER TABLE `tbl_pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indexes for table `tbl_pembayaran`
--
ALTER TABLE `tbl_pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD KEY `id_order` (`id_order`);

--
-- Indexes for table `tbl_produk`
--
ALTER TABLE `tbl_produk`
  ADD PRIMARY KEY (`id_produk`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_admin`
--
ALTER TABLE `tbl_admin`
  MODIFY `id_admin` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_detail_order`
--
ALTER TABLE `tbl_detail_order`
  MODIFY `id_detail_order` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `tbl_feedback`
--
ALTER TABLE `tbl_feedback`
  MODIFY `id_feedback` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tbl_kategori`
--
ALTER TABLE `tbl_kategori`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_master_produk`
--
ALTER TABLE `tbl_master_produk`
  MODIFY `ms_id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_order`
--
ALTER TABLE `tbl_order`
  MODIFY `id_order` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `tbl_pembayaran`
--
ALTER TABLE `tbl_pembayaran`
  MODIFY `id_pembayaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tbl_feedback`
--
ALTER TABLE `tbl_feedback`
  ADD CONSTRAINT `tbl_feedback_ibfk_1` FOREIGN KEY (`id_pelanggan`) REFERENCES `tbl_pelanggan` (`id_pelanggan`);

--
-- Constraints for table `tbl_master_produk`
--
ALTER TABLE `tbl_master_produk`
  ADD CONSTRAINT `fk_kategori` FOREIGN KEY (`ms_id_kategori`) REFERENCES `tbl_kategori` (`id_kategori`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `tbl_order`
--
ALTER TABLE `tbl_order`
  ADD CONSTRAINT `tbl_order_ibfk_1` FOREIGN KEY (`id_pelanggan`) REFERENCES `tbl_pelanggan` (`id_pelanggan`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
