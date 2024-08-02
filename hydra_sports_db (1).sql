-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 01, 2024 at 06:26 PM
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
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`id`, `category_name`, `status`, `image`) VALUES
(11, 'Accessories', 1, '66aa7d0d498bfhat_red.jpg'),
(12, 'Dresses', 1, '66aa8c5d3d935dress.png'),
(13, 'Shirts', 1, '66aa7c1fbe314skirt_white.png'),
(16, 'Jackets', 1, '66aa785aecb67jacket_blue.png'),
(17, 'Jeans', 1, '66aa786b4f353jean.jpg'),
(18, 'Snackers', 1, '66aa78a5203f6nike_black.png'),
(19, 'Sportwear', 1, '66aa78c946ec2sportwear_black.jpg'),
(20, 'Shoes', 1, '66aa78e19e6e0sandals.png'),
(21, 'Clothing', 1, '66aa78f5e226apolo_blue.png');

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
(6, 'Brown'),
(4, 'Green'),
(5, 'Pink'),
(2, 'Red'),
(3, 'White');

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `customer_phone` varchar(15) NOT NULL,
  `shipping_address` varchar(255) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `order_status_id` int NOT NULL,
  `payment_status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
  `unit` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `product_name`, `category_id`, `description`, `created_date`, `updated_date`, `view_count`, `purchase_count`, `comment_count`, `status`, `unit`) VALUES
(38, 'Backpack', 11, 'New', '2024-07-31 18:29:32', '2024-07-31 18:29:32', 0, 0, 0, 1, NULL),
(39, 'Bag', 11, 'Hot', '2024-07-31 18:36:50', '2024-07-31 18:36:50', 0, 0, 0, 1, NULL),
(40, 'Hat', 11, 'Hot', '2024-07-31 18:38:28', '2024-07-31 18:38:28', 0, 0, 0, 1, NULL),
(41, 'Crop', 21, 'New', '2024-07-31 18:40:47', '2024-08-01 17:58:37', 0, 0, 0, 1, NULL),
(42, 'Snackers Nike', 18, 'New', '2024-07-31 18:43:29', '2024-08-01 17:58:30', 0, 0, 0, 1, NULL),
(43, 'Hoodie', 21, 'New', '2024-07-31 18:45:29', '2024-08-01 17:58:22', 0, 0, 0, 1, NULL),
(44, 'Sandals', 20, 'New', '2024-07-31 18:47:01', '2024-08-01 17:58:12', 0, 0, 0, 1, NULL),
(45, 'Polo', 21, 'Hot', '2024-07-31 18:48:44', '2024-07-31 19:07:02', 0, 0, 0, 1, NULL),
(46, 'Dresses Summer', 12, 'Hot', '2024-07-31 18:50:15', '2024-08-01 17:57:54', 0, 0, 0, 1, NULL),
(47, 'SportWear Collection', 19, 'Hot', '2024-07-31 18:51:57', '2024-08-01 17:57:43', 0, 0, 0, 1, NULL),
(48, 'T-Shirt', 21, 'New', '2024-07-31 18:53:17', '2024-07-31 18:54:49', 0, 0, 0, 1, NULL),
(49, 'Socks', 11, 'New', '2024-07-31 18:54:20', '2024-07-31 18:55:31', 0, 0, 0, 1, NULL),
(50, 'Jacket', 21, 'New', '2024-07-31 19:09:08', '2024-08-01 17:57:28', 0, 0, 0, 1, NULL);

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
(8, 47, 'bag_black.png', 1),
(9, 48, 'bag_green.jpg', 1),
(10, 49, 'hat_black.png', 1),
(13, 51, 'crop_green.jpg', 1),
(14, 50, 'crop_pink.png', 1),
(17, 52, 'nike_red.png', 1),
(18, 53, 'nike_pink.png', 1),
(21, 54, 'hoodie_black.png', 1),
(22, 55, 'hoodie_white.png', 1),
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
(49, 61, 'dress_green.png', 1);

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
(67, 50, 1, 2, 1000, 200),
(68, 50, 5, 1, 1000, 100);

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
  `order_id` int DEFAULT NULL,
  `rating` tinyint UNSIGNED DEFAULT NULL,
  `content` text,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`id`, `user_id`, `product_id`, `order_id`, `rating`, `content`, `created_date`) VALUES
(1, 8, 48, 0, 5, 'Perfect', '2024-07-31 19:47:05');

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
(4, '230'),
(5, '240'),
(6, '250'),
(3, 'L'),
(2, 'M'),
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
  `status` tinyint UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role`, `password`, `username`, `email`, `full_name`, `address`, `phone`, `status`) VALUES
(1, 1, 'hydra', 'admin', 'admin@gamil.com', 'admin', 'admin', '+84 123456789', 1),
(2, 0, 'test', 'user1', 'user1@gmail.com', 'Người dùng nhất', 'Hà Nội', '+84 254687478', 1),
(3, 0, '12312', 'user2', 'test2@gmail.com', 'Người dùng 2', '12412', '12323', 1),
(4, 0, '12314', 'ad12', 'test12@gmail.com', 'người thử nhất Ngan', 'bực', '142', 1),
(5, 0, '123123', 'a12', 'a1@gamil.com', 'wd205', 'asd2', '132323', 1),
(6, 0, '1256', 'a123', 'hoho@gmail.com', 'thử lần nữa', 'nam nam', '+84 2556546', 1),
(7, 0, 'ha21', 'hah2', 'hehe@gmail.com', 'them lan nua', 'ha noi', '+84 365165', 1),
(8, 0, '123', 'Ngân', 'vuthingan13620013@gmail.com', 'Ngân Vũ', 'Hải dương', '0368216001', 1),
(9, 0, '123', 'hana vu', 'vuthingan@gmai', 'hana', 'Hải dương', '0368216001', 1);

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
  ADD KEY `product_id` (`product_id`);

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `color`
--
ALTER TABLE `color`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `order`
--
ALTER TABLE `order`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_detail`
--
ALTER TABLE `order_detail`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_status`
--
ALTER TABLE `order_status`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `product_image`
--
ALTER TABLE `product_image`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `product_variant`
--
ALTER TABLE `product_variant`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `product_voucher`
--
ALTER TABLE `product_voucher`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `size`
--
ALTER TABLE `size`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
