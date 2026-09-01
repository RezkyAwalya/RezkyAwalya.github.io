-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 11, 2025 at 06:04 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kasir_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id_barang` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `varian` varchar(100) DEFAULT NULL,
  `harga_beli` decimal(10,2) NOT NULL,
  `harga_jual` decimal(10,2) NOT NULL,
  `diskon` decimal(5,0) NOT NULL DEFAULT 0,
  `stok` int(11) NOT NULL,
  `satuan` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id_barang`, `nama`, `varian`, `harga_beli`, `harga_jual`, `diskon`, `stok`, `satuan`) VALUES
(2, 'Laptop', 'Elektronik', 5000000.00, 4000000.00, 20, 0, ''),
(4, 'HP', 'Elektronik', 2000000.00, 1800000.00, 10, 0, ''),
(5, 'TV', 'Elektronik', 5000000.00, 4000000.00, 20, 0, ''),
(7, 'Kulkas', 'Elektronik', 10000000.00, 9000000.00, 10, 0, '');

-- --------------------------------------------------------

--
-- Table structure for table `pembeli`
--

CREATE TABLE `pembeli` (
  `id_pembeli` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jns_kelamin` enum('Laki-laki','Perempuan') NOT NULL,
  `alamat` text NOT NULL,
  `kode_pos` varchar(10) DEFAULT NULL,
  `kota` varchar(50) DEFAULT NULL,
  `tgl_lahir` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembeli`
--

INSERT INTO `pembeli` (`id_pembeli`, `nama`, `jns_kelamin`, `alamat`, `kode_pos`, `kota`, `tgl_lahir`) VALUES
(1, 'alya', 'Perempuan', 'rapkal', '00765', 'makassar', '2007-01-17'),
(2, 'Jaehyun', 'Laki-laki', 'Korea', '09202', 'Gangnam', '1997-02-14'),
(3, 'al', 'Perempuan', 'skdhs', '23813', 'makassarr', '2025-04-11'),
(4, 'yaya', 'Perempuan', 'rapkal', '12345', 'mks', '2025-04-11');

-- --------------------------------------------------------

--
-- Table structure for table `pembelian`
--

CREATE TABLE `pembelian` (
  `id_pembelian` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `id_supplier` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `tgl` date DEFAULT curdate()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pesanan`
--

CREATE TABLE `pesanan` (
  `id_pesanan` int(11) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `id_barang` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `tgl_pesan` datetime DEFAULT current_timestamp(),
  `total_harga` decimal(10,2) NOT NULL,
  `diskon` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pesanan`
--

INSERT INTO `pesanan` (`id_pesanan`, `id_pelanggan`, `id_barang`, `qty`, `tgl_pesan`, `total_harga`, `diskon`) VALUES
(13, 1, 2, 2, '2025-04-01 19:39:32', 8400000.00, 0),
(26, 2, 2, 1, '2025-04-02 12:22:26', 3000000.00, 0),
(28, 1, 2, 1, '2025-04-02 12:26:35', 3000000.00, 0);

-- --------------------------------------------------------

--
-- Table structure for table `struk_pembelian`
--

CREATE TABLE `struk_pembelian` (
  `id_struk` int(11) NOT NULL,
  `id_pesanan` int(11) DEFAULT NULL,
  `nama_pembeli` varchar(255) DEFAULT NULL,
  `nama_barang` varchar(255) DEFAULT NULL,
  `harga_sebelum_diskon` decimal(10,2) DEFAULT NULL,
  `diskon` decimal(10,2) DEFAULT NULL,
  `harga_setelah_diskon` decimal(10,2) DEFAULT NULL,
  `tgl_struk` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `struk_pembelian`
--

INSERT INTO `struk_pembelian` (`id_struk`, `id_pesanan`, `nama_pembeli`, `nama_barang`, `harga_sebelum_diskon`, `diskon`, `harga_setelah_diskon`, `tgl_struk`) VALUES
(1, 28, '', 'Laptop', 6000000.00, 3000000.00, 3000000.00, '2025-04-02 04:26:35');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id_supplier` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `kode_pos` varchar(10) DEFAULT NULL,
  `kota` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`) VALUES
(2, 'admin', '$2y$10$hoNuU5O3tFjYXSzIieDDqO/JSasW1zet60s41oTNWLFXBWuB9F/1C');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`);

--
-- Indexes for table `pembeli`
--
ALTER TABLE `pembeli`
  ADD PRIMARY KEY (`id_pembeli`);

--
-- Indexes for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD PRIMARY KEY (`id_pembelian`),
  ADD KEY `pembelian_ibfk_1` (`id_barang`),
  ADD KEY `pembelian_ibfk_2` (`id_supplier`);

--
-- Indexes for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id_pesanan`),
  ADD KEY `pesanan_ibfk_2` (`id_barang`),
  ADD KEY `pesanan_ibfk_1` (`id_pelanggan`);

--
-- Indexes for table `struk_pembelian`
--
ALTER TABLE `struk_pembelian`
  ADD PRIMARY KEY (`id_struk`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id_supplier`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id_barang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `pembeli`
--
ALTER TABLE `pembeli`
  MODIFY `id_pembeli` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pembelian`
--
ALTER TABLE `pembelian`
  MODIFY `id_pembelian` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id_pesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `struk_pembelian`
--
ALTER TABLE `struk_pembelian`
  MODIFY `id_struk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id_supplier` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD CONSTRAINT `pembelian_ibfk_1` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pembelian_ibfk_2` FOREIGN KEY (`id_supplier`) REFERENCES `supplier` (`id_supplier`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pesanan`
--
ALTER TABLE `pesanan`
  ADD CONSTRAINT `pesanan_ibfk_1` FOREIGN KEY (`id_pelanggan`) REFERENCES `pembeli` (`id_pembeli`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pesanan_ibfk_2` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
