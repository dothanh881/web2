<?php

session_name('customer_session');
session_start();


if (isset($_SESSION['user_id']) && isset($_SESSION['status_user'])){
    $user_id = $_SESSION['user_id'];
    $status = $_SESSION['status_user'];

    if($status === 0){
        echo '<script>console.log("Account status is 0. Displaying alert message...");</script>';
        echo '<script>alert("Your account have been blocked for unusual behavior!!");</script>';
        $user_id = '';
        

    }

} else {
    $user_id = '';
}
;



?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mobile Shopee</title>

    <!-- Bootstrap CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <!-- Owl-carousel CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"
        integrity="sha256-UhQQ4fxEeABh4JrcmAJ1+16id/1dnlOEVCFOxDef9Lw=" crossorigin="anonymous" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css"
        integrity="sha256-kksNxjDRxd/5+jGurZUJd1sdR2v+ClrCl3svESBaJqw=" crossorigin="anonymous" />

    <!-- font awesome icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css"
        integrity="sha256-h20CPZ0QyXlBuAw7A+KluUYx/3pK+c7lYEpqLTlxjYQ=" crossorigin="anonymous" />

    <!-- Custom CSS file -->
    <link rel="stylesheet" href="style.css">
    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Latest compiled JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"
        integrity="sha512-tS3SF+sOSvM6ZXsHnSnjXzBsCtXTwhmJyPJUhCV7QjSpcFNvDyCIlEyHhPOnQjWrH/NlxYLbm3DwzIAEV0yQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"
        integrity="sha512-hzTunOHPWCEaOCPAJ9wSxQL8vmEyjabiPwQXdbwnBxQFr2VWvthN/xcbyyCwLwLwT0aSOOCBTk/sffaClByTqSQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <style>
        #message {
            position: fixed;
            /* Thiết lập vị trí cố định */
            top: 50px;
            /* Đặt khoảng cách từ đỉnh trang đến message, ví dụ như header có chiều cao là 60px */
            left: 0;
            /* Đặt vị trí từ bên trái */

            border-radius: 0;
            /* Không có góc bo tròn */
            width: 100%;
            z-index: 999;
            /* Đảm bảo phần tử này hiển thị trên tất cả các phần tử khác */

        }

        #header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 999;
            /* Đảm bảo message hiển thị trên header */

        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            /* Xác định số lượng cột và kích thước */
            grid-auto-rows: auto;
            /* Xác định chiều cao mặc định của mỗi hàng */
            gap: 20px;
            /* Khoảng cách giữa các grid item */
        }


        .color-second {
            color: #269493;
        }

        .color-second-bg {
            background: #269493;
        }

        .color-third-bg {
            background: #269492;
        }

        #popup {
            position: fixed;
            /* Vị trí tương đối với viewport */
            top: 15%;
            /* Canh giữa theo chiều dọc */
            left: 55%;
            /* Canh giữa theo chiều ngang */
            transform: translate(-50%, -50%);
            /* Điều chỉnh vị trí dựa trên kích thước nội dung */
            display: none;
            /* Ban đầu ẩn */
            background-color: #269492;
            /* Màu nền */
            padding: 20px;
            /* Khoảng cách xung quanh nội dung */
            border: 1px solid #ccc;
            /* Viền */
            z-index: 100;
            /* Đảm bảo nó hiển thị trên các phần tử khác */
            border-radius: 10px;
        }

        .popup-content {
            max-width: 600px;
            /* Giới hạn chiều rộng */
            margin: 0 auto;
            /* Canh giữa theo chiều ngang */
        }

        .close {
            position: absolute;
            top: 7px;
            right: 10px;
            cursor: pointer;
            font-size: 20px;
            font-weight: bold;
        }

        .close:hover {
            color: white;
        }
    </style>

    <?php
    include ('functions.php');
    ?>
</head>

<body>
    <div id="message"></div>

    <!-- start #header -->
    <header id="header">
        <div class="strip d-flex justify-content-between px-4  bg-light">
            <p class="font-rale font-size-12 text-black-50 m-0"></p>
            <div class="font-rale font-size-14 ml-auto">

            </div>
        </div>

        <!-- Primary Navigation -->
        <nav class="navbar navbar-expand-lg navbar-dark color-second-bg">
            <a class="navbar-brand ml-2" href="index.php"> Mobile Shopee</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav m-auto font-rubik">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">On Sale</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a type="button" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false" href="searchpage.php?">Products</a>
                        <div class="dropdown-menu">
                            <?php
                            $brand = $conn->prepare("SELECT category_name FROM `product`,`category` WHERE product.category_id = category.category_id group by category_name");
                            $brand->execute();
                            $result_brand = $brand->get_result();
                            while ($brand_item = $result_brand->fetch_assoc()) {
                                ?>
                                <a class="dropdown-item"
                                    href="category.php?sCate=<?php echo $brand_item['category_name'] ?>"><?php echo $brand_item['category_name'] ?></a>
                            <?php } ?>
                        </div>
                    </li>



                    <div class="form-container ml-3">
                        <form method="post" action="searchpage.php" class="d-flex" onsubmit="return check();" >
                            <input type="text" name="search_box" placeholder="search here..." class="form-control " id="search">
                            <button type="submit" class="btn btn-success" id="search_btn" name="search_btn" >Search</button>
                            <div id="popup" class="hidden">
                                <div class="popup-content">
                                    <span class="close">&times;</span>
                                    <p>Enter name's product to search </p>
                                </div>
                            </div>
                        </form>
                    </div>

                </ul>

                <?php if (isset($_SESSION['username'])) {
                    ?>

                    <div class="dropdown ">
                        <a class="px-3 mr-4 border-right border-left dropdown-toggle text-light " type="button"
                            id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Hi <?php echo $_SESSION['username'] ?>
                        </a>

                        <div class="dropdown-menu drop" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="profile.php">Profile</a>
                            <a class="dropdown-item" href="order.php">Order</a>
                            <a class="dropdown-item" href="logout.php"
                                onclick="return confirm('logout from the website?');">Logout</a>
                        </div>
                    </div>
                    <?php
                } else {
                    echo '<a href="login.php" class="px-3 mr-4 border-right border-left text-light ">Login</a>';
                }
                ?>










                <a href="cart.php" class="py-2 rounded-pill color-primary-bg  text-decoration-none mr-2 ">
                    <span class="font-size-16 px-2 text-white"><i class="fas fa-shopping-cart"></i></span>
                    <span id="cart-item" class="px-3 py-2 rounded-pill text-dark bg-light"><span></span></span>
                </a>



            </div>
        </nav>
        <!-- !Primary Navigation -->

    </header>
    <!-- !start #header -->
    <script>
        const openPopupButton = document.getElementById('openPopupButton');
        const popup = document.getElementById('popup');
        const closeButton = document.querySelector('.close');
        const search = document.getElementById('search');
        function check() {

            if (search.value == '') {
                popup.style.display = 'block';
                
                return false;
            }
        }
        closeButton.addEventListener('click', () => {
            popup.style.display = 'none';
        });
    </script>
    <!-- start #main-site -->
    <main id="main-site">