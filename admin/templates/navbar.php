<style>

.bgpink{
  background: #D96666;
}

.btns{
	background: #f29999;
}
</style>


<?php
// Kiểm tra xem phần tử 'username' có tồn tại trong mảng $_SESSION hay không
if ( isset($_SESSION["user_id"]) ) {
	$admin = $_SESSION['admin'];
	$user_id = $_SESSION['user_id'];
  } 

?>

<nav class="navbar navbar-dark fixed-top bgpink flex-md-nowrap p-0 shadow">
  <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">Mobile Shopee </a>


   
    	<?php
    		if (isset($_SESSION['user_id'])) {
    			?>
 						<div class="dropdown">

                        <a class="px-3 ml-3 mr-5 border-right border-left dropdown-toggle text-light " type="button"
                            id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Hi <?php echo $admin  ?> 
                        </a>

                        <div class="dropdown-menu drop" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="profile.php">Profile</a>
                            <a class="dropdown-item" href="../admin/admin-logout.php"
                                onclick="return confirm('logout from the website?');">Logout</a>
                        </div>
                    </div>
    				
    			<?php
    		}else{
    			$uriAr = explode("/", $_SERVER['REQUEST_URI']);
    			$page = end($uriAr);
    			if ($page === "login.php") {
    				?>
	    				<a class="nav-link  navbar-brand " href="../admin/register.php">Register</a>
	    			<?php
    			}else{
    				?>
	    				<a class="nav-link   navbar-brand" href=" login.php">Login</a>
	    			<?php
    			}


    			
    		}

    	?>
      
    
  
</nav>