<?php
session_name('admin_session');

session_start();
include_once("./templates/top.php");
include_once("./templates/navbar.php");
include("./../functions.php");
?>







<div class="container-fluid">
  <div class="row">
    <?php include "./templates/sidebar.php"; ?>
  
      <div class="col-10">
      <div class="row">
    
        <h2>Profile</h2>
      </div>
    </div>
    



<?php

$sql = "SELECT * FROM `user` WHERE `user_id` = ? AND is_admin = 1 ";

$select = $conn->prepare($sql);

$select->bind_param("s", $user_id);

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
        <input type="password" class="form-control" placeholder="Enter password" name="password" style="margin-bottom:10px"
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



<?php include_once("./templates/footer.php"); ?>
<script type="text/javascript" src="./js/customers.js"></script>
