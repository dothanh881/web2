-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th5 06, 2024 lúc 09:07 AM
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
(284, 'f5889a61ccd0', 10, 1, 1129.00, 'Samsung Galaxy S23 Ultra', './assets/products/img10.png');

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
  `street` varchar(255) DEFAULT NULL,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `ward` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `order`
--

INSERT INTO `order` (`order_id`, `user_id`, `order_date`, `order_total_price`, `method`, `order_status`, `city`, `district`, `street`, `fullname`, `email`, `phone_number`, `ward`) VALUES
('85911', 'f5889a61ccd0', '2024-05-06', 484.00, 'onlinebanking', 'Pending', 'Ho Chi Minh', 'Tan Phu', '48/42 Le Nga', 'Thanh Do', 'abc@gmail.com', '123456789', 'Ward 6'),
('99352', 'f5889a61ccd0', '2024-05-06', 2500.00, 'cod', 'Pending', 'Ho Chi Minh', 'Phu Nhuan', '48/42 Le Nga', 'Thanh Do', 'abc@gmail.com', '123456789', 'Ward 3');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_detail`
--

CREATE TABLE `order_detail` (
  `order_detail_price` decimal(10,2) NOT NULL,
  `order_detail_quantity` int(11) NOT NULL,
  `order_id` varchar(255) NOT NULL,
  `item_id` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `order_detail`
--

INSERT INTO `order_detail` (`order_detail_price`, `order_detail_quantity`, `order_id`, `item_id`, `total_price`) VALUES
(484.00, 1, '85911', 6, 484.00),
(1452.00, 1, '99352', 2, 1452.00),
(1048.00, 1, '99352', 5, 1048.00);

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
(1, 1, 'iPhone 15 Pro Max', 0, 1459.35, 'Black', './assets/products/img1.png', 'iPhone 15 Pro Max is the most advanced iPhone with the largest screen, best battery life, strongest configuration and super durable, super light aerospace-standard Titanium frame design. iPhone 15 Pro Max possesses Apple most outstanding features. Accordi', 2, 512, 8, 6.00, '2024-04-14 14:12:47', '2024-04-14 14:12:47'),
(2, 1, 'iPhone 15 Pro Max', 9, 1452.00, 'Silver', './assets/products/img2.png', 'iPhone 15 Pro Max is the most advanced iPhone with the largest screen, best battery life, strongest configuration and super durable, super light aerospace-standard Titanium frame design. iPhone 15 Pro Max possesses Apple most outstanding features. Accordi', 2, 512, 8, 6.00, '2024-04-14 14:12:47', '2024-04-14 14:12:47'),
(3, 1, 'iPhone 14 Plus', 5, 1129.00, 'Purple', './assets/products/img3.png', 'The appeal of the new generation iPhone 2022 with a large screen, the best battery ever, impressive night photography and a series of top-notch technologies, the iPhone 14 Plus brings users into advanced mobile experiences. Advanced, ready for an active,', 2, 256, 6, 6.00, '2024-04-14 14:12:47', '2024-04-14 14:12:47'),
(4, 1, 'iPhone 14 Plus', 7, 1169.56, 'Yellow', './assets/products/img4.png', 'The appeal of the new generation iPhone 2022 with a large screen, the best battery ever, impressive night photography and a series of top-notch technologies, the iPhone 14 Plus brings users into advanced mobile experiences. Advanced, ready for an active,', 2, 256, 6, 6.00, '2024-04-14 14:12:47', '2024-04-14 14:12:47'),
(5, 1, 'iPhone 13 Pro Max', -4, 1048.00, 'White', './assets/products/img5.png', 'iPhone 13 Pro Max has the best dual camera system ever, the fastest Apple A15 processor in the smartphone world and extremely long battery life, ready to accompany you all day long.', 2, 512, 8, 6.00, '2024-04-14 14:12:47', '2024-04-14 14:12:47'),
(6, 1, 'iPhone 12 Pro Max', -22, 484.00, 'Yellow', './assets/products/img6.png', 'In the last months of 2020, Apple officially introduced to users as well as iFans the new generation of iPhone 12 series with a series of breakthrough features, completely transformed design, powerful performance and one of That is the iPhone 12 Pro Max 1', 2, 128, 6, 6.70, '2024-04-14 14:12:47', '2024-04-14 14:12:47'),
(7, 2, 'Samsung Galaxy S24 Ultra', 3, 1089.00, 'Blue', './assets/products/img7.png', 'Samsung Galaxy S24 Ultra is the smartest Galaxy phone ever with connection power, creative power and entertainment power all powered by Galaxy AI artificial intelligence. Completely new design from the classy Titanium frame, super camera with resolution u', 2, 512, 12, 6.80, '2024-04-14 14:12:47', '2024-04-14 14:12:47'),
(8, 2, 'Samsung Galaxy S22 Ultra', -3, 605.00, 'Black', './assets/products/img8.png', 'Samsung Galaxy S24 Ultra is the smartest Galaxy phone ever with connection power, creative power and entertainment power all powered by Galaxy AI artificial intelligence. Completely new design from the classy Titanium frame, super camera with resolution u', 2, 256, 12, 6.00, '2024-04-14 14:12:47', '2024-04-14 14:12:47'),
(9, 2, 'Samsung Galaxy Z Fold5', 10, 1493.00, 'Blue', './assets/products/img9.png', 'Joining Samsung Galaxy Z Flip 5 flexibly, you will experience a series of exciting breakthrough technologies and a completely new unique design. Where you can freely explore and confidently express your personality. The compactness, fit and fashion of the', 0, 512, 12, 7.00, '2024-04-14 14:12:47', '2024-04-14 14:12:47'),
(10, 2, 'Samsung Galaxy S23 Ultra', 7, 1129.00, 'Green', './assets/products/img10.png', 'Proud to be the first Galaxy phone to possess a superb 200MP sensor, the Samsung Galaxy S23 Ultra takes users into a world of cutting-edge photography. The power is also explosive with the most powerful Snapdragon processor for revolutionary gaming perfor', 2, 512, 12, 6.00, '2024-04-14 14:12:47', '2024-04-14 14:12:47'),
(11, 2, 'Samsung Galaxy S23 FE', -18, 524.00, 'Purple', './assets/products/img11.png', 'The Galaxy S23 FE 5G is the best Galaxy FE device Samsung has ever launched. Equipped with premium features from design to outstanding performance, an incredible night camera system. All combine to bring the perfect experience for work and entertainment', 2, 512, 8, 6.40, '2024-04-14 14:12:47', '2024-04-14 14:12:47'),
(12, 2, 'Samsung Galaxy A14', -4, 201.00, 'Silver', './assets/products/img12.png', 'Adding color and experience to your life, Samsung introduces the cheap Galaxy A14 4G with a series of new improvements. Everything is harmoniously combined from youthful design, 50MP camera system, sharp screen to super large battery, creating an attracti', 2, 128, 4, 6.00, '2024-04-14 14:12:47', '2024-04-14 14:12:47'),
(13, 2, 'Samsung Galaxy M54', 9, 1089.00, 'Silver', './assets/products/img13.png', 'Following the success of the Galaxy M53 5G, Samsung continues to launch the Samsung Galaxy M54 5G phone model. This launch, Samsung has upgraded performance, battery capacity and improved design to help bring the best product to you.', 2, 256, 8, 6.70, '2024-04-14 14:12:47', '2024-04-14 14:12:47'),
(34, 1, 'iPhone 15 Plus', 20, 989.90, 'Green', './assets/products/img14.png', 'iPhone 15 Plus 256GB not only stands out thanks to its 6.7-inch OLED Super Retina XDR screen but also offers impressive storage capacity with 256GB internal memory. In addition, this new generation of iPhone is also equipped with a pair of modern rear cam', 1, 256, 6, 6.70, '2024-05-05 22:24:54', '2024-05-05 22:24:54'),
(35, 1, 'iPhone 15', 20, 747.00, 'Yellow', './assets/products/img15.png', 'iPhone 15 not only stands out thanks to its 6.1-inch OLED Super Retina XDR screen but also offers impressive storage capacity with 256GB internal memory. In addition, this new generation of iPhone is also equipped with a pair of modern rear cameras with 4', 1, 128, 6, 6.10, '2024-05-05 22:26:45', '2024-05-05 22:26:45');

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
  `status` int(11) NOT NULL DEFAULT 1,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `register_date` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `fullname` varchar(255) NOT NULL,
  `ward` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `user`
--

INSERT INTO `user` (`user_id`, `email`, `username`, `password`, `street`, `district`, `city`, `phone_number`, `status`, `is_admin`, `register_date`, `updated_at`, `fullname`, `ward`) VALUES
('30cc6292fb19', 'thanhdanh@gmail.com', 'thanhdanh', '$2y$10$05QFlsVLYe/YJS0dfxTIs.cHp3Hx4zY55wGcAn6KWzdOH63/MB6Xq', '82 An Duong Vuong', 'District 10', 'Ho Chi Minh', '0342337766', 1, 0, '2024-05-06 09:13:08', '2024-05-06 09:13:08', 'Thanh Danh', 'Ward 12'),
('53091d01d890', 'thanh@gmail.com', 'dothanh1', '$2y$10$f0iEZLKTgVpN/mUPXPINCuLvI3u7M9pwkLlH/W2YIOqkChHJVi0Ei', '273 An Duong Vuong', 'District 5 ', 'Ho Chi Minh ', '0981776491', 1, 0, '2024-05-04 22:46:53', '2024-05-04 22:46:53', 'Thanh Do', 'Ward 8'),
('5d314b93c7b7', 'admin@email.com', 'admin', '$2y$10$u.LVXI1z1AY9eU2gsItc7.i0WsA2cbwxO1vJVm3OwJ4aEFqnOhIn2', '273 An Duong Vuong', 'District 5 ', 'Ho Chi Minh      ', '0981776492', 1, 1, '2024-04-14 21:21:53', '2024-04-14 21:21:53', 'Phu Thanh', 'Ward 8'),
('b690eca96339', 'thanhdanh@gmail.com', 'thanhdanh1', '$2y$10$2Z/ZJOgTLGTnDjEA79uqQeu7C2.MAh/bjXQ5PveRvU7PgUCyfp0DK', '82 An Duong Vuong', 'District 10', 'Ho Chi Minh', '0221545454', 0, 0, '2024-05-06 09:16:03', '2024-05-06 09:16:03', 'Danh Nguyen', 'Ward 10'),
('f5889a61ccd0', 'abc@gmail.com', 'user123', '$2y$10$yeceLurYhwpONvWihcG6F.k07fjvzJ5WayKkEqy.qMD5NsnsRX6/K', '48/42 Le Nga', 'Tan Phu ', 'Ho Chi Minh ', '0123456789', 1, 0, '2024-04-14 21:16:21', '2024-04-14 21:16:21', 'Thanh Do', 'Ward 10');

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
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=285;

--
-- AUTO_INCREMENT cho bảng `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT cho bảng `product`
--
ALTER TABLE `product`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

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
