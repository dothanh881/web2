<?php 
session_name('admin_session');

session_start(); ?>

<?php include_once("./templates/top.php"); ?>
<?php include_once("./templates/navbar.php"); ?>

<div class="container-fluid">
  <div class="row">
    
    <?php include "./templates/sidebar.php";
          include "./../functions.php";
    ?>
   <div class="container p-5">

<h4>Edit Customer Detail</h4>



<?php
      function input_filter($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
     
    if(isset($_POST['update_btn'])){
      
      $user_id = $_POST['user_id'];
      $fullname = input_filter($_POST['fullname']);
      $email = input_filter($_POST['email']);
      $phone = input_filter($_POST['phone']);
      $street = input_filter($_POST['street']);
   
      $city = $_POST['city'];
      $district = $_POST['district'];
    
      $fullname = mysqli_real_escape_string($conn, $fullname);
      $email = mysqli_real_escape_string($conn, $email);
      $phone = mysqli_real_escape_string($conn, $phone);
      $street = mysqli_real_escape_string($conn, $street);
    
      $sql = "UPDATE `user` SET fullname = ?, email = ?, phone_number = ?, street = ?, city = ?, district = ? WHERE user_id = ?";
     
    
      $stmt = $conn->prepare($sql);
     
      $stmt->bind_param("sssssss", $fullname, $email, $phone, $street, $city, $district, $user_id);
     
      $stmt->execute();
     
      
  }
     ?>




<?php
// Get db for each product to edit
   if(isset($_GET['customer'])){

    $customer_id = $_GET['customer'];
    $sql = "SELECT * FROM `user` WHERE `user_id` = ? AND is_admin = 0 ";

    $select = $conn->prepare($sql);
    
    $select -> bind_param("s", $customer_id);
   
    $select->execute();
 
    $result = $select->get_result();

 
    if($result ->num_rows == 1){
      $row1 = $result->fetch_assoc();
      $distrc = $row1['district'];
     
        
  // \getdb
?>

<form method="post"  enctype='multipart/form-data'>
	<div class="form-group">
      <input type="text" class="form-control" name="user_id" value="<?php echo $row1['user_id']  ?>" hidden>
    </div>
    
    <div class="form-group">
      <label for="fullname">Full Name:</label>
      <input type="text" class="form-control" name="fullname" value="<?php echo $row1['fullname']  ?>">
    </div>
    <div class="form-group">
      <label for="email">Email:</label>
      <input type="text" class="form-control" name="email" value="<?php echo $row1['email']  ?>">
    </div>
    <div class="form-group">
      <label for="phone">Phone:</label>
      <input type="text" class="form-control" name="phone" value="<?php echo $row1['phone_number']  ?>">
    </div>
    <div class="form-group">
      <label for="street">Street:</label>
      <input type="text" class="form-control" name="street" value="<?php echo $row1['street']  ?>">
    </div>


   <div class="row">
    <div class="col-6">
    <div class="form-group">
		        		<label>City: </label>
		        	  <select id="city" name="city" class="form-control">
                      <option value="<?php echo $row1['city'] ?> "><?php echo $row1['city']  ?></option>
      

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
        		
        	

      
     
    <div class="form-group">
      <button type="submit" style="height:40px" name="update_btn" class="btn btn-primary">Update</button>
    </div>
    
  </form>

  <?php }
  }else{
    echo '<p class="empty">no product user!</p>';
  }

  ?>
    </div>

  </div>
</div>


<?php include_once("./templates/footer.php"); ?>