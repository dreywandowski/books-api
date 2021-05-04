-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 02, 2021 at 09:24 PM
-- Server version: 8.0.21
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `books`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

DROP TABLE IF EXISTS `books`;
CREATE TABLE IF NOT EXISTS `books` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `isbn` varchar(255) NOT NULL,
  `authors` varchar(255) NOT NULL,
  `release_date` date NOT NULL,
  `number_of_pages` int NOT NULL,
  `publisher` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `name`, `isbn`, `authors`, `release_date`, `number_of_pages`, `publisher`, `country`) VALUES
(1, 'Wary Transgressor', '3839392-393849', 'James Hardley Chase', '2008-11-02', 67, 'Harlequinn Books', 'USA'),
(2, 'cAnimal Farm', '3839392-393849', 'George Orwell', '2008-11-02', 67, 'Harlequinn Books', 'USA'),
(3, 'Animal Farm', '3839392-393849', 'George Orwell', '2008-11-02', 67, 'Harlequinn Books', 'USA'),
(4, '1984', '3839392-393849', 'George Orwell', '2008-11-02', 67, 'Harlequinn Books', 'USA'),
(5, 'Things Fall Apart', '3392-393849', 'Chinua Achebe', '2009-11-02', 500, 'Harlequinn Books', 'Nigeria');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
