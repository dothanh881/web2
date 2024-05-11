<?php






session_name('admin_session');

session_start();

include ('./../functions.php');


?>







<?php include "./templates/top.php"; ?>

<?php include "./templates/navbar.php"; ?>

<div class="container">
    
    <div class="row justify-content-center" style="margin:100px 0;">
        <div class="col-md-4">
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
        $username = input_filter($_POST['username']);
        $password = input_filter($_POST['password']);

        // Tạo một kết nối đến cơ sở dữ liệu MySQL
    
        // escaping 
        $username = mysqli_real_escape_string($conn, $username);

        // Query template
        $query = "SELECT user_id, password FROM user WHERE `username`=? AND `is_admin` = 1 AND `status` = 1";

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
                header("location: ./index.php");
                exit; // Ensure script stops here to prevent further execution
            } else {
                echo "<div id='alertMessage' class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Warning!</strong>Your password is not correct. Please enter again !
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
              <span aria-hidden='true'>&times;</span>
            </button>
          </div>";
            }
        } else {
            echo "<div id='alertMessage' class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Warning!</strong>Username does not exists !
            <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
              <span aria-hidden='true'>&times;</span>
            </button>
          </div>";
        }

        // Đóng truy vấn và kết nối
        $stmt->close();
        $conn->close();
    }





    ?>
            <h4 class="text-center">Admin Login</h4>
            <p class="message"></p>
            <form id="admin-login-form" method="post" onsubmit="return checkLogin();"
                action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" name="username" id="username" placeholder="Enter username">
                    <small></small>

                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                    <small></small>
                </div>
                <input type="hidden" name="admin_login" value="1">
                <button type="submit" name="Login" class="btn btn-success login-btn">Login</button>
            </form>
        </div>
    </div>
</div>





<?php include "./templates/footer.php"; ?>

<script type="text/javascript" src="./js/main.js"></script>
<script>

    var nameEle = document.getElementById('username');
    var passwordEle = document.getElementById('password');


    nameEle.onblur = function () {
        const name = nameEle.value.trim();
        if (!name) {
            setError(nameEle, "Username can not be empty !");

        } else {
            setSuccess(nameEle);
        }
    };
    passwordEle.onblur = function () {
        const password = passwordEle.value.trim();
        if (!password) {
            setError(passwordEle, "Password can not be empty!");
        }
        else {
            setSuccess(passwordEle);
        }
    }
    function checkLogin() {
        let hasErrors = false; // Flag to track if errors are found

        // Get all input elements in the form (assuming you have a form element)
        const inputs = document.querySelectorAll('input');

        for (const input of inputs) {
            if (input.style.borderColor === 'red') { // Check if border color is red
                hasErrors = true;
                break; // Exit the loop if an error is found (optional)
            }
        }

        if (hasErrors) {
            alert("Please fix the errors before submitting the form!");
            return false; // Prevent form submission (optional)
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