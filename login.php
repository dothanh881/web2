<?php
// require functions.php file
require ('functions.php');
session_name('customer_session');

session_start();

?>

<?php
function input_filter($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (isset($_POST['Login'])) {
    // filter user_input
    $username = input_filter($_POST['fname']);
    $password = input_filter($_POST['password']);

    // Tạo một kết nối đến cơ sở dữ liệu MySQL

    // escaping 
    $username = mysqli_real_escape_string($conn, $username);

    // Query template
    $query = "SELECT user_id, password, status FROM user WHERE `username`=? AND `is_admin` = 0 AND `status` = 1";

    // Chuẩn bị truy vấn
    $stmt = $conn->prepare($query);

    // Kiểm tra và xử lý lỗi nếu không thể chuẩn bị truy vấn
    if (!$stmt) {
        die("Error: " . $conn->error);
    }

    // Liên kết các biến với truy vấn
    $stmt->bind_param("s", $username);

    // Thực thi truy vấn
    $stmt->execute();

    // Lấy kết quả
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $hash_password = $row['password'];

        if (password_verify($password, $hash_password)) {
            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['status_user'] = $row['status'];
          
                // Redirect to index page
                header("location: ./index.php");
                exit;
            }
           
        else{
            
            echo '<div id="alertMessage" class="alert alert-danger alert-dismissible fade show mt-5" role="alert">
            <strong>Failed</strong> Incorrect username or password!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>';

        }
    } else {
        echo '<div id="alertMessage" class="alert alert-danger alert-dismissible fade show mt-5" role="alert">
		<strong>Failed</strong> Incorrect username or password!
		<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		  <span aria-hidden="true">&times;</span>
		</button>
	  </div>';
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
        #header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 999;
            /* Đảm bảo message hiển thị trên header */

        }
    </style>
</head>

<body>
    <header id="header">
    <nav class="navbar navbar-expand-lg navbar-dark color-second-bg">
        <a class="navbar-brand" href="index.php">Mobile Shopee</a>

    </nav>
    </header>
    
    <p><br /></p>
    <br>
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
                        <form id="login" method="post" onsubmit="return checkLogin();" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">
                            <div class="row">
                                <label for="fname">Username</label>
                                <input type="text" class="form-control" name="fname" id="fname" required />
                                <small></small>
                            </div>
                            <div class="row">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" name="password" id="password" required />
                                <small></small>
                            </div>


                            <div><a href="register.php">Create a new account?</a></div>
                            <br>
                            <div class="text-center">
                                <div class="row">
                                    <div class="col-md-4 offset-md-4"> <!-- Centered column with offset -->
                                        <input type="submit" class="btn btn-success" name="Login" style="width: 100%;"
                                            value="Login">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="panel-footer">
                        <div id="e_msg"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4"></div>
        </div>
</body>

</html>

<script>
    
    const nameEle = document.getElementById('fname');
    const passwordEle = document.getElementById('password');
    function checkLogin() {
        var count = 0;
        const name = nameEle.value.trim();
        const password = passwordEle.value.trim();
        if (name=='') {
            setError(nameEle, "User name can not be empty !");
            count++
        }
        else {
            setSuccess(nameEle)
        }
        if (password=='') {
            setError(passwordEle, "Password can not be empty !");
            count++
        }
        else {
            setSuccess(passwordEle)
        }
        if (count > 0) {
            return false;
        }
    }
    function setError(ele, message) {
        let parentEle = ele.parentNode;
        parentEle.querySelector('small').innerText = message;
        ele.style.borderColor = "red";
        parentEle.querySelector('small').style.color = "red";
    }

    function setSuccess(ele) {
        ele.style.borderColor = "green";
        ele.parentNode.querySelector('small').innerText = "";
    }


    const timeoutDuration = 5000;

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