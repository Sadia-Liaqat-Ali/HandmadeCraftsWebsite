-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 15, 2025 at 12:30 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `handmadecrafts`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `email`, `password`, `created_at`) VALUES
(2, NULL, 'admin@gmail.com', '1234', '2025-05-06 06:19:57');

-- --------------------------------------------------------

--
-- Table structure for table `artisan`
--

CREATE TABLE `artisan` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `contact` varchar(20) DEFAULT NULL,
  `skills` text DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('active','suspended','banned') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `artisan`
--

INSERT INTO `artisan` (`id`, `name`, `email`, `password`, `contact`, `skills`, `bio`, `created_at`, `status`) VALUES
(1, 'Diya Shezadi', 'art@gmail.com', '2c5f64ab07ccb3e410aa97fc09687cc3', '1122', 'yes', NULL, '2025-05-06 06:17:09', 'active'),
(2, 'Ateeqa', 'sadia@gmail.com', '91b5cd208feabcc9b01cd14b7e4e83ad', '12345', 'web designer', 'I Am a fashion designer . I achieved a diploma in DSFFV fashion designing from technical collage lahore', '2025-06-13 17:22:20', 'active'),
(3, 'Umra', 'umra@gmail.com', '6aa836149566af20fd20a7d7c64f37f9', '333990', 'BSCS', NULL, '2025-06-14 21:54:52', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `custom_requests`
--

CREATE TABLE `custom_requests` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_name` varchar(100) DEFAULT NULL,
  `category` varchar(50) DEFAULT NULL,
  `details` text DEFAULT NULL,
  `contact` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `custom_requests`
--

INSERT INTO `custom_requests` (`id`, `user_id`, `product_name`, `category`, `details`, `contact`, `created_at`) VALUES
(2, 1, 'Handmade Butterfly zip', 'Clothing', 'Add a touch of elegance to your accessories with this beautifully crafted Handmade Butterfly Zip', 'diya@gmail.com', '2025-06-14 19:57:24'),
(4, 1, ' Hand-stitched Embroidered Pillow', 'Home Decor', 'I want a custom pillow with traditional Sindhi embroidery in purple and gold threads. Approx size: 16x16 inches', 'user@example.com', '2025-06-14 19:59:32'),
(5, 1, ' Hand-stitched Embroidered Pillow', 'Home Decor', 'I want a custom pillow with traditional Sindhi embroidery in purple and gold threads. Approx size: 16x16 inches', 'user@example.com', '2025-06-14 20:01:13');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `request_id` int(11) NOT NULL,
  `sender` varchar(50) NOT NULL,
  `message` text NOT NULL,
  `sent_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `request_id`, `sender`, `message`, `sent_at`) VALUES
(16, 1, 'customer', 'ok', '2025-06-14 05:31:03'),
(17, 1, 'customer', 'Hi', '2025-06-14 05:31:06'),
(18, 1, 'artisan', 'Hi', '2025-06-14 05:33:24'),
(19, 1, 'artisan', 'good', '2025-06-14 05:33:29'),
(20, 1, 'artisan', 'good', '2025-06-14 05:34:15'),
(21, 1, 'user', 'ok fine', '2025-06-14 19:30:24');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `payment_gateway` varchar(100) DEFAULT NULL,
  `tax_amount` int(11) DEFAULT 0,
  `shipping_fee` int(11) DEFAULT 0,
  `total_amount` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `state` varchar(50) NOT NULL,
  `zip` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `payment_receipt` varchar(255) NOT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` varchar(50) NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `product_id`, `quantity`, `payment_gateway`, `tax_amount`, `shipping_fee`, `total_amount`, `name`, `email`, `phone`, `state`, `zip`, `address`, `payment_receipt`, `order_date`, `status`) VALUES
(5, 1, 3, 1, 'Debit Card', 120, 300, 4420, 'Diya Shezadi ', 'diyashezadi@gmail.com', '11111111', 'Punjab', '69000', 'Islamabad', 'uploads/receipts/1749923010_logo3.PNG', '2025-06-14 17:43:30', 'Processing'),
(6, 1, 1, 1, 'EasyPaisa', 6, 3, 108, 'Sadia', 'sadia@gmail.com', '1235555555555', 'KPK', '80035', 'Quetta', 'uploads/receipts/1749924149_freepik-export-20241030055851oQj4.png', '2025-06-14 18:02:29', 'Pending'),
(9, 1, 2, 1, 'EasyPaisa', 152, 200, 2252, 'Sadia', 'sadia@gmail.com', '1235555555555', 'KPK', '80035', 'Quetta', 'uploads/receipts/1749924149_freepik-export-20241030055851oQj4.png', '2025-06-14 18:02:29', 'Pending'),
(10, 1, 2, 1, 'Debit Card', 152, 200, 2252, 'aish', 'aish@gmail.com', '88990', 'Punjab', '88255', 'Lahore', 'uploads/receipts/1749924478_WhatsApp Image 2024-11-16 at 7.16.30 PM.jpeg', '2025-06-14 18:07:58', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `payment_gateways`
--

CREATE TABLE `payment_gateways` (
  `id` int(11) NOT NULL,
  `gateway_name` varchar(100) NOT NULL,
  `allowed` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payment_gateways`
--

INSERT INTO `payment_gateways` (`id`, `gateway_name`, `allowed`) VALUES
(1, 'Bank Transfer', 0),
(2, 'JazzCash', 0),
(3, 'EasyPaisa', 1),
(4, 'Card Payment', 0),
(5, 'Cash on Delivery', 1),
(6, 'Debit Card', 1),
(7, 'new', 1);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `saller_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `image` varchar(255) NOT NULL,
  `custom_request` tinyint(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `category` varchar(100) NOT NULL,
  `status` varchar(50) DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `saller_id`, `name`, `description`, `price`, `stock`, `image`, `custom_request`, `created_at`, `category`, `status`) VALUES
(1, 0, 'Diya', 'mm', 99, 88, '_d873868b-a64a-45bf-8767-30c25f35cb4b.jpg', 0, '2025-06-13 18:04:55', 'Jewllry', 'Rejected'),
(3, 2, 'Diy handmade crafts', 'handmade craft sweet looking fr daily for decoration', 4000, 20, '1749918572_2.PNG', 1, '2025-06-14 16:29:32', 'Home Decor', 'Approved'),
(4, 2, 'Handcrafted Floral Embroidered Cotton Tote Bag', 'Elevate your everyday style with this Handcrafted Floral Embroidered Cotton Tote Bag. Made from 100% pure cotton and adorned with intricate floral embroidery, this spacious and durable tote combines tradition with elegance. Perfect for shopping, school, or casual outings, each piece reflects the artistry of skilled artisans and adds a charming handmade touch to your look.\r\n', 3000, 15, '1749931573_ChatGPT Image Jun 13, 2025, 10_02_49 PM.png', 1, '2025-06-14 20:06:13', 'Clothing', 'Approved'),
(5, 3, 'Handmade Butterfly Zip Pouch', 'A beautifully handcrafted zip pouch featuring vibrant butterfly embroidery. Made with durable cotton canvas, it\'s perfect for storing cosmetics, stationery, or everyday essentials.', 8600, 70, '1749938212_33.PNG', 1, '2025-06-14 21:56:52', 'Clothing', 'Approved'),
(6, 3, 'Crochet Coaster Set (Pack of 4)', 'Add a touch of handmade elegance to your table with these colorful crochet coasters. A perfect gift for home lovers or a treat for yourself.', 5000, 30, '1749938298_444.PNG', 1, '2025-06-14 21:58:18', 'Home Decor', 'Approved'),
(7, 3, 'Hand-painted Clay Jewelry Set', 'This unique jewelry set includes a necklace and earrings, hand-painted with intricate motifs. Crafted from lightweight clay and sealed for durability.', 5000, 8, '1749938369_55.PNG', 1, '2025-06-14 21:59:29', 'Jewelry', 'Approved'),
(8, 3, 'Floral Embroidered Cotton Tote Bag', 'A stylish tote bag featuring beautiful floral embroidery. Made from pure cotton, eco-friendly and washable.', 2300, 9, '1749938415_Capture.PNG', 0, '2025-06-14 22:00:15', 'Clothing', 'Approved'),
(9, 2, 'Handmade Wooden key holder', 'Hand-carved wooden box with intricate floral patterns. Perfect for storingkeys, or keepsakes. Made from polished rosewood with velvet lining inside.', 1500, 80, '1749938619_ChatGPT Image Jun 13, 2025, 10_39_15 AM.png', 1, '2025-06-14 22:03:39', 'Home Decor', 'Approved'),
(10, 2, 'Crochet Bunny Plush Toy', 'This soft and cuddly crochet bunny is made with love using premium cotton yarn. Safe for kids and perfect as a nursery companion or baby shower gift. Features floppy ears and embroidered eyes for added safety.', 900, 5, '1749938695_66.PNG', 1, '2025-06-14 22:04:55', 'Toys', 'Approved');

-- --------------------------------------------------------

--
-- Table structure for table `promotions`
--

CREATE TABLE `promotions` (
  `id` int(11) NOT NULL,
  `type` enum('Product Activated','Tax Updated','Shipping Updated') NOT NULL,
  `description` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `promotions`
--

INSERT INTO `promotions` (`id`, `type`, `description`, `created_at`) VALUES
(1, 'Tax Updated', 'Tax updated to 6% for category: Jewllry', '2025-06-14 17:00:27'),
(2, 'Shipping Updated', 'Shipping updated to Rs. 3 for category: Jewllry', '2025-06-14 17:00:44'),
(4, 'Product Activated', 'Product \"Handcrafted Floral Embroidered Cotton Tote Bag\" has been activated by admin.', '2025-06-14 20:24:22'),
(6, 'Tax Updated', 'Tax updated to 4% for category: Toys', '2025-06-14 22:06:54'),
(7, 'Shipping Updated', 'Shipping updated to Rs. 2 for category: Clothing', '2025-06-14 22:07:30'),
(11, 'Tax Updated', 'Tax updated to 77% for category: Toys', '2025-06-14 22:11:59'),
(13, 'Shipping Updated', 'Shipping updated to Rs. 7 for category: Jewelry', '2025-06-14 22:13:52'),
(16, 'Shipping Updated', 'Shipping updated to Rs. 1000 for category: Toys', '2025-06-14 22:14:21');

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_name` varchar(100) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `product_id`, `user_name`, `rating`, `comment`, `created_at`) VALUES
(2, 1, 'diyya', 5, 'excellent looking', '2025-06-13 22:52:59'),
(3, 3, 'diyya', 3, 'great not too', '2025-06-14 12:41:23'),
(4, 9, 'wafa', 5, '“Beautiful craftsmanship with intricate woodwork. Perfect for gifting or storing precious items.”\r\n\r\n', '2025-06-14 15:28:10'),
(5, 10, 'Uzma Shah', 5, '“Super soft and well-stitched — my child adores it! Definitely feels safe and handmade with care.”\r\n\r\nLet me know if you need more reviews or want to show them dynamically from your database.', '2025-06-14 15:29:38');

-- --------------------------------------------------------

--
-- Table structure for table `shipping_rates`
--

CREATE TABLE `shipping_rates` (
  `id` int(11) NOT NULL,
  `category` varchar(100) NOT NULL,
  `shipping_fee` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `shipping_rates`
--

INSERT INTO `shipping_rates` (`id`, `category`, `shipping_fee`) VALUES
(1, 'Jewllry', 700),
(2, 'Clothing', 500),
(3, 'Home Decor', 600),
(4, 'Toy', 80),
(5, 'Jewelry', 120),
(6, 'Jewelry', 700),
(7, 'Toys', 750),
(8, 'Toys', 750),
(9, 'Toys', 750),
(10, 'Toys', 750),
(11, 'Clothing', 1500),
(12, 'Jewllry', 1500),
(13, 'Jewllry', 1500),
(14, 'Jewllry', 1500),
(15, 'Jewllry', 1500),
(16, 'Home Decor', 600);

-- --------------------------------------------------------

--
-- Table structure for table `taxes`
--

CREATE TABLE `taxes` (
  `id` int(11) NOT NULL,
  `category` varchar(100) NOT NULL,
  `tax_percent` decimal(5,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `taxes`
--

INSERT INTO `taxes` (`id`, `category`, `tax_percent`) VALUES
(1, 'Jewllry', '6.00'),
(2, 'Clothing', '8.00'),
(3, 'Home Decor', '3.00'),
(4, 'Toy', '5.00'),
(5, 'Jewelry', '7.00'),
(6, 'Toys', '3.00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `contact` varchar(20) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('active','suspended','banned') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `address`, `contact`, `created_at`, `status`) VALUES
(1, 'Diya Shezadi mam', 'diya@gmail.com', '81dc9bdb52d04dc20036dbd8313ed055', 'hazro', '03014357855', '2025-05-06 06:09:26', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

CREATE TABLE `wishlist` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`id`, `user_id`, `product_id`, `created_at`) VALUES
(2, 5, 1, '2025-06-14 00:39:04'),
(3, 1, 1, '2025-06-14 02:21:47'),
(4, 1, 2, '2025-06-14 05:47:36'),
(5, 1, 3, '2025-06-14 17:28:17'),
(6, 1, 7, '2025-06-14 22:23:55');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `artisan`
--
ALTER TABLE `artisan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `custom_requests`
--
ALTER TABLE `custom_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_gateways`
--
ALTER TABLE `payment_gateways`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_saller` (`saller_id`);

--
-- Indexes for table `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shipping_rates`
--
ALTER TABLE `shipping_rates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `taxes`
--
ALTER TABLE `taxes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `artisan`
--
ALTER TABLE `artisan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `custom_requests`
--
ALTER TABLE `custom_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `payment_gateways`
--
ALTER TABLE `payment_gateways`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `promotions`
--
ALTER TABLE `promotions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `shipping_rates`
--
ALTER TABLE `shipping_rates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `taxes`
--
ALTER TABLE `taxes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `fk_saller` FOREIGN KEY (`saller_id`) REFERENCES `artisan` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
