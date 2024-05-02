
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
<div class="container ">
			
         <div class="row">
    
       

          <div class="col-md-6 col-lg-4 form-group date-check">
            <label for="datefrom">From</label>
            <input type="date" id="datefrom" name="datefrom" class="form-control">
          </div>
      
          <div class="col-md-6 col-lg-4 form-group date-check">
            <label for="dateto">To</label>
            <input type="date" id="dateto" name="dateto" class="form-control">
          </div>
         </div>

      <div class="row">

        <div class=" col-md-6 col-lg-3 search-p ">
          <div id="DataTables_Table_0_filter" class="dataTables_filter">
            <label><input type="search" id="myInput" onkeyup="myFunction()" class="form-control" placeholder="Order Number" aria-controls="DataTables_Table_0">
            </label>
        </div>
          <div class="search-btnn ">
            <button class="dt-button add-new btn btn-primary" type="button"><span><span class="d-none d-sm-inline-block">Search</span></span></button>

          </div>
        </div>

      
       
      </div>
      <br>
    

<div class="container">
   <div class="row">
      <div class="title">My Order</div>
      <div class="col-md-10 text-center">
      <table class="table">
  <thead>
    <tr>
      <th scope="col">Order Number</th>
      <th scope="col">Order Status</th>
      <th scope="col">Order Date</th>
      <th scope="col">Order Total</th>
      <th scope="col">Order Detail</th>
    </tr>
  </thead>
  <tbody>
<?php
   $stmt = $conn ->prepare("SELECT * FROM `order` WHERE user_id = ?");
   $stmt -> bind_param("s", $user_id);
   $stmt -> execute();
   $result = $stmt ->get_result();

   while($order = $result->fetch_object()){
   ?>


    <tr>
      <th scope="row">#<?php echo $order->order_id ?></th>
      <td><?php echo $order->order_status ?></td>
      <td><?php echo $order->order_date ?></td>
      <td><?php echo $order->order_total_price ?></td>
      <td><a href="order-detail.php">Details</a></td>

    </tr>
   
  </tbody>
</table>
<?php } ?>

      </div>
   </div>
</div>





<br><br>









<?php
include("footer.php");
?>