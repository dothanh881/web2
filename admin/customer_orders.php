<?php
session_name('admin_session');
session_start();


?>
<?php include_once("./templates/top.php"); ?>
<?php include_once("./templates/navbar.php"); 
    include("./../functions.php");

?>

<div class="container-fluid">
  <div class="row">
    
    <?php include "./templates/sidebar.php"; ?>

      <div class="row">
      	<div class="col-10">
      		<h2>Order Management</h2>
      	</div>
      </div>
      
      <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
			<th scope="col">Order #</th>
      <th scope="col">Order Status</th>
      <th scope="col">Customer</th>
      <th scope="col">Created On</th>
      <th scope="col">Order Total</th>
      <th scope="col">View</th>
            </tr>
          </thead>
          <tbody id="customer_order_list">
           
		  <?php
   $stmt = $conn ->prepare("SELECT * FROM `order` ");
	$stmt -> execute();
   $result = $stmt ->get_result();

   while($order = $result->fetch_object()){
   ?>

	
<tr>
      <th scope="row">#<?php echo $order->order_id ?></th>
      <td><?php echo $order->order_status ?></td>
      <td><?php echo $order->fullname ?> 
		<br>
		<?php  echo $order->email ?>
	</td>
      <td><?php echo $order->order_date ?></td>
      <td>$<?php echo $order->order_total_price ?></td>
      <td>
	  <a href="edit_order.php?order=<?=$order->order_id ?>" class="btn btn-primary">
    <i class="far fa-eye"></i> View
</a>
    </tr>

    <?php } ?>





          </tbody>
        </table>
      </div>
    </main>
  </div>
</div>





<?php include_once("./templates/footer.php"); ?>



<script type="text/javascript" src="./js/customers.js"></script>