-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 10, 2024 at 03:50 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `carrental`
--

-- --------------------------------------------------------

--
-- Table structure for table `cars`
--

CREATE TABLE `cars` (
  `id` int(11) NOT NULL,
  `brand` varchar(50) DEFAULT NULL,
  `model` varchar(50) DEFAULT NULL,
  `color` varchar(20) DEFAULT NULL,
  `image` char(255) DEFAULT NULL,
  `km` int(11) DEFAULT NULL,
  `price` decimal(10,0) DEFAULT NULL,
  `available` tinyint(1) DEFAULT 1,
  `owner_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cars`
--

INSERT INTO `cars` (`id`, `brand`, `model`, `color`, `image`, `km`, `price`, `available`, `owner_id`) VALUES
(1, 'Toyota', 'Corolla', 'Red', 'corolla.jpg', 50000, 15000, 1, 1),
(2, 'Honda', 'Civic', 'Blue', 'civic.jpg', 60000, 17000, 1, 1),
(3, 'Ford', 'Fiesta', 'Silver', 'fiesta.jpg', 40000, 12000, 1, 3),
(4, 'Tesla', 'Model S', 'Black', 'model_s.jpg', 20000, 60000, 0, 4),
(5, 'Chevrolet', 'Camaro', 'Yellow', 'camaro.jpg', 30000, 35000, 1, 4),
(6, 'BMW', '3 Series', 'White', '3_series.jpg', 45000, 25000, 0, 2),
(7, 'Mercedes-Benz', 'E-Class', 'Gray', 'e_class.jpg', 55000, 30000, 1, 2),
(8, 'Fiat', 'Punto', 'Red', 'punto.jpg', 30000, 10000, 1, 3),
(9, 'Ferrari', 'F8', 'Red', 'F8.jpg', 10000, 200000, 1, 4),
(10, 'Audi', 'R8', 'Blue', 'R8.jpg', 15000, 150000, 0, 2),
(11, 'Lamborghini', 'Aventador', 'Yellow', 'aventador.jpg', 10000, 250000, 1, 1),
(12, 'Bugatti', 'Veyron', 'Black', 'veyron.jpg', 5000, 1000000, 1, 3),
(13, 'Porsche', '911', 'Silver', '911.jpg', 20000, 100000, 0, 1),
(14, 'McLaren', '720S', 'Orange', '720S.jpg', 10000, 200000, 1, 2),
(15, 'Koenigsegg', 'Agera', 'Blue', 'agera.jpg', 5000, 1000000, 1, 4),
(16, 'Pagani', 'Huayra', 'Silver', 'huayra.jpg', 5000, 1000000, 1, 3),
(17, 'Rolls-Royce', 'Phantom', 'Black', 'phantom.jpg', 20000, 500000, 0, 2),
(18, 'Bentley', 'Continental GT', 'White', 'continental_gt.jpg', 20000, 300000, 1, 1),
(19, 'Maserati', 'GranTurismo', 'Red', 'granturismo.jpg', 20000, 150000, 1, 4),
(20, 'Lotus', 'Evora', 'Orange', 'evora.jpg', 20000, 50000, 1, 3),
(21, 'Alfa Romeo', 'Giulia', 'Red', 'giulia.jpg', 20000, 50000, 1, 2),
(22, 'Jaguar', 'F-Type', 'Blue', 'f_type.jpg', 20000, 100000, 0, 1),
(23, 'Aston Martin', 'DB11', 'Silver', 'db11.jpg', 20000, 200000, 1, 4),
(24, 'Volvo', 'XC90', 'Black', 'xc90.jpg', 20000, 60000, 1, 3),
(26, 'Jeep', 'Wrangler', 'Green', 'wrangler.jpg', 20000, 40000, 0, 1),
(27, 'Land Rover', 'Range Rover', 'White', 'range_rover.jpg', 20000, 80000, 1, 2),

-- --------------------------------------------------------

--
-- Table structure for table `command`
--

CREATE TABLE `command` (
  `command_id` int(11) NOT NULL,
  `car_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `rental_date` date DEFAULT curdate(),
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `rental_period` int(11) DEFAULT NULL,
  `confirmed` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `command`
--

INSERT INTO `command` (`command_id`, `car_id`, `user_id`, `rental_date`, `start_date`, `end_date`, `rental_period`, `confirmed`) VALUES
(1, 1, 2, '2024-03-25', '2024-04-01', '2024-04-08', 7, 0),
(2, 6, 1, '2024-03-25', '2024-04-05', '2024-04-10', 5, 1),
(3, 3, 3, '2024-03-25', '2024-04-02', '2024-04-07', 5, 1),
(4, 4, 4, '2024-03-25', '2024-04-03', '2024-04-06', 3, 1),
(5, 5, 5, '2024-03-25', '2024-04-04', '2024-04-09', 5, 1),
(6, 2, 4, '2024-03-25', '2024-04-05', '2024-04-10', 5, 0),
(7, 7, 1, '2024-03-25', '2024-04-06', '2024-04-11', 5, 1),
(8, 8, 1, '2024-03-25', '2024-04-07', '2024-04-12', 5, 0),
(9, 9, 2, '2024-03-25', '2024-04-08', '2024-04-13', 5, NULL),
(10, 10, 2, '2024-03-25', '2024-04-09', '2024-04-14', 5, NULL),
(11, 11, 3, '2024-03-25', '2024-04-10', '2024-04-15', 5, NULL),
(12, 12, 3, '2024-03-25', '2024-04-11', '2024-04-16', 5, 1),
(13, 13, 3, '2024-03-25', '2024-04-12', '2024-04-17', 5, 0),
(14, 14, 5, '2024-03-25', '2024-04-13', '2024-04-18', 5, 1),
(15, 15, 5, '2024-03-25', '2024-04-14', '2024-04-19', 5, NULL),
(16, 16, 5, '2024-03-25', '2024-04-15', '2024-04-20', 5, 1),
(17, 17, 2, '2024-03-25', '2024-04-16', '2024-04-21', 5, 0),
(18, 1, 2, '2024-04-10', '2024-04-11', '2024-04-13', 2, NULL),
(19, 1, 2, '2024-04-10', '2024-04-10', '2024-04-26', 16, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstName` varchar(30) DEFAULT NULL,
  `lastName` varchar(30) DEFAULT NULL,
  `password` char(255) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `creation_date` date DEFAULT curdate(),
  `role` varchar(30) DEFAULT NULL,
  `country` varchar(30) DEFAULT '',
  `state` varchar(30) DEFAULT '',
  `profile_image` char(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstName`, `lastName`, `password`, `email`, `creation_date`, `role`, `country`, `state`, `profile_image`) VALUES
(1, 'John', 'Doe', '$2y$10$XmlB4fnBhkyj5GfebEmnAudokyMGub.wwY8ITtmiIp1TvxgsUubui', 'john@example.com', '2024-03-25', 'customer', 'United States', 'California', 'mezyen.jpg'),
(2, 'Alice', 'Smith', '$2y$10$/ZTHJRJsHG5lirB1JjaRpOXHOOF1KC6y7ZanpbgVUye6KRAIKhYGa', 'alice@example.com', '2024-03-25', 'admin', 'United States', 'New York', 'mezyena.jpg'),
(3, 'Bob', 'Johnson', '$2y$10$4YbFe/Uuyyd1WODpO0jTpOFFeGsumfTkpU6HO50/pe0pIUowkOw7m', 'bob@example.com', '2024-03-25', 'customer', 'United States', 'Texas', NULL),
(4, 'Emily', 'Brown', '$2y$10$4GEXhqzPZxhzy.keNOIEIuLaFFZ8/o0KJsZSv2fG58t7mE6MZEIEq', 'emily@example.com', '2024-03-26', 'seller', 'United States', 'Florida', NULL),
(5, 'David', 'Wilson', '$2y$10$n1m.W.Hmme3QKayqqHqTPuMj1W9DjPNwUnRc3vHZ.L1Tqez9ZwFIe', 'david@example.com', '2024-03-27', 'banned', 'United States', 'Washington', NULL),
(6, 'Sophia', 'Taylor', '$2y$10$8XkhXG1wzDHwJ0feOea40uIzfqjYVFSUc5QIyD9O0tariD0j.CY/2', 'sophia@example.com', '2024-03-27', 'customer', 'United States', 'California', NULL),
(7, 'Testing_forgot', 'Testing_forgot', '$2y$10$GMYuzMrzpMxKytHUXvE0T.Lr6VAXVS/NyS7mmDAJsJFTCV2edMeaW', 'xixolif560@dacgu.com', '2024-04-08', 'customer', '', '', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cars`
--
ALTER TABLE `cars`
  ADD PRIMARY KEY (`id`),
  ADD KEY `owner_id` (`owner_id`);

--
-- Indexes for table `command`
--
ALTER TABLE `command`
  ADD PRIMARY KEY (`command_id`),
  ADD KEY `car_id` (`car_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cars`
--
ALTER TABLE `cars`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `command`
--
ALTER TABLE `command`
  MODIFY `command_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cars`
--
ALTER TABLE `cars`
  ADD CONSTRAINT `cars_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `command`
--
ALTER TABLE `command`
  ADD CONSTRAINT `command_ibfk_1` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `command_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
