

<?php
    // require functions.php file
    require ('functions.php');
    session_name('customer_session');

	session_start();

?>

<?php
    function input_filter($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    if(isset($_POST['Login'])){
        // filter user_input
        $username = input_filter($_POST['fname']);
        $password = input_filter($_POST['password']);
    
        // Tạo một kết nối đến cơ sở dữ liệu MySQL
    
        // escaping 
        $username = mysqli_real_escape_string($conn, $username);
    
        // Query template
        $query = "SELECT user_id, password FROM user WHERE `username`=? AND `is_admin` = 0 AND `status` = 1";
    
        // Chuẩn bị truy vấn
        $stmt = $conn->prepare($query);
    
        // Kiểm tra và xử lý lỗi nếu không thể chuẩn bị truy vấn
        if (!$stmt) {
            die("Error: " .$conn->error);
        }
    
        // Liên kết các biến với truy vấn
        $stmt->bind_param("s", $username);
    
        // Thực thi truy vấn
        $stmt->execute();
    
        // Lấy kết quả
        $result = $stmt->get_result();
    
        if($result->num_rows == 1){
            $row = $result->fetch_assoc();
            $hash_password = $row['password'];
    
            if(password_verify($password, $hash_password)){
                $_SESSION['username'] = $username;
                $_SESSION['user_id'] = $row['user_id'];
                header("location: ./index.php");
                exit; // Ensure script stops here to prevent further execution
            } 
        } else {
            echo "<script>alert('Incorrect username or password !! Enter again please ! ')</script>";
        }
    
        // Đóng truy vấn và kết nối
        $stmt->close();
        $conn->close();
    }
    
    
      
    
    
?>







<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
     <!-- Bootstrap CDN -->
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

<!-- Owl-carousel CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" integrity="sha256-UhQQ4fxEeABh4JrcmAJ1+16id/1dnlOEVCFOxDef9Lw=" crossorigin="anonymous" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css" integrity="sha256-kksNxjDRxd/5+jGurZUJd1sdR2v+ClrCl3svESBaJqw=" crossorigin="anonymous" />

<!-- font awesome icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" integrity="sha256-h20CPZ0QyXlBuAw7A+KluUYx/3pK+c7lYEpqLTlxjYQ=" crossorigin="anonymous" />

<!-- Custom CSS file -->
<link rel="stylesheet" href="style.css">

<style>
    
.color-second {
    color: #269493;
}

.color-second-bg {
    background: #269493;
}

.color-third-bg {
    background: #269492;
}


</style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark color-second-bg">
        <a class="navbar-brand" href="index.php">Mobile Shopee</a>
       
    </nav>
    <p><br/></p>
<div class="container-fluid">
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-8" id="signup_msg">
				<!--Alert from signup form-->
			</div>
			<div class="col-md-2"></div>
		</div>
		<div class="row mt-3">
			<div class="col-md-4"></div>
			<div class="col-md-4">
				<div class="panel panel-primary">
					 <h3 class="text-center">Login</h3>
					<div class="panel-body">
						<!--User Login Form-->
						<form  id="login" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>">
							<label for="fname">Username</label>
							<input type="text" class="form-control" name="fname" id="fname" required/>
							<label for="password">Password</label>
							<input type="password" class="form-control" name="password" id="password" required/>
							<p><br/></p>
							<a href="#" style="color:#333; list-style:none;">Forgotten Password</a><input type="submit" class="btn btn-success" name="Login" style="float:right;" Value="Login">
							<div><a href="register.php?register=1">Create a new account?</a></div>						
						</form>
				</div>
				<div class="panel-footer"><div id="e_msg"></div></div>
			</div>
		</div>
		<div class="col-md-4"></div>
	</div>
</body>
</html>
