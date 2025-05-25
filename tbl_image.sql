-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 25, 2025 at 09:57 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_image`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_image`
--

CREATE TABLE `tbl_image` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` varchar(200) NOT NULL,
  `quantity` int(50) NOT NULL,
  `filename` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_image`
--

INSERT INTO `tbl_image` (`id`, `name`, `price`, `description`, `quantity`, `filename`) VALUES
(64, 'prinz', 6999.00, 'tdhrhh', 439, '4.png'),
(69, 'rwwggrw', 77857.00, 'ghfhxndbh5y5e', 0, 'img_6831c8dd278b80.74828904.png'),
(70, 'nfkdjgk', 555.00, 'fbzgbhgtdzhdbfdbdz', 4, 'img_6831e2a3d30dd3.78779048.png'),
(71, 'prinz', 666.00, ' fhhbdh', 2, 'img_6831e69d020657.06948232.png'),
(72, 'example', 54635.00, 'fdgxfhdfhzddzeftgbsdz', 0, 'img_68320d10b3c936.13516095.png'),
(73, 'nfkdjgk', 77.00, 'sfgvsebs', 6, 'img_68322ab75977f7.84285718.png'),
(74, 'tecno 1', 557.00, 'ddfsdsfd', 999779, 'img_68322b213d5a34.71026182.png'),
(77, 'prinz', 55.00, 'dbgsgrf', 88, 'img_68326910b855d7.17009315.png'),
(78, 'tecno pova 5', 7700.00, 'midrange level gaming phone', 90, 'img_68326a54198318.05730084.png'),
(79, 'Tecno Pova 3', 9500.00, 'good for gaming and good camera', 0, 'img_68326bc2284309.89563113.png'),
(80, 'tecno pova 4', 6999.00, 'best gaming budget phone for you', 54, 'img_6832749ca53a28.22794443.png'),
(81, 'Tecno Camon 20 Limited Edition', 9999.00, 'midrange gaming phone and 50px camera 12/256gb', 99, 'img_68327baf8ac828.55241158.png'),
(82, 'tecno', 7777.00, 'budget gaming phone with aestetic design', 5, 'img_6832a298ec2445.60842220.png');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_image`
--
ALTER TABLE `tbl_image`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_image`
--
ALTER TABLE `tbl_image`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
