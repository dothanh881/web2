<?php 

// Kiểm tra xem phần tử 'username' có tồn tại trong mảng $_SESSION hay không
if ( isset($_SESSION["user_id"]) ) {
  $admin = $_SESSION['admin'];
} else {
  // Xử lý trường hợp không tồn tại 'username' trong $_SESSION
   header('location:login_admin.php');
}
?>
<nav class="col-md-2 d-none d-md-block bg-light sidebar">
      <div class="sidebar-sticky">
        <ul class="nav flex-column">

          <?php 


            $uri = $_SERVER['REQUEST_URI']; 
            $uriAr = explode("/", $uri);
            $page = end($uriAr);

          ?>

<li class="nav-item">
            <a class="nav-link <?php echo ($page == '' || $page == 'index_admin.php') ? 'active' : ''; ?>" href="index_admin.php">
            <i class="fa fa-user" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;<span data-feather="users"></span>
              Admin  <span class="sr-only">(current)</span>
            </a>
          </li>

<li class="nav-item">



            <a class="nav-link <?php echo ($page == 'dashboard.php') ? 'active' : ''; ?>" href="dashboard.php">
            <i class="fa fa-home" aria-hidden="true"></i>
 &nbsp;&nbsp; <span data-feather="home"></span>

              DashBoard
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link <?php echo ($page == 'customers.php') ? 'active' : ''; ?>" href="customers.php">
            <i class="fa fa-users" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp; <span data-feather="users"></span>
              Customers
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?php echo ($page == 'products.php') ? 'active' : ''; ?>" href="products.php">
            <i class="fa fa-archive" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp; <span data-feather="shopping-cart"></span>
              Products
            </a>
          </li>
        
          <li class="nav-item">
            <a class="nav-link <?php echo ($page == 'customer_orders.php') ? 'active' : ''; ?>" href="customer_orders.php">
            <i class="fa fa-th-list" aria-hidden="true"></i>&nbsp;&nbsp;&nbsp;&nbsp;<span data-feather="clipboard"></span>
              Orders
            </a>
          </li>
       
        
          <li class="nav-item">
            <a class="nav-link <?php echo ($page == 'categories.php') ? 'active' : ''; ?>" href="categories.php">
            <i class="fa fa-bars"></i>&nbsp;&nbsp;&nbsp;&nbsp; <span data-feather="layers"></span>
              Categories
            </a>
          </li>
          
        
          
        </ul>

       
      </div>
    </nav>


    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
       
        <div class="btn-toolbar mb-2 mb-md-0">

        </div>
      </div>