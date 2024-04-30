<?php 

session_name('customer_session');
    session_start();
 
    
    if(isset($_SESSION['user_id'])){
        $user_id = $_SESSION['user_id'];
       
     }else{
        $user_id = '';
     };


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mobile Shopee</title>

    <!-- Bootstrap CDN -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <!-- Owl-carousel CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha256-UhQQ4fxEeABh4JrcmAJ1+16id/1dnlOEVCFOxDef9Lw=" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" integrity="sha256-kksNxjDRxd/5+jGurZUJd1sdR2v+ClrCl3svESBaJqw=" crossorigin="anonymous" />

    <!-- font awesome icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" integrity="sha256-h20CPZ0QyXlBuAw7A+KluUYx/3pK+c7lYEpqLTlxjYQ=" crossorigin="anonymous" />

    <!-- Custom CSS file -->
    <link rel="stylesheet" href="style.css">
<!-- Latest compiled and minified CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Latest compiled JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>    

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha512-tS3SF+sOSvM6ZXsHnSnjXzBsCtXTwhmJyPJUhCV7QjSpcFNvDyCIlEyHhPOnQjWrH/NlxYLbm3DwzIAEV0yQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha512-hzTunOHPWCEaOCPAJ9wSxQL8vmEyjabiPwQXdbwnBxQFr2VWvthN/xcbyyCwLwLwT0aSOOCBTk/sffaClByTqSQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>



<?php
include('functions.php');
?>
</head>
<body>

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
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav m-auto font-rubik">
    <li class="nav-item active">
        <a class="nav-link" href="#">On Sale</a>
    </li>
    <li class="nav-item">
    <div class="dropdown">
        <a class="nav-link  dropdown-toggle"  id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Products</a>
        <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
    <button class="dropdown-item" type="button">Samsung</button>
    <button class="dropdown-item" type="button">Iphone</button>
  </div>
    </div>

    </li>
   

    <li class="nav-item">
        <a class="nav-link" href="#">Order</a>
    </li>
    <div class="form-container">
    <form method="post" action="searchpage.php" class="d-flex">
        <input type="text" name="search_box" placeholder="search here..." class="form-control " id="search">
        <button class="btn btn-success" id="search_btn" name="search_btn">Search</button>
    </form>
</div>
    
</ul>

            <?php if(isset($_SESSION['username'])){
			?>
            
            <div class="dropdown ">
            <a class="px-3 mr-4 border-right border-left dropdown-toggle text-light " type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Hi <?php echo $_SESSION['username']?>
            </a>
            
            <div class="dropdown-menu drop" aria-labelledby="dropdownMenuButton">
                <a class="dropdown-item" href="profile.php">Profile</a>
                <a class="dropdown-item" href="#">Order</a>
                <a class="dropdown-item" href="logout.php" onclick="return confirm('logout from the website?');">Logout</a>
            </div>
            </div>
            <?php
			}
            else{
				echo '<a href="login.php" class="px-3 mr-4 border-right border-left text-light ">Login</a>';
				}
				?>


       
<?php
      
      $select_rows = $conn->prepare("SELECT * FROM `cart` WHERE `user_id` = ?");
      $select_rows->bind_param("s", $user_id);
      $select_rows->execute();

// Lấy kết quả và đếm số dòng trả về
$result = $select_rows->get_result();
$row_count = $result->num_rows;

      ?>

           

          
          
           
                <a href="cart.php" class="py-2 rounded-pill color-primary-bg  text-decoration-none mr-2 ">
                    <span class="font-size-16 px-2 text-white"><i class="fas fa-shopping-cart"></i></span>
                    <span id="cart-count"  class="px-3 py-2 rounded-pill text-dark bg-light"><span><?= $row_count; ?></span></span>
                </a>
                

            
        </div>
    </nav>
    <!-- !Primary Navigation -->

</header>
<!-- !start #header -->

<!-- start #main-site -->
<main id="main-site">
                <div id="message"></div>