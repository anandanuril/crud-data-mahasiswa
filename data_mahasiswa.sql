-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 08, 2024 at 01:05 AM
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
-- Database: `data_mahasiswa`
--

-- --------------------------------------------------------

--
-- Table structure for table `nilai`
--

CREATE TABLE `nilai` (
  `id` int(11) NOT NULL,
  `nim` int(10) DEFAULT NULL,
  `nilai` decimal(5,2) DEFAULT NULL,
  `semester` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nilai`
--

INSERT INTO `nilai` (`id`, `nim`, `nilai`, `semester`) VALUES
(7, 202251215, 3.40, 'Genap 2023/2024'),
(8, 202251215, 3.61, 'Gasal 2022/2023'),
(22, 202257107, 3.80, 'Genap 2023/2024'),
(24, 202253131, 2.80, 'Gasal 2023/2024');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `nim` int(9) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `tempat_lahir` varchar(255) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `jenis_kelamin` enum('Laki-Laki','Perempuan') NOT NULL,
  `jurusan` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `alamat` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`nim`, `nama`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `jurusan`, `email`, `alamat`) VALUES
(202251215, 'Aulady Fibra Syaluna Goesni', 'Pati', '2004-03-01', 'Perempuan', 'Teknik Informatika', '202251215@std.umk.ac.id', 'Pati'),
(202251219, 'Alfiya Zahrotul Jannah', 'Jepara', '2003-05-08', 'Perempuan', 'Teknik Informatika', '202251219@std.umk.ac.id', 'Jepara'),
(202253131, 'Ananda Rehan', 'Pati', '2003-11-13', 'Laki-Laki', 'Sistem Informasi', '202253131@std.umk.ac.id', 'Kudus'),
(202253225, 'Kinan Tiara', 'Jepara', '2004-05-22', 'Perempuan', 'Sistem Informasi', '202253225@std.umk.ac.id', 'Kudus'),
(202254010, 'Muhammad Yusuf', 'Semarang', '2004-08-10', 'Laki-Laki', 'Teknik Mesin', '202254010@std.umk.ac.id', 'Kudus'),
(202257107, 'Avinda Deviana', 'Surabaya', '2003-07-01', 'Perempuan', 'Teknik Industri', '202257107@std.umk.ac.id', 'Kudus');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`username`, `password`) VALUES
('nana', '81dc9bdb52d04dc20036dbd8313ed055'),
('nuril', '5a1e3a5aede16d438c38862cac1a78db');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `nilai`
--
ALTER TABLE `nilai`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_nim` (`nim`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`nim`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `nilai`
--
ALTER TABLE `nilai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `nim` int(9) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=202257108;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `nilai`
--
ALTER TABLE `nilai`
  ADD CONSTRAINT `fk_nim` FOREIGN KEY (`nim`) REFERENCES `students` (`nim`),
  ADD CONSTRAINT `nilai_ibfk_1` FOREIGN KEY (`nim`) REFERENCES `students` (`nim`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
