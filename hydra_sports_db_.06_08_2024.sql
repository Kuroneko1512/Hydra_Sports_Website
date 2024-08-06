-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 06, 2024 at 01:08 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hydra_sports_db`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `update_status_with_related` (IN `main_table` VARCHAR(255), IN `main_id` INT, IN `related_tables` JSON, IN `new_status` TINYINT)   BEGIN
    DECLARE i INT DEFAULT 0;
    DECLARE table_name VARCHAR(255);
    DECLARE foreign_key VARCHAR(255);

    -- Update main table
    SET @sql = CONCAT('UPDATE ', main_table, ' SET status = ? WHERE id = ?');
    PREPARE stmt FROM @sql;
    SET @new_status = new_status;
    SET @main_id = main_id;
    EXECUTE stmt USING @new_status, @main_id;
    DEALLOCATE PREPARE stmt;

    -- Update related tables
    WHILE i < JSON_LENGTH(related_tables) DO
        SET table_name = JSON_UNQUOTE(JSON_EXTRACT(related_tables, CONCAT('$[', i, '].table')));
        SET foreign_key = JSON_UNQUOTE(JSON_EXTRACT(related_tables, CONCAT('$[', i, '].key')));
        
        SET @sql = CONCAT('UPDATE ', table_name, ' SET status = ? WHERE ', foreign_key, ' = ?');
        PREPARE stmt FROM @sql;
        EXECUTE stmt USING @new_status, @main_id;
        DEALLOCATE PREPARE stmt;
        
        SET i = i + 1;
    END WHILE;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `id` int NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `category_name`, `description`, `status`, `image`) VALUES
(1, 'Giày Chạy Bộ', 'Giày chuyên chạy bộ , hỗ trợ tốt cho các hoạt động mạnh ', 1, NULL),
(2, 'Giày Chạy Trail', '', 1, NULL),
(3, 'Giày Luyện Tập', '', 1, NULL),
(4, 'Giày Casual', '', 1, NULL),
(5, 'Dép Chạy Bộ', '', 1, NULL),
(6, 'Giày Leo Núi', 'Giày hỗ trợ cho việc leo núi', 1, 'img_66b019ec39d0c9.07335310.jpeg'),
(11, 'Accessories', '2', 1, '66abd76ae1a57sock_black.jpg'),
(12, 'Dresses', '2', 1, '66abd7327e0cadress.png'),
(13, 'Shirts', '2', 1, '66abd727b7f70skirt_white.png'),
(16, 'Jackets', '2', 1, '66abd7122e0c8jacket_blue.png'),
(17, 'Jeans', '2', 1, '66abd70212205jean.jpg'),
(18, 'Snackers', '2', 1, '66abd6f27e0a4nike_red.png'),
(19, 'Sportwear', '2', 1, '66abd6d759a93sportwear_black.jpg'),
(20, 'Shoes', '2', 1, '66abd6c81bc1fsandals.png'),
(21, 'Clothing', '2', 1, '66abd6b6222f0polo_white.png');

-- --------------------------------------------------------

--
-- Table structure for table `color`
--

CREATE TABLE `color` (
  `id` int NOT NULL,
  `color_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `color`
--

INSERT INTO `color` (`id`, `color_name`) VALUES
(1, 'Black'),
(7, 'Black/Orange'),
(3, 'Blue'),
(6, 'Cam đỏ'),
(4, 'Green'),
(8, 'Grey/Orange'),
(9, 'Navy/Orange'),
(2, 'Red'),
(5, 'White');

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `customer_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `customer_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `customer_phone` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `shipping_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `order_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `order_status_id` int DEFAULT NULL,
  `payment_status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `order`
--

INSERT INTO `order` (`id`, `user_id`, `customer_name`, `customer_email`, `customer_phone`, `shipping_address`, `order_date`, `order_status_id`, `payment_status`) VALUES
(1, NULL, NULL, NULL, NULL, NULL, '2024-08-05 12:05:00', NULL, '0'),
(2, NULL, NULL, NULL, NULL, NULL, '2024-08-05 12:08:11', NULL, '0'),
(3, NULL, NULL, NULL, NULL, NULL, '2024-08-05 12:23:02', NULL, '0'),
(4, NULL, NULL, NULL, NULL, NULL, '2024-08-05 12:25:00', NULL, '0');

-- --------------------------------------------------------

--
-- Table structure for table `order_detail`
--

CREATE TABLE `order_detail` (
  `id` int NOT NULL,
  `order_id` int NOT NULL,
  `product_variant_id` int NOT NULL,
  `quantity` int NOT NULL,
  `price` bigint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `order_detail`
--

INSERT INTO `order_detail` (`id`, `order_id`, `product_variant_id`, `quantity`, `price`) VALUES
(1, 1, 68, 1, 1000),
(2, 2, 68, 1, 1000),
(3, 3, 65, 2, 900),
(4, 4, 65, 2, 900);

-- --------------------------------------------------------

--
-- Table structure for table `order_status`
--

CREATE TABLE `order_status` (
  `id` int NOT NULL,
  `status_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `category_id` int NOT NULL,
  `description` text NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `view_count` int DEFAULT '0',
  `purchase_count` int DEFAULT '0',
  `comment_count` int DEFAULT '0',
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `unit` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `product_name`, `category_id`, `description`, `created_date`, `updated_date`, `view_count`, `purchase_count`, `comment_count`, `status`, `unit`, `image`) VALUES
(1, 'Giầy HoKa 1', 1, 'Giầy Đẹp', '2024-07-22 10:53:55', '2024-08-05 12:50:27', 0, 0, 0, 1, 'Đôi', 'uploads/products/S20964-213_2.jpeg'),
(2, 'Giầy Nike 2', 4, 'Giầy xịn', '2024-07-22 10:53:55', '2024-07-24 12:28:15', 0, 0, 0, 1, 'Đôi', NULL),
(3, 'Giày Saucony Triumph', 1, 'Dòng giày chuyên hỗ trợ cho luyện tập và chạy đường dài với bộ đệm êm', '2024-08-05 03:43:02', '2024-08-05 03:43:02', 0, 0, 0, 1, NULL, 'uploads/products/S20964-213_2.jpeg'),
(4, 'Giày Saucony Triumph 2', 1, 'Dòng giày chuyên hỗ trợ cho luyện tập và chạy đường dài với bộ đệm êm', '2024-08-05 03:44:47', '2024-08-05 03:44:47', 0, 0, 0, 1, NULL, 'uploads/products/S20964-215_2.jpeg'),
(18, 'test', 4, 'ádasdas', '2024-08-05 04:26:24', '2024-08-05 04:26:24', 0, 0, 0, 1, NULL, 'uploads/products/S20964-213_2.jpeg'),
(19, 'test 2', 5, 'aaaaaaaa', '2024-08-05 04:32:39', '2024-08-05 04:32:39', 0, 0, 0, 1, NULL, 'uploads/products/S20964-215_1.jpeg'),
(20, 'test 3', 5, 'aaaaaaaa', '2024-08-05 04:35:10', '2024-08-05 04:35:10', 0, 0, 0, 1, NULL, 'uploads/products/S20964-215_1.jpeg'),
(21, 'test 4', 6, 'leo núi', '2024-08-05 04:35:55', '2024-08-05 04:35:55', 0, 0, 0, 1, NULL, 'uploads/products/S20964-213_2.jpeg'),
(22, 'test 5', 6, 'aa', '2024-08-05 04:40:00', '2024-08-05 04:40:00', 0, 0, 0, 1, NULL, 'uploads/products/S20964-215_1.jpeg'),
(23, 'test 5', 6, 'aa', '2024-08-05 04:41:28', '2024-08-05 04:41:28', 0, 0, 0, 1, NULL, 'uploads/products/S20964-215_1.jpeg'),
(24, 'test 5', 6, 'aa', '2024-08-05 04:42:37', '2024-08-05 04:42:37', 0, 0, 0, 1, NULL, 'uploads/products/S20964-215_1.jpeg'),
(25, 'test 5', 6, 'aa', '2024-08-05 04:46:24', '2024-08-05 04:46:24', 0, 0, 0, 1, NULL, 'uploads/products/S20964-215_1.jpeg'),
(26, 'test 10', 6, 'Giày hỗ trợ cho việc leo núi', '2024-08-05 05:06:32', '2024-08-05 05:06:32', 0, 0, 0, 1, NULL, 'uploads/products/S20964-240_3.jpeg'),
(38, 'Backpack', 11, 'New', '2024-07-31 11:29:32', '2024-07-31 11:29:32', 0, 0, 0, 1, NULL, NULL),
(39, 'Bag', 11, 'Hot', '2024-07-31 11:36:50', '2024-07-31 11:36:50', 0, 0, 0, 1, NULL, NULL),
(40, 'Hat', 11, 'Hot', '2024-07-31 11:38:28', '2024-07-31 11:38:28', 0, 0, 0, 1, NULL, NULL),
(41, 'Crop', 21, 'New', '2024-07-31 11:40:47', '2024-08-05 12:09:58', 0, 0, 0, 1, NULL, NULL),
(42, 'Snackers Nike', 18, 'New', '2024-07-31 11:43:29', '2024-08-01 10:58:30', 0, 0, 0, 1, NULL, NULL),
(43, 'Hoodie', 21, 'New', '2024-07-31 11:45:29', '2024-08-05 12:09:58', 0, 0, 0, 1, NULL, NULL),
(44, 'Sandals', 20, 'New', '2024-07-31 11:47:01', '2024-08-01 10:58:12', 0, 0, 0, 1, NULL, NULL),
(45, 'Polo', 21, 'Hot', '2024-07-31 11:48:44', '2024-08-05 12:09:58', 0, 0, 0, 1, NULL, NULL),
(46, 'Dresses Summer', 12, 'Hot', '2024-07-31 11:50:15', '2024-08-01 10:57:54', 0, 0, 0, 1, NULL, NULL),
(47, 'SportWear Collection', 19, 'Hot', '2024-07-31 11:51:57', '2024-08-01 10:57:43', 0, 0, 0, 1, NULL, NULL),
(48, 'T-Shirt', 21, 'New', '2024-07-31 11:53:17', '2024-08-05 12:09:58', 0, 0, 0, 1, NULL, NULL),
(49, 'Socks', 11, 'New', '2024-07-31 11:54:20', '2024-07-31 11:55:31', 0, 0, 0, 1, NULL, NULL),
(50, 'Jacket', 21, 'New', '2024-07-31 12:09:08', '2024-08-05 12:09:58', 0, 0, 0, 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `product_image`
--

CREATE TABLE `product_image` (
  `id` int NOT NULL,
  `product_variant_id` int NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `is_primary` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `product_image`
--

INSERT INTO `product_image` (`id`, `product_variant_id`, `image_url`, `is_primary`) VALUES
(3, 45, 'backpack_pink.png', 1),
(4, 46, 'backpack_brown.png', 1),
(6, 25, 'uploads/products/S20964-240_3.jpeg', 0),
(7, 25, 'uploads/products/S20964-240_4.jpeg', 0),
(8, 47, 'bag_black.png', 1),
(9, 48, 'bag_green.jpg', 1),
(10, 49, 'hat_black.png', 1),
(12, 34, 'uploads/products/S20964-213_2.jpeg', 1),
(13, 51, 'crop_green.jpg', 1),
(14, 50, 'crop_pink.png', 1),
(15, 34, 'uploads/products/S20964-213_3.jpeg', 0),
(16, 35, 'uploads/products/S20964-215_1.jpeg', 1),
(17, 52, 'nike_red.png', 1),
(18, 53, 'nike_pink.png', 1),
(19, 35, 'uploads/products/S20964-215_2.jpeg', 0),
(20, 25, 'uploads/products/S20964-240_5.jpeg', 0),
(21, 54, 'hoodie_black.png', 1),
(22, 55, 'hoodie_white.png', 1),
(23, 25, 'uploads/products/S20964-240_6.jpeg', 0),
(25, 57, 'slides_black.png', 1),
(26, 56, 'slides_white.png', 1),
(32, 60, 'dress.png', 1),
(35, 63, 'sportwear_black.jpg', 1),
(36, 62, 'sportwear_gray.jpg', 1),
(39, 64, 't-shirt_white.png', 1),
(40, 65, 't-shirt_brown.jpg', 1),
(42, 66, 'sock_black.jpg', 1),
(43, 59, 'polo_white.png', 1),
(44, 58, 'polo_blue.png', 1),
(47, 67, 'jacket_black.png', 1),
(48, 68, 'jacket.png', 1),
(49, 61, 'dress_green.png', 1),
(50, 69, 'uploads/products/S20964-240_4.jpeg', 1),
(51, 70, 'uploads/products/S20964-213_3.jpeg', 1),
(52, 70, 'uploads/products/S20964-213_5.jpeg', 0),
(53, 71, 'uploads/products/S20964-215_1.jpeg', 1),
(54, 71, 'uploads/products/S20964-215_2.jpeg', 0);

-- --------------------------------------------------------

--
-- Table structure for table `product_variant`
--

CREATE TABLE `product_variant` (
  `id` int NOT NULL,
  `product_id` int NOT NULL,
  `color_id` int NOT NULL,
  `size_id` int NOT NULL,
  `price` bigint NOT NULL,
  `stock` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `product_variant`
--

INSERT INTO `product_variant` (`id`, `product_id`, `color_id`, `size_id`, `price`, `stock`) VALUES
(6, 4, 9, 8, 10000, 10),
(7, 4, 5, 6, 10000, 10),
(15, 18, 6, 9, 10000, 10),
(16, 19, 4, 7, 10000, 10),
(19, 20, 4, 9, 10000, 10),
(20, 21, 2, 4, 10000, 10),
(22, 23, 5, 6, 10000, 10),
(23, 22, 5, 6, 10000, 10),
(24, 25, 5, 6, 10000, 10),
(25, 26, 7, 9, 10000, 10),
(27, 24, 5, 6, 10000, 10),
(34, 1, 1, 1, 100000, 10),
(35, 1, 1, 2, 100000, 20),
(45, 38, 5, 1, 1000, 100),
(46, 38, 6, 2, 2000, 100),
(47, 39, 1, 1, 100, 10),
(48, 39, 4, 2, 200, 10),
(49, 40, 1, 3, 1000, 200),
(50, 41, 5, 1, 1000, 200),
(51, 41, 4, 2, 2000, 100),
(52, 42, 2, 4, 1000, 200),
(53, 42, 5, 5, 1500, 100),
(54, 43, 1, 2, 500, 200),
(55, 43, 3, 3, 700, 100),
(56, 44, 3, 5, 1000, 200),
(57, 44, 1, 6, 1500, 40),
(58, 45, 4, 2, 100, 10),
(59, 45, 3, 1, 200, 20),
(60, 46, 3, 2, 1000, 20),
(61, 46, 4, 1, 1500, 10),
(62, 47, 3, 2, 300, 5),
(63, 47, 1, 3, 400, 100),
(64, 48, 3, 1, 1000, 4),
(65, 48, 6, 2, 900, 100),
(66, 49, 1, 3, 1000, 200),
(67, 50, 1, 2, 2000, 200),
(68, 50, 5, 1, 1000, 100),
(69, 3, 8, 7, 10000, 10),
(70, 3, 9, 7, 10000, 10),
(71, 3, 9, 8, 10000, 10);

-- --------------------------------------------------------

--
-- Table structure for table `product_voucher`
--

CREATE TABLE `product_voucher` (
  `id` int NOT NULL,
  `product_id` int NOT NULL,
  `voucher_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `order_id` int NOT NULL,
  `rating` tinyint UNSIGNED DEFAULT NULL,
  `content` text,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int NOT NULL,
  `role_name` varchar(255) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `size`
--

CREATE TABLE `size` (
  `id` int NOT NULL,
  `size_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `size`
--

INSERT INTO `size` (`id`, `size_name`) VALUES
(4, '38'),
(5, '39'),
(6, '40'),
(9, '40.5'),
(7, '41'),
(8, '41.5'),
(10, '42'),
(2, 'L'),
(3, 'M'),
(1, 'S');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `role` tinyint UNSIGNED NOT NULL DEFAULT '0',
  `password` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `full_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `status` tinyint UNSIGNED NOT NULL DEFAULT '1',
  `avatar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role`, `password`, `username`, `email`, `full_name`, `address`, `phone`, `status`, `avatar`) VALUES
(1, 1, 'hydra', 'admin', 'admin@gamil.com', 'admin', 'admin', '+84 123456789', 1, 'NekoSports_logo.png'),
(2, 0, 'test', 'user1', 'user1@gmail.com', 'Ngan ganaasdadsdasdasd', 'Hà Nội', '+84 254687478', 1, NULL),
(3, 0, '12312', 'user2', 'test2@gmail.com', 'Người dùng 22', '12412', '12323', 1, NULL),
(4, 0, '12314', 'ad12', 'test12@gmail.com', 'người thử nhất', 'bực', '142', 1, NULL),
(5, 0, 'A!23sqwe', 'a1qw', 'a1@gamil.com', 'ok roi', 'asd2', '+8478898798', 0, NULL),
(6, 0, 'A123@asd', 'a123', 'hoho@gmail.com', 'thử lần nữa', 'nam nam', '+842556546', 0, NULL),
(7, 0, 'Hggg12@3', 'hah2', 'hehe@gmail.com', 'them lan nua', 'ha noi', '+842584967', 0, NULL),
(8, 0, 'Hung@13123', 'aads', 'hai@gmail.com', 'trần', 'ádasd', '+842551321321', 1, NULL),
(9, 0, 'Hung@13123', 'aads1', 'ha2i@gmail.com', 'trần', 'ádasd', '+84255132131', 1, NULL),
(10, 0, 'Hung@13123', 'aads2', 'ha3i@gmail.com', 'trần', 'ádasd', '+84255132771', 1, NULL),
(11, 0, 'Hung@13123', 'aads3', 'ha4i@gmail.com', 'trần', 'ádasd', '+84255132171', 1, NULL),
(12, 0, 'G123@!aa', 'asd1', 'asd@gmail.com', 'haha', 'asdasd', '+841657978', 1, NULL),
(13, 0, 'Hung@13123', 'aads5', 'ha5i@gmail.com', 'trần', 'ádasd', '+84255132137', 1, NULL),
(14, 0, 'Hung@13123', 'aads6', 'ha6i@gmail.com', 'trần', 'ádasd', '+84255132777', 1, 'brands_3.jpeg'),
(15, 0, 'Longnv!2', 'longnv', 'long@gmail.com', 'Nguyễn Long', 'long  lom dom', '+847895558', 1, 'brands_1.jpeg'),
(16, 0, 'Vhu212@aa', 'vuh2', 'vu@gmail.com', 'Nguyễn Long', 'asdasd', '+84555555987', 1, 'img_66b0175e09cef2.90615847.jpeg'),
(17, 0, 'A!qweqwe1', 'a1225', 'a12@gamil.com', 'a', 'asd2', '+8423654987', 1, 'img_66b01afe4aaf71.85459224.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `voucher`
--

CREATE TABLE `voucher` (
  `id` int NOT NULL,
  `code` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `discount_percentage` int NOT NULL,
  `max_discount_amount` bigint NOT NULL,
  `valid_from` date NOT NULL,
  `valid_to` date NOT NULL,
  `minimum_order_value` bigint NOT NULL,
  `usage_limit` int NOT NULL,
  `used_count` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `category_name` (`category_name`);

--
-- Indexes for table `color`
--
ALTER TABLE `color`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `color_name` (`color_name`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `order_status_id` (`order_status_id`);

--
-- Indexes for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_variant_id` (`product_variant_id`);

--
-- Indexes for table `order_status`
--
ALTER TABLE `order_status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `product_image`
--
ALTER TABLE `product_image`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_variant_id` (`product_variant_id`);

--
-- Indexes for table `product_variant`
--
ALTER TABLE `product_variant`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_product_variant` (`product_id`,`color_id`,`size_id`),
  ADD KEY `color_id` (`color_id`),
  ADD KEY `size_id` (`size_id`);

--
-- Indexes for table `product_voucher`
--
ALTER TABLE `product_voucher`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `voucher_id` (`voucher_id`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `size`
--
ALTER TABLE `size`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `size_name` (`size_name`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `voucher`
--
ALTER TABLE `voucher`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `color`
--
ALTER TABLE `color`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `order_detail`
--
ALTER TABLE `order_detail`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `order_status`
--
ALTER TABLE `order_status`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `product_image`
--
ALTER TABLE `product_image`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `product_variant`
--
ALTER TABLE `product_variant`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `product_voucher`
--
ALTER TABLE `product_voucher`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `size`
--
ALTER TABLE `size`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `voucher`
--
ALTER TABLE `voucher`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `order_ibfk_2` FOREIGN KEY (`order_status_id`) REFERENCES `order_status` (`id`);

--
-- Constraints for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD CONSTRAINT `order_detail_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`),
  ADD CONSTRAINT `order_detail_ibfk_2` FOREIGN KEY (`product_variant_id`) REFERENCES `product_variant` (`id`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`);

--
-- Constraints for table `product_image`
--
ALTER TABLE `product_image`
  ADD CONSTRAINT `product_image_ibfk_1` FOREIGN KEY (`product_variant_id`) REFERENCES `product_variant` (`id`);

--
-- Constraints for table `product_variant`
--
ALTER TABLE `product_variant`
  ADD CONSTRAINT `product_variant_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `product_variant_ibfk_2` FOREIGN KEY (`color_id`) REFERENCES `color` (`id`),
  ADD CONSTRAINT `product_variant_ibfk_3` FOREIGN KEY (`size_id`) REFERENCES `size` (`id`);

--
-- Constraints for table `product_voucher`
--
ALTER TABLE `product_voucher`
  ADD CONSTRAINT `product_voucher_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `product_voucher_ibfk_2` FOREIGN KEY (`voucher_id`) REFERENCES `voucher` (`id`);

--
-- Constraints for table `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `review_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `review_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `review_ibfk_3` FOREIGN KEY (`order_id`) REFERENCES `order` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
