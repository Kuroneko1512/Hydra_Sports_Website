-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 04, 2024 at 06:06 AM
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
(6, 'Giày Leo Núi', 'Giày hỗ trợ cho việc leo núi', 1, NULL);

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
(2, 'Red');

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
  `unit` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `product_name`, `category_id`, `description`, `created_date`, `updated_date`, `view_count`, `purchase_count`, `comment_count`, `status`, `unit`, `image`) VALUES
(1, 'Giầy HoKa 1', 1, 'Giầy Đẹp', '2024-07-22 10:53:55', '2024-07-24 12:51:57', 0, 0, 0, 1, 'Đôi', NULL),
(2, 'Giầy Nike 2', 4, 'Giầy xịn', '2024-07-22 10:53:55', '2024-07-24 12:28:15', 0, 0, 0, 1, 'Đôi', NULL);

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
(1, 1, 1, 2, 100000, 20),
(2, 1, 1, 1, 100000, 1000);

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
  `status` tinyint UNSIGNED NOT NULL DEFAULT '1',
  `avatar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `role`, `password`, `username`, `email`, `full_name`, `address`, `phone`, `status`, `avatar`) VALUES
(1, 1, 'hydra', 'admin', 'admin@gamil.com', 'admin', 'admin', '+84 123456789', 1, NULL),
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
(14, 0, 'Hung@13123', 'aads6', 'ha6i@gmail.com', 'trần', 'ádasd', '+84255132777', 1, NULL),
(15, 0, 'Longnv!2', 'longnv', 'long@gmail.com', 'Nguyễn Long', 'long  lom dom', '+847895558', 1, NULL),
(16, 0, 'Vhu212@aa', 'vuh2', 'vu@gmail.com', 'Nguyễn  vũ', 'asdasd', '+84555555987', 1, NULL);

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `color`
--
ALTER TABLE `color`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `product_image`
--
ALTER TABLE `product_image`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_variant`
--
ALTER TABLE `product_variant`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

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
