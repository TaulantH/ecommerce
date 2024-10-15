-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 15, 2024 at 04:24 PM
-- Server version: 8.0.31
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project_fullstack_ecommerce`
--
CREATE DATABASE IF NOT EXISTS `project_fullstack_ecommerce` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `project_fullstack_ecommerce`;

-- --------------------------------------------------------

--
-- Table structure for table `banlist`
--

DROP TABLE IF EXISTS `banlist`;
CREATE TABLE IF NOT EXISTS `banlist` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `expiration_time` datetime NOT NULL,
  `fk_users` int NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `fk_users` (`fk_users`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `banlist`
--

INSERT INTO `banlist` (`ID`, `expiration_time`, `fk_users`) VALUES
(15, '2023-08-23 20:35:00', 5),
(16, '2023-08-23 20:38:00', 5),
(17, '2023-08-23 20:46:00', 5);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `category` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`ID`, `category`) VALUES
(1, 'Tops'),
(2, 'Pants'),
(3, 'Dresses'),
(4, 'Fleece & Sweats');

-- --------------------------------------------------------

--
-- Table structure for table `discounts`
--

DROP TABLE IF EXISTS `discounts`;
CREATE TABLE IF NOT EXISTS `discounts` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `discount` int NOT NULL,
  `fk_category` int NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `fk_category` (`fk_category`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `discounts`
--

INSERT INTO `discounts` (`ID`, `discount`, `fk_category`, `name`) VALUES
(9, 25, 1, NULL),
(10, 69, 3, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `fk_user` int NOT NULL,
  `fk_product` int NOT NULL,
  `fk_purchase` int NOT NULL,
  `quantity` int NOT NULL,
  PRIMARY KEY (`ID`),
  KEY `fk_user` (`fk_user`),
  KEY `fk_product` (`fk_product`),
  KEY `fk_purchase` (`fk_purchase`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`ID`, `fk_user`, `fk_product`, `fk_purchase`, `quantity`) VALUES
(17, 5, 17, 30, 2),
(18, 5, 19, 31, 1),
(19, 5, 17, 32, 7),
(20, 5, 17, 33, 7),
(21, 5, 17, 34, 7),
(22, 5, 17, 35, 2),
(23, 5, 21, 35, 1),
(24, 5, 20, 36, 1),
(25, 5, 21, 36, 1),
(26, 5, 22, 36, 1),
(27, 5, 17, 37, 1),
(28, 5, 18, 37, 1),
(29, 5, 19, 37, 1),
(30, 10, 22, 38, 1),
(31, 10, 23, 38, 1),
(32, 10, 23, 39, 1),
(33, 10, 22, 40, 1),
(34, 10, 24, 40, 1),
(35, 10, 18, 41, 1),
(36, 10, 19, 42, 1),
(37, 10, 19, 43, 2),
(38, 10, 18, 44, 1),
(39, 10, 17, 44, 1),
(40, 11, 18, 45, 1),
(41, 11, 19, 45, 1),
(42, 11, 18, 46, 1),
(43, 11, 20, 46, 1),
(44, 11, 20, 47, 1),
(45, 11, 19, 48, 1),
(46, 11, 18, 48, 1),
(47, 11, 19, 49, 1),
(48, 10, 17, 50, 1),
(49, 10, 19, 50, 1),
(50, 10, 19, 51, 1),
(51, 10, 19, 52, 1),
(52, 10, 18, 53, 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration_time` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `password_reset_tokens`
--

INSERT INTO `password_reset_tokens` (`id`, `user_id`, `token`, `expiration_time`) VALUES
(1, 10, '6274f90a8a5816fa1927dcd337fc12bfcd0ced0a96c6cdf18c93a4ef240d2661', '2023-09-22 22:25:20'),
(2, 10, '08c90e988a459272a369b2c6359fe52ac7c04178e0ed45f1d6dc333371f9d666', '2023-09-22 22:28:17'),
(3, 10, 'e37cfd2dd710f30da2ddefa14364aad76e2cd26e006e4e1fe14b11cc9b63b12e', '2023-09-22 22:33:01'),
(4, 10, '655695407a35eafe36079a9ca0f0e91141848dcc34058036e18c48eca7a4f40c', '2023-09-22 22:33:59'),
(5, 10, '6505caac4528c2eb2e1f2678f936fe6e2a0aaca4798405d789966b165ded7b56', '2023-09-22 22:34:03'),
(6, 10, '8edf0cb53e984469cd8c6d2456dc4bc21041de820ecb7b4ad4954fbcdb8f4064', '2023-09-22 22:34:17'),
(7, 10, '03229b1d839f6dfaf132eafd5ae9db4015b668f3b0631dad57bd27ede7b83848', '2023-09-22 22:34:30'),
(8, 10, '17b7566cc3ebf98099ff372a577cd54b1979752c6ac57a8ff9f36abd87361e7d', '2023-09-22 22:35:11'),
(9, 11, '55b0eae632957024649de43a8ad6d76d060a9ca88c0700d5e657f40a5f5770f4', '2023-09-22 22:35:36'),
(10, 11, 'e31ada68bb8eb65ef8ad38e62e4150005e087adb31058a3d5b0e68ebbbfd4b16', '2023-09-22 22:35:59'),
(11, 11, '93d4b00e30b76f0ed981d433fe5504766c7c1a9dc2f74d3af8f7d48dc807a056', '2023-09-22 22:39:02'),
(12, 10, 'fb3d1b4b2c3c6112eeca1950a23da0f9549c987763a36de25ad19cb0d003a5ca', '2023-09-22 22:40:35'),
(13, 10, 'd8d2ce6f9e2b6f29ce8d6509349d3d61f216cec1c01d8475e3aa6c9ecb379394', '2023-09-22 22:41:52'),
(14, 10, '553a87ff424bc200daf006e3e0a5403936b4ba9dade4410b122b5a1a74dfbb30', '2023-09-22 22:42:00'),
(15, 10, '436d98db5170bc5c570e79a4c0a625071aa9aca8d469777c1fc8397723f439d7', '2023-09-22 22:42:36'),
(16, 10, '47fa86b110642848a0f98057b0fc6305923ff125decb2438ad936a0d2d1f2c0a', '2023-09-23 10:32:24'),
(17, 10, '96e76db05a3df2f831b778955701a07dd95f9a67d1d61917797f7bb095791642', '2023-09-23 10:38:58');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `ID` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(8,2) DEFAULT NULL,
  `details` text COLLATE utf8mb4_unicode_ci,
  `picture` tinytext COLLATE utf8mb4_unicode_ci,
  `availability` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `display` tinyint(1) DEFAULT NULL,
  `fk_category` int DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `fk_category` (`fk_category`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`ID`, `name`, `price`, `details`, `picture`, `availability`, `display`, `fk_category`) VALUES
(17, 'Cassandra Shirred Yoke Sleeveless Blouse Brown', '39.95', 'Fabrication: 100% Viscose\r\nCare and Use Instructions: Cold Hand Wash Separately Or Cold Delicate Machine Wash In Garment Bag.\r\nSize and Fit: Our Model Is Wearing Size Au 8/Xs.', 'tops1.jpg', 'coming soon', 1, 1),
(18, 'Mountain TShirt', '29.99', '- 4.2 oz./yd² (US) 7 oz./L yd (CA), 52/48 Airlume combed and ringspun cotton/polyester, 32 singles\r\n- Retail fit\r\n- Unisex sizing\r\n- Coverstitched collar and sleeves\r\n- Shoulder-to-shoulder taping\r\n- Side seams\r\n- Tear away label', 'product.png', 'available', 1, 1),
(19, 'White Long Sleeve Crew Neck TShirt', '15.99', 'Stock up on the essentials with this white long-sleeve T-shirt.\r\n\r\n- Crew neckline\r\n- Long sleeves\r\n- Soft cotton blend\r\n- Regular fit\r\n- Model is 5\'8&quot;/173cm and wears UK 10/EU 38/US 6', 'tops3.jpg', 'coming soon', 1, 1),
(20, 'Boyfriend Flannel Shirt', '45.60', 'The Boyfriend Plaid Shirt is the one you\'ve been looking for. Comfy and relaxed, this long sleeve button-up is the perfect does-it-all shirt, from that Zoom meeting to brunch with the girls. Best part? You didn’t even have to steal it from his wardrobe.', 'tops4.jpg', 'coming soon', 1, 1),
(21, 'Linen Long Sleeve Shirt', '69.99', 'Stylish and comfortable, there\'s nothing uptight about the Linen long sleeve shirt. in 100% French Linen this button up shirt strikes the perfect balance to take your look from day to night, a must have for everyone\'s wardrobe.', 'tops5.jpg', 'available', 1, 1),
(22, 'Jude Suiting Pant', '59.99', 'Style to sit mid or low rise\r\nFitted through waist and hip\r\nFull length wide leg\r\nLightweight natural fabric\r\nSize up for baggy fit', 'pants1.jpg', 'available', 1, 2),
(23, 'Bella Bootleg Pant', '29.99', 'Flare silhouette\r\nCan be worn high or low rise with fold over waistband\r\nFitted at waist and hips\r\nComfortable stretch cotton fabric\r\nResponsible materials used with recycled cotton', 'pants2.jpg', 'available', 1, 2),
(24, 'Kyros Cargo Pant', '79.99', 'Elevated Cargo Pant\r\nFunctional Cargo Pockets\r\nBaggy Low\r\nMid Rise\r\n100% Organic Cotton', 'pants3.jpg', 'available', 1, 2),
(25, 'Loose Fit Pant', '69.99', 'Loose leg profile\r\nCentre front zip closure with metal button\r\nFront slant pockets\r\n2 back patch pockets\r\nCarpenter colourways feature a carpenter side pocket and hammer loop', 'pants4.jpg', 'available', 1, 2),
(26, 'Trippy Slim Trackie', '29.99', 'Relaxed fit\r\nElasticated waist band with functional draw cord\r\nPockets At The Hips and back pocket\r\nRib cuffs legs', 'pants5.jpg', 'coming soon', 1, 2),
(27, 'Active Nba Loose Fit Track', '89.99', 'Loose fit Track - Side entry front pocket - Back right side patch pocket - Elasticated waist with draw cord pulls - Overlocked side stitch detail', 'pants6.jpg', 'coming soon', 1, 2),
(28, 'Lexi Shirred Maxi Dress', '69.99', 'Midi length\r\nShirred bodice\r\nAdjustable straps\r\n100% Australian Cotton\r\nPockets', 'dresses1.jpg', 'coming soon', 1, 3),
(29, 'Denim Mini Dress', '59.99', 'Mini Length\r\nRidged Non-Stretch Denim\r\nShort Sleeve\r\nSide Seam Pockets\r\nButton Front\r\nContrast Stitch Detail\r\nWaist Tie\r\nUsing 30% Recycled Cotton', 'dresses2.jpg', 'available', 1, 3),
(30, 'Haven Slip Midi Dress', '59.99', 'Thin Straps with Metal Adjusters\r\nSlight Scoop Neck\r\nBodice Bias Cut\r\nMidi Length\r\nUsing Responsibly Sourced Viscose', 'dresses3.jpg', 'available', 1, 3),
(31, 'One Shoulder Mini Dress', '49.99', 'One Shoulder\r\nAdjustable Side Cut Out Feature with Tie\r\nFully Lined\r\nMini Length\r\nMade with Linen Fibre', 'dresses4.jpg', 'available', 1, 3),
(32, 'Classic Washed Hoodie', '54.99', 'Elevated, vintage washed effect\r\nRelaxed, oversized fit\r\nDrop shoulder\r\nRib cuff and hem\r\nHoodie\r\nKanga pouch pocket\r\nVariety of colours\r\nBrushed fleece\r\n80% Cotton 20% Recycled Polyester 300gsm', 'flecce1.jpg', 'available', 1, 4),
(33, 'Plush Essential Gym Trackpant', '39.99', 'Relaxed fit with room to move\r\nMid rise, true waistline, ultimate comfort\r\nFull length to the ankle\r\nInternal elasticated waistband with functioning drawcord\r\nSide drop-in pockets to hold your essentials\r\nElasticated Cuff', 'flecce2.jpg', 'available', 1, 4),
(34, 'Ultra Soft Fitted Long Sleeve Top', '34.99', 'Crew Neck\r\nlong sleeve\r\nStraight Hem\r\nSlim fit\r\nWaist length', 'flecce3.jpg', 'available', 1, 4),
(35, 'Trippy Slim Trackie', '27.99', 'Relaxed fit\r\nElasticated waist band with functional draw cord\r\nPockets At The Hips and back pocket\r\nRib cuffs legs', 'flecce4.jpg', 'available', 1, 4),
(36, 'Tactical Cargo Pant', '79.99', 'Loose fit\r\nCargo pockets\r\nSlant front pockets\r\nBack patch pockets\r\nAdjustable side waist tabs\r\nStitch details\r\nTwill or Herringbone textured fabrication', 'flecce5.jpg', 'available', 1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

DROP TABLE IF EXISTS `purchases`;
CREATE TABLE IF NOT EXISTS `purchases` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `product_id` int DEFAULT NULL,
  `full_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_method` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `credit_card` int DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `cvv` int DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `purchase_date` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `product_id` (`product_id`)
) ENGINE=MyISAM AUTO_INCREMENT=54 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `purchases`
--

INSERT INTO `purchases` (`id`, `user_id`, `product_id`, `full_name`, `address`, `city`, `country`, `payment_method`, `credit_card`, `expiry_date`, `cvv`, `total_amount`, `purchase_date`) VALUES
(46, 11, NULL, 'Taulant Hoxha', 'William Walker', 'PRIZREN', 'Kosovo', 'visa', 2147483647, '2023-09-06', 123, '58.96', '2023-08-31'),
(45, 11, NULL, 'Taulant Hoxha', 'William Walker', 'PRIZREN', 'ads', 'PayPal', 2147483647, '2023-09-02', 111, '35.86', '2023-08-31'),
(44, 10, NULL, 'Taulant Hoxha', 'William Walker', 'PRIZREN', 'Kosovo', 'PayPal', 2147483647, '2023-09-09', 111, '54.55', '2023-08-31'),
(43, 10, NULL, 'Taulant Hoxha', 'William Walker', 'PRIZREN', 'asd', 'MasterCard', 2147483647, '2023-09-09', 555, '24.94', '2023-08-31'),
(42, 10, NULL, 'Taulant Hoxha', 'William Walker', 'PRIZREN', 'Kosovo', 'PayPal', 2147483647, '2023-09-08', 111, '12.47', '2023-08-31'),
(41, 10, NULL, 'Taulant Hoxha', 'William Walker', 'PRIZREN', 'Kosovo', 'MasterCard', 2147483647, '2023-09-01', 111, '23.39', '2023-08-31'),
(40, 10, NULL, 'Taulant Hoxha', 'William Walker', 'PRIZREN', 'Kosovo', 'MasterCard', 2147483647, '2023-09-08', 444, '62.99', '2023-08-27'),
(39, 10, NULL, 'Taulant Hoxha', 'William Walker', 'PRIZREN', 'Kosovo', 'visa', 2147483647, '2023-08-31', 111, '13.50', '2023-08-27'),
(38, 10, NULL, 'Taulant Hoxha', 'William Walker', 'PRIZREN', 'Kosovo', 'PayPal', 2147483647, '2023-09-06', 555, '40.49', '2023-08-27'),
(37, 5, NULL, 'Taulant Hoxha', 'William Walker', 'PRIZREN', 'Kosovo', 'MasterCard', 2147483647, '2023-09-07', 555, '85.93', '2023-08-24'),
(36, 5, NULL, 'Taulant Hoxha', 'William Walker', 'PRIZREN', 'Kosovo', 'visa', 2147483647, '2023-08-31', 121, '142.59', '2023-08-24'),
(35, 5, NULL, 'Taulant Hoxha', 'William Walker', 'PRIZREN', 'Kosovo', 'visa', 2147483647, '2023-08-30', 111, '149.89', '2023-08-24'),
(34, 5, NULL, 'Taulant Hoxha', 'William Walker', 'PRIZREN', 'Kosovo', 'visa', 2147483647, '2023-08-31', 111, '279.65', '2023-08-23'),
(33, 5, NULL, 'Taulant Hoxha', 'William Walker', 'PRIZREN', 'Kosovo', 'MasterCard', 2147483647, '2023-08-25', 211, '279.65', '2023-08-23'),
(32, 5, NULL, 'Taulant Hoxha', 'William Walker', 'PRIZREN', 'Kosovo', 'MasterCard', 2147483647, '2023-08-25', 211, '279.65', '2023-08-23'),
(31, 5, NULL, 'Taulant Hoxha', 'qwe', 'as', 'Kosovo', 'PayPal', 2147483647, '2023-08-31', 121, '15.99', '2023-08-23'),
(30, 5, NULL, 'Taulant Hoxha', 'qwe', 'as', 'Kosovo', 'visa', 2147483647, '2023-08-31', 414, '79.90', '2023-08-23'),
(47, 11, NULL, 'Taulant Hoxha', 'William Walker', 'PRIZREN', 'Kosovo', 'MasterCard', 2147483647, '2023-09-07', 111, '35.57', '2023-08-31'),
(48, 11, NULL, 'Taulant Hoxha', 'William Walker', 'PRIZREN', 'Kosovo', 'visa', 2147483647, '2023-09-29', 111, '35.86', '2023-09-01'),
(49, 11, NULL, 'Taulant Hoxha', 'William Walker', 'PRIZREN', 'Kosovo', 'visa', 2147483647, '2023-10-06', 123, '12.47', '2023-09-01'),
(50, 10, NULL, 'Taulant Hoxha', 'In reprehenderit vol', 'Dolor id quia eum il', 'Est nemo dolor labor', 'PayPal', 2147483647, '1981-02-20', 123, '55.94', '2024-01-08'),
(51, 10, NULL, 'Taulant Hoxha', 'Ullamco ullamco mole', 'Voluptatem Dolor ut', 'Modi consequatur mol', 'visa', 2147483647, '1991-10-23', 123, '15.99', '2024-01-08'),
(52, 10, NULL, 'Taulant Hoxha', 'Ullamco ullamco mole', 'Voluptatem Dolor ut', 'Modi consequatur mol', 'visa', 2147483647, '1991-10-23', 123, '15.99', '2024-01-08'),
(53, 10, NULL, 'Taulant Hoxha', 'Voluptatem nostrum n', 'Quia in fugiat accu', 'Aliquid exercitation', 'MasterCard', 2147483647, '1985-05-17', 123, '29.99', '2024-01-08');

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

DROP TABLE IF EXISTS `questions`;
CREATE TABLE IF NOT EXISTS `questions` (
  `id` int NOT NULL AUTO_INCREMENT,
  `question_text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `answer` text COLLATE utf8mb4_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `fk_product_idx` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `question_text`, `product_id`, `user_id`, `created_at`, `answer`) VALUES
(1, 'ycx', 1, 6, '2023-08-17 08:47:59', 'no'),
(5, 'Has it water cooling', 1, 6, '2023-08-21 06:14:29', 'no but 3 fans are included'),
(9, 'is it also available in red', 5, 6, '2023-08-21 11:36:31', 'Yes'),
(10, 'a', 17, 5, '2023-08-24 09:37:31', NULL),
(11, 'why\r\n', 18, 13, '2024-01-10 18:12:05', 'what why\r\n'),
(12, '', 35, 5, '2024-10-14 13:42:13', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
CREATE TABLE IF NOT EXISTS `reviews` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `rating` int DEFAULT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `product_id` (`product_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `product_id`, `user_id`, `rating`, `comment`, `created_at`) VALUES
(11, 1, 6, 1, 'good lok', '2023-08-17 09:00:42'),
(12, 1, 6, 5, 'powerfull', '2023-08-21 11:38:58'),
(13, 5, 6, 5, 'nice fit', '2023-08-21 11:39:28'),
(14, 13, 6, 1, 'works well', '2023-08-22 07:25:57'),
(15, 5, 5, 1, '', '2023-08-23 11:26:46'),
(16, 17, 5, 1, 'ads', '2023-08-24 09:37:23'),
(18, 23, 10, 4, '', '2023-08-27 17:30:34'),
(19, 23, 10, 3, '', '2023-08-27 17:31:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `fname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_of_birth` date NOT NULL,
  `phone_number` int NOT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  `picture` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fname`, `lname`, `username`, `email`, `date_of_birth`, `phone_number`, `gender`, `password`, `role`, `picture`) VALUES
(5, 'Taulant', 'Hoxha', 'taulant', 'taul@gmail.com', '1000-04-04', 4444444, 'female', '96cae35ce8a9b0244178bf28e4966c2ce1b8385723a96a6b838858cdd6ca0a1e', 'adm', 'avatar.png'),
(13, 'Taulant', 'Hoxha', 'taul', 'taulant@gmail.com', '2024-01-25', 13123123, 'female', '1af05ab8b7b9cac16b439c79701db01f2ac68d356049ebcfb676ec27a2f60971', 'user', 'avatar.png'),
(14, 'Taulant', 'Hoxha', 'Taulant', 'htaulant0@gmail.com', '2002-12-10', 1211212, 'female', '29fbec3c6484d16621659eeb31c23d77691810a6341bf91bcf1cd26f515c154c', 'user', 'avatar.png'),
(16, 'Freya Fulton', 'Cochran', 'hocexacicy', 'filan@gmail.com', '2024-05-10', 1, 'female', 'b2fe8b46929bfa4c65fee9d5d43a2423799b18e360782e9abc27bd420877243e', 'user', 'avatar.png');

-- --------------------------------------------------------

--
-- Table structure for table `user_carts`
--

DROP TABLE IF EXISTS `user_carts`;
CREATE TABLE IF NOT EXISTS `user_carts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `product_id` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=64 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_carts`
--

INSERT INTO `user_carts` (`id`, `user_id`, `product_id`, `quantity`) VALUES
(19, 6, 1, 3),
(20, 6, 13, 2),
(33, 5, 17, 2),
(34, 5, 18, 4),
(35, 5, 19, 1),
(36, 5, 20, 1),
(37, 5, 23, 1),
(61, 10, 18, 1),
(62, 15, 17, 1),
(63, 5, 35, 1);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `banlist`
--
ALTER TABLE `banlist`
  ADD CONSTRAINT `banlist_ibfk_1` FOREIGN KEY (`fk_users`) REFERENCES `users` (`id`);

--
-- Constraints for table `discounts`
--
ALTER TABLE `discounts`
  ADD CONSTRAINT `discounts_ibfk_1` FOREIGN KEY (`fk_category`) REFERENCES `categories` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
