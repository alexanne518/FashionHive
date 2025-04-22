-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 22, 2025 at 08:38 PM
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
  `Name` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`Category_Id`, `Name`) VALUES
(1, 'T-Shirt'),
(2, 'Pants'),
(3, 'Sweater'),
(4, 'Shorts'),
(5, 'Capris'),
(6, 'Hoodie'),
(7, 'Skirt'),
(8, 'Jacket'),
(9, 'Button-up'),
(11, 'Long sleeve'),
(12, 'Tank Top'),
(13, 'Halter Top'),
(14, 'Tube Top'),
(15, 'Swim Suit'),
(16, 'Body Suit'),
(17, 'Dress'),
(18, 'Other');

-- --------------------------------------------------------

--
-- Table structure for table `closet_item`
--

CREATE TABLE `closet_item` (
  `Item_Id` int(11) NOT NULL,
  `Item_Image` varchar(50) NOT NULL,
  `Category_Id` int(11) NOT NULL COMMENT 'idk if ima do they can just put a ceteogry or if it will be a choice and a item can have any diffrent ceteogries',
  `Size_Id` int(11) NOT NULL,
  `User_Id` int(11) NOT NULL,
  `Color_Id` int(11) NOT NULL,
  `Description` varchar(100) NOT NULL COMMENT 'not sure if i should just make this text cause i dont want it to be too long'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `closet_item`
--

INSERT INTO `closet_item` (`Item_Id`, `Item_Image`, `Category_Id`, `Size_Id`, `User_Id`, `Color_Id`, `Description`) VALUES
(1, 'Red_Top.jpg', 3, 4, 6, 1, 'Cosy deep red knit sweater, off the shoulder'),
(2, 'BlackHolsterTop.jpg', 13, 2, 6, 10, 'Ribbon tie up back, with frills going down the fro'),
(4, 'Fur_Hoodie.jpg', 8, 5, 6, 13, 'over sized reversable fur zip up hoodie'),
(7, 'graySkirt.jpg', 7, 2, 6, 13, 'A-line skirt, with draw string, low-rise mini skir'),
(8, 'dc692ee9382c06db77ba351d43118599.jpg', 2, 4, 6, 10, 'graphic design sweat pants'),
(9, '08a53dffae31a44b8e0eaa12c224e2be.jpg', 15, 3, 6, 14, 'Y2K, triangle bikini, tie straps, gemstone details'),
(10, 'download (15).jpg', 4, 3, 6, 4, 'low waisted, Abercrombie Fitch'),
(13, '030beb2e-fca6-4a24-9c35-5c9ee5615195.jpg', 16, 3, 6, 10, 'zip but body suit short sleeve, grommet belt to sn'),
(19, 'ac6bb9203ae6195d96e6768f8caa573c.jpg', 17, 4, 16, 13, 'sleeveless short dress'),
(20, '2196ab6b-6169-476c-87d9-acb3c9336cad.jpg', 12, 2, 16, 10, 'Full length DC tank top '),
(21, '6575d035-7138-4ada-99c7-5a5edda3847c.jpg', 1, 3, 16, 11, 'baby T, with a cat design'),
(22, 'dfe13d1a-c42f-49fc-aa3c-8a1427c68a2b.jpg', 2, 3, 16, 13, 'monkey sweat pants'),
(23, 'harley v neck long sleeve.jpg', 11, 5, 12, 10, 'Harley Davidson graphic long sleeve, v neck line, '),
(24, 'a3136e319c663605e02552206561a668.jpg', 4, 4, 12, 10, 'Jean shorts, black denim wash, cobra design on one'),
(25, '72f954730ffa3782ddf5bbf796b90dc6.jpg', 7, 2, 16, 10, 'mini skirt, lace details, ruffles at the bottom'),
(26, '7b982c37b4b89e5177e41c267db25218.jpg', 1, 5, 17, 9, 'over sized t shirt, with blanched design'),
(28, 'Screenshot_20250419_160318_TikTok.webp', 1, 2, 18, 11, 'silk  shirt with bows and lace detailing, with gems for buttons '),
(29, 'Screenshot_20250419_160249_TikTok.webp', 7, 2, 18, 8, 'Dusty pink high rise A-line lace skirt, heart buttons, lace up sides'),
(30, 'Screenshot_20250419_161507_Chrome.webp', 9, 3, 18, 11, 'of the shoulder top with a center bow lace doing down the front and on all the edges from Liz Lisa'),
(31, 'Screenshot_20250419_161615_Chrome.webp', 17, 2, 18, 8, 'baby pink very frilly dress with a lot of ruffles big bow in the middle'),
(32, 'Screenshot_20250419_162121_Chrome.webp', 5, 4, 18, 15, 'jean capris with flower embroidery'),
(33, 'ee63762e03e0ff8ec2d6b5d41a36f487.jpg', 6, 5, 12, 10, 'over sized hoodie with spray painted crosses'),
(34, '8d92a9b02ba39ef9654a530bf12033ed.jpg', 2, 4, 19, 13, 'sweat pants, street wear');

-- --------------------------------------------------------

--
-- Table structure for table `color`
--

CREATE TABLE `color` (
  `Color_Id` int(11) NOT NULL,
  `Color` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `color`
--

INSERT INTO `color` (`Color_Id`, `Color`) VALUES
(1, 'Red'),
(2, 'Yellow'),
(3, 'Orange'),
(4, 'Blue'),
(5, 'Green'),
(6, 'Turquoise'),
(7, 'Purple'),
(8, 'Pink'),
(9, 'Brown'),
(10, 'Black'),
(11, 'White'),
(12, 'Off-white'),
(13, 'Grey'),
(14, 'Pattern'),
(15, 'Jean');

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
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `User_Id` int(11) NOT NULL COMMENT 'user to keep the and show that they liked it when browsing',
  `Item_Id` int(11) NOT NULL COMMENT 'i wanna read the table and see how many times it shows up and thrm like that will display how musny likes there are'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`User_Id`, `Item_Id`) VALUES
(12, 9),
(12, 26),
(16, 7),
(16, 9),
(17, 26),
(18, 9);

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
(7, 'XXL'),
(8, 'XXXL'),
(9, 'XXXXL');

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
(6, 'me', '$2a$10$49f68a5c8493ec2c0bf48uXfXJg5JIHf8HivnutkzwqJEgRzQ4jk.', '$2a$10$49f68a5c8493ec2c0bf489$', NULL),
(12, 'alex', '$2x$10$202cb962ac59075b964b0u17KOeAgWKmMLNwnJdPBNvzQ3dRZ6ukK', '$2x$10$202cb962ac59075b964b07$', NULL),
(16, 'hi', '$2a$10$bfa99df33b137bc8fb5f5uRfWHHENsclDwxnLNsEeGLUYJWL2DzV.', '$2a$10$bfa99df33b137bc8fb5f54$', NULL),
(17, 'donald', '*0', '$2y$6$202cb962ac59075b964b07$', NULL),
(18, 'nelly', '*0', '$2a$7$5c12e5ef40371e308f2dd1$', NULL),
(19, 'bao', '*0', '$2x$9$202cb962ac59075b964b07$', NULL);

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
  ADD KEY `size_Id_FK` (`Size_Id`),
  ADD KEY `color_id_FK` (`Color_Id`);

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
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`User_Id`,`Item_Id`),
  ADD KEY `user_Like_id_FK` (`User_Id`),
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
  MODIFY `Category_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `closet_item`
--
ALTER TABLE `closet_item`
  MODIFY `Item_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `color`
--
ALTER TABLE `color`
  MODIFY `Color_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `size`
--
ALTER TABLE `size`
  MODIFY `Size_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `User_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

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
  ADD CONSTRAINT `color_id_FK` FOREIGN KEY (`Color_Id`) REFERENCES `color` (`Color_Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `size_Id_FK` FOREIGN KEY (`Size_Id`) REFERENCES `size` (`Size_Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_Id_FK` FOREIGN KEY (`User_Id`) REFERENCES `user` (`User_Id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `favortie_list`
--
ALTER TABLE `favortie_list`
  ADD CONSTRAINT `item_Fav_Id_FK` FOREIGN KEY (`Item_Id`) REFERENCES `closet_item` (`Item_Id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_Fav_Id_FK` FOREIGN KEY (`User_Id`) REFERENCES `user` (`User_Id`);

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
