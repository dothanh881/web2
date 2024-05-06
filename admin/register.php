
<?php

// require functions.php file
require ('./../functions.php');
include('./../code-generator.php');
session_name('admin_session');

session_start();
if(isset($_SESSION['user_id'])){
	$user_id = $_SESSION['user_id'];
 }else{
	$user_id = '';
 };
	function input_filter($data){
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}


 if(isset($_POST['register'])){

	$username = input_filter($_POST['username']);
	$email = input_filter($_POST['email']);
	$mobile = input_filter($_POST['mobile']);
	$pass = input_filter($_POST['password']);
	$repass = input_filter($_POST['repassword']);
	$street = input_filter($_POST['street']);
	$city = input_filter($_POST['city']);
	$district = input_filter($_POST['district']);
	$fullname = input_filter($_POST['fullname']);
	$user_id = input_filter($_POST['customer_id']);
	$ward = input_filter($_POST['ward']);


	$username = mysqli_real_escape_string($conn, $username);
	$pass = mysqli_real_escape_string($conn, $pass);
	$mobile = mysqli_real_escape_string($conn, $mobile);
	$email = mysqli_real_escape_string($conn, $email);
	$repass = mysqli_real_escape_string($conn, $repass);
	$street = mysqli_real_escape_string($conn, $street);
	$city = mysqli_real_escape_string($conn, $city);
	$district = mysqli_real_escape_string($conn, $district);
	$fullname = mysqli_real_escape_string($conn, $fullname);
	$user_id = mysqli_real_escape_string($conn, $user_id);
	$ward = mysqli_real_escape_string($conn, $ward);



	$query = "SELECT * FROM user WHERE `username`=? ";

	$stmt = $conn->prepare($query);

	if (!$stmt) {
		die("Error: " .$conn->error);
	}

	$stmt->bind_param("s", $username);
	$stmt->execute();


	$result = $stmt->get_result();

	if($result-> num_rows > 0 ){
		echo '<div class="alert alert-danger alert-dismissible fade show mt-5" role="alert">
		<strong>Warning</strong>Username already exists!.
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>';
	}
	else{
		if($pass != $repass){
			echo '<div class="alert alert-danger alert-dismissible fade show mt-5" role="alert">
			<strong>Failed!</strong>Confirm password not matched!.
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>';
		}
		else{
			$enc_pass = password_hash($pass, PASSWORD_DEFAULT);

			$status = 1;
			$is_admin = 1;

			$insert_user = $conn->prepare("INSERT INTO `user` (`user_id` ,`email`, `username`, `password`, `street`, `district`, `city`, `phone_number`, `status`, `is_admin`, `fullname`, `ward` ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");


			$insert_user-> bind_param("ssssssssiiss",$user_id , $email, $username,$enc_pass, $street, $district, $city, $mobile, $status, $is_admin, $fullname, $ward);
			$insert_user-> execute();
			echo '
			<div class="alert alert-success alert-dismissible fade show mt-5" role="alert">
			<strong>Success!</strong> Registered account successfully.
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>';
		}
	}
	$stmt->close();
	$conn->close();
 }


?>


<?php include "./templates/top.php"; ?>

<?php include "./templates/navbar.php"; ?>

<p><br/></p>
<p><br/></p>

<div class="container-fluid">
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-8" id="signup_msg">
				<!--Alert from signup form-->
			</div>
			<div class="col-md-2"></div>
		</div>
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-8">
				<div class="panel panel-primary">
					<h4 class="text-center">Register</h4>
					<div class="panel-body">
					

					<form id="signup_form" method="post">
						<div class="row">
							<div class="col-md-12">
								<label for="username">Username</label>
								<input type="text" id="user_name" name="username" class="form-control" required>
								<input class="form-control" value="<?php echo $cus_id;?>" required name="customer_id"  type="hidden">

							</div>
						
						</div>
						<div class="row">
							<div class="col-md-6">
								<label for="email">Email</label>
								<input type="text" id="email" name="email"class="form-control" required>
							</div>
							<div class="col-md-6">
								<label for="mobile">Contact Number</label>
								<input type="text" id="mobile" name="mobile"class="form-control" required>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<label for="password">Password</label>
								<input type="password" id="password" name="password"class="form-control" required>
							</div>
							<div class="col-md-6">
								<label for="repassword">Confirm Password</label>
								<input type="password" id="repassword" name="repassword"class="form-control" required>
							</div>
							
						</div>
						<div class="row">
							<div class="col-md-12">
								<label for="fullname">Full Name</label>
								<input type="text" id="fullname" name="fullname"class="form-control" required>
							</div>
						</div>
						<div class="row">
							
						</div>
						<div class="row">
							<div class="col-md-6">
								<label for="street">Street</label>
								<input type="text" id="street" name="street"class="form-control" required>
							</div>
							<div class="col-md-6">
								<label for="ward">Ward</label>
								<select id="ward" name="ward" class="form-control" required>
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
                                <label for="city">City</label>
                                <select id="city" name="city" class="form-control" required>
                                    <option value="">Select City</option>
                                    <option value="Ho Chi Minh">Ho Chi Minh</option>
                                    
                                    <!-- Add more options as needed -->
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="district">District</label>
                                <select id="district" name="district" class="form-control" required>
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
						
						<p><br/></p>
						
						<div class="row">
							<div class="col-md-12">
								<input style="width:100%;" value="Register Now" type="submit" name="register"class="btn btn-success btn-lg">
							</div>
						</div>
						

						<p><br/></p>
					</div>
					</form>
					<div class="panel-footer"></div>
				</div>
			</div>
			<div class="col-md-2"></div>
		</div>
	</div>


<?php include "./templates/footer.php"; ?>

<script type="text/javascript" src="./js/main.js"></script>
