-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 18, 2023 at 06:25 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sensus`
--

-- --------------------------------------------------------

--
-- Table structure for table `detail_penduduk`
--

CREATE TABLE `detail_penduduk` (
  `id_detail` int(20) NOT NULL,
  `nik` varchar(16) NOT NULL,
  `nama_penduduk` varchar(200) NOT NULL,
  `id_dusun` int(20) NOT NULL,
  `id_pekerjaan` int(20) NOT NULL,
  `gender` enum('laki-laki','perempuan') NOT NULL,
  `date_birth` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `detail_penduduk`
--

INSERT INTO `detail_penduduk` (`id_detail`, `nik`, `nama_penduduk`, `id_dusun`, `id_pekerjaan`, `gender`, `date_birth`) VALUES
(9, '11223344556677', 'restu ahmad byhaqi', 3, 1, 'laki-laki', '2004-03-03'),
(10, '19012122250', 'patricia', 5, 3, 'perempuan', '2004-04-04');

-- --------------------------------------------------------

--
-- Table structure for table `dusun`
--

CREATE TABLE `dusun` (
  `id_dusun` int(20) NOT NULL,
  `code_dusun` varchar(5) NOT NULL,
  `nama_dusun` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `dusun`
--

INSERT INTO `dusun` (`id_dusun`, `code_dusun`, `nama_dusun`) VALUES
(3, '03', 'magersari'),
(5, '012', 'pokesari'),
(6, '012', 'candisari');

-- --------------------------------------------------------

--
-- Table structure for table `pekerjaan`
--

CREATE TABLE `pekerjaan` (
  `id_pekerjaan` int(20) NOT NULL,
  `nama_pekerjaan` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pekerjaan`
--

INSERT INTO `pekerjaan` (`id_pekerjaan`, `nama_pekerjaan`) VALUES
(1, 'Cyber Srucity'),
(2, 'fishing'),
(3, 'Programer');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role_id` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `email`, `username`, `password`, `role_id`) VALUES
(4, 'restuahmad612@gmail.com', 'awokawok', '93a84595f6d1bbc60723ee4be2587828', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detail_penduduk`
--
ALTER TABLE `detail_penduduk`
  ADD PRIMARY KEY (`id_detail`),
  ADD KEY `id_dusun` (`id_dusun`),
  ADD KEY `id_pekerjaan` (`id_pekerjaan`);

--
-- Indexes for table `dusun`
--
ALTER TABLE `dusun`
  ADD PRIMARY KEY (`id_dusun`);

--
-- Indexes for table `pekerjaan`
--
ALTER TABLE `pekerjaan`
  ADD PRIMARY KEY (`id_pekerjaan`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detail_penduduk`
--
ALTER TABLE `detail_penduduk`
  MODIFY `id_detail` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `dusun`
--
ALTER TABLE `dusun`
  MODIFY `id_dusun` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `pekerjaan`
--
ALTER TABLE `pekerjaan`
  MODIFY `id_pekerjaan` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_penduduk`
--
ALTER TABLE `detail_penduduk`
  ADD CONSTRAINT `detail_penduduk_ibfk_1` FOREIGN KEY (`id_dusun`) REFERENCES `dusun` (`id_dusun`),
  ADD CONSTRAINT `detail_penduduk_ibfk_2` FOREIGN KEY (`id_pekerjaan`) REFERENCES `pekerjaan` (`id_pekerjaan`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
