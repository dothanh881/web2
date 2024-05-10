<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<!-- Bootstrap CDN -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
		integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

	<!-- Owl-carousel CDN -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"
		integrity="sha256-UhQQ4fxEeABh4JrcmAJ1+16id/1dnlOEVCFOxDef9Lw=" crossorigin="anonymous" />
	<link rel="stylesheet"
		href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css"
		integrity="sha256-kksNxjDRxd/5+jGurZUJd1sdR2v+ClrCl3svESBaJqw=" crossorigin="anonymous" />

	<!-- font awesome icons -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css"
		integrity="sha256-h20CPZ0QyXlBuAw7A+KluUYx/3pK+c7lYEpqLTlxjYQ=" crossorigin="anonymous" />

	<!-- Custom CSS file -->
	<link rel="stylesheet" href="style.css">

	<?php
	include ('code-generator.php');
	?>


	<style>
		.color-second {
			color: #269493;
		}

		.color-second-bg {
			background: #269493;
		}

		.color-third-bg {
			background: #269493;
		}
	</style>
</head>

<body>

	<nav class="navbar navbar-expand-lg navbar-dark color-second-bg">
		<a class="navbar-brand" href="index.php">Mobile Shopee</a>

	</nav>
	<br>
	<?php
	// require functions.php file
	require ('functions.php');
	session_name('customer_session');

	session_start();
	function input_filter($data)
	{
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

	if (isset($_POST['register'])) {

		$username = input_filter($_POST['username']);
		$email = input_filter($_POST['email']);
		$mobile = input_filter($_POST['mobile']);
		$pass = input_filter($_POST['password']);
		$repass = input_filter($_POST['repassword']);
		$street = input_filter($_POST['street']);
		$city = input_filter($_POST['city']);
		$district = input_filter($_POST['district']);
		$user_id = input_filter($_POST['customer_id']);
		$fullname = input_filter($_POST['fullname']);
		$ward = input_filter($_POST['ward']);


		$username = mysqli_real_escape_string($conn, $username);
		$pass = mysqli_real_escape_string($conn, $pass);
		$mobile = mysqli_real_escape_string($conn, $mobile);
		$email = mysqli_real_escape_string($conn, $email);
		$repass = mysqli_real_escape_string($conn, $repass);
		$street = mysqli_real_escape_string($conn, $street);
		$city = mysqli_real_escape_string($conn, $city);
		$district = mysqli_real_escape_string($conn, $district);
		$user_id = mysqli_real_escape_string($conn, $user_id);
		$fullname = mysqli_real_escape_string($conn, $fullname);
		$ward = mysqli_real_escape_string($conn, $ward);



		$query = "SELECT * FROM user WHERE `username`=? ";

		$stmt = $conn->prepare($query);

		if (!$stmt) {
			die("Error: " . $conn->error);
		}

		$stmt->bind_param("s", $username);
		$stmt->execute();


		$result = $stmt->get_result();

		if ($result->num_rows > 0) {
			echo '<div id="alertMessage" class="alert alert-danger alert-dismissible fade show" role="alert">
		<strong>Warning!</strong>Username already exists!.
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>';
		} else {
			if ($pass != $repass) {
				echo '<div id="alertMessage" class="alert alert-danger alert-dismissible fade show" role="alert">
			<strong>Failed!</strong>Confirm password not matched!.
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>';
			} else {
				$enc_pass = password_hash($pass, PASSWORD_DEFAULT);


				$insert_user = $conn->prepare("INSERT INTO `user` (`user_id`, `email`, `username`, `password`, `street`, `district`, `city`, `phone_number`, `fullname`, `ward` ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");


				$insert_user->bind_param("ssssssssss", $user_id, $email, $username, $enc_pass, $street, $district, $city, $mobile, $fullname, $ward);
				$insert_user->execute();
				echo '<div id="alertMessage" class="alert alert-success alert-dismissible fade show" role="alert">
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


						<form id="signup_form" method="post" onsubmit="return check();">
							<div class="row">
								<div class="col-md-12">
									<label for="username">Username</label>
									<input type="text" id="user_name" name="username" class="form-control" required>
									<input class="form-control" value="<?php echo $cus_id; ?>" required
										name="customer_id" type="hidden">
									<small></small>
								</div>

							</div>
							<div class="row">
								<div class="col-md-6">
									<label for="email">Email</label>
									<input type="text" id="email" name="email" class="form-control" required>
									<small></small>
								</div>
								<div class="col-md-6">
									<label for="mobile">Contact Number</label>
									<input type="number" id="mobile" name="mobile" class="form-control" required>
									<small></small>

								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<label for="password">Password</label>
									<input type="password" id="password" name="password" class="form-control" required>
									<small></small>

								</div>
								<div class="col-md-6">
									<label for="repassword">Confirm Password</label>
									<input type="password" id="repassword" name="repassword" class="form-control"
										required>
									<small></small>

								</div>

							</div>
							<div class="row">
								<div class="col-md-12">
									<label for="fullname">Full Name</label>
									<input type="text" id="fullname" name="fullname" class="form-control" required>
									<small></small>

								</div>
							</div>

							<div class="row">
								<div class="col-md-6">
									<label for="street">Street</label>
									<input type="text" id="street" name="street" class="form-control" required>
									<small></small>
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
									</select>
								</div>
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

									</select>
								</div>
							</div>

							<p><br /></p>

							<div class="row">
								<div class="col-md-12">
									<input style="width:100%;" value="Register Now" type="submit" name="register"
										class="btn btn-success btn-lg">
								</div>
							</div><br>
							<p>Already have an account?</p>
							<a href="login.php">
								<div class="row">
									<div class="col-md-12">
										<input style="width:100%;" value="Login Now" name="signup_button"
											class="btn btn-warning btn-lg">
									</div>
								</div>
							</a>
							<p><br /></p>
					</div>
					</form>
					<div class="panel-footer"></div>
				</div>
			</div>
			<div class="col-md-2"></div>
		</div>
	</div>
</body>

</html>
</body>

</html>
<script>

	const usernameElement = document.getElementById('user_name');
	const emailElenment = document.getElementById('email');
	const mobileElenment = document.getElementById('mobile');
	const passwordElenment = document.getElementById('password');
	const repasswordElenment = document.getElementById('repassword');
	const fullnameElenment = document.getElementById('fullname');
	const streetElenment = document.getElementById('street');

	function check() {
		const phoneRegex = /^0[1-9]{9}$/;
		const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
		var username = usernameElement.value.trim();
		var email = emailElenment.value.trim();
		var mobile = mobileElenment.value.trim();
		var password = passwordElenment.value.trim();
		var repassword = repasswordElenment.value.trim();
		var fullname = fullnameElenment.value.trim();
		var street = streetElenment.value.trim();
		var countError = 0;
		if (!username) {
			setError(usernameElement, "Please enter user name again !");
			countError ++
		} else {
			setSuccess(usernameElement);
		}
		if (!emailRegex.test(email)) {
			setError(emailElenment, "Please enter mail again !");
			countError ++
		} else {
			setSuccess(emailElenment);
		}
		if (!phoneRegex.test(mobile)) {
			setError(mobileElenment, "The phone number is not in the correct format !");
			countError ++
		} else {
			setSuccess(mobileElenment);
		}
		if (!password) {
			setError(passwordElenment, "Password can not just have space !");
			countError ++
		} else {
			setSuccess(passwordElenment);
		}
		if (!repassword) {
			setError(repasswordElenment, "Password can not just have space !");
			countError ++
		} else {
			setSuccess(repasswordElenment);
		}
		if (!fullname) {
			setError(fullnameElenment, "Full name can not be empty !");
			countError ++
		} else {
			setSuccess(fullnameElenment);
		}
		if (!street) {
			setError(streetElenment, "Street can not be empty !");
			countError ++
		} else {
			setSuccess(streetElenment);
		}
		if (countError > 0) {
			return false;
		}
	}

	function setError(ele, message) {
		let parentEle = ele.parentNode;
		parentEle.querySelector('small').innerText = message;
		ele.style.borderColor="red";
		parentEle.querySelector('small').style.color = "red";
	}

	function setSuccess(ele) {
		ele.style.borderColor="green";
		ele.parentNode.querySelector('small').innerText = "";
	}

	const timeoutDuration = 3000;

// Get the alert element
const alertElement = document.getElementById('alertMessage');

// Function to hide the alert after a timeout
const hideAlert = () => {
	alertElement.classList.remove('show');
	setTimeout(() => {
		alertElement.style.display = 'none';
	}, 200); // Transition duration in milliseconds
};

// Hide the alert after the specified duration
setTimeout(hideAlert, timeoutDuration);

// Add event listener to close button to hide alert immediately if clicked
alertElement.querySelector('.close').addEventListener('click', hideAlert);
</script>