<?php include ('header.php');


if (isset($_SESSION['username'])) ?>
<br><br><br>

<div class="d-flex text-center justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-5 border-bottom">
  <h1  class="h2 text-center ">&nbsp;&nbsp;&nbsp;Hello, <?php echo $_SESSION['username'] ?></h1>
  <div class="btn-toolbar mb-2 mb-md-0">

  </div>
</div>





<?php
function input_filter($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

$customer_id = $_SESSION['user_id'];
$sql = "SELECT password FROM `user` WHERE `user_id` = ? AND is_admin = 0 ";

$select = $conn->prepare($sql);

$select->bind_param("s", $customer_id);

$select->execute();

$result = $select->get_result();

$passDB = $result->fetch_assoc();
//xuly


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $user_id = $_POST['user_id'];
  $fullname = input_filter($_POST['fullname']);
  $email = input_filter($_POST['email']);
  $phone = input_filter($_POST['phone']);
  $street = input_filter($_POST['street']);
  $city = $_POST['city'];
  $district = $_POST['district'];
  $ward = $_POST['ward'];
  $password = input_filter($_POST['password']);

  $fullname = mysqli_real_escape_string($conn, $fullname);
  $email = mysqli_real_escape_string($conn, $email);
  $phone = mysqli_real_escape_string($conn, $phone);
  $street = mysqli_real_escape_string($conn, $street);
  $pass = mysqli_real_escape_string($conn, $password);

  if (array_key_exists('newPassword', $_POST)) {
    $newPass = input_filter($_POST['newPassword']);
    $newPass = mysqli_real_escape_string($conn, $newPass);

    if (password_verify($pass, $passDB['password']) ) {
      $sql = "UPDATE `user` SET fullname = ?, email = ?, phone_number = ?, street = ?, city = ?, district = ?, ward = ?, password = ? WHERE user_id = ?";

      $enc_pass = password_hash($newPass, PASSWORD_DEFAULT);
      $stmt = $conn->prepare($sql);

      $stmt->bind_param("sssssssss", $fullname, $email, $phone, $street, $city, $district, $ward, $enc_pass, $user_id);

      $stmt->execute();
      echo " <div id='alertMessage' class='alert alert-success alert-dismissible fade show'>
      <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
      <strong>Success!</strong> Information have changed.
    </div>";
    } else {
      echo "<div  id='alertMessage' class='alert alert-warning alert-dismissible fade show'>
      <button type='button'class='btn-close' data-bs-dismiss='alert'></button>
      <strong>Warning!</strong> Password incorrect . Please enter again !
    </div>"
      ;
    }
  } else{
    $sql = "UPDATE `user` SET fullname = ?, email = ?, phone_number = ?, street = ?, ward=?, city = ?, district = ? WHERE user_id = ?";
    if (password_verify($pass, $passDB['password'])) {
      $stmt = $conn->prepare($sql);

      $stmt->bind_param("ssssssss", $fullname, $email, $phone, $street,$ward, $city, $district, $user_id);

      $stmt->execute();
      echo " <div  id='alertMessage' class='alert alert-success alert-dismissible fade show'>
      <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
      <strong>Success!</strong> Information have changed.
    </div>";
    } else {
      echo "<div id='alertMessage' class='alert alert-warning alert-dismissible fade show'>
      <button type='button'class='btn-close' data-bs-dismiss='alert'></button>
      <strong>Warning!</strong> Password incorrect. Please enter again !
    </div>" ;
    }
  }
}
// Get db for each product to edit
$customer_id = $_SESSION['user_id'];
$sql = "SELECT * FROM `user` WHERE `user_id` = ? AND is_admin = 0 ";

$select = $conn->prepare($sql);

$select->bind_param("s", $customer_id);

$select->execute();

$result = $select->get_result();


if ($result->num_rows == 1) {
  $row1 = $result->fetch_assoc();
  $distrc = $row1['district'];


  // \getdb
  ?>



  <form method="post" enctype='multipart/form-data' class="container" onsubmit="return checkPassword()">
    <div class="form-group">
      <input type="text" class="form-control" name="user_id" value="<?php echo $row1['user_id'] ?>" hidden>
    </div>

    <div class="form-group">
      <label for="fullname">Full Name:</label>
      <input type="text" class="form-control" name="fullname" value="<?php echo $row1['fullname'] ?>">
    </div>
    <div class="form-group">
      <label for="email">Email:</label>
      <input type="text" class="form-control" name="email" value="<?php echo $row1['email'] ?>">
    </div>
    <div class="form-group">
      <label for="phone">Phone:</label>
      <input type="text" class="form-control" name="phone" value="<?php echo $row1['phone_number'] ?>">
    </div>

    <div class="row">
        <div class="col-md-6">
        <div class="form-group">
      <label for="street">Street:</label>
      <input type="text" class="form-control" name="street" value="<?php echo $row1['street']  ?>">
    </div>
        </div>
      <div class="col-md-6">
								<label for="ward">Ward</label>
								<select id="ward" name="ward" class="form-control" required>
                <option value="<?php echo $row1['ward'] ?> "><?php echo $row1['ward']  ?></option>

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
      <div class="col-6">
        <div class="form-group">
          <label>City: </label>
          <select id="city" name="city" class="form-control">
            <option value="<?php echo $row1['city'] ?> "><?php echo $row1['city'] ?></option>


          </select>
        </div>
      </div>

      <div class="col-6">
        <div class="form-group">
          <label>District: </label>
          <select id="district" name="district" class="form-control">
            <option value="<?php echo $distrc ?> "><?php echo $distrc ?> </option>
            <option value="district1">District 1</option>
            <option value="district 2">District 2</option>
            <option value="district 3">District 3</option>
            <option value="district 4">District 4</option>
            <option value="district 5">District 5</option>
            <option value="district 6">District 6</option>
            <option value="district 7">District 7</option>
            <option value="district 8">District 8</option>
            <option value="district 9">District 9</option>
            <option value="district 10">District 10</option>
            <option value="district 11">District 11</option>
            <option value="district 12">District 12</option>
            <option value="Tan Binh">Tan Binh </option>
            <option value="Binh Tan">Binh Tan </option>
            <option value="Tan Phu">Tan Phu</option>
            <option value="Go Vap">Go Vap</option>
            <option value="Phu Nhuan">Phu Nhuan</option>
            <option value="Binh Chanh">Binh Chanh</option>
            <option value="Hoc Mon">Hoc Mon</option>
            <option value="Can Gio">Can Gio</option>
            <option value="Cu Chi">Cu Chi</option>
            <option value="Nha Be">Nha Be</option>

          </select>
        </div>
      </div>


    </div>
    <div class="form-group" style="margin-bottom:20px" id="box-password">
      <label for="password">Password:</label>
      <div class="row-6">
        <input type="password" class="form-control" placeholder="Enter password" id="password" name="password" style="margin-bottom:10px"
          required>
      </div>
      <div class="row-6">
        <a href="#" id="click-re-password" style="color:#D96666;">Change your password ?</a>
      </div>
    </div>




    <div class="form-group">
      <button type="submit" style="height:40px" name="update_btn" class="btn sbtn">Update</button>
    </div>
  </form>
<?php } else {
  echo '<p class="empty">no product user!</p>';
}

?>
</div>

</div>
</div>
<script>
    document.getElementById('click-re-password').addEventListener('click', function (e) {
    e.preventDefault();
    var link = document.getElementById('click-re-password');
    var inputContainer = document.getElementById('box-password');
    link.style.display = 'none';
    inputContainer.innerHTML += '<div id="input-re-password" ><div><label for="newPassword">New Password:</label><input type="password" class="form-control" placeholder="Enter new password" id="newPassword" name="newPassword" style="margin-bottom:10px" required> <small></small></div><div><input type="password" class="form-control" placeholder="Confirm new password" id="re-newPassword" name="re-newPassword" required><small></small></div></div>';
inputContainer.style.display='block';
  });
   function checkPassword() {
    // Get the password and re-typed password values
    var password = document.getElementById('password').value.trim();
    var newPassword = document.getElementById('newPassword'); // Check for existence
    var re_newPassword = document.getElementById('re-newPassword'); // Check for existence

    // Check if the password is empty
    if (!password) {
      alert("Please enter your password.");
      return false;
    }

    // Validate new password and re-typed password (only if elements exist)
    if (newPassword && re_newPassword) {
      if (!newPassword.value.trim()) {
        alert("Please enter your new password.");
        return false;
      }
      if (!re_newPassword.value.trim() || newPassword.value !== re_newPassword.value) {
        setError(re_newPassword,"New password is not confirm !")
        return false;
      }
    }

    // Rest of your form submission logic (assuming you have a submit button)
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


<?php include ('footer.php'); ?>