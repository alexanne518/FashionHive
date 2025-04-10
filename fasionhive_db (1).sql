-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 06, 2025 at 02:20 AM
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
-- Database: `fasionhive_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `Category_Id` int(11) NOT NULL,
  `Name` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`Category_Id`, `Name`) VALUES
(1, 'T-Shirt'),
(2, 'Pants'),
(3, 'Sweater');

-- --------------------------------------------------------

--
-- Table structure for table `closet_item`
--

CREATE TABLE `closet_item` (
  `Item_Id` int(11) NOT NULL,
  `Item_Image` varchar(30) NOT NULL,
  `Category_Id` int(11) NOT NULL COMMENT 'idk if ima do they can just put a ceteogry or if it will be a choice and a item can have any diffrent ceteogries',
  `Size_Id` int(11) NOT NULL,
  `User_Id` int(11) NOT NULL,
  `Description` varchar(50) NOT NULL COMMENT 'not sure if i should just make this text cause i dont want it to be too long'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `closet_item`
--

INSERT INTO `closet_item` (`Item_Id`, `Item_Image`, `Category_Id`, `Size_Id`, `User_Id`, `Description`) VALUES
(1, 'Red_Top.jpg', 3, 4, 6, 'Cosy deep red knit sweater, off the shoulder');

-- --------------------------------------------------------

--
-- Table structure for table `color`
--

CREATE TABLE `color` (
  `Color_Id` int(11) NOT NULL,
  `Color` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `favortie_list`
--

CREATE TABLE `favortie_list` (
  `User_Id` int(11) NOT NULL,
  `Item_Id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `item_details`
--

CREATE TABLE `item_details` (
  `Item_Id` int(11) NOT NULL,
  `Color_Id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `user_Id` int(11) NOT NULL COMMENT 'user to keep the and show that they liked it when browsing',
  `Item_Id` int(11) NOT NULL COMMENT 'i wanna read the table and see how many times it shows up and thrm like that will display how musny likes there are'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `size`
--

CREATE TABLE `size` (
  `Size_Id` int(11) NOT NULL,
  `Size` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `size`
--

INSERT INTO `size` (`Size_Id`, `Size`) VALUES
(1, 'XXS'),
(2, 'XS'),
(3, 'S'),
(4, 'M'),
(5, 'L'),
(6, 'XL'),
(7, 'XXL');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `User_Id` int(11) NOT NULL,
  `Username` varchar(20) NOT NULL,
  `Password` varchar(255) NOT NULL,
  `Salt` varchar(30) NOT NULL,
  `Profile_Img` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`User_Id`, `Username`, `Password`, `Salt`, `Profile_Img`) VALUES
(6, 'me', '$2a$10$49f68a5c8493ec2c0bf48uXfXJg5JIHf8HivnutkzwqJEgRzQ4jk.', '$2a$10$49f68a5c8493ec2c0bf489$', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_comment`
--

CREATE TABLE `user_comment` (
  `Comment_Id` int(11) NOT NULL,
  `Comment` text NOT NULL,
  `Item_Id` int(11) NOT NULL,
  `User_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`Category_Id`);

--
-- Indexes for table `closet_item`
--
ALTER TABLE `closet_item`
  ADD PRIMARY KEY (`Item_Id`),
  ADD KEY `Category_Id_FK` (`Category_Id`),
  ADD KEY `user_Id_FK` (`User_Id`),
  ADD KEY `size_Id_FK` (`Size_Id`);

--
-- Indexes for table `color`
--
ALTER TABLE `color`
  ADD PRIMARY KEY (`Color_Id`);

--
-- Indexes for table `favortie_list`
--
ALTER TABLE `favortie_list`
  ADD PRIMARY KEY (`User_Id`,`Item_Id`),
  ADD KEY `item_Fav_Id_FK` (`Item_Id`),
  ADD KEY `user_Fav_Id_FK` (`User_Id`);

--
-- Indexes for table `item_details`
--
ALTER TABLE `item_details`
  ADD PRIMARY KEY (`Item_Id`,`Color_Id`),
  ADD KEY `Item_Id_FK` (`Item_Id`),
  ADD KEY `Color_Id_FK` (`Color_Id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`user_Id`,`Item_Id`),
  ADD KEY `user_Like_id_FK` (`user_Id`),
  ADD KEY `Item_Liked_Id_FK` (`Item_Id`);

--
-- Indexes for table `size`
--
ALTER TABLE `size`
  ADD PRIMARY KEY (`Size_Id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`User_Id`);

--
-- Indexes for table `user_comment`
--
ALTER TABLE `user_comment`
  ADD PRIMARY KEY (`Comment_Id`),
  ADD KEY `comment_Item_Id_FK` (`Item_Id`),
  ADD KEY `User_FK` (`User_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `Category_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `closet_item`
--
ALTER TABLE `closet_item`
  MODIFY `Item_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `color`
--
ALTER TABLE `color`
  MODIFY `Color_Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `size`
--
ALTER TABLE `size`
  MODIFY `Size_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `User_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_comment`
--
ALTER TABLE `user_comment`
  MODIFY `Comment_Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `closet_item`
--
ALTER TABLE `closet_item`
  ADD CONSTRAINT `Category_Id_FK` FOREIGN KEY (`Category_Id`) REFERENCES `category` (`Category_Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `size_Id_FK` FOREIGN KEY (`Size_Id`) REFERENCES `size` (`Size_Id`),
  ADD CONSTRAINT `user_Id_FK` FOREIGN KEY (`User_Id`) REFERENCES `user` (`User_Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `favortie_list`
--
ALTER TABLE `favortie_list`
  ADD CONSTRAINT `item_Fav_Id_FK` FOREIGN KEY (`Item_Id`) REFERENCES `closet_item` (`Item_Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_Fav_Id_FK` FOREIGN KEY (`User_Id`) REFERENCES `user` (`User_Id`);

--
-- Constraints for table `item_details`
--
ALTER TABLE `item_details`
  ADD CONSTRAINT `Color_Id_FK` FOREIGN KEY (`Color_Id`) REFERENCES `color` (`Color_Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Item_Id_FK` FOREIGN KEY (`Item_Id`) REFERENCES `closet_item` (`Item_Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `Item_Liked_Id_FK` FOREIGN KEY (`Item_Id`) REFERENCES `closet_item` (`Item_Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_Like_id_FK` FOREIGN KEY (`user_Id`) REFERENCES `user` (`User_Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_comment`
--
ALTER TABLE `user_comment`
  ADD CONSTRAINT `User_FK` FOREIGN KEY (`User_ID`) REFERENCES `user` (`User_Id`),
  ADD CONSTRAINT `comment_Item_Id_FK` FOREIGN KEY (`Item_Id`) REFERENCES `closet_item` (`Item_Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
