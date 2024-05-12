-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th5 11, 2024 lúc 05:48 PM
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
('01171', '8016c59ca618', '2024-05-10', 1129.00, 'cod', 'Processing', 'Ho Chi Minh', 'Go Vap', '50 Pham Van Dong', 'Huynh Duy Khang', 'khanghuynh@gmail.com', '0981332561', 'Ward 11'),
('03834', '8016c59ca618', '2024-05-10', 1452.00, 'cod', 'Processing', 'Ho Chi Minh', 'Go Vap', '50 Pham Van Dong', 'Huynh Duy Khang', 'khanghuynh@gmail.com', '0981332561', 'Ward 11'),
('04410', '8016c59ca618', '2024-05-10', 1452.00, 'cod', 'Processing', 'Ho Chi Minh', 'Go Vap', '50 Pham Van Dong', 'Huynh Duy Khang', 'khanghuynh@gmail.com', '0981332561', 'Ward 11'),
('05263', 'f5889a61ccd0', '2024-05-10', 484.00, 'cod', 'Cancelled', 'Ho Chi Minh ', 'Tan Phu ', '48/42 Le Nga', 'Thanh Do', 'abc@gmail.com', '0123456789', 'Ward 10'),
('05971', '8016c59ca618', '2024-05-07', 4142.35, 'onlinebanking', 'Complete', 'Ho Chi Minh', 'Go Vap', '50 Pham Van Dong', 'Huynh Duy Khang', 'khanghuynh@gmail.com', '0981332561', 'Ward 11'),
('07452', '8016c59ca618', '2024-05-10', 1129.00, 'cod', 'Processing', 'Ho Chi Minh', 'Go Vap', '50 Pham Van Dong', 'Huynh Duy Khang', 'khanghuynh@gmail.com', '0981332561', 'Ward 11'),
('10244', '8016c59ca618', '2024-05-10', 1493.00, 'cod', 'Cancelled', 'Ho Chi Minh', 'Go Vap', '50 Pham Van Dong', 'Huynh Duy Khang', 'khanghuynh@gmail.com', '0981332561', 'Ward 11'),
('10847', '8016c59ca618', '2024-05-10', 1493.00, 'cod', 'Processing', 'Ho Chi Minh', 'Go Vap', '50 Pham Van Dong', 'Huynh Duy Khang', 'khanghuynh@gmail.com', '0981332561', 'Ward 11'),
('12228', 'f5889a61ccd0', '2024-05-06', 4644.35, 'cod', 'Complete', 'Ho Chi Minh', 'District 10', '601A Cach Mang Thang Tam', 'Nhien Nguyen', 'nhienng@gmail.com', '0375542863', 'Ward 11'),
('16977', 'f5889a61ccd0', '2024-05-10', 1089.00, 'cod', 'Processing', 'Ho Chi Minh ', 'Tan Phu ', '48/42 Le Nga', 'Thanh Do', 'abc@gmail.com', '0123456789', 'Ward 10'),
('17847', '8016c59ca618', '2024-05-07', 4556.00, 'cod', 'Complete', 'Ho Chi Minh', 'Tan Binh', '86/71 Au Co', 'Khang Huynh', 'dkhang@gmail.com', '0982256691', 'Ward 9'),
('17951', '8016c59ca618', '2024-05-10', 605.00, 'cod', 'Processing', 'Ho Chi Minh', 'Go Vap', '50 Pham Van Dong', 'Huynh Duy Khang', 'khanghuynh@gmail.com', '0981332561', 'Ward 11'),
('18247', '34b8a535e37c', '2024-05-07', 3489.00, 'cod', 'Complete', 'Ho Chi Minh', 'District 11', '237 Ly Thuong Kiet', 'Be Yeu Dau', 'beyeu@gmail.com', '0981445421', 'Ward 10'),
('18977', '8016c59ca618', '2024-05-10', 1089.00, 'onlinebanking', 'Processing', 'Ho Chi Minh', 'Go Vap', '50 Pham Van Dong', 'Huynh Duy Khang', 'khanghuynh@gmail.com', '0981332561', 'Ward 11'),
('20540', 'f5889a61ccd0', '2024-05-11', 1493.00, 'cod', 'Complete', 'Ho Chi Minh  ', 'Tan Phu  ', '48/42 Le Nga', 'Thanh Do', 'abc@gmail.com', '0981776491', 'Ward 10 '),
('28190', 'f5889a61ccd0', '2024-05-06', 1736.90, 'onlinebanking', 'Complete', 'Ho Chi Minh', 'District 10', '401A Cach Mang Thang Tam', 'Do Thanh', 'thanh@gmail.com', '0981776491', 'Ward 8'),
('30045', '8016c59ca618', '2024-05-10', 1129.00, 'cod', 'Processing', 'Ho Chi Minh', 'Go Vap', '50 Pham Van Dong', 'Huynh Duy Khang', 'khanghuynh@gmail.com', '0981332561', 'Ward 11'),
('30915', 'b690eca96339', '2024-05-07', 5726.12, 'onlinebanking', 'Complete', '', 'Tan Binh', '88/14 Nguyen Thi Nho', 'Nguyen Danh', 'danh@gmail.com', '0985566441', 'Ward 9'),
('32893', '4ac4503d26ea', '2024-05-09', 2911.35, 'cod', 'Complete', 'Ho Chi Minh', 'District 10', '42 Thanh Thai', 'Nguyen Ngoc Nhien', 'nguyenngocnhien@gmail.com', '0985566691', 'Ward 12'),
('34272', '8016c59ca618', '2024-05-10', 1169.56, 'cod', 'Complete', 'Ho Chi Minh', 'Go Vap', '50 Pham Van Dong', 'Huynh Duy Khang', 'khanghuynh@gmail.com', '0981332561', 'Ward 11'),
('36261', '8016c59ca618', '2024-05-10', 524.00, 'cod', 'Complete', 'Ho Chi Minh', 'Go Vap', '50 Pham Van Dong', 'Huynh Duy Khang', 'khanghuynh@gmail.com', '0981332561', 'Ward 11'),
('39815', 'b690eca96339', '2024-05-09', 1048.00, 'onlinebanking', 'Pending', 'Ho Chi Minh', 'District 10', '82 An Duong Vuong', 'Danh Nguyen', 'thanhdanh@gmail.com', '0221545454', 'Ward 10'),
('41781', 'f5889a61ccd0', '2024-05-10', 1048.00, 'cod', 'Pending', 'Ho Chi Minh ', 'Tan Phu ', '48/42 Le Nga', 'Thanh Do', 'abc@gmail.com', '0123456789', 'Ward 10'),
('43033', '53091d01d890', '2024-05-09', 2258.00, 'onlinebanking', 'Complete', 'Ho Chi Minh ', 'District 5 ', '273 An Duong Vuong', 'Thanh Do', 'thanh@gmail.com', '0981776491', 'Ward 8'),
('46288', '53091d01d890', '2024-05-06', 4678.12, 'onlinebanking', 'Complete', 'Ho Chi Minh', 'District 11', '14 Dong Nai', 'Duy Khang', 'khanghuynh@gmail.com', '0982256691', 'Ward 10'),
('48411', '8016c59ca618', '2024-05-09', 2548.35, 'cod', 'Complete', 'Ho Chi Minh', 'Go Vap', '50 Pham Van Dong', 'Huynh Duy Khang', 'khanghuynh@gmail.com', '0981332561', 'Ward 11'),
('51306', 'f5889a61ccd0', '2024-05-10', 524.00, 'cod', 'Pending', 'Ho Chi Minh ', 'Tan Phu ', '48/42 Le Nga', 'Thanh Do', 'abc@gmail.com', '0123456789', 'Ward 10'),
('51532', 'f5889a61ccd0', '2024-05-09', 1734.00, 'cod', 'Complete', 'Ho Chi Minh ', 'Tan Phu ', '48/42 Le Nga', 'Thanh Do', 'abc@gmail.com', '0123456789', 'Ward 10'),
('53325', '34b8a535e37c', '2024-05-09', 1330.00, 'cod', 'Complete', 'Ho Chi Minh', 'District 11', '237 Ly Thuong Kiet', 'Be Yeu Dau', 'beyeu@gmail.com', '0981445421', 'Ward 10'),
('54296', '4ac4503d26ea', '2024-05-07', 6854.00, 'cod', 'Complete', 'Ho Chi Minh', 'District 10', '42 Thanh Thai', 'Nguyen Ngoc Nhien', 'nguyenngocnhien@gmail.com', '0985566691', 'Ward 12'),
('55138', 'f5889a61ccd0', '2024-05-07', 2137.00, 'cod', 'Processing', 'Ho Chi Minh', 'District 6', '654/5A Pham Van Chi', 'Phu Thanh', 'thanh@gmail.com', '0981776491', 'Ward 8'),
('56739', 'b690eca96339', '2024-05-09', 2905.00, 'cod', 'Complete', 'Ho Chi Minh', 'District 10', '82 An Duong Vuong', 'Danh Nguyen', 'thanhdanh@gmail.com', '0221545454', 'Ward 10'),
('59114', 'b690eca96339', '2024-05-09', 1169.56, 'onlinebanking', 'Complete', 'Ho Chi Minh', 'District 3', 'Vo Thi Sau', 'Danh Vo', 'danhvothanh@gmail.com', '0981776491', 'Ward 6'),
('60136', 'b690eca96339', '2024-05-10', 989.90, 'cod', 'Complete', 'Ho Chi Minh', 'District 10', '82 An Duong Vuong', 'Danh Nguyen', 'thanhdanh@gmail.com', '0221545454', 'Ward 10'),
('62529', 'f5889a61ccd0', '2024-05-10', 605.00, 'cod', 'Pending', 'Ho Chi Minh ', 'Tan Phu ', '48/42 Le Nga', 'Thanh Do', 'abc@gmail.com', '0123456789', 'Ward 10'),
('64693', 'f5889a61ccd0', '2024-05-09', 3670.00, 'onlinebanking', 'Complete', 'Ho Chi Minh ', 'Tan Phu ', '48/42 Le Nga', 'Thanh Do', 'abc@gmail.com', '0123456789', 'Ward 10'),
('64882', 'f5889a61ccd0', '2024-05-06', 2258.00, 'onlinebanking', 'Cancelled', 'Ho Chi Minh ', 'Tan Phu ', '48/42 Le Nga', 'Thanh Do', 'abc@gmail.com', '0123456789', 'Ward 10'),
('65079', 'f5889a61ccd0', '2024-05-10', 1459.35, 'cod', 'Pending', 'Ho Chi Minh ', 'Tan Phu ', '48/42 Le Nga', 'Thanh Do', 'abc@gmail.com', '0123456789', 'Ward 10'),
('65645', 'f5889a61ccd0', '2024-05-09', 1976.00, 'cod', 'Cancelled', 'Ho Chi Minh ', 'Tan Phu ', '48/42 Le Nga', 'Thanh Do', 'abc@gmail.com', '0123456789', 'Ward 10'),
('68590', 'b690eca96339', '2024-05-10', 1089.00, 'cod', 'Pending', 'Ho Chi Minh', 'District 10', '82 An Duong Vuong', 'Danh Nguyen', 'thanhdanh@gmail.com', '0221545454', 'Ward 10'),
('68751', '53091d01d890', '2024-05-11', 989.90, 'onlinebanking', 'Complete', 'Ho Chi Minh ', 'District 5 ', '273 An Duong Vuong', 'Thanh Do', 'thanh@gmail.com', '0981776491', 'Ward 8'),
('70752', 'b690eca96339', '2024-05-07', 4296.90, 'onlinebanking', 'Complete', 'Ho Chi Minh', 'District 11', '124  Nguyen Thi Nho', 'Danh', 'danh@gmail.com', '0167558223', 'Ward 12'),
('72850', 'f5889a61ccd0', '2024-05-06', 4155.00, 'cod', 'Pending', 'Ho Chi Minh', 'Go Vap', '40 Pham Van Dong', 'Khang Huynh', 'khang@gmail.com', '0144785523', 'Ward 10'),
('75004', '8016c59ca618', '2024-05-10', 989.90, 'cod', 'Processing', 'Ho Chi Minh', 'Go Vap', '50 Pham Van Dong', 'Huynh Duy Khang', 'khanghuynh@gmail.com', '0981332561', 'Ward 11'),
('85911', 'f5889a61ccd0', '2024-05-06', 484.00, 'onlinebanking', 'Complete', 'Ho Chi Minh', 'Tan Phu', '48/42 Le Nga', 'Thanh Do', 'abc@gmail.com', '123456789', 'Ward 6'),
('86252', '53091d01d890', '2024-05-06', 3636.35, 'cod', 'Complete', 'Ho Chi Minh ', 'District 5 ', '273 An Duong Vuong', 'Thanh Do', 'thanh@gmail.com', '0981776491', 'Ward 8'),
('88695', 'f5889a61ccd0', '2024-05-10', 1493.00, 'cod', 'Pending', 'Ho Chi Minh ', 'Tan Phu ', '48/42 Le Nga', 'Thanh Do', 'abc@gmail.com', '0123456789', 'Ward 10'),
('89314', 'b690eca96339', '2024-05-07', 2062.35, 'cod', 'Pending', 'Ho Chi Minh', 'District 10', '82 An Duong Vuong', 'Danh Nguyen', 'thanhdanh@gmail.com', '0221545454', 'Ward 10'),
('89571', 'f5889a61ccd0', '2024-05-10', 1048.00, 'cod', 'Pending', 'Ho Chi Minh ', 'Tan Phu ', '48/42 Le Nga', 'Thanh Do', 'abc@gmail.com', '0123456789', 'Ward 10'),
('89887', 'f5889a61ccd0', '2024-05-11', 747.00, 'onlinebanking', 'Pending', 'Ho Chi Minh', 'District 11', '319 Ly Thuong Kiet', 'Do Thanh', 'thanhdo@gmail.com', '0981776491', 'Ward 10'),
('92546', '53091d01d890', '2024-05-11', 484.00, 'cod', 'Complete', 'Ho Chi Minh ', 'District 5 ', '273 An Duong Vuong', 'Thanh Do', 'thanh@gmail.com', '0981776491', 'Ward 8'),
('93975', 'f5889a61ccd0', '2024-05-07', 3328.90, 'cod', 'Complete', 'Ho Chi Minh ', 'Tan Phu ', '48/42 Le Nga', 'Thanh Do', 'abc@gmail.com', '0123456789', 'Ward 10'),
('93982', 'f5889a61ccd0', '2024-05-10', 484.00, 'cod', 'Pending', 'Ho Chi Minh ', 'Tan Phu ', '48/42 Le Nga', 'Thanh Do', 'abc@gmail.com', '0123456789', 'Ward 10'),
('96037', 'f5889a61ccd0', '2024-05-10', 524.00, 'cod', 'Pending', 'Ho Chi Minh ', 'Tan Phu ', '48/42 Le Nga', 'Thanh Do', 'abc@gmail.com', '0123456789', 'Ward 10'),
('97594', 'b690eca96339', '2024-05-10', 1129.00, 'cod', 'Pending', 'Ho Chi Minh', 'District 10', '82 An Duong Vuong', 'Danh Nguyen', 'thanhdanh@gmail.com', '0221545454', 'Ward 10'),
('98788', 'b690eca96339', '2024-05-10', 1169.56, 'cod', 'Complete', 'Ho Chi Minh', 'District 10', '82 An Duong Vuong', 'Danh Nguyen', 'thanhdanh@gmail.com', '0221545454', 'Ward 10'),
('99352', 'f5889a61ccd0', '2024-05-06', 2500.00, 'cod', 'Processing', 'Ho Chi Minh', 'Phu Nhuan', '48/42 Le Nga', 'Thanh Do', 'abc@gmail.com', '123456789', 'Ward 3');

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
(1129.00, 1, '01171', 3, 1129.00),
(1452.00, 1, '03834', 2, 1452.00),
(1452.00, 1, '04410', 2, 1452.00),
(484.00, 1, '05263', 6, 484.00),
(1459.35, 1, '05971', 1, 1459.35),
(1452.00, 1, '05971', 2, 1452.00),
(484.00, 1, '05971', 6, 484.00),
(747.00, 1, '05971', 35, 747.00),
(1129.00, 1, '07452', 3, 1129.00),
(1493.00, 1, '10244', 9, 1493.00),
(1493.00, 1, '10847', 9, 1493.00),
(1459.35, 1, '12228', 1, 1459.35),
(1048.00, 2, '12228', 5, 2096.00),
(1089.00, 1, '12228', 13, 1089.00),
(1089.00, 1, '16977', 13, 1089.00),
(1089.00, 1, '17847', 7, 1089.00),
(1129.00, 1, '17847', 10, 1129.00),
(524.00, 2, '17847', 11, 1048.00),
(201.00, 1, '17847', 12, 201.00),
(1089.00, 1, '17847', 13, 1089.00),
(605.00, 1, '17951', 8, 605.00),
(1129.00, 1, '18247', 3, 1129.00),
(524.00, 1, '18247', 11, 524.00),
(1089.00, 1, '18247', 13, 1089.00),
(747.00, 1, '18247', 35, 747.00),
(1089.00, 1, '18977', 13, 1089.00),
(1493.00, 1, '20540', 9, 1493.00),
(989.90, 1, '28190', 34, 989.90),
(747.00, 1, '28190', 35, 747.00),
(1129.00, 1, '30045', 3, 1129.00),
(1129.00, 3, '30915', 3, 3387.00),
(1169.56, 2, '30915', 4, 2339.12),
(1459.35, 1, '32893', 1, 1459.35),
(1452.00, 1, '32893', 2, 1452.00),
(1169.56, 1, '34272', 4, 1169.56),
(524.00, 1, '36261', 11, 524.00),
(1048.00, 1, '39815', 5, 1048.00),
(1048.00, 1, '41781', 5, 1048.00),
(1129.00, 2, '43033', 10, 2258.00),
(1129.00, 1, '46288', 3, 1129.00),
(1169.56, 2, '46288', 4, 2339.12),
(605.00, 2, '46288', 8, 1210.00),
(1459.35, 1, '48411', 1, 1459.35),
(1089.00, 1, '48411', 7, 1089.00),
(524.00, 1, '51306', 11, 524.00),
(1129.00, 1, '51532', 3, 1129.00),
(605.00, 1, '51532', 8, 605.00),
(1129.00, 1, '53325', 3, 1129.00),
(201.00, 1, '53325', 12, 201.00),
(1129.00, 3, '54296', 3, 3387.00),
(1048.00, 1, '54296', 5, 1048.00),
(1089.00, 1, '54296', 7, 1089.00),
(1129.00, 1, '54296', 10, 1129.00),
(201.00, 1, '54296', 12, 201.00),
(1089.00, 1, '55138', 7, 1089.00),
(524.00, 2, '55138', 11, 1048.00),
(605.00, 2, '56739', 8, 1210.00),
(201.00, 1, '56739', 12, 201.00),
(747.00, 2, '56739', 35, 1494.00),
(1169.56, 1, '59114', 4, 1169.56),
(989.90, 1, '60136', 34, 989.90),
(605.00, 1, '62529', 8, 605.00),
(1452.00, 1, '64693', 2, 1452.00),
(1129.00, 1, '64693', 3, 1129.00),
(1089.00, 1, '64693', 13, 1089.00),
(1129.00, 2, '64882', 10, 2258.00),
(1459.35, 1, '65079', 1, 1459.35),
(1452.00, 1, '65645', 2, 1452.00),
(524.00, 1, '65645', 11, 524.00),
(1089.00, 1, '68590', 7, 1089.00),
(989.90, 1, '68751', 34, 989.90),
(1089.00, 2, '70752', 7, 2178.00),
(1048.00, 1, '72850', 5, 1048.00),
(1089.00, 1, '72850', 7, 1089.00),
(524.00, 1, '72850', 11, 524.00),
(747.00, 2, '72850', 35, 1494.00),
(989.90, 1, '75004', 34, 989.90),
(484.00, 1, '85911', 6, 484.00),
(1459.35, 1, '86252', 1, 1459.35),
(1048.00, 1, '86252', 5, 1048.00),
(1129.00, 1, '86252', 10, 1129.00),
(1493.00, 1, '88695', 9, 1493.00),
(1459.35, 1, '89314', 1, 1459.35),
(201.00, 3, '89314', 12, 603.00),
(1048.00, 1, '89571', 5, 1048.00),
(747.00, 1, '89887', 35, 747.00),
(484.00, 1, '92546', 6, 484.00),
(1129.00, 1, '93975', 3, 1129.00),
(605.00, 2, '93975', 8, 1210.00),
(989.90, 1, '93975', 34, 989.90),
(484.00, 1, '93982', 6, 484.00),
(524.00, 1, '96037', 11, 524.00),
(1129.00, 1, '97594', 3, 1129.00),
(1169.56, 1, '98788', 4, 1169.56),
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
(1, 1, 'iPhone 15 Pro Max', 187, 1560.00, 'Black', './assets/products/img1.png', 'iPhone 15 Pro Max is the most advanced iPhone with the largest screen, best battery life, strongest configuration and super durable, super light aerospace-standard Titanium frame design. iPhone 15 Pro Max possesses Apple most outstanding features.', 2, 512, 8, 6.00, '2024-04-14 14:12:47', '2024-04-14 14:12:47'),
(2, 1, 'iPhone 15 Pro Max', 189, 1452.00, 'Silver', './assets/products/img2.png', 'iPhone 15 Pro Max is the most advanced iPhone with the largest screen, best battery life, strongest configuration and super durable, super light aerospace-standard Titanium frame design. iPhone 15 Pro Max possesses Apple most outstanding features.', 2, 512, 8, 6.00, '2024-04-14 14:12:47', '2024-04-14 14:12:47'),
(3, 1, 'iPhone 14 Plus', 187, 1129.00, 'Purple', './assets/products/img3.png', 'The appeal of the new generation iPhone 2022 with a large screen, the best battery ever, impressive night photography and a series of top-notch technologies, the iPhone 14 Plus brings users into advanced mobile experiences.', 2, 256, 6, 6.00, '2024-04-14 14:12:47', '2024-04-14 14:12:47'),
(4, 1, 'iPhone 14 Plus', 196, 1169.56, 'Yellow', './assets/products/img4.png', 'The appeal of the new generation iPhone 2022 with a large screen, the best battery ever, impressive night photography and a series of top-notch technologies, the iPhone 14 Plus brings users into advanced mobile experiences.', 2, 256, 6, 6.00, '2024-04-14 14:12:47', '2024-04-14 14:12:47'),
(5, 1, 'iPhone 13 Pro Max', 187, 1048.00, 'White', './assets/products/img5.png', 'iPhone 13 Pro Max has the best dual camera system ever, the fastest Apple A15 processor in the smartphone world and extremely long battery life, ready to accompany you all day long.', 2, 512, 8, 6.00, '2024-04-14 14:12:47', '2024-04-14 14:12:47'),
(6, 1, 'iPhone 12 Pro Max', 187, 484.00, 'Yellow', './assets/products/img6.png', 'In the last months of 2020, Apple officially introduced to users as well as iFans the new generation of iPhone 12 series with a series of breakthrough features, completely transformed design, powerful performance and one of That is the iPhone 12 Pro Max 1', 2, 128, 6, 6.70, '2024-04-14 14:12:47', '2024-04-14 14:12:47'),
(7, 2, 'Samsung Galaxy S24 Ultra', 189, 1089.00, 'Blue', './assets/products/img7.png', 'Samsung Galaxy S24 Ultra is the smartest Galaxy phone ever with connection power, creative power and entertainment power all powered by Galaxy AI artificial intelligence. Completely new design from the classy Titanium frame, super camera with resolution ', 2, 512, 12, 6.80, '2024-04-14 14:12:47', '2024-04-14 14:12:47'),
(8, 2, 'Samsung Galaxy S22 Ultra', 174, 605.00, 'Black', './assets/products/img8.png', 'Samsung Galaxy S24 Ultra is the smartest Galaxy phone ever with connection power, creative power and entertainment power all powered by Galaxy AI artificial intelligence. Completely new design from the classy Titanium frame, super camera with resolution ', 2, 256, 12, 6.00, '2024-04-14 14:12:47', '2024-04-14 14:12:47'),
(9, 2, 'Samsung Galaxy Z Fold5', 48, 1493.00, 'Blue', './assets/products/img9.png', 'Joining Samsung Galaxy Z Flip 5 flexibly, you will experience a series of exciting breakthrough technologies and a completely new unique design. Where you can freely explore and confidently express your personality. The compactness, fit and fashion of the', 2, 512, 12, 7.00, '2024-04-14 14:12:47', '2024-04-14 14:12:47'),
(10, 2, 'Samsung Galaxy S23 Ultra', 176, 1129.00, 'Green', './assets/products/img10.png', 'Proud to be the first Galaxy phone to possess a superb 200MP sensor, the Samsung Galaxy S23 Ultra takes users into a world of cutting-edge photography. The power is also explosive with the most powerful Snapdragon processor for revolutionary gaming ', 2, 512, 12, 6.00, '2024-04-14 14:12:47', '2024-04-14 14:12:47'),
(11, 2, 'Samsung Galaxy S23 FE', 189, 524.00, 'Purple', './assets/products/img11.png', 'The Galaxy S23 FE 5G is the best Galaxy FE device Samsung has ever launched. Equipped with premium features from design to outstanding performance, an incredible night camera system. All combine to bring the perfect experience for work and entertainment', 2, 512, 8, 6.40, '2024-04-14 14:12:47', '2024-04-14 14:12:47'),
(12, 2, 'Samsung Galaxy A14', 200, 201.00, 'Silver', './assets/products/img12.png', 'Adding color and experience to your life, Samsung introduces the cheap Galaxy A14 4G with a series of new improvements. Everything is harmoniously combined from youthful design, 50MP camera system, sharp screen to super large battery', 2, 128, 4, 6.00, '2024-04-14 14:12:47', '2024-04-14 14:12:47'),
(13, 2, 'Samsung Galaxy M54', 198, 1089.00, 'Silver', './assets/products/img13.png', 'Following the success of the Galaxy M53 5G, Samsung continues to launch the Samsung Galaxy M54 5G phone model. This launch, Samsung has upgraded performance, battery capacity and improved design to help bring the best product to you.', 1, 256, 8, 6.70, '2024-04-14 14:12:47', '2024-04-14 14:12:47'),
(34, 1, 'iPhone 15 Plus', 188, 989.90, 'Green', './assets/products/img14.png', 'iPhone 15 Plus 256GB not only stands out thanks to its 6.7-inch OLED Super Retina XDR screen but also offers impressive storage capacity with 256GB internal memory. In addition, this new generation of iPhone is also equipped', 2, 256, 6, 6.70, '2024-05-05 22:24:54', '2024-05-05 22:24:54'),
(35, 1, 'iPhone 15', 180, 747.00, 'Yellow', './assets/products/img15.png', 'iPhone 15 not only stands out thanks to its 6.1-inch OLED Super Retina XDR screen but also offers impressive storage capacity with 256GB internal memory. In addition, this new generation of iPhone is also equipped with a pair of modern rear cameras', 2, 128, 6, 6.10, '2024-05-05 22:26:45', '2024-05-05 22:26:45'),
(44, 1, 'Iphone X', 122, 852.66, 'Black', './assets/products/img17.png', 'good', 0, 128, 6, 6.40, '2024-05-11 11:21:31', '2024-05-11 11:21:31');

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
('34b8a535e37c', 'beyeu@gmail.com', 'beyeu', '$2y$10$/9Orx1/p1ajGVFjeYn8veeGXFhzW9NKt8Xfn2Ue3lLIaWvykobB5y', '237 Ly Thuong Kiet', 'District 11 ', 'Ho Chi Minh ', '0981445421', 0, 0, '2024-05-07 11:28:03', '2024-05-07 11:28:03', 'Be Yeu Dau', 'Ward 10 '),
('4ac4503d26ea', 'nguyenngocnhien@gmail.com', 'ngnhien91', '$2y$10$i0OpDgk8X99SrnmL0tYYJeV1ACdvgoE9pHG7Nuv8dX9RuEVI7Mn5O', '42 Thanh Thai', 'District 10', 'Ho Chi Minh', '0985566691', 1, 0, '2024-05-07 09:19:09', '2024-05-07 09:19:09', 'Nguyen Ngoc Nhien', 'Ward 12'),
('53091d01d890', 'thanh@gmail.com', 'dothanh1', '$2y$10$f0iEZLKTgVpN/mUPXPINCuLvI3u7M9pwkLlH/W2YIOqkChHJVi0Ei', '273 An Duong Vuong', 'District 5 ', 'Ho Chi Minh ', '0981776491', 1, 0, '2024-05-04 22:46:53', '2024-05-04 22:46:53', 'Thanh Do', 'Ward 8'),
('5d314b93c7b7', 'admin@email.com', 'admin', '$2y$10$u.LVXI1z1AY9eU2gsItc7.i0WsA2cbwxO1vJVm3OwJ4aEFqnOhIn2', '273 An Duong Vuong', 'District 5 ', 'Ho Chi Minh      ', '0981776492', 1, 1, '2024-04-14 21:21:53', '2024-04-14 21:21:53', 'Phu Thanh', 'Ward 8'),
('8016c59ca618', 'khanghuynh@gmail.com', 'dkhang', '$2y$10$CyhfKE3rKNv0ZWr6ielNC.CqHfOzCBSBiCx9bi4y2KgMCvm2TVTJW', '50 Pham Van Dong', 'Go Vap', 'Ho Chi Minh', '0981332561', 1, 0, '2024-05-07 09:13:36', '2024-05-07 09:13:36', 'Huynh Duy Khang', 'Ward 11'),
('b690eca96339', 'thanhdanh@gmail.com', 'thanhdanh1', '$2y$10$2Z/ZJOgTLGTnDjEA79uqQeu7C2.MAh/bjXQ5PveRvU7PgUCyfp0DK', '82 An Duong Vuong', 'District 10', 'Ho Chi Minh', '0221545454', 1, 0, '2024-05-06 09:16:03', '2024-05-06 09:16:03', 'Danh Nguyen', 'Ward 10'),
('f47e925465cc', 'admin1@gmail.com', 'admin12', '$2y$10$Bg.tbal3TSjIACv4HHQosOZrWVh5BzG2a73X4.8J1d2hwH9x1V8Jq', '319 Ly Thuong Kiet', 'District 11', 'Ho Chi Minh', '0165452116', 1, 1, '2024-05-06 14:34:54', '2024-05-06 14:34:54', 'Admin12', 'Ward 10'),
('f5889a61ccd0', 'abc@gmail.com', 'user123', '$2y$10$yeceLurYhwpONvWihcG6F.k07fjvzJ5WayKkEqy.qMD5NsnsRX6/K', '48/42 Le Nga', 'Tan Phu   ', 'Ho Chi Minh   ', '0981776491', 1, 0, '2024-04-14 21:16:21', '2024-04-14 21:16:21', 'Thanh Do Phu', 'Ward 10  ');

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
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=471;

--
-- AUTO_INCREMENT cho bảng `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT cho bảng `product`
--
ALTER TABLE `product`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

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
