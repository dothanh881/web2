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

  





?>


<?php
// Get db for each product to edit
   if(isset($_GET['userId'])){

    $user_id = $_GET['userId'];

   
 $sql = "SELECT * FROM `order` 

 WHERE `order`.user_id  = ?";

    $select = $conn->prepare($sql);
    
    $select -> bind_param("s", $user_id);
   
    $select->execute();
 
    $result = $select->get_result();

 
    if($result ->num_rows  > 0 ){
      while($orders = $result->fetch_object()){
    
   

        
  // \getdb
?>

<form method="post" >

<div class="form-group">
      <input type="text" class="form-control" name="order_id" value="<?php echo $orders-> user_id  ?>" hidden>
    </div>
    
<div class="row">


            <div class="col-md-6">
             
              <div class="text">
                  <h6>Order: #<?php echo $orders-> order_id ?></h6>
                  <h6>Create On: <?php echo $orders-> order_date ?></h6>   
                  <h6>Customer: <?php echo $orders->email ?></h6>
                  <h6>Payment method: <?php echo $orders->method ?></h6>
                  <h6>Order status: <strong class="mr-3"><?php echo $orders->order_status ?></strong>  
              

                </h6>

                  
                 
 
              </div>
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
                <h6>Address: <?php echo $orders->street . ", " . $orders->ward . ", " .$orders->district. ", " . $orders->city. "." ?></h6>
              </div>
            </div>
        </div>
<br>
<br>
       

   


          
           

       
  </form>

  <?php }
  }else{
    echo '<p class="empty">no success</p>';
  }
}

  ?>
    </div>

  </div>
</div>


<?php include_once("./templates/footer.php"); ?>
