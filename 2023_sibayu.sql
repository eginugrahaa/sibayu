-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: May 26, 2023 at 02:14 AM
-- Server version: 5.7.33
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `2023_sibayu`
--

-- --------------------------------------------------------

--
-- Table structure for table `pengaturan`
--

CREATE TABLE `pengaturan` (
  `pengaturan_nama` varchar(100) NOT NULL,
  `pengaturan_isi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `pengaturan`
--

INSERT INTO `pengaturan` (`pengaturan_nama`, `pengaturan_isi`) VALUES
('0_no_instansi', ''),
('1_nama_sekolah', 'SMK NEGERI 1 SUBANG'),
('2_nama_kepala', ''),
('3_nip', ''),
('4_alamat', 'Jln. Arief Rahman Hakim No. 35 Subang, Jawa Barat.'),
('5_kota', 'Subang'),
('6_kontak', 'Telp. (0260) 411410'),
('7_logo', 'logo-bankmini.png');

-- --------------------------------------------------------

--
-- Table structure for table `peserta`
--

CREATE TABLE `peserta` (
  `peserta_id` int(11) NOT NULL,
  `tahun_masuk_id` int(11) DEFAULT NULL,
  `no_identitas` varchar(100) NOT NULL,
  `nama_lengkap` varchar(255) NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `tingkat` char(10) NOT NULL,
  `kelas` char(50) NOT NULL,
  `bantuan` varchar(25) NOT NULL,
  `aktif_peserta` enum('1','0') NOT NULL,
  `waktu_entri` datetime NOT NULL,
  `waktu_update` datetime DEFAULT NULL,
  `petugas_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `petugas`
--

CREATE TABLE `petugas` (
  `petugas_id` int(11) NOT NULL,
  `nama_pengguna` varchar(255) NOT NULL,
  `kata_sandi` varchar(255) NOT NULL,
  `nama_petugas` varchar(255) NOT NULL,
  `level` enum('admin','teller') NOT NULL,
  `masuk_terakhir` datetime DEFAULT NULL,
  `aktif_petugas` enum('1','0') NOT NULL,
  `waktu_entri` datetime NOT NULL,
  `waktu_update` datetime NOT NULL,
  `parent_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `petugas`
--

INSERT INTO `petugas` (`petugas_id`, `nama_pengguna`, `kata_sandi`, `nama_petugas`, `level`, `masuk_terakhir`, `aktif_petugas`, `waktu_entri`, `waktu_update`, `parent_id`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Administrator', 'admin', '2023-05-26 08:53:24', '1', '2021-07-02 14:33:30', '2023-05-26 09:12:55', 1),
(13, 'petugas', 'afb91ef692fd08c445e8cb1bab2ccf9c', 'Petugas', 'teller', '2023-05-25 19:43:07', '1', '2023-05-18 16:04:12', '2023-05-26 09:13:08', 1);

-- --------------------------------------------------------

--
-- Table structure for table `rincian`
--

CREATE TABLE `rincian` (
  `rincian_id` int(11) NOT NULL,
  `transaksi_id` int(11) NOT NULL,
  `peserta_id` int(11) NOT NULL,
  `tagihan_id` int(11) DEFAULT NULL,
  `nama_transaksi` varchar(255) DEFAULT NULL,
  `tipe_transaksi` enum('tunai','diskon') NOT NULL,
  `nominal_bayar` bigint(20) NOT NULL,
  `waktu_entri` datetime NOT NULL,
  `petugas_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tagihan`
--

CREATE TABLE `tagihan` (
  `tagihan_id` int(11) NOT NULL,
  `tahun_masuk_id` int(11) NOT NULL,
  `nama_tagihan` varchar(100) NOT NULL,
  `nominal` bigint(20) NOT NULL,
  `tipe_tagihan` enum('angsur','sekali') NOT NULL,
  `aktif_tagihan` enum('1','0') NOT NULL,
  `waktu_entri` datetime NOT NULL,
  `waktu_update` datetime NOT NULL,
  `petugas_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tagihan_peserta`
--

CREATE TABLE `tagihan_peserta` (
  `tagihan_peserta_id` int(11) NOT NULL,
  `tagihan_id` int(11) NOT NULL,
  `peserta_id` int(11) NOT NULL,
  `waktu_entri` datetime NOT NULL,
  `petugas_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `tahun_masuk`
--

CREATE TABLE `tahun_masuk` (
  `tahun_masuk_id` int(11) NOT NULL,
  `nama_tahun_masuk` varchar(100) NOT NULL,
  `aktif_tahun_masuk` enum('1','0') NOT NULL,
  `waktu_entri` datetime NOT NULL,
  `waktu_update` datetime NOT NULL,
  `petugas_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `transaksi_id` int(11) NOT NULL,
  `peserta_id` int(11) NOT NULL,
  `waktu_entri` datetime NOT NULL,
  `petugas_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `pengaturan`
--
ALTER TABLE `pengaturan`
  ADD PRIMARY KEY (`pengaturan_nama`);

--
-- Indexes for table `peserta`
--
ALTER TABLE `peserta`
  ADD PRIMARY KEY (`peserta_id`);

--
-- Indexes for table `petugas`
--
ALTER TABLE `petugas`
  ADD PRIMARY KEY (`petugas_id`);

--
-- Indexes for table `rincian`
--
ALTER TABLE `rincian`
  ADD PRIMARY KEY (`rincian_id`);

--
-- Indexes for table `tagihan`
--
ALTER TABLE `tagihan`
  ADD PRIMARY KEY (`tagihan_id`);

--
-- Indexes for table `tagihan_peserta`
--
ALTER TABLE `tagihan_peserta`
  ADD PRIMARY KEY (`tagihan_peserta_id`);

--
-- Indexes for table `tahun_masuk`
--
ALTER TABLE `tahun_masuk`
  ADD PRIMARY KEY (`tahun_masuk_id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`transaksi_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `peserta`
--
ALTER TABLE `peserta`
  MODIFY `peserta_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `petugas`
--
ALTER TABLE `petugas`
  MODIFY `petugas_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `rincian`
--
ALTER TABLE `rincian`
  MODIFY `rincian_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tagihan`
--
ALTER TABLE `tagihan`
  MODIFY `tagihan_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tagihan_peserta`
--
ALTER TABLE `tagihan_peserta`
  MODIFY `tagihan_peserta_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tahun_masuk`
--
ALTER TABLE `tahun_masuk`
  MODIFY `tahun_masuk_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `transaksi_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
