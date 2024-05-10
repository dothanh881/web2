

<?php 
include('header.php');
?>
<?php 

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
 }else{
    $user_id = '';

    header('location:login.php');   
 }; 



 










?>

<style>
 .section {
        overflow-x: hidden;
    }

	
</style>

<br><br><br>
			<!-- container -->
			<div class="container">
				<!-- row -->
				<!-- Order Details -->
	
                <?php 
                if(isset($_GET['order'])){
                    $orderid = $_GET['order'];

                    $stmt = $conn -> prepare("SELECT * FROM `order` WHERE user_id = ? AND  order_id = ?");
                    $stmt -> bind_param("ss", $user_id, $orderid);
                    $stmt -> execute();

                    $res = $stmt -> get_result();
                    if( $res -> num_rows == 1){
                        $row = $res -> fetch_assoc();
                        
                    }
                }
                ?>
<div class="section">
    <div class="container">
        <?php if(isset($row)): ?>
            <div class="row" id="order">
                <div class="text-center">
                    <h1 class="display-4 mt-2 text-danger">Thank You!</h1>
                    <h2 class="text-success">Your Order Placed Successfully!</h2>
                    <h4>Order Number: <?php echo $row['order_id'] ?></h4>
                    <a href="order-detail.php?order<?php echo $row['order_id'] ?>">Click here for order details</a>
                </div>
            </div>
        <?php  ?>
            
        <?php endif; ?>
    </div>
</div>


<?php 
include('footer.php');
?>