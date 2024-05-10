






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


<br>
<br>
<br>
<br>
<br>

<?php

$grand_total = 0;
$allItems = '';
$items = array();
$sum = array();

$sql = "SELECT CONCAT(name, ' x(',cart_quantity,')') AS ItemQty, cart_price, cart_quantity FROM `cart` WHERE user_id = ?";

$stmt = $conn -> prepare($sql);
$stmt -> bind_param("s" , $user_id);
$stmt -> execute();
$result = $stmt-> get_result();
while ($row = $result -> fetch_assoc()){
   $grand_total += ($row['cart_price'] * $row['cart_quantity']);
	$sum[] = ($row['cart_price'] * $row['cart_quantity']);
   $items[] = $row['ItemQty'];
}

	
	$allItems = implode(", " , $items);

?>

<?php
 include("code-generator.php");
?>


<div class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<!-- Order Details -->
	
				
<div class="row "  >
	<div class="col-md-6 " >
	<div class="order-details border border-secondary " >

						
							<br>

					

							<form action="" method="post" id="placeOrder" onsubmit="return validateForm();">
							
							<input type="hidden" name="grand_total" value="<?= $grand_total ?>">
		<input type="hidden" name="order_id" value="<?= $orderid ?>">
		<input type="hidden" name="allItems" value="<?= $allItems ?>">
		<div class="section-title text-center">

							<h3 class="title">Your Order</h3>
						</div>
						<div class="order-summary">
						<div class="order col">
						<div><strong>Product</strong></div>
								

					<div class="row">
								
							<div class="col-6 text-left">
								<p>
								<?php 
							 foreach($items as $item){
								echo "<div>" . $item . "</div>";
							 }
							
							?>
								</p>
							</div>
							
						
							<div class="col-6 text-right">
								<p>
								<?php
								 foreach($sum as $su){
									echo  "<div> $su$</div>";
								}
								?>
							</p>
							</div>
							
							
								
					</div>
								
								<div class="row">
									<div class="col-6">
									<div><strong>Total:</strong>

									</div>
									</div>
									<div class="col-6 text-right">
								<strong><?php 
							 echo "<p> $grand_total$</p>";
							?></strong>
									</div>
								
							
								</div>


						

						<div class="input-checkbox">
						<div><strong>Delivery Address</strong></div>

							<input type="radio" name="address" id="available-address-radio" value="available-address" >
                            <label for="available-address-radio">
									<span></span>
									Deliver to available address.
							</label>
						</div>
                        <div class="input-checkbox">
							<input type="radio" name="address" id="new-address-radio" value="new-address" >
                           
                            
                            <label for="new-address-radio">
									<span></span>
									Deliver to new address.
								</label>
						</div>
						<div class="payment-method">
								<div><strong>Choose Payment Method:</strong></div>
<!-- 

								<div class="form-group">
									<select name="method" class="form-contrl">
										<option value="" selected disabled>-Select Payment Method-</option>
										<option value="cod">Cash on Delivery</option>
										<option value="onlinebanking">Online Banking</option>



									</select>
								</div> -->

							<div class="input-radio">
								<input type="radio" name="payment" id="payment-1" value="cod">
							
								<label for="payment-1">
									<span></span>
									Cash On Delivery
								</label>
								
							</div>
							<div class="input-radio">
								<input type="radio" name="payment" id="payment-2"value="onlinebanking" >

								<label for="payment-2">
									<span></span>
									Online Banking
								</label>
							</div>
						</div>

						<br>

						<input data-toggle="modal" data-target="#mi-modal"  type="button" name="checkout"  id="btn-checkout" class="btn btn-primary" value="Order Place">
						<a href="cart.php" class="btn btn-secondary">Back</a>
<br><br>


						</div>
						
	</div>
		

	</div>
	</div>

						<div class="col-md-6">

<!-- Shiping Details -->
<div class="shiping-details ">
							<div class="section-title">
								<h3 class="title1">New Address</h3>
							</div>
						
							
							<div class="row">
							<div class="col-md-6">
								<label for="newFullname">Name</label>
								<input type="text" id="newFullname" name="newFullname" class="form-control" >
							</div>
							<div class="col-md-6">
								<label for="newEmail">Email</label>
								<input type="email" id="newEmail" name="newEmail"class="form-control" >
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<label for="newPhone">Phone</label>
								<input type="text" id="newPhone" name="newPhone"class="form-control" >
							</div>
						</div>

								<div class="caption">
                                <div class="row">
							<div class="col-md-6">
								<label for="newStreet">Street</label>
								<input type="text" id="newStreet" name="newStreet"class="form-control" >
							</div>
							<div class="col-md-6">
								<label for="new_Ward">Ward</label>
								<select id="newWard" name="new_Ward" class="form-control" >
                                    <option value="">Select Ward</option>
									<option value="Ward 1">Ward 1</option>
									<option value="Ward 2">Ward 2</option>
									<option value="Ward 3">Ward 3</option>
									<option value="Ward 4">Ward 4</option>
									<option value="Ward 5">Ward 5</option>
									<option value="Ward 6">Ward 6</option>
									<option value="Ward 7">Ward 7</option>
									<option value="Ward 8">Ward 8</option>
									<option value="Ward 9">Ward 9</option>
									<option value="Ward 10">Ward 10</option>
									<option value="Ward 11">Ward 11</option>
									<option value="Ward 12">Ward 12</option>
                                    
                                    <!-- Add more options as needed -->
                                </select>							</div>
						</div>
						<div class="row">
							
						<div class="col-md-6">
                                <label for="newCity">City</label>
                                <select id="newCity" name="newCity" class="form-control" >
                                    <option value="">Select City</option>
                                    <option value="Ho Chi Minh">Ho Chi Minh</option>
                                    
                                    <!-- Add more options as needed -->
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="newDistrict">District</label>
                                <select id="newDistrict" name="newDistrict" class="form-control" >
                                    <option value="">Select District</option>
									<option value="District 1">District 1</option>
                                    <option value="District 2">District 2</option>
                                    <option value="District 3">District 3</option>
                                    <option value="District 4">District 4</option>
                                    <option value="District 5">District 5</option>
                                    <option value="District 6">District 6</option>
                                    <option value="District 7">District 7</option>
                                    <option value="District 8">District 8</option>
                                    <option value="District 9">District 9</option>
                                    <option value="District 10">District 10</option>
                                    <option value="District 11">District 11</option>
                                    <option value="District 12">District 12</option>
                                    <option value="Tan Binh">Tan Binh </option>
                                    <option value="Binh Tan">Binh Tan </option>
                                    <option value="Tan Phu">Tan Phu</option>
                                    <option value="Go Vap">Go Vap</option>
                                    <option value="Phu Nhuan">Phu Nhuan</option>
                                    <option value="Binh Chanh">Binh Chanh</option>
                                  
                                    <!-- Add more options as needed -->
                                </select>
                            </div>
						</div>
							
							</div>
						</div>



						<?php 
$customer_id = $_SESSION['user_id'];
$sql = "SELECT * FROM `user` WHERE `user_id` = ? AND is_admin = 0 ";

$select = $conn->prepare($sql);

$select->bind_param("s", $customer_id);

$select->execute();

$result = $select->get_result();


if ($result->num_rows == 1) {
  $row1 = $result->fetch_assoc();
  



?>

						
				<!-- Shiping Details Available -->
				<div class="shiping-details-available"
				data-user-id="<?php echo $row1['user_id']; ?>"
    data-fullname="<?php echo $row1['fullname']; ?>"
    data-email="<?php echo $row1['email']; ?>"
    data-phone="<?php echo $row1['phone_number']; ?>"
    data-street="<?php echo $row1['street']; ?>"
    data-ward="<?php echo $row1['ward']; ?>"
    data-city="<?php echo $row1['city']; ?>"
    data-district="<?php echo $row1['district']; ?>"
				
				
				>
							<div class="section-title">
								<h3 class="title1">Your Address</h3>
							</div>

							<div class="form-group">
      						<input type="text" class="form-control" name="user_id" value="<?php echo $row1['user_id'] ?>" hidden>
   							 </div>
						
							<div class="row">
							<div class="col-md-6">
								<label for="name">Name</label>
								<input type="text" id="name" name="fullname" class="form-control" value="<?php echo $row1['fullname'] ?>" required>
							</div>
							<div class="col-md-6">
								<label for="email">Email</label>
								<input type="email" id="email" name="email"class="form-control" value="<?php echo $row1['email'] ?>" required>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<label for="phone">Phone</label>
								<input type="text" id="phone" name="phone"class="form-control"  value="<?php echo $row1['phone_number'] ?>" required>
							</div>
						</div>

								<div class="caption">
                                <div class="row">
							<div class="col-md-6">
								<label for="street">Street</label>
								<input type="text" id="street" name="street"class="form-control"  value="<?php echo $row1['street'] ?>" required>
							</div>
							<div class="col-md-6">
								<label for="ward">Ward</label>
								<input type="text" id="ward" name="ward"class="form-control"  value="<?php echo $row1['ward'] ?>" required>
							</div>
						</div>
						<div class="row">
							
						<div class="col-md-6">
                                <label for="city">City</label>
                               <input type="text" id="city" name="city" class="form-control"  value="<?php echo $row1['city'] ?>">
                            </div>
                            <div class="col-md-6">
                                <label for="district">District</label>
								<input type="text" name="district" id="district" class="form-control"  value="<?php echo $row1['district'] ?>">
                            </div>
						</div>
							
							</div>
						</div>

                
				<?php }else{

echo '<p class="empty">no product user!</p>';

				}?>
				

 			
		

						</div>
						
			




		
			
				
				

			














	
	
						</div>
	
						<div class="modal  " id="mi-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
         <div class="modal-dialog">
            <div class="modal-content">
               <!-- Modal Header -->
               <div class="modal-header">
                  <h4 class="modal-title">Modal Heading</h4>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
               </div>
               <!-- Modal body -->
            <div class="modal-body">
                 
			   <div class="section-title text-center">

						<h3 class="title">Your Order</h3>
						</div>
						<div class="order-summary">
						<div class="order col">
							
							<div><strong>Product</strong></div>


								
							
							

						<div class="row">
							
						<div class="col-6 text-left">
							<p>
							<?php 
						foreach($items as $item){
							echo "<div>" . $item . "</div>";
						}

						?>
							</p>
						</div>


						<div class="col-6 text-right">
							<p>
							<?php
							foreach($sum as $su){
								echo  "<div> $su$</div>";
							}
							?>
						</p>
						</div>


							
						</div>
						<hr>
							
							<div class="row">
								<div class="col-6">
								<div><strong>Total:</strong>

								</div>
								</div>
								<div class="col-6 text-right">
							<strong><?php 
						echo "<p> $grand_total$</p>";
						?></strong>
								</div>
							

							</div>
							<hr>

							<h5><i class="fas fa-info"></i> Info</h5>
							<br>

							<div id="info-checkout">
								
							</div>
							<div id="info-payment">

							</div>
						<br><br>

										
									</div>
										
									
									
								
							
							</div>

               </div>
               <!-- Modal footer -->
               <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="modal-btn-no" data-dismiss="modal" >Cancel</button>
     
		
		
							
						
		<button type="submit" id="modal-btn-si" name="submit"class="btn btn-primary" >Confirm </button>
		
	
	
	


			
	</form>	
	  
      </div>

            </div>
         </div>
      </div>

  
	
   


	

				


     
	
			<!-- /container -->
		</div>
	
		
						
						
				</div>
<br>
<br>
<br>
<?php 
include('footer.php');
?>
<script>


</script>