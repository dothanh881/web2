<?php
require('functions.php');

session_name('customer_session');
session_start();
unset($_SESSION['cart']); // Xóa thông tin giỏ hàng
 // Xóa thông tin đăng nhập của người dùng
unset($_SESSION['user_id']);
session_destroy();

header('location: index.php');
?>