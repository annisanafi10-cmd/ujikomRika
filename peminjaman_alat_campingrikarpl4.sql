-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 11, 2026 at 01:42 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `peminjaman_alat_campingrikarpl4`
--

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int NOT NULL,
  `nama_kategori` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id_peminjaman` int NOT NULL,
  `id_user` int DEFAULT NULL,
  `id_alat` int DEFAULT NULL,
  `tanggal_pinjam` date DEFAULT NULL,
  `tanggal_kembali` date DEFAULT NULL,
  `jumlah_bayar` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tabel_alat`
--

CREATE TABLE `tabel_alat` (
  `id_alat` int NOT NULL,
  `nama_alat` varchar(100) NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `harga_sewa_perhari` decimal(12,2) NOT NULL,
  `stok` int NOT NULL,
  `kondisi` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tabel_alat`
--

INSERT INTO `tabel_alat` (`id_alat`, `nama_alat`, `kategori`, `harga_sewa_perhari`, `stok`, `kondisi`) VALUES
(1, 'Tenda', 'tunai', '5000.00', 15, 'baik'),
(2, 'Sleeping bag', 'Tunai', '10000.00', 10, 'baik'),
(3, 'Senter', 'Tunai', '5000.00', 10, 'baik'),
(4, 'Kompor Portabel', 'Tunai', '20000.00', 15, 'baik'),
(5, 'Tas Carrier / Ransel', 'Perlengkapan', '35000.00', 10, 'Baik'),
(6, 'Jas Hujan', 'Pakaian', '10000.00', 14, 'Baik'),
(7, 'Pakaian Ganti', 'Pakaian', '5000.00', 20, 'Baik'),
(8, 'Sepatu / Sandal Gunung', 'Alat Kaki', '25000.00', 11, 'Baik'),
(9, 'Topi / Buff', 'Aksesoris', '5000.00', 25, 'Baik'),
(10, 'Kompas', 'Navigasi', '7000.00', 8, 'Baik'),
(11, 'Peta', 'Navigasi', '5000.00', 5, 'Baik'),
(12, 'Peluit', 'Keamanan', '3000.00', 15, 'Baik'),
(13, 'Kotak P3K', 'Kesehatan', '15000.00', 10, 'Lengkap');

-- --------------------------------------------------------

--
-- Table structure for table `tabel_detail_peminjaman`
--

CREATE TABLE `tabel_detail_peminjaman` (
  `id_detail` int NOT NULL,
  `id_peminjaman` int NOT NULL,
  `id_alat` int NOT NULL,
  `jumlah` int NOT NULL,
  `subtotal` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tabel_detail_peminjaman`
--

INSERT INTO `tabel_detail_peminjaman` (`id_detail`, `id_peminjaman`, `id_alat`, `jumlah`, `subtotal`) VALUES
(1, 1, 1, 10, '250000.00');

-- --------------------------------------------------------

--
-- Table structure for table `tabel_peminjaman`
--

CREATE TABLE `tabel_peminjaman` (
  `id_peminjaman` int NOT NULL,
  `id_alat` int NOT NULL,
  `id_user` int NOT NULL,
  `tanggal_pinjam` date NOT NULL,
  `tanggal_kembali` date NOT NULL,
  `total_harga` decimal(10,0) NOT NULL,
  `status` enum('dipinjam','dikembalikan','dibatalkan') NOT NULL,
  `jumlah` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tabel_peminjaman`
--

INSERT INTO `tabel_peminjaman` (`id_peminjaman`, `id_alat`, `id_user`, `tanggal_pinjam`, `tanggal_kembali`, `total_harga`, `status`, `jumlah`) VALUES
(1, 2, 6, '2026-04-11', '2026-04-11', '0', 'dikembalikan', 1),
(2, 1, 6, '2026-04-11', '2026-04-11', '0', 'dikembalikan', 1),
(3, 1, 6, '2026-04-11', '2026-04-11', '0', 'dikembalikan', 2),
(4, 4, 6, '2026-04-11', '2026-04-11', '0', 'dipinjam', 1),
(5, 1, 6, '2026-04-11', '2026-04-11', '0', 'dipinjam', 1),
(6, 1, 6, '2026-04-11', '2026-04-11', '0', 'dikembalikan', 1),
(7, 2, 12, '2026-04-11', '2026-04-11', '10000', 'dipinjam', 1),
(8, 3, 12, '2026-04-11', '2026-04-11', '5000', 'dipinjam', 1),
(9, 3, 12, '2026-04-11', '2026-04-11', '10000', 'dipinjam', 2),
(10, 6, 12, '2026-04-11', '2026-04-11', '10000', 'dipinjam', 1),
(11, 8, 12, '2026-04-11', '2026-04-11', '25000', 'dipinjam', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tabel_transaksi`
--

CREATE TABLE `tabel_transaksi` (
  `id_transaksi` int NOT NULL,
  `id_peminjaman` int NOT NULL,
  `tanggal_bayar` date NOT NULL,
  `mode_pembayaran` varchar(50) NOT NULL,
  `jumlah_bayar` decimal(12,2) NOT NULL,
  `status_pembayaran` enum('lunas','belumlunas') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tabel_user`
--

CREATE TABLE `tabel_user` (
  `id_user` int NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `no_hp` varchar(15) DEFAULT NULL,
  `alamat` text,
  `role` enum('admin','petugas','peminjam') NOT NULL DEFAULT 'peminjam',
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tabel_user`
--

INSERT INTO `tabel_user` (`id_user`, `nama`, `email`, `no_hp`, `alamat`, `role`, `password`) VALUES
(4, 'naila', 'admin@gmail.com', NULL, NULL, 'admin', '123'),
(6, 'Rika Witri', 'rika@gmail.com', '087676766', 'cempaka', 'peminjam', '$2y$10$PisJ/8PMrud3yrzvqBWJlOsYw7oqlKRv3Hvs63Y2uZOH5f2OxP00W'),
(7, 'Rahma Wati', 'rahma@gmail.com', '087667676', 'Garut', 'petugas', '$2y$10$JxO1.1JFJYMF7LyXYCAYx.1oCVRrLxrf5Kg8Go8eliyZiz7veYj/e'),
(8, 'Salsabila', 'salsa@gmail.com', '67688788', 'Jepang', 'petugas', '$2y$10$8c5/LawgYdRtbVRZklCH/OY1cg4giskyk08liSx.tHO1eJMwZRYqW'),
(9, 'Putri', 'pu@gmail.com', '75768787', 'bbj', 'petugas', '$2y$10$g.2CNHwgfaKjHhBqE9oO.eNf1JY/n107AKs28UkTcZV.KIWU/bYwq'),
(10, 'fitri', 'pipit@gmail.com', '7576755', 'cipageran', 'peminjam', '$2y$10$7Ptx4z/OHu8CarNXTkoG8e3HRMyMMK6uZe4DtBV8iGxh4akF/Rnv2'),
(11, 'rehan', 'rehan@gmail.com', '5565758', 'cibaduyut', 'petugas', '$2y$10$j75oVjIuF.M4l3Cw2BQxCObieyuVHP1zX/dvuM2jszx2XDupc6A3O'),
(12, 'rey', 'rey@gmail.com', NULL, NULL, 'peminjam', '12'),
(13, 'fitri', 'fitri12@gmail.com', NULL, NULL, 'peminjam', '123');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int NOT NULL,
  `id_peminjaman` int DEFAULT NULL,
  `jumlah_bayar` decimal(10,2) DEFAULT NULL,
  `tanggal_bayar` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `no_hp` varchar(15) DEFAULT NULL,
  `alamat` text,
  `password` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id_peminjaman`),
  ADD KEY `fk_peminjaman_user` (`id_user`);

--
-- Indexes for table `tabel_alat`
--
ALTER TABLE `tabel_alat`
  ADD PRIMARY KEY (`id_alat`);

--
-- Indexes for table `tabel_detail_peminjaman`
--
ALTER TABLE `tabel_detail_peminjaman`
  ADD PRIMARY KEY (`id_detail`);

--
-- Indexes for table `tabel_peminjaman`
--
ALTER TABLE `tabel_peminjaman`
  ADD PRIMARY KEY (`id_peminjaman`);

--
-- Indexes for table `tabel_transaksi`
--
ALTER TABLE `tabel_transaksi`
  ADD PRIMARY KEY (`id_transaksi`);

--
-- Indexes for table `tabel_user`
--
ALTER TABLE `tabel_user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `id_peminjaman` (`id_peminjaman`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id_peminjaman` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tabel_alat`
--
ALTER TABLE `tabel_alat`
  MODIFY `id_alat` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tabel_detail_peminjaman`
--
ALTER TABLE `tabel_detail_peminjaman`
  MODIFY `id_detail` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tabel_peminjaman`
--
ALTER TABLE `tabel_peminjaman`
  MODIFY `id_peminjaman` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tabel_transaksi`
--
ALTER TABLE `tabel_transaksi`
  MODIFY `id_transaksi` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tabel_user`
--
ALTER TABLE `tabel_user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `fk_peminjaman_user` FOREIGN KEY (`id_user`) REFERENCES `tabel_user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`id_peminjaman`) REFERENCES `peminjaman` (`id_peminjaman`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
