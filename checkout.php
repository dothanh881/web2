






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

$sql = "SELECT CONCAT(name, ' x',cart_quantity,'') AS ItemQty, cart_price, cart_quantity FROM `cart` WHERE user_id = ?";

$stmt = $conn -> prepare($sql);
$stmt -> bind_param("s" , $user_id);
$stmt -> execute();
$result = $stmt-> get_result();
while ($row = $result -> fetch_assoc()){
   $grand_total += ($row['cart_price'] * $row['cart_quantity']);
	$sum[] = ($row['cart_price'] * $row['cart_quantity']);
   $items[] = $row['ItemQty'];
}

	
	$allItems = implode("<br> " , $items);

?>

<?php
 include("code-generator.php");
?>


<div class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				<!-- Order Details -->
	
	

<div class="row " id="order">
	<div class="col-md-6 " >
	<div class="order-details border border-secondary " >

						
							<br>

					


		<form action="" method="post" id="placeOrder">

		<input type="hidden" name="grand_total" value="<?= $grand_total ?>">
		<input type="hidden" name="order_id" value="<?= $orderid ?>">
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
									echo  "<div>" .  $su . "</div>";
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
							 echo $grand_total;
							?></strong>
									</div>
								
							
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
								<input type="radio" name="payment" id="payment-1" value="COD">
							
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


						<div class="input-checkbox">
						<div><strong>Delivery Address</strong></div>

							<input type="radio" name="address" id="available-address-radio" >
                            <label for="shiping-address">
									<span></span>
									Deliver to available address.
							</label>
						</div>
                        <div class="input-checkbox">
							<input type="radio" name="address" id="new-address-radio" >
                           
                            
                            <label for="shiping-address">
									<span></span>
									Deliver to new address.
								</label>
						</div>
                     
						<br>

						<input type="submit" name="submit" class="btn btn-primary" value="Order Place">
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
								<label for="name">Name</label>
								<input type="text" id="name" name="newFullname" class="form-control" >
							</div>
							<div class="col-md-6">
								<label for="email">Email</label>
								<input type="email" id="email" name="newEmail"class="form-control" >
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<label for="phone">Phone</label>
								<input type="text" id="phone" name="newPhone"class="form-control" >
							</div>
						</div>

								<div class="caption">
                                <div class="row">
							<div class="col-md-12">
								<label for="street">Street</label>
								<input type="text" id="street" name="newStreet"class="form-control" >
							</div>
						</div>
						<div class="row">
							
						<div class="col-md-6">
                                <label for="city">City</label>
                                <select id="city" name="newCity" class="form-control" >
                                    <option value="">Select City</option>
                                    <option value="HCMC">Ho Chi Minh</option>
                                    
                                    <!-- Add more options as needed -->
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="district">District</label>
                                <select id="district" name="newDistrict" class="form-control" >
                                    <option value="">Select District</option>
                                    <option value="district1">District 1</option>
                                    <option value="district2">District 2</option>
                                    <option value="district3">District 3</option>
                                    <option value="district4">District 4</option>
                                    <option value="district5">District 5</option>
                                    <option value="district6">District 6</option>
                                    <option value="district7">District 7</option>
                                    <option value="district8">District 8</option>
                                    <option value="district9">District 9</option>
                                    <option value="district10">District 10</option>
                                    <option value="district11">District 11</option>
                                    <option value="district12">District 12</option>
                                    <option value="TanBinh">Tan Binh </option>
                                    <option value="BinhTan">Binh Tan </option>
                                    <option value="TanPhu">Tan Phu</option>
                                    <option value="GoVap">Go Vap</option>
                                    <option value="PhuNhuan">Phu Nhuan</option>
                                    <option value="BinhChanh">Binh Chanh</option>
                                    <option value="HocMon">Hoc Mon</option>
                                    <option value="CanGio">Can Gio</option>
                                    <option value="CuChi">Cu Chi</option>
                                    <option value="NhaBe">Nha Be</option>
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
				<div class="shiping-details-available">
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
							<div class="col-md-12">
								<label for="street">Street</label>
								<input type="text" id="street" name="street"class="form-control"  value="<?php echo $row1['street'] ?>" required>
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






		
					

						</form>

				
							
						
	</div>

		</div>
						
						
					</div>
					<!-- /Order Details -->


						<!-- /Shiping Details -->
      
			
				
	
	

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