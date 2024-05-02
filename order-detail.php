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
<br>
<br><br> 
<br>


<?php

if(isset($_GET['order']))
{

  $order_id = $_GET['order'];
  
  $stmt = $conn->prepare("SELECT * FROM `order`  WHERE order_id = ? ");
  $stmt -> bind_param("s", $order_id);
  $stmt -> execute();

  $result = $stmt -> get_result();
   if($result -> num_rows == 1){
      $row = $result->fetch_assoc();
   
?>

      <div class="container">
         <div class="row">

         <div class="text-center">
                <h5 class=" mt-1 text-success">Order Number: #<?php echo $row['order_id'] ?> </h5>
                <h6>Order Date: <?php echo $row['order_date'] ?> </h6>
                <!-- <h6>Order Status: <?php echo $row['order_status'] ?> </h6> -->
                <h6>Order total: $<?php echo $row['order_total_price'] ?> </h6>
                <h6>Payment method: <?php echo $row['method'] ?> </h6>
                <h6>Name: <?php echo $row['fullname'] ?> </h6>
                <h6>E-mail: <?php echo $row['email'] ?> </h6>
                <h6>Phone: <?php echo $row['phone_number'] ?> </h6>
                <h6>Address: <?php echo $row['street'] .", ". $row['district'] ." district, ". $row['city']  ?>  </h6>
         </div>
      </div>
      <?php  } } ?>

      </div>



<div class="container">
   <div class="row">
      <div class="title mb-2"><strong>Order-detail</strong></div>
   
      <div class="col-md-12 text-center">
      <table class="table">
  <thead>
    <tr>
      <!-- <th scope="col">#</th> -->
      <th scope="col">Image</th>
      <th scope="col">Name</th>
      <th scope="col">Price</th>
      <th scope="col">Quantity</th>
      <th scope="col">Total</th>
    </tr>
  </thead>
  <tbody>

  <?php

if(isset($_GET['order']))
{

  $order_id = $_GET['order'];
  
  $stmt = $conn->prepare("SELECT * FROM `order_detail` INNER JOIN `product` ON `product`.item_id = `order_detail`.item_id WHERE `order_detail`.order_id = ?");
  $stmt -> bind_param("s", $order_id);
  $stmt -> execute();

  $result = $stmt -> get_result();
  
  while($order = $result->fetch_object()){  
?>



    <tr>
      <!-- <th scope="row"><?php echo $order->item_id ?></th> -->
      <td> <img src="<?php echo $order->item_image ?>" style=" width: 80px;" alt=""></td>
      <td><?php echo $order->item_name ?></td>
      <td>$<?php echo $order->order_detail_price ?></td>
      <td><?php echo $order->order_detail_quantity ?></td>
      <td>$<?php echo $order->total_price ?></td>

    </tr>

   <?php }
}
   ?>
   
  </tbody>
</table>


      </div>
   </div>
</div>



























<br><br>









<?php
include("footer.php");
?>