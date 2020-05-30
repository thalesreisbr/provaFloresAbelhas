-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 29, 2020 at 02:21 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.3.18

CREATE DATABASE flores;

USE flores;	



SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `calendarioflores`
--

-- --------------------------------------------------------

--
-- Table structure for table `abelha`
--

CREATE TABLE `abelha` (
  `id` int(1) NOT NULL,
  `nome` varchar(30) NOT NULL,
  `especie` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `abelha`
--

INSERT INTO `abelha` (`id`, `nome`, `especie`) VALUES
(1, 'Uruçu', 'Melipona scutellaris'),
(2, 'Uruçu-Amarela', 'Melipona rufiventris'),
(3, 'Guarupu', 'Melipona bicolor'),
(4, 'Iraí', 'Nannotrigona testaceicornes');

-- --------------------------------------------------------

--
-- Table structure for table `flor`
--

CREATE TABLE `flor` (
  `id` int(11) NOT NULL,
  `nome` varchar(30) NOT NULL,
  `especie` varchar(60) NOT NULL,
  `descricao` varchar(400) NOT NULL,
  `idImagem` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `florescimento`
--

CREATE TABLE `florescimento` (
  `id` int(11) NOT NULL,
  `idMes` varchar(5) NOT NULL,
  `idFlor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



-- --------------------------------------------------------

--
-- Table structure for table `imagem`
--

CREATE TABLE `imagem` (
  `id` int(11) NOT NULL,
  `arquivo` varchar(40) NOT NULL,
  `data` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- --------------------------------------------------------

--
-- Table structure for table `polinizacao`
--

CREATE TABLE `polinizacao` (
  `id` int(11) NOT NULL,
  `idFlor` int(11) NOT NULL,
  `idAbelha` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `polinizacao`
--

--
-- Indexes for dumped tables
--

--
-- Indexes for table `abelha`
--
ALTER TABLE `abelha`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `flor`
--
ALTER TABLE `flor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_imagem` (`idImagem`);

--
-- Indexes for table `florescimento`
--
ALTER TABLE `florescimento`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_flor` (`idFlor`);

--
-- Indexes for table `imagem`
--
ALTER TABLE `imagem`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `polinizacao`
--
ALTER TABLE `polinizacao`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_abelha` (`idAbelha`);

--
-- AUTO_INCREMENT for dumped tables
--
ALTER TABLE imagem MODIFY COLUMN id INT(11) auto_increment;

--
-- AUTO_INCREMENT for table `abelha`
--
ALTER TABLE `abelha`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;


--
-- Constraints for dumped tables
--

--
-- Constraints for table `flor`
--
ALTER TABLE `flor`
  ADD CONSTRAINT `fk_imagem` FOREIGN KEY (`idImagem`) REFERENCES `imagem` (`id`);

ALTER TABLE polinizacao MODIFY COLUMN id INT(11) auto_increment;



ALTER TABLE flor MODIFY COLUMN id INT(11) auto_increment;

--
-- Constraints for table `florescimento`
--
ALTER TABLE `florescimento`
  ADD CONSTRAINT `fk_flor` FOREIGN KEY (`idFlor`) REFERENCES `flor` (`id`);

ALTER TABLE florescimento MODIFY COLUMN id INT(11) auto_increment;

--
-- Constraints for table `polinizacao`
--
ALTER TABLE polinizacao MODIFY COLUMN id INT(11) auto_increment;

ALTER TABLE `polinizacao`
  ADD CONSTRAINT `fk_abelha` FOREIGN KEY (`idAbelha`) REFERENCES `abelha` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
