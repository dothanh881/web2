<?php 
session_name('admin_session');

session_start(); ?>

<?php include_once("./templates/top.php"); ?>
<?php include_once("./templates/navbar.php"); ?>



<div class="container-fluid">
  <div class="row">
    
    <?php include "./templates/sidebar.php";
          include "./../functions.php";
    ?>
   <div class="container p-5">

<h4>Edit Order Detail</h4>


<hr>
<?php

  if(isset($_GET['order'])){
    $order_id = $_GET['order'];
    
    if(isset($_POST['update-status'])){

      $order_status = $_POST['order_status'];
  
      $stmt =  $conn-> prepare("UPDATE `order` SET order_status = ? WHERE order_id = ?");
      $stmt -> bind_param("ss", $order_status, $order_id);
      $stmt -> execute();

      echo '<div class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <strong>Update successfully!</strong> 
    </div>';
  
  
    }
   
  }
  else{
     echo '<div class="alert alert-danger alert-dismissible">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <strong>Unsuccessfully!</strong> 
    </div>';
    
  }






?>


<?php
// Get db for each product to edit
   if(isset($_GET['order'])){

    $order_id = $_GET['order'];

   
 $sql = "SELECT * FROM `order_detail` 
 INNER JOIN  `product` ON `order_detail`.item_id = `product`.item_id 
 INNER JOIN  `order` ON `order_detail`.order_id = `order`.order_id 
 WHERE `order_detail`. order_id = ?";

    $select = $conn->prepare($sql);
    
    $select -> bind_param("s", $order_id);
   
    $select->execute();
 
    $result = $select->get_result();

 
    if($result ->num_rows  > 0 ){
      $orders = $result->fetch_object();
    
   

        
  // \getdb
?>

<form method="post" >

<div class="form-group">
      <input type="text" class="form-control" name="order_id" value="<?php echo $orders-> order_id  ?>" hidden>
    </div>
    
<div class="row">


            <div class="col-md-6">
             
              <div class="text">
                  <h6>Order: #<?php echo $orders-> order_id ?></h6>
                  <h6>Create On: <?php echo $orders-> order_date ?></h6>   
                  <h6>Customer: <?php echo $orders->email ?></h6>
                  <h6>Payment method: <?php echo $orders->method ?></h6>
                  <h6>Order status: <strong class="mr-3"><?php echo $orders->order_status ?></strong>  
                  
                  <!-- <button  onclick=" return confirm('Are you sure you want to cancel order?');" class="btn btn-danger text-white ml-2">Cancel order</button> -->
                  <button id="change-status" class="btn btn-info text-white">Change status</button>

                </h6>

                  
                 
 
              </div>
            </div>

</div>

        <div class="row">
          <div class="col-md-4 show-change" id="show-change" style="margin-left: 185px;">
            <div class="form-group">
              <select name="order_status" class="form-control">
                <option value="<?=$orders->order_status ?>" selected> <?php echo $orders->order_status ?></option>
                <option value="Pending">Pending</option>
                <option value="Processing">Processing</option>
                <option value="Complete">Complete</option>
                <option value="Cancelled">Cancelled</option>
              </select>
            </div>
            <button name="update-status" type="submit"  class="btn btn-primary">Save</button>
            <button class="btn btn-secondary">Cancel</button>
          </div>
        </div>
          
        <br><br>
        <h5><i class="fas fa-info"></i> Info</h5>
        <hr>
        <div class="row">

            <div class="col-md-8">
              <div class="text">
               
                <h6>Order total: $<?php echo $orders->order_total_price ?></h6>
                <h6>Name: <?php echo $orders->fullname ?></h6>
                <h6>Phone: <?php echo $orders->phone_number ?></h6>
                <h6>Address: <?php echo $orders->street . ", " . $orders->district . ", " . $orders->city. "." ?></h6>
              </div>
            </div>
        </div>
<br>
<br>
        <h5><i class="fas fa-th-list"></i> Products</h5>

        <div class="container">
   <div class="row">
   
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
  
  $stmt = $conn->prepare("SELECT * FROM `order_detail` INNER JOIN `product` ON `product`.item_id = `order_detail`.item_id 
                                               
  
   WHERE `order_detail`.order_id = ?");
  $stmt -> bind_param("s", $order_id);
  $stmt -> execute();

  $result = $stmt -> get_result();
  
  while($order = $result->fetch_object()){  
?>



    <tr>
      <!-- <th scope="row"><?php echo $order->item_id ?></th> -->
      <td> <img src="./../<?php echo $order->item_image ?>" style=" width: 80px;" alt=""></td>
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



          
           

       
  </form>

  <?php }
  }else{
    echo '<p class="empty">no success</p>';
  }

  ?>
    </div>

  </div>
</div>


<?php include_once("./templates/footer.php"); ?>
<script>
    document.addEventListener("DOMContentLoaded", function(e) {
        // Chọn radio buttons
        var btnChange = document.getElementById("change-status");

       
        var showChange = document.querySelector(".show-change");
        // Ẩn phần shipping-details ban đầu
        showChange.style.display = "none";

        // Bắt sự kiện click trên radio buttons
        btnChange.addEventListener("click", function(e) {
			e.preventDefault(); 
            showChange.style.display = "block"; 
			btnChange.style.display = 'none';

        });

      
    });
</script>