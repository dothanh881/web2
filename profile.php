<?php include ('header.php');


if (isset($_SESSION['username'])) ?>
<br><br><br>
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-2 mb-5 border-bottom">
  <h1 class="h2 ">Hello, <?php echo $_SESSION['username'] ?></h1>
  <div class="btn-toolbar mb-2 mb-md-0">

  </div>
</div>





<?php

$customer_id = $_SESSION['user_id'];
$sql = "SELECT password FROM `user` WHERE `user_id` = ? AND is_admin = 0 ";

$select = $conn->prepare($sql);

$select->bind_param("s", $customer_id);

$select->execute();

$result = $select->get_result();

$passDB = $result->fetch_assoc();
//xuly
function input_filter($data)
{
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

if (isset($_POST['update_btn'])) {

  $user_id = $_POST['user_id'];
  $fullname = input_filter($_POST['fullname']);
  $email = input_filter($_POST['email']);
  $phone = input_filter($_POST['phone']);
  $password = input_filter($_POST['password']);
  $street = input_filter($_POST['street']);
  $city = $_POST['city'];
  $district = $_POST['district'];
  $ward = $_POST['ward'];

  $fullname = mysqli_real_escape_string($conn, $fullname);
  $email = mysqli_real_escape_string($conn, $email);
  $phone = mysqli_real_escape_string($conn, $phone);
  $street = mysqli_real_escape_string($conn, $street);
  $pass = mysqli_real_escape_string($conn, $password);

  if (array_key_exists('newPassword', $_POST)) {
    $newPassword = input_filter($_POST['newPassword']);
    $newPass = mysqli_real_escape_string($conn, $newPassword);
    $sql = "UPDATE `user` SET fullname = ?, email = ?, phone_number = ?, street = ?, city = ?, district = ?, ward = ?, password = ? WHERE user_id = ?";
    if (password_verify($pass, $passDB['password'])) {
      $enc_pass = password_hash($newPass, PASSWORD_DEFAULT);
      $stmt = $conn->prepare($sql);

      $stmt->bind_param("sssssssss", $fullname, $email, $phone, $street, $city, $district, $ward, $enc_pass, $user_id);

      $stmt->execute();
      echo " <div class='alert alert-success alert-dismissible fade show'>
      <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
      <strong>Success!</strong> Information have changed.
    </div>";
    } else {
      echo "<div class='alert alert-warning alert-dismissible fade show'>
      <button type='button'class='btn-close' data-bs-dismiss='alert'></button>
      <strong>Warning!</strong> Password incorrect. Please enter again !
    </div>"
      ;
    }
  } else{
    $sql = "UPDATE `user` SET fullname = ?, email = ?, phone_number = ?, street = ?, city = ?, district = ? WHERE user_id = ?";
    if (password_verify($pass, $passDB['password'])) {
      $stmt = $conn->prepare($sql);

      $stmt->bind_param("sssssss", $fullname, $email, $phone, $street, $city, $district, $user_id);

      $stmt->execute();
      echo " <div class='alert alert-success alert-dismissible fade show'>
      <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
      <strong>Success!</strong> Information have changed.
    </div>";
    } else {
      echo "<div class='alert alert-warning alert-dismissible fade show'>
      <button type='button'class='btn-close' data-bs-dismiss='alert'></button>
      <strong>Warning!</strong> Password incorrect. Please enter again !
    </div>"
      ;

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
        <input type="text" class="form-control" placeholder="Enter password" name="password" style="margin-bottom:10px"
          required>
      </div>
      <div class="row-6">
        <a href="#" id="click-re-password">Change your password ?</a>
      </div>
    </div>




    <div class="form-group">
      <button type="submit" style="height:40px" name="update_btn" class="btn btn-primary">Update</button>
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
  function checkPassword() {
    // Get the password value (assuming it's a text input field)
    const password = document.getElementsByName('password')[0].value.trim();
    const input_repass = document.getElementsById('input-re-password');

    // Check if the password is empty
    if (password === '') {
      alert("Please enter your password.");
      return false; // Prevent form submission if password is empty
    }
    if (input_repass) {
      const valNewPass = document.getElementsByName('newPassword')[0].value.trim();
      const valRe_NewPassword = document.getElementsByName('re-newPassword')[0].value.trim();
      if (valNewPass === '') {
        alert("Please enter your new password.")
        return false;
      }
      if (valRe_NewPassword === '') {
        alert("Please re-enter your new password.")
        return false;
      }
      if (valNewPass !== valRe_NewPassword) {
        alert("The new passwords do not match.");
        return false;
      }
    }
    return true;
  }
  document.getElementById('click-re-password').addEventListener('click', function (e) {
    e.preventDefault();
    var link = document.getElementById('click-re-password');
    var inputContainer = document.getElementById('box-password');
    link.style.display = 'none';
    inputContainer.innerHTML += '<div id="input-re-password" ><label for="newPassword">New Password:</label><input type="password" class="form-control" placeholder="Enter new password" name="newPassword" style="margin-bottom:10px" required><input type="password" class="form-control" placeholder="Confirm new password" name="re-newPassword" required></div>';
inputContainer.style.display='block';
  });
</script>


<?php include ('footer.php'); ?>