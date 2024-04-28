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
<br>
<div class="section">
			<!-- container -->
			<div class="container">
				<!-- row -->
				

						<!-- /Shiping Details -->
						
					
                <div class="row">
	<!-- Order Details -->
    <div class="col-md-12 order-details">
						<div class="section-title text-center">
							<h3 class="title">Your Order</h3>
						</div>
						<div class="order-summary">
							<div class="order-col">
								<div><strong>Product</strong></div>
								<div><strong>Total</strong></div>
							</div>
							<div class="order-products">
							</div>
						<div class="payment-method">
							<div class="input-radio">
								<input type="radio" name="payment" id="payment-1">
								<label for="payment-1">
									<span></span>
									Cash On Delivery
								</label>
								
							</div>
							<div class="input-radio">
								<input type="radio" name="payment" id="payment-3">
								<label for="payment-3">
									<span></span>
									Online Banking
								</label>
								
							</div>
						</div>
						<div class="input-checkbox">
							<input type="radio" name="address" id="terms">
                            <label for="shiping-address">
									<span></span>
									Deliver to available address.
							</label>
                            
                            
						</div>
                        <div class="input-checkbox">
							<input type="radio" name="address" id="terms">
                           
                            
                            <label for="shiping-address">
									<span></span>
									Deliver to new address.
								</label>
						</div>
                     
						<button type="button" class="btn btn-primary">Check out</button>
					</div>
					<!-- /Order Details -->
				</div>
                </div>
				
				



                <div class="row">
                <div class="col-md-6">
						<!-- Shiping Details -->
						<div class="shiping-details">
							<div class="section-title">
								<h3 class="title1">Deliver Address</h3>
							</div>
						
							<div class="row">
							<div class="col-md-6">
								<label for="name">Name</label>
								<input type="text" id="name" name="fullname" class="form-control" required>
							</div>
							<div class="col-md-6">
								<label for="email">Email</label>
								<input type="email" id="email" name="email"class="form-control" required>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<label for="phone">Phone</label>
								<input type="text" id="phone" name="phone"class="form-control" required>
							</div>
						</div>

								<div class="caption">
                                <div class="row">
							<div class="col-md-12">
								<label for="street">Street</label>
								<input type="text" id="street" name="street"class="form-control" required>
							</div>
						</div>
						<div class="row">
						<div class="col-md-6">
                                <label for="city">City</label>
                                <select id="city" name="city" class="form-control" required>
                                    <option value="">Select City</option>
                                    <option value="HCMC">Ho Chi Minh</option>
                                    
                                    <!-- Add more options as needed -->
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="district">District</label>
                                <select id="district" name="district" class="form-control" required>
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