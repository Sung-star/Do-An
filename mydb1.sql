-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 11, 2025 at 11:17 AM
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
-- Database: `mydb1`
--

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int UNSIGNED NOT NULL,
  `brandname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `brandname`, `code`, `image`, `description`, `created_at`, `updated_at`) VALUES
(11, 'Apple', NULL, NULL, 'Thương hiệu điện thoại cao cấp từ Mỹ', NULL, NULL),
(12, 'Samsung', NULL, NULL, 'Thương hiệu điện thoại và điện tử nổi tiếng Hàn Quốc', NULL, NULL),
(13, 'Dell', NULL, NULL, 'Thương hiệu laptop và PC nổi tiếng từ Mỹ', NULL, NULL),
(14, 'Sony', NULL, NULL, 'Thương hiệu điện tử và công nghệ từ Nhật Bản', NULL, NULL),
(15, 'Logitech', NULL, NULL, 'Thương hiệu thiết bị ngoại vi máy tính', NULL, NULL),
(16, 'Keychron', NULL, NULL, 'Thương hiệu bàn phím cơ nổi tiếng', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `cateid` int UNSIGNED NOT NULL,
  `catename` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `description` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cateid`, `catename`, `code`, `image`, `created_at`, `updated_at`, `description`) VALUES
(11, 'Điện thoại', NULL, NULL, NULL, NULL, 'Danh mục các loại điện thoại thông minh'),
(12, 'Laptop', NULL, NULL, NULL, NULL, 'Danh mục các loại máy tính xách tay'),
(13, 'Tai nghe', NULL, NULL, NULL, NULL, 'Danh mục các loại tai nghe chất lượng cao'),
(14, 'Máy tính bảng', NULL, NULL, NULL, NULL, 'Danh mục các loại máy tính bảng'),
(15, 'Đồng hồ thông minh', NULL, NULL, NULL, NULL, 'Danh mục các loại đồng hồ thông minh'),
(16, 'Chuột máy tính', NULL, NULL, NULL, NULL, 'Danh mục các loại chuột máy tính'),
(17, 'Bàn phím cơ', NULL, NULL, NULL, NULL, 'Danh mục các loại bàn phím cơ');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint UNSIGNED NOT NULL,
  `fullname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tel` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `fullname`, `tel`, `email`, `address`, `created_at`, `updated_at`) VALUES
(1, 'Công Minh', '0912367742', 'congminh@gmail.com', 'TP Hồ Chí Minh', '2025-09-29 17:40:01', '2025-10-07 08:16:52'),
(2, 'Hoài Sung', '0362367742', 'sung142005@gmail.com', 'Lâm Đồng', NULL, '2025-10-07 08:17:05');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2025_06_09_034334_create_categories_table', 1),
(2, '2025_06_09_034502_create_products_table', 1),
(3, '2025_06_16_024826_edit_categories_table', 1),
(4, '2025_06_16_031826_create_brands_table', 1),
(5, '2025_06_16_032104_add_brandid_to_products_table', 1),
(6, '2025_06_29_090357_edit_products_add_filename', 1),
(7, '2025_06_30_014535_create_users_table', 1),
(8, '2025_07_14_023049_create_customers_table', 1),
(9, '2025_07_14_023049_create_orders_table', 1),
(10, '2025_07_14_023050_create_orderitems_table', 1),
(11, '2025_07_23_133028_add_image_to_brands_and_categories', 1),
(13, '2025_09_26_034916_add_sold_and_is_featured_to_products_table', 2),
(14, '2025_10_04_101946_add_total_amount_to_orders_table', 2),
(15, '2025_10_04_102202_add_status_to_orders_table', 3),
(16, '2025_10_07_091930_create_reviews_table', 4),
(17, '2025_10_07_150738_add_payment_method_to_orders_table', 5),
(18, '2025_10_07_155700_add_stock_to_products_table', 6);

-- --------------------------------------------------------

--
-- Table structure for table `orderitems`
--

CREATE TABLE `orderitems` (
  `id` bigint UNSIGNED NOT NULL,
  `orderid` bigint UNSIGNED NOT NULL,
  `productid` bigint UNSIGNED NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(15,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orderitems`
--

INSERT INTO `orderitems` (`id`, `orderid`, `productid`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(6, 7, 10, 1, '990000.00', '2025-10-04 00:26:07', '2025-10-04 00:26:07'),
(7, 8, 9, 1, '470000.00', '2025-10-04 00:54:44', '2025-10-04 00:54:44'),
(10, 14, 2, 1, '15399000.00', '2025-10-04 04:42:50', '2025-10-04 04:42:50'),
(11, 14, 12, 1, '23990000.00', '2025-10-04 04:42:50', '2025-10-04 04:42:50'),
(14, 17, 14, 3, '7990000.00', '2025-10-04 05:25:31', '2025-10-04 05:25:31'),
(15, 18, 12, 1, '23990000.00', '2025-10-04 05:43:56', '2025-10-04 05:43:56'),
(16, 19, 12, 1, '23990000.00', '2025-10-04 05:54:49', '2025-10-04 05:54:49'),
(17, 19, 2, 1, '15399000.00', '2025-10-04 05:54:49', '2025-10-04 05:54:49'),
(18, 19, 5, 1, '750000.00', '2025-10-04 05:54:49', '2025-10-04 05:54:49'),
(19, 20, 2, 1, '15399000.00', '2025-10-07 02:11:03', '2025-10-07 02:11:03'),
(20, 20, 7, 1, '16999000.00', '2025-10-07 02:11:03', '2025-10-07 02:11:03'),
(21, 21, 3, 1, '27000000.00', '2025-10-07 06:43:55', '2025-10-07 06:43:55'),
(22, 22, 2, 1, '15399000.00', '2025-10-07 07:39:02', '2025-10-07 07:39:02'),
(23, 23, 12, 1, '23990000.00', '2025-10-07 07:55:26', '2025-10-07 07:55:26'),
(24, 25, 2, 1, '15399000.00', '2025-10-07 08:05:45', '2025-10-07 08:05:45'),
(25, 26, 12, 1, '23990000.00', '2025-10-07 08:27:38', '2025-10-07 08:27:38'),
(26, 27, 2, 1, '15399000.00', '2025-10-07 08:28:35', '2025-10-07 08:28:35'),
(27, 28, 12, 1, '23990000.00', '2025-10-07 08:31:13', '2025-10-07 08:31:13'),
(28, 29, 2, 1, '15399000.00', '2025-10-07 08:35:17', '2025-10-07 08:35:17'),
(31, 34, 2, 1, '15399000.00', '2025-10-07 08:59:32', '2025-10-07 08:59:32'),
(32, 35, 7, 1, '16999000.00', '2025-10-07 09:13:54', '2025-10-07 09:13:54'),
(33, 36, 5, 1, '750000.00', '2025-10-07 09:17:07', '2025-10-07 09:17:07'),
(34, 37, 12, 1, '23990000.00', '2025-10-08 05:37:56', '2025-10-08 05:37:56');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint UNSIGNED NOT NULL,
  `customerid` bigint UNSIGNED NOT NULL,
  `orderdate` date NOT NULL DEFAULT '2025-09-26',
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `total_amount` decimal(15,2) NOT NULL DEFAULT '0.00',
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'cod',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Chờ xử lý'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customerid`, `orderdate`, `description`, `created_at`, `updated_at`, `total_amount`, `payment_method`, `status`) VALUES
(7, 2, '2025-09-26', 'Khách hàng: sung\nSĐT: 31241274\nEmail: xuabgyaf@gmaill.com\nĐịa chỉ: 12361 TP Hồ Chí Minh\nThanh toán: MoMo\nTổng tiền: 990.000 VNĐ\n[ĐÃ THANH TOÁN MOMO - 2025-10-04 07:26:10]', '2025-10-04 00:26:07', '2025-10-04 03:43:38', '990000.00', 'momo', 'Chờ xử lý'),
(8, 1, '2025-09-26', 'Khách hàng: Hair Care 1\nSĐT: 123132\nEmail: qwdhas@gmail.com\nĐịa chỉ: Lâm Đồng\nThanh toán: MoMo\nTổng tiền: 470.000 VNĐ\n[ĐÃ THANH TOÁN MOMO - 2025-10-04 07:54:59]', '2025-10-04 00:54:44', '2025-10-04 03:43:38', '470000.00', 'momo', 'Chờ xử lý'),
(14, 1, '2025-09-26', 'Khách hàng: Bảo\nSĐT: 123132\nEmail: qwdhas@gmail.com\nĐịa chỉ: Lâm Đồng\nThanh toán: MoMo\nTổng tiền: 39.389.000 VNĐ', '2025-10-04 04:42:50', '2025-10-04 05:33:30', '0.00', 'cod', 'Hoàn thành'),
(17, 2, '2025-09-26', 'Khách hàng: Minh ròm\nSĐT: 31241274\nEmail: hocongminh@gmail.com\nĐịa chỉ: Bình Định\nThanh toán: MoMo\nTổng tiền: 23.970.000 VNĐ', '2025-10-04 05:25:31', '2025-10-04 05:26:18', '0.00', 'cod', 'Hoàn thành'),
(18, 2, '2025-09-26', 'Khách hàng: Hoài Sung\nSĐT: 31241274\nEmail: sung142005@gmail.com\nĐịa chỉ: Lâm Đồng\nThanh toán: MoMo\nTổng tiền: 23.990.000 VNĐ', '2025-10-04 05:43:56', '2025-10-04 05:43:56', '0.00', 'momo', 'Chờ xử lý'),
(19, 1, '2025-09-26', 'Khách hàng: Huy\nSĐT: 0183131\nEmail: user@gmail.com\nĐịa chỉ: Bình Định\nThanh toán: MoMo\nTổng tiền: 40.139.000 VNĐ', '2025-10-04 05:54:49', '2025-10-04 05:54:59', '0.00', 'momo', 'Hoàn thành'),
(20, 2, '2025-09-26', 'Khách hàng: Huy\nSĐT: 0183131\nEmail: user@gmail.com\nĐịa chỉ: Bình Định\nThanh toán: MoMo\nTổng tiền: 32.398.000 VNĐ', '2025-10-07 02:11:03', '2025-10-07 02:11:37', '0.00', 'cod', 'Hoàn thành'),
(21, 1, '2025-09-26', 'Khách hàng: Huy\nSĐT: 0183131\nEmail: user@gmail.com\nĐịa chỉ: Bình Định\nThanh toán: COD\nTổng tiền: 27.000.000 VNĐ', '2025-10-07 06:43:55', '2025-10-07 08:16:08', '0.00', 'cod', 'Hoàn thành'),
(22, 2, '2025-09-26', 'Khách hàng: Huy\nSĐT: 0183131\nEmail: user@gmail.com\nĐịa chỉ: Bình Định\nThanh toán: COD\nTổng tiền: 15.399.000 VNĐ', '2025-10-07 07:39:02', '2025-10-07 07:39:02', '0.00', 'momo', 'Chờ xử lý'),
(23, 2, '2025-09-26', 'Khách hàng: Huy\nSĐT: 0183131\nEmail: user@gmail.com\nĐịa chỉ: Bình Định\nThanh toán: COD\nTổng tiền: 23.990.000 VNĐ', '2025-10-07 07:55:26', '2025-10-07 07:55:26', '0.00', 'cod', 'Chờ xử lý'),
(24, 2, '2025-09-26', 'Khách hàng: Huy\nSĐT: 0183131\nEmail: user@gmail.com\nĐịa chỉ: Bình Định\nThanh toán: COD\nTổng tiền: 0 VNĐ', '2025-10-07 08:05:29', '2025-10-07 08:05:29', '0.00', 'cod', 'Chờ xử lý'),
(25, 2, '2025-09-26', 'Khách hàng: Hoài Sung\nSĐT: 31241274\nEmail: sung142005@gmail.com\nĐịa chỉ: Lâm Đồng\nThanh toán: COD\nTổng tiền: 15.399.000 VNĐ', '2025-10-07 08:05:45', '2025-10-07 08:05:45', '0.00', 'momo', 'Chờ xử lý'),
(26, 2, '2025-09-26', 'Khách hàng: Hoài Sung\nSĐT: 31241274\nEmail: sung142005@gmail.com\nĐịa chỉ: Lâm Đồng\nThanh toán: COD\nTổng tiền: 23.990.000 VNĐ', '2025-10-07 08:27:38', '2025-10-07 08:27:38', '0.00', 'cod', 'Chờ xử lý'),
(27, 2, '2025-09-26', 'Khách hàng: Hoài Sung\nSĐT: 31241274\nEmail: sung142005@gmail.com\nĐịa chỉ: Lâm Đồng\nThanh toán: MoMo\nTổng tiền: 15.399.000 VNĐ\n[ĐÃ THANH TOÁN MOMO - 2025-10-07 15:28:38]', '2025-10-07 08:28:35', '2025-10-07 08:28:38', '0.00', 'cod', 'Chờ xử lý'),
(28, 2, '2025-09-26', 'Khách hàng: Hair Care 1\nSĐT: 19274914\nEmail: qwdhas@gmail.com\nĐịa chỉ: Lâm Đồng\nThanh toán: MoMo\nTổng tiền: 23.990.000 VNĐ\n[ĐÃ THANH TOÁN MOMO - 2025-10-07 15:31:18]', '2025-10-07 08:31:13', '2025-10-07 08:31:18', '0.00', 'cod', 'Chờ xử lý'),
(29, 2, '2025-09-26', 'Khách hàng: Đức Huy\nSĐT: 19274914\nEmail: user@gmail.com\nĐịa chỉ: Bình Định\nThanh toán: MoMo\nTổng tiền: 15.399.000 VNĐ\n[ĐÃ THANH TOÁN MOMO - 2025-10-07 15:37:37]', '2025-10-07 08:35:17', '2025-10-07 08:37:37', '0.00', 'cod', 'Chờ xử lý'),
(30, 2, '2025-09-26', 'Khách hàng: Đức Huy\nSĐT: 19274914\nEmail: user@gmail.com\nĐịa chỉ: Bình Định\nThanh toán: MoMo\nTổng tiền: 0 VNĐ\n[ĐÃ THANH TOÁN MOMO - 2025-10-07 15:37:49]', '2025-10-07 08:37:47', '2025-10-07 08:37:49', '0.00', 'cod', 'Chờ xử lý'),
(31, 2, '2025-09-26', 'Khách hàng: Đức Huy\nSĐT: 19274914\nEmail: user@gmail.com\nĐịa chỉ: Bình Định\nThanh toán: MoMo\nTổng tiền: 0 VNĐ\n[ĐÃ THANH TOÁN MOMO - 2025-10-07 15:39:35]', '2025-10-07 08:39:26', '2025-10-07 08:39:35', '0.00', 'cod', 'Chờ xử lý'),
(34, 2, '2025-09-26', 'Khách hàng: Đức Huy\nSĐT: 19274914\nEmail: user@gmail.com\nĐịa chỉ: Bình Định\nThanh toán: MoMo\nTổng tiền: 15.399.000 VNĐ\n[ĐÃ THANH TOÁN MOMO - 2025-10-07 16:01:31]', '2025-10-07 08:59:32', '2025-10-07 09:10:18', '0.00', 'momo', 'Hoàn thành'),
(35, 2, '2025-09-26', 'Khách hàng: Đức Huy\nSĐT: 19274914\nEmail: user@gmail.com\nĐịa chỉ: Bình Định\nThanh toán: COD\nTổng tiền: 16.999.000 VNĐ', '2025-10-07 09:13:54', '2025-10-07 09:13:54', '0.00', 'cod', 'Chờ xử lý'),
(36, 2, '2025-09-26', 'Khách hàng: Đức Huy\nSĐT: 19274914\nEmail: user@gmail.com\nĐịa chỉ: Bình Định\nThanh toán: MoMo\nTổng tiền: 750.000 VNĐ\n[ĐÃ THANH TOÁN MOMO - 2025-10-07 16:17:10]', '2025-10-07 09:17:07', '2025-10-07 09:17:10', '0.00', 'momo', 'Đã thanh toán'),
(37, 1, '2025-09-26', 'Khách hàng: Đức Huy\nSĐT: 19274914\nEmail: user@gmail.com\nĐịa chỉ: Bình Định\nThanh toán: COD\nTổng tiền: 23.990.000 VNĐ', '2025-10-08 05:37:56', '2025-10-08 05:37:56', '0.00', 'cod', 'Chờ xử lý');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint UNSIGNED NOT NULL,
  `proname` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` int NOT NULL,
  `description` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cateid` int UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `brandid` int UNSIGNED NOT NULL,
  `fileName` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sold` int NOT NULL DEFAULT '0',
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `stock` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `proname`, `price`, `description`, `cateid`, `created_at`, `updated_at`, `brandid`, `fileName`, `sold`, `is_featured`, `stock`) VALUES
(2, 'Samsung Galaxy S24', 15399000, 'Điện thoại Samsung cao cấp với camera đỉnh cao', 11, NULL, '2025-10-07 08:59:32', 12, 'galaxy_s24.jpg', 0, 0, 100),
(3, 'MacBook Pro', 27000000, 'Laptop MacBook Pro hiệu năng mạnh mẽ cho lập trình và thiết kế', 12, NULL, '2025-09-25 19:19:19', 11, 'macbook_pro.jpg', 0, 0, 100),
(4, 'Dell XPS 13', 21650000, 'Laptop Dell XPS 13 mỏng nhẹ, màn hình sắc nét', 12, NULL, '2025-09-25 19:19:19', 13, 'dell_xps13.jpg', 0, 0, 100),
(5, 'AirPods Pro 2', 750000, 'Tai nghe AirPods Pro 2 với tính năng chống ồn chủ động', 13, NULL, '2025-10-07 09:17:07', 11, 'airpods_pro2.jpg', 0, 0, 100),
(6, 'Sony Headphones', 354000, 'Tai nghe Sony chất lượng âm thanh tuyệt hảo', 13, NULL, '2025-09-25 19:19:19', 14, 'sony_headphones.jpg', 0, 0, 100),
(7, 'iPad Pro', 16999000, 'Máy tính bảng iPad Pro phục vụ công việc và giải trí', 14, NULL, '2025-10-07 09:13:54', 11, 'ipad_pro.jpg', 0, 0, 100),
(8, 'Apple Watch', 2000000, 'Đồng hồ thông minh Apple Watch hỗ trợ theo dõi sức khỏe', 15, NULL, '2025-09-25 19:19:19', 11, 'apple_watch.jpg', 0, 0, 100),
(9, 'Logitech Mouse', 470000, 'Chuột Logitech thiết kế tiện dụng và chính xác', 16, NULL, '2025-09-25 19:19:19', 15, 'logitech_mouse.jpg', 0, 0, 100),
(10, 'Mechanical Keyboard', 990000, 'Bàn phím cơ cao cấp dành cho game thủ và lập trình viên', 17, NULL, '2025-09-25 19:19:19', 16, 'mechanical_keyboard.jpg', 0, 0, 100),
(12, 'Asus ROG Phone 8', 23990000, 'Điện thoại gaming hiệu năng cao với tản nhiệt vượt trội', 11, '2025-10-04 11:09:11', '2025-10-08 05:37:56', 12, 'rog_phone8.jpg', 0, 0, 100),
(13, 'HP Spectre x360', 28990000, 'Laptop 2-trong-1 cao cấp, màn hình cảm ứng gập 360 độ', 12, '2025-10-04 11:09:11', '2025-10-04 11:09:11', 11, 'hp_spectre_x360.jpg', 0, 0, 100),
(14, 'Bose QuietComfort 45', 7990000, 'Tai nghe chống ồn chủ động, âm thanh cao cấp', 13, '2025-10-04 11:09:11', '2025-10-04 11:09:11', 14, 'bose_qc45.jpg', 0, 0, 100);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint UNSIGNED NOT NULL,
  `product_id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `rating` tinyint UNSIGNED NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `product_id`, `user_id`, `rating`, `comment`, `created_at`, `updated_at`) VALUES
(1, 2, NULL, 2, 'Điện thoại hoạt động rất mượt mà, pin dùng được cả ngày.', '2025-08-15 19:45:38', '2025-10-07 02:25:49'),
(2, 2, NULL, 4, 'Laptop chạy nhanh, màn hình sắc nét, phù hợp cho công việc văn phòng.', '2025-09-22 21:42:02', '2025-10-07 02:25:49'),
(3, 2, NULL, 2, 'Âm thanh của tai nghe rất rõ và ấm, đeo lâu không bị đau tai.', '2025-09-17 16:10:23', '2025-10-07 02:25:49'),
(4, 2, NULL, 5, 'Camera của điện thoại chụp ảnh đẹp, màu sắc sống động.', '2025-08-03 10:48:23', '2025-10-07 02:25:49'),
(5, 2, NULL, 1, 'Máy tính bảng có thiết kế gọn nhẹ, pin bền, thích hợp cho học tập.', '2025-08-23 17:22:36', '2025-10-07 02:25:49'),
(6, 2, NULL, 1, 'Màn hình hiển thị sắc nét, màu chuẩn, rất tốt cho thiết kế đồ họa.', '2025-09-23 13:30:11', '2025-10-07 02:25:49'),
(7, 2, NULL, 3, 'Bàn phím gõ êm, phản hồi tốt, phù hợp cho lập trình.', '2025-09-22 12:12:23', '2025-10-07 02:25:49'),
(8, 3, NULL, 1, 'Pin sạc dự phòng dung lượng cao, sạc nhanh và an toàn.', '2025-08-07 23:31:29', '2025-10-07 02:25:49'),
(9, 3, NULL, 4, 'Loa Bluetooth âm thanh to, rõ, pin dùng được lâu.', '2025-07-24 16:28:21', '2025-10-07 02:25:49'),
(10, 3, NULL, 1, 'Laptop chơi game hiệu năng mạnh, tản nhiệt ổn định.', '2025-08-02 11:51:34', '2025-10-07 02:25:49'),
(11, 3, NULL, 4, 'Điện thoại có thiết kế đẹp, cầm chắc tay, cảm biến vân tay nhanh.', '2025-07-21 08:50:47', '2025-10-07 02:25:49'),
(12, 3, NULL, 2, 'Tai nghe không dây kết nối ổn định, chất âm tốt.', '2025-09-15 10:13:07', '2025-10-07 02:25:49'),
(13, 3, NULL, 4, 'Máy in in nhanh và tiết kiệm mực, dễ kết nối với máy tính.', '2025-07-07 16:29:23', '2025-10-07 02:25:49'),
(14, 3, NULL, 5, 'Điện thoại màn hình lớn, xem phim rất thích.', '2025-08-20 19:36:18', '2025-10-07 02:25:49'),
(15, 3, NULL, 5, 'Laptop mỏng nhẹ, dễ mang theo khi đi làm việc.', '2025-09-29 04:47:41', '2025-10-07 02:25:49'),
(16, 3, NULL, 3, 'Máy ảnh cho chất lượng ảnh tốt, dễ sử dụng cho người mới.', '2025-07-19 07:04:18', '2025-10-07 02:25:49'),
(17, 4, NULL, 1, 'Router wifi phát sóng mạnh, không bị gián đoạn khi xem video.', '2025-07-21 14:26:41', '2025-10-07 02:25:49'),
(18, 4, NULL, 1, 'Tablet hỗ trợ bút cảm ứng, tiện lợi cho ghi chú và vẽ.', '2025-07-10 04:01:17', '2025-10-07 02:25:49'),
(19, 4, NULL, 5, 'Tai nghe chống ồn tốt, pin lâu, nghe nhạc thoải mái.', '2025-09-13 21:25:40', '2025-10-07 02:25:49'),
(20, 4, NULL, 4, 'Bàn phím cơ gõ thích, đèn led đẹp, giá hợp lý.', '2025-08-21 12:55:08', '2025-10-07 02:25:49'),
(21, 4, NULL, 5, 'Màn hình cong rộng, chơi game rất đã mắt.', '2025-08-07 01:30:33', '2025-10-07 02:25:49'),
(22, 4, NULL, 2, 'Điện thoại sạc nhanh, chỉ mất khoảng 1 giờ là đầy pin.', '2025-07-08 02:15:50', '2025-10-07 02:25:49'),
(23, 4, NULL, 5, 'Laptop pin trâu, chạy mát, phù hợp cho sinh viên.', '2025-10-05 05:30:08', '2025-10-07 02:25:49'),
(24, 4, NULL, 2, 'Loa mini nhỏ gọn, âm thanh rõ, kết nối nhanh với điện thoại.', '2025-10-03 14:19:42', '2025-10-07 02:25:49'),
(25, 4, NULL, 3, 'Chuột không dây nhạy, pin dùng cả tháng không phải sạc.', '2025-10-06 08:53:36', '2025-10-07 02:25:49'),
(26, 5, NULL, 3, 'Ut sint impedit facere dolorem possimus quia ducimus repudiandae cupiditate ex et.', '2025-08-18 05:45:02', '2025-10-07 02:25:49'),
(27, 5, NULL, 3, 'Voluptas id est distinctio aliquam alias.', '2025-09-03 15:22:08', '2025-10-07 02:25:49'),
(28, 5, NULL, 5, 'Libero ea est et ad totam dolores ipsum numquam non eum qui consequatur enim rerum.', '2025-07-23 16:53:14', '2025-10-07 02:25:49'),
(29, 5, NULL, 1, 'Quasi et qui et.', '2025-09-01 03:32:16', '2025-10-07 02:25:49'),
(30, 5, NULL, 5, 'Unde maxime adipisci non voluptates consectetur vero iure non quisquam.', '2025-09-09 15:46:20', '2025-10-07 02:25:49'),
(31, 5, NULL, 2, 'Tempore recusandae non vitae id natus dolores ut dolorum ratione aliquam aliquid repudiandae.', '2025-08-14 04:29:28', '2025-10-07 02:25:49'),
(32, 5, NULL, 1, 'Est ut blanditiis et.', '2025-08-20 19:41:13', '2025-10-07 02:25:49'),
(33, 5, NULL, 3, 'Voluptatibus cupiditate quam hic voluptatem nihil.', '2025-10-03 05:32:36', '2025-10-07 02:25:49'),
(34, 6, NULL, 3, 'Numquam recusandae aut quis quas facere ut odio quae rem optio.', '2025-07-26 04:49:20', '2025-10-07 02:25:49'),
(35, 6, NULL, 1, 'Dolorum quia tempore nihil officiis dolor aut facilis aut ex cum qui temporibus ut.', '2025-08-05 03:31:23', '2025-10-07 02:25:49'),
(36, 6, NULL, 4, 'Maxime veritatis cum excepturi numquam voluptas.', '2025-09-06 00:01:45', '2025-10-07 02:25:49'),
(37, 6, NULL, 4, 'In fugiat dolore omnis cupiditate.', '2025-10-02 17:28:50', '2025-10-07 02:25:49'),
(38, 6, NULL, 4, 'Eum dolorem et dolor officiis rem omnis laudantium impedit architecto voluptatem.', '2025-08-10 19:34:15', '2025-10-07 02:25:49'),
(39, 6, NULL, 5, 'Excepturi nisi eligendi consequatur expedita ratione vel est et qui quis dolor.', '2025-07-21 22:44:52', '2025-10-07 02:25:49'),
(40, 6, NULL, 4, 'Deserunt voluptatum aut nesciunt tempora earum necessitatibus.', '2025-09-19 09:28:48', '2025-10-07 02:25:49'),
(41, 6, NULL, 4, 'Odio laudantium recusandae qui perferendis rerum esse voluptates.', '2025-07-19 01:20:59', '2025-10-07 02:25:49'),
(42, 6, NULL, 2, 'Quidem eius voluptas qui corrupti quae suscipit.', '2025-08-29 17:16:15', '2025-10-07 02:25:49'),
(43, 6, NULL, 5, 'Eaque consequatur eligendi est labore consectetur soluta.', '2025-08-31 01:42:00', '2025-10-07 02:25:49'),
(44, 7, NULL, 5, 'Quidem aut qui velit est ut laboriosam dolores.', '2025-07-29 18:35:03', '2025-10-07 02:25:49'),
(45, 7, NULL, 2, 'Quos aut enim suscipit laboriosam aspernatur unde.', '2025-07-18 08:26:10', '2025-10-07 02:25:49'),
(46, 7, NULL, 5, 'Iusto nostrum quasi laboriosam temporibus vitae hic nostrum nam.', '2025-09-22 16:43:28', '2025-10-07 02:25:49'),
(47, 7, NULL, 4, 'Asperiores molestiae eum quos impedit officiis.', '2025-07-24 13:47:32', '2025-10-07 02:25:49'),
(48, 7, NULL, 5, 'Magni quo est sed eius saepe assumenda.', '2025-08-13 04:23:35', '2025-10-07 02:25:49'),
(49, 7, NULL, 2, 'Totam numquam quo omnis ea.', '2025-09-03 12:10:29', '2025-10-07 02:25:49'),
(50, 8, NULL, 4, 'Illum aut voluptatibus numquam id ab et.', '2025-08-06 03:56:27', '2025-10-07 02:25:49'),
(51, 8, NULL, 3, 'Debitis ea sed ut esse quis aut eveniet.', '2025-08-17 05:27:21', '2025-10-07 02:25:49'),
(52, 8, NULL, 4, 'Est natus vel consequatur soluta ut ab nemo voluptatem cumque.', '2025-09-13 21:14:39', '2025-10-07 02:25:49'),
(53, 8, NULL, 3, 'Eveniet culpa quod molestiae nihil voluptates.', '2025-08-26 07:21:18', '2025-10-07 02:25:49'),
(54, 8, NULL, 2, 'Culpa placeat voluptatem eos necessitatibus quibusdam illo.', '2025-08-09 03:32:32', '2025-10-07 02:25:49'),
(55, 8, NULL, 5, 'Mollitia qui ut consequatur ut porro aperiam repellat.', '2025-09-09 14:03:56', '2025-10-07 02:25:49'),
(56, 8, NULL, 3, 'Voluptate dolores sapiente ut molestiae est itaque ut accusantium.', '2025-07-13 10:43:35', '2025-10-07 02:25:49'),
(57, 8, NULL, 3, 'Ut earum similique ea et enim magnam fuga.', '2025-08-25 12:28:21', '2025-10-07 02:25:49'),
(58, 8, NULL, 4, 'Quia et voluptatum sit soluta ut dolorum culpa autem.', '2025-10-03 01:42:53', '2025-10-07 02:25:49'),
(59, 8, NULL, 5, 'Omnis inventore occaecati iste quam nemo deserunt nihil.', '2025-10-01 03:11:57', '2025-10-07 02:25:49'),
(60, 9, NULL, 2, 'Rerum et fuga nesciunt est eveniet temporibus voluptas occaecati ut repellendus molestias tempore.', '2025-07-08 09:40:18', '2025-10-07 02:25:49'),
(61, 9, NULL, 4, 'Rerum atque tempora qui reprehenderit accusantium non quia maiores nesciunt animi atque autem delectus.', '2025-08-24 04:21:38', '2025-10-07 02:25:49'),
(62, 9, NULL, 3, 'Esse natus tempore veniam et ut eveniet aperiam quidem.', '2025-08-25 08:51:30', '2025-10-07 02:25:49'),
(63, 9, NULL, 2, 'Et neque itaque est sed saepe non enim in voluptates rerum eaque dolor eum consequatur voluptatem.', '2025-07-31 12:10:44', '2025-10-07 02:25:49'),
(64, 9, NULL, 2, 'Numquam est incidunt esse sunt recusandae et laudantium eos.', '2025-08-31 22:45:21', '2025-10-07 02:25:49'),
(65, 10, NULL, 2, 'Et dignissimos suscipit explicabo quia fuga aut.', '2025-08-30 14:44:57', '2025-10-07 02:25:49'),
(66, 10, NULL, 5, 'Iste voluptas blanditiis voluptatum nostrum.', '2025-09-23 12:53:32', '2025-10-07 02:25:49'),
(67, 10, NULL, 4, 'Voluptates non et ipsum qui ad qui aliquid.', '2025-07-12 02:47:29', '2025-10-07 02:25:49'),
(68, 10, NULL, 4, 'Aperiam quasi enim quasi ut harum voluptatum sed.', '2025-08-27 15:19:55', '2025-10-07 02:25:49'),
(69, 10, NULL, 4, 'Dolorem fuga aliquam consequatur non sunt fugiat tempore eos molestias error maiores iure.', '2025-07-30 08:38:14', '2025-10-07 02:25:49'),
(70, 10, NULL, 5, 'Qui qui sed voluptatem culpa consectetur quidem dolore.', '2025-08-02 01:59:00', '2025-10-07 02:25:49'),
(71, 10, NULL, 4, 'Illo hic et dolores pariatur optio possimus deserunt perspiciatis.', '2025-08-03 20:53:34', '2025-10-07 02:25:49'),
(72, 12, NULL, 4, 'Omnis et dolorem maiores a.', '2025-07-13 06:42:57', '2025-10-07 02:25:49'),
(73, 12, NULL, 3, 'Et aut laborum dolores vero fugiat.', '2025-09-13 09:16:03', '2025-10-07 02:25:49'),
(74, 12, NULL, 2, 'Asperiores occaecati et et aut et dicta aperiam consequatur et iste.', '2025-08-21 05:32:37', '2025-10-07 02:25:49'),
(75, 12, NULL, 2, 'A nihil reiciendis soluta itaque nisi quae.', '2025-09-23 08:11:13', '2025-10-07 02:25:49'),
(76, 12, NULL, 3, 'Libero ad provident eum fuga vel delectus vel possimus nihil veritatis eveniet asperiores ipsa.', '2025-09-30 08:11:43', '2025-10-07 02:25:49'),
(77, 12, NULL, 5, 'Ipsam doloremque doloribus eos illum sunt fuga.', '2025-07-11 19:13:14', '2025-10-07 02:25:49'),
(78, 13, NULL, 2, 'Numquam odit accusantium explicabo repellendus exercitationem labore dolorum voluptatem aperiam nesciunt cupiditate.', '2025-08-08 04:31:52', '2025-10-07 02:25:49'),
(79, 13, NULL, 4, 'Consequatur odit quis consequatur quo perspiciatis neque quisquam deleniti.', '2025-10-01 19:32:17', '2025-10-07 02:25:49'),
(80, 13, NULL, 4, 'Saepe minus doloribus quo temporibus nisi id consequuntur consequatur.', '2025-09-10 14:56:23', '2025-10-07 02:25:49'),
(81, 13, NULL, 5, 'Distinctio quo hic distinctio sed enim qui aut facilis iure adipisci non nam nihil dolore praesentium iusto.', '2025-08-05 20:06:01', '2025-10-07 02:25:49'),
(82, 13, NULL, 5, 'Id vitae et voluptatem sed et optio.', '2025-07-10 10:13:13', '2025-10-07 02:25:49'),
(83, 14, NULL, 4, 'Nisi qui accusamus non odit nihil ut esse numquam eveniet ut non aspernatur.', '2025-09-15 21:58:33', '2025-10-07 02:25:49'),
(84, 14, NULL, 5, 'Deserunt pariatur eos aut velit vel modi.', '2025-07-12 19:17:12', '2025-10-07 02:25:49'),
(85, 14, NULL, 3, 'Ut eveniet voluptatem aut nobis quo enim nihil.', '2025-08-28 10:30:48', '2025-10-07 02:25:49'),
(86, 14, NULL, 2, 'Ipsam excepturi cumque perferendis inventore aspernatur eius nihil consequatur suscipit cupiditate quia et et.', '2025-09-24 21:20:33', '2025-10-07 02:25:49'),
(87, 14, NULL, 4, 'Aut non tempore soluta quis velit dolore.', '2025-08-21 02:44:38', '2025-10-07 02:25:49'),
(88, 2, NULL, 5, 'điện thoại mượt', '2025-10-07 02:33:27', '2025-10-07 02:33:27');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fullname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` tinyint NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `fullname`, `email`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'user1', '$2y$12$Fw/18fcGRnLRlJs4vJc3qOaE0UJHpV8BvtUfE8LULFIfun12i966a', 'Nguyen Van A1', 'user1@gmail.com', 1, NULL, NULL, NULL),
(2, 'Hoài Sung', '$2y$12$Dk4a/BLnlkz.5hcN0UJKC.LqOBUrb3Q1CQMNwrOsDcVNEtBu1Nb/u', 'Nguyen Van A2', 'user2@gmail.com', 1, NULL, NULL, NULL),
(3, 'user3', '$2y$12$wEUvGS7sxLr8IasjKncYD.FrAl2RHsSHMT3ZoEK2KZMbcCtS9Gsju', 'Nguyen Van A3', 'user3@gmail.com', 1, NULL, NULL, NULL),
(4, 'user4', '$2y$12$I992JHNY8OhZkfFKX3/NZesO9y89MX6jjYfvGSSG3OHFrnh.y6l16', 'Nguyen Van A4', 'user4@gmail.com', 1, NULL, NULL, NULL),
(5, 'user5', '$2y$12$oIQ49jAmbU2oyLGvrZC8ZepEHu9RdciiRd5lTK6TmR8H8DjhJOL.G', 'Nguyen Van A5', 'user5@gmail.com', 1, NULL, NULL, NULL),
(6, 'user6', '$2y$12$RCmI3Ock19ezNukO908vyuMO9ln7p1uTM61rFhb23YEjF/qr/wDiy', 'Nguyen Van A6', 'user6@gmail.com', 1, NULL, NULL, NULL),
(7, 'user7', '$2y$12$dGocKUsGxTV7a9iBXd6oRO/zFYk2cmapRAQtCJsgpa097y3kPcztm', 'Nguyen Van A7', 'user7@gmail.com', 1, NULL, NULL, NULL),
(8, 'user8', '$2y$12$2qDHKKF7//mZ29FFD5uHgO9y/DQfOipICEVxD7x0.jcm.PzNZ3Vve', 'Nguyen Van A8', 'user8@gmail.com', 1, NULL, NULL, NULL),
(9, 'user9', '$2y$12$wnBF/b2BAcmgFBdnNRUtaO.mJgU5Lkt/tpKiazOAPkx.ERpX.8JeO', 'Nguyen Van A9', 'user9@gmail.com', 1, NULL, NULL, NULL),
(10, 'Sung', '$2y$12$1GZiYrppjDStEqrtUlGCEO/A5hMHnoYoxkOuiqdrsN0LIgOLv.wb2', 'Tạ Văn Hoài Sung', 'xuanta@gmail.com', 0, 'g4npF8B4YdkhzRhnFcQYd9TC8NkeaT1dzsWXS1lFqfc5QfpLMaXxerpeeyEq', '2025-10-08 05:52:57', '2025-10-08 05:52:57');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `brands_brandname_unique` (`brandname`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cateid`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customers_tel_unique` (`tel`),
  ADD UNIQUE KEY `customers_email_unique` (`email`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orderitems`
--
ALTER TABLE `orderitems`
  ADD PRIMARY KEY (`id`),
  ADD KEY `products_proid_foreign` (`productid`),
  ADD KEY `orders_orderid_foreign` (`orderid`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_customerid_foreign` (`customerid`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `categories_cateid_foreign` (`cateid`),
  ADD KEY `products_brandid_foreign` (`brandid`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `reviews_product_id_foreign` (`product_id`),
  ADD KEY `reviews_user_id_foreign` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `cateid` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `orderitems`
--
ALTER TABLE `orderitems`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orderitems`
--
ALTER TABLE `orderitems`
  ADD CONSTRAINT `orders_orderid_foreign` FOREIGN KEY (`orderid`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `products_proid_foreign` FOREIGN KEY (`productid`) REFERENCES `products` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_customerid_foreign` FOREIGN KEY (`customerid`) REFERENCES `customers` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `categories_cateid_foreign` FOREIGN KEY (`cateid`) REFERENCES `categories` (`cateid`),
  ADD CONSTRAINT `products_brandid_foreign` FOREIGN KEY (`brandid`) REFERENCES `brands` (`id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
