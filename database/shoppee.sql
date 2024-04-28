-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 20, 2024 lúc 05:09 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `shoppee`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `item_id` int(11) NOT NULL,
  `cart_quantity` int(11) DEFAULT NULL,
  `cart_price` decimal(10,2) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `cart_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `cart`
--

INSERT INTO `cart` (`cart_id`, `user_id`, `item_id`, `cart_quantity`, `cart_price`, `name`, `cart_image`) VALUES
(38, 'f5889a61ccd0', 4, 1, 1169.56, 'iPhone 14 Plus', './assets/products/img4.png');

--
-- Bẫy `cart`
--
DELIMITER $$
CREATE TRIGGER `check_cart_quantity_before_insert_update` BEFORE INSERT ON `cart` FOR EACH ROW begin
      declare item_quantity int;

      -- lấy số lượng tồn kho của sản phẩm
      select `item_quantity` into item_quantity
      from `product`
      where `item_id` = new.`item_id`;

      -- kiểm tra nếu số lượng trong giỏ hàng vượt quá số lượng tồn kho
      if new.`cart_quantity` > item_quantity then
          signal sqlstate '45000'
          set message_text = 'the quantity in the cart exceeds the available quantity in stock.';
      end if;
  end
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `category`
--

INSERT INTO `category` (`category_id`, `category_name`) VALUES
(1, 'APPLE'),
(2, 'SAMSUNG');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order`
--

CREATE TABLE `order` (
  `order_id` varchar(255) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `order_date` date NOT NULL DEFAULT current_timestamp(),
  `order_total_price` decimal(10,2) NOT NULL,
  `method` varchar(50) NOT NULL,
  `order_status` varchar(50) NOT NULL DEFAULT 'Pending',
  `city` varchar(100) DEFAULT NULL,
  `district` varchar(30) DEFAULT NULL,
  `street` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_detail`
--

CREATE TABLE `order_detail` (
  `order_detail_price` decimal(10,2) NOT NULL,
  `order_detail_quantity` int(11) NOT NULL,
  `order_id` varchar(255) NOT NULL,
  `item_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product`
--

CREATE TABLE `product` (
  `item_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `item_quantity` int(11) NOT NULL,
  `item_price` decimal(10,2) NOT NULL,
  `item_color` varchar(20) DEFAULT NULL,
  `item_image` varchar(255) DEFAULT NULL,
  `item_discription` varchar(255) DEFAULT NULL,
  `item_status` int(11) NOT NULL DEFAULT 0,
  `item_rom` int(11) DEFAULT NULL,
  `item_ram` int(11) DEFAULT NULL,
  `size_screen` decimal(10,2) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `product`
--

INSERT INTO `product` (`item_id`, `category_id`, `item_name`, `item_quantity`, `item_price`, `item_color`, `item_image`, `item_discription`, `item_status`, `item_rom`, `item_ram`, `size_screen`, `created_at`, `updated_at`) VALUES
(1, 1, 'iPhone 15 Pro Max', 9, 1459.35, 'Black', './assets/products/img1.png', 'iPhone 15 Pro Max is the most advanced iPhone with the largest screen, best battery life, strongest configuration and super durable, super light aerospace-standard Titanium frame design. iPhone 15 Pro Max possesses Apple most outstanding features. Accordi', 1, 512, 8, 6.00, '2024-04-14 14:12:47', '2024-04-14 14:12:47'),
(2, 2, 'iPhone 15 Pro Max', 10, 1452.00, 'Black', './assets/products/img2.png', 'iPhone 15 Pro Max is the most advanced iPhone with the largest screen, best battery life, strongest configuration and super durable, super light aerospace-standard Titanium frame design. iPhone 15 Pro Max possesses Apple most outstanding features. Accordi', 1, 512, 8, 6.00, '2024-04-14 14:12:47', '2024-04-14 14:12:47'),
(3, 1, 'iPhone 14 Plus', 10, 1129.00, 'Purple', './assets/products/img3.png', 'The appeal of the new generation iPhone 2022 with a large screen, the best battery ever, impressive night photography and a series of top-notch technologies, the iPhone 14 Plus brings users into advanced mobile experiences. Advanced, ready for an active,', 1, 256, 6, 6.00, '2024-04-14 14:12:47', '2024-04-14 14:12:47'),
(4, 1, 'iPhone 14 Plus', 10, 1169.56, 'Yellow', './assets/products/img4.png', 'The appeal of the new generation iPhone 2022 with a large screen, the best battery ever, impressive night photography and a series of top-notch technologies, the iPhone 14 Plus brings users into advanced mobile experiences. Advanced, ready for an active,', 1, 256, 6, 6.00, '2024-04-14 14:12:47', '2024-04-14 14:12:47'),
(5, 1, 'iPhone 13 Pro Max', 10, 1048.00, 'White', './assets/products/img5.png', 'iPhone 13 Pro Max has the best dual camera system ever, the fastest Apple A15 processor in the smartphone world and extremely long battery life, ready to accompany you all day long.', 1, 512, 6, 6.70, '2024-04-14 14:12:47', '2024-04-14 14:12:47'),
(6, 1, 'iPhone 12 Pro Max', 10, 484.00, 'Yellow', './assets/products/img6.png', 'In the last months of 2020, Apple officially introduced to users as well as iFans the new generation of iPhone 12 series with a series of breakthrough features, completely transformed design, powerful performance and one of That is the iPhone 12 Pro Max 1', 1, 128, 6, 6.70, '2024-04-14 14:12:47', '2024-04-14 14:12:47'),
(7, 2, 'Samsung Galaxy S24 Ultra', 10, 1089.00, 'Blue', './assets/products/img7.png', 'Samsung Galaxy S24 Ultra is the smartest Galaxy phone ever with connection power, creative power and entertainment power all powered by Galaxy AI artificial intelligence. Completely new design from the classy Titanium frame, super camera with resolution u', 1, 512, 12, 6.80, '2024-04-14 14:12:47', '2024-04-14 14:12:47'),
(8, 2, 'Samsung Galaxy S22 Ultra', 10, 605.00, 'Black', './assets/products/img8.png', 'Samsung Galaxy S24 Ultra is the smartest Galaxy phone ever with connection power, creative power and entertainment power all powered by Galaxy AI artificial intelligence. Completely new design from the classy Titanium frame, super camera with resolution u', 1, 256, 12, 6.00, '2024-04-14 14:12:47', '2024-04-14 14:12:47'),
(9, 2, 'Samsung Galaxy Z Fold5', 10, 1493.00, 'Blue', './assets/products/img9.png', 'Joining Samsung Galaxy Z Flip 5 flexibly, you will experience a series of exciting breakthrough technologies and a completely new unique design. Where you can freely explore and confidently express your personality. The compactness, fit and fashion of the', 0, 512, 12, 7.00, '2024-04-14 14:12:47', '2024-04-14 14:12:47'),
(10, 2, 'Samsung Galaxy S23 Ultra', 10, 1129.00, 'Green', './assets/products/img10.png', 'Proud to be the first Galaxy phone to possess a superb 200MP sensor, the Samsung Galaxy S23 Ultra takes users into a world of cutting-edge photography. The power is also explosive with the most powerful Snapdragon processor for revolutionary gaming perfor', 1, 512, 12, 6.80, '2024-04-14 14:12:47', '2024-04-14 14:12:47'),
(11, 2, 'Samsung Galaxy S23 FE', 10, 524.00, 'Purple', './assets/products/img11.png', 'The Galaxy S23 FE 5G is the best Galaxy FE device Samsung has ever launched. Equipped with premium features from design to outstanding performance, an incredible night camera system. All combine to bring the perfect experience for work and entertainment', 1, 512, 8, 6.40, '2024-04-14 14:12:47', '2024-04-14 14:12:47'),
(12, 2, 'Samsung Galaxy A14', 10, 201.00, 'Silver', './assets/products/img12.png', 'Adding color and experience to your life, Samsung introduces the cheap Galaxy A14 4G with a series of new improvements. Everything is harmoniously combined from youthful design, 50MP camera system, sharp screen to super large battery, creating an attracti', 1, 128, 4, 6.60, '2024-04-14 14:12:47', '2024-04-14 14:12:47'),
(13, 2, 'Samsung Galaxy M54', 10, 1089.00, 'Silver', './assets/products/img13.png', 'Following the success of the Galaxy M53 5G, Samsung continues to launch the Samsung Galaxy M54 5G phone model. This launch, Samsung has upgraded performance, battery capacity and improved design to help bring the best product to you.', 1, 256, 8, 6.70, '2024-04-14 14:12:47', '2024-04-14 14:12:47');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `user`
--

CREATE TABLE `user` (
  `user_id` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `street` varchar(255) NOT NULL,
  `district` varchar(30) NOT NULL,
  `city` varchar(100) NOT NULL,
  `phone_number` varchar(100) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `register_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `fullname` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `user`
--

INSERT INTO `user` (`user_id`, `email`, `username`, `password`, `street`, `district`, `city`, `phone_number`, `status`, `is_admin`, `register_date`, `updated_at`, `fullname`) VALUES
('5d314b93c7b7', 'admin@email.com', 'admin', '$2y$10$u.LVXI1z1AY9eU2gsItc7.i0WsA2cbwxO1vJVm3OwJ4aEFqnOhIn2', '273 An Duong Vuong', 'district 5', 'HCMC   ', '0981776491', 1, 1, '2024-04-14 21:21:53', '2024-04-14 21:21:53', 'Phu Thanh'),
('bb14664305c0', 'thanhabc@gmail.com', 'thanhdo', '$2y$10$T/2yWVozYX18CYtrJGWQg.W2GmJbWFNA6jT0g8xcym4Ynu3vteQCq', '48/42 Le Nga', 'TanPhu', 'HCMC', '0125665893', 1, 0, '2024-04-16 22:10:16', '2024-04-16 22:10:16', 'Thanh Do Phu'),
('f2279ebced53', 'test@gmail.com', 'test1', '$2y$10$PKKWO3uJOjIxNv4eQhuJg.cBoXnDWATsbV.wFR9/Aea8BJf5KGK8y', 'Nguyen Thi Nho', 'district 11 ', 'HCMC  ', '015972369', 1, 0, '2024-04-20 21:09:14', '2024-04-20 21:09:14', 'Test Thanh Do'),
('f5889a61ccd0', 'abc@gmail.com', 'user123', '$2y$10$yeceLurYhwpONvWihcG6F.k07fjvzJ5WayKkEqy.qMD5NsnsRX6/K', '48/42 Le Nga', 'TanPhu', 'HCMC', '0123456789', 1, 0, '2024-04-14 21:16:21', '2024-04-14 21:16:21', 'Thanh Do');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `fk_cart_user_id` (`user_id`),
  ADD KEY `fk_cart_item_id` (`item_id`);

--
-- Chỉ mục cho bảng `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Chỉ mục cho bảng `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `order_ibfk_1` (`user_id`);

--
-- Chỉ mục cho bảng `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`order_id`,`item_id`),
  ADD KEY `fk_order_detail_item_id` (`item_id`);

--
-- Chỉ mục cho bảng `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `fk_product_category` (`category_id`);

--
-- Chỉ mục cho bảng `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT cho bảng `product`
--
ALTER TABLE `product`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `fk_cart_item_id` FOREIGN KEY (`item_id`) REFERENCES `product` (`item_id`),
  ADD CONSTRAINT `fk_cart_user_id` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Các ràng buộc cho bảng `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`user_id`);

--
-- Các ràng buộc cho bảng `order_detail`
--
ALTER TABLE `order_detail`
  ADD CONSTRAINT `fk_order_detail_item_id` FOREIGN KEY (`item_id`) REFERENCES `product` (`item_id`),
  ADD CONSTRAINT `fk_order_detail_order_id` FOREIGN KEY (`order_id`) REFERENCES `order` (`order_id`);

--
-- Các ràng buộc cho bảng `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `fk_product_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
