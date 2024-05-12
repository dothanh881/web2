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


     <?php
      function input_filter($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
     
    if(isset($_POST['update_btn'])){
      
      $item_id = $_POST['item_id'];
      $item_name = input_filter($_POST['item_name']);
      $item_desc = input_filter($_POST['item_desc']);
      $item_price = input_filter($_POST['item_price']);
      $item_category = $_POST['category'];
      $item_status = $_POST['status'];
      $item_rom = $_POST['item_rom'];
      $item_ram = $_POST['item_ram'];
      $item_color = $_POST['item_color'];
      $item_screen = $_POST['item_screen'];
      $item_quantity = $_POST['item_qty'];
    
      $item_name = mysqli_real_escape_string($conn, $item_name);
      $item_desc = mysqli_real_escape_string($conn, $item_desc);
      $item_price = mysqli_real_escape_string($conn, $item_price);
    
      $sql = "UPDATE `product` SET item_name = ?, item_discription = ?, item_price = ?, category_id = ?, item_status = ?, item_rom = ?, item_ram = ?, item_color = ?, size_screen = ?, item_quantity = ? WHERE item_id = ?";
      $updateCart = "UPDATE `cart` SET  cart_price = ?, name = ? WHERE item_id = ?";
    
      $stmt = $conn->prepare($sql);
      $queryCart = $conn->prepare($updateCart);
      $stmt->bind_param("ssdiiiisdii", $item_name, $item_desc, $item_price, $item_category, $item_status, $item_rom, $item_ram, $item_color, $item_screen , $item_quantity, $item_id);
      $queryCart->bind_param("dsi",  $item_price, $item_name, $item_id);
      $stmt->execute();
      echo '<div id="alertMessage" class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <strong>Update successfully!</strong> 
    </div>';
      $queryCart->execute();
      // Xử lý ảnh mới
      $old_image = $_POST['item_image'];
      $imageNew = $_FILES['item_NewImage']['name'];
    
      if(!empty($imageNew)){
          $imageNew_temp = $_FILES['item_NewImage']['tmp_name'];
          $imageNew_size = $_FILES['item_NewImage']['size'];
          $image_folder = './assets/products/' . $imageNew;
    
          if($imageNew_size > 2000000){
            echo '<div id="alertMessage" class="alert alert-warning alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Image size too large!</strong> 
          </div>';
          } else {
              $query = "UPDATE `product` SET item_image = ? WHERE item_id = ?";
              $stmt = $conn->prepare($query);
              $stmt->bind_param("si", $image_folder, $item_id);
              $stmt->execute();

            
          

              $upCart = "UPDATE `cart` SET cart_image = ? WHERE item_id = ?";
              $query1 = $conn->prepare($upCart);
              $query1 ->bind_param("si", $image_folder, $item_id );
              $query1->execute();
              
              move_uploaded_file($imageNew_temp, __DIR__ . "/../" . $image_folder);
          }
      } else {
          // Nếu không có ảnh mới được chọn
          $imageNew = $old_image; // Sử dụng lại ảnh cũ
      }
  }
     ?>
      
      <div class="container p-5">

<h4>Edit Product Detail</h4>
<?php
   // Get db for each product to edit
   if(isset($_GET['update'])){

    $update_id = $_GET['update'];
    $sql = "SELECT * FROM `product` WHERE `item_id` = $update_id ";

    $select = $conn->prepare($sql);
 
   
    $select->execute();
 
    $result = $select->get_result();

 
    if($result ->num_rows == 1){
      $row1 = $result->fetch_assoc();
        $category_id = $row1['category_id'];
        $status = $row1['item_status'];
        $rom = $row1['item_rom'];
        $ram = $row1['item_ram'];
        $color = $row1['item_color'];  
        $screen = $row1['size_screen'];
        $image = $row1['item_image'];
        
        
  // \getdb
?>






<form method="post"  enctype='multipart/form-data'>
	<div class="form-group">
      <input type="text" class="form-control" name="item_id" value="<?php echo $row1['item_id']  ?>" hidden>
    </div>
    
    <div class="form-group">
      <label for="name">Product Name:</label>
      <input type="text" class="form-control" name="item_name" value="<?php echo $row1['item_name']  ?>">
    </div>
    <div class="form-group">
      <label for="desc">Product Description:</label>
      <input type="text" class="form-control" name="item_desc" value="<?php echo $row1['item_discription']  ?>">
    </div>
  <div class="row">
    <div class="col-6">
        <div class="form-group">
          <label for="price">Unit Price ($):</label>
          <input type="number" class="form-control" min="0"   step="0.01" name="item_price" value="<?php echo  $row1['item_price'] ?>">
      </div>
   
    </div>
    <div class="col-6">
        <div class="form-group">
          <label for="qty">Product Quantity:</label>
          <input type="number" class="form-control" min="0"  name="item_qty" value="<?php echo  $row1['item_quantity'] ?>">
      </div>
   
    </div>
  </div>
   
   

   <div class="row">
    <div class="col-6">
    <div class="form-group">
		        		<label>Category Name</label>
		        	  <select id="category" name="category" class="form-control">
        <?php
        
        $sql="SELECT * from category WHERE category_id='$category_id'";
        $result = $conn-> query($sql);
        if ($result-> num_rows > 0){
          while($row = $result-> fetch_assoc()){
            echo"<option value='". $row['category_id'] ."'>" .$row['category_name'] ."</option>";
          }
        }
          
        ?>
          <?php
          $sql="SELECT * from category WHERE category_id!='$category_id'";
          $result = $conn-> query($sql);
          if ($result-> num_rows > 0){
            while($row = $result-> fetch_assoc()){
              echo"<option value='". $row['category_id'] ."'>" .$row['category_name'] ."</option>";
            }
          }
        ?>
       
      </select>
		        	</div>
    </div>


    <div class="col-6">
    <div class="form-group">
		        		<label>Status Product</label>
		        		<select class="form-control status_list" name="status">
		        			 <option value="<?php echo $status ?> ">
                   
                   <?php
                   if($status == 2){
                    echo $status . "  (sold)";
                   }
                   
                   
                   else if ($status == 1){
                    echo $status . "  (published)";
                   }
                   
                   else if ($status == 0){
                    echo $status . "  (unpublished - in stock)";
                   }
                   
                   ?>
                  
                  </option>
              
              <option value="0">0  (unpublished - in stock)</option>
              <option value="1">1  (published)</option>

                  

                  
		        		</select>
		        	</div>
    </div>
   </div>
        		
        	

      <div class="row">
      <div class="col-6">
        			<div class="form-group">
		        		<label>ROM</label>
		        		<select class="form-control rom_list" name="item_rom" >
                <option value="<?php echo $rom ?> "><?php echo $rom ?></option>
                <?php 
            
$sql = "SELECT distinct(item_rom) FROM `product` WHERE item_rom != $rom ORDER BY item_rom asc" ;
$result = $conn->prepare($sql);
$result -> execute();

$rom = $result ->get_result();

while($row = $rom->fetch_assoc()){ ?>
  <option value="<?php echo $row['item_rom'] ?>"><?php echo $row['item_rom'] ?></option>


<?php } ?>
		        		
		        	
		        		</select>
		        	</div>
        		</div>
            <div class="col-6">
        			<div class="form-group">
		        		<label>RAM</label>
		        		<select class="form-control ram_list" name="item_ram">
		        	
                  <option value="<?php echo $ram ?> "><?php echo $ram ?></option>
                  <?php 
            
            $sql = "SELECT distinct(item_ram) FROM `product` WHERE item_ram != $ram ORDER BY item_ram asc" ;
            $result = $conn->prepare($sql);
            $result -> execute();
            
            $ram = $result ->get_result();
            
            while($row = $ram->fetch_assoc()){ ?>
              <option value="<?php echo $row['item_ram'] ?>"><?php echo $row['item_ram'] ?></option>
            
            
            <?php } ?>
		        		</select>
		        	</div>
        		</div>
      </div>
    
      <div class="row">
        <div class="col-6">
                <div class="form-group">
                  <label>Color</label>
                  <select class="form-control color_list" name="item_color">
                
                  <option value="<?php echo $color ?>"><?php echo $color ?></option>
                  <option value="Red">Red</option>
		        			<option value="Blue">Blue</option>
		        			<option value="Yellow">Yellow</option>
		        			<option value="Purple">Purple</option>
		        			<option value="Black">Black</option>
		        			<option value="White">White</option>
		        			<option value="Green">Green</option>
		        			<option value="Silver">Silver</option>
                  </select>
                </div>
        		</div>


            <div class="col-6">
        			<div class="form-group">
		        		<label>Screen</label>
		        		<select class="form-control ram_list" name="item_screen">
                <option value="<?php echo $screen ?>"><?php echo $screen ?></option>
                <script>
                  var opt;
                  for(var i = 5.1; i < 7.1; i+=0.1){
                    document.write(`<option value="${i.toFixed(1)}">${i.toFixed(1)} inches</option>`)
                  }
                 </script>

		        		</select>
		        	</div>
        		</div>
      </div>
            
   
      <div class="form-group">
         <img width='200px' id="preview_image" height='150px' src='./../<?php echo $row1['item_image'] ?>'>
         <div>
            <label for="file">Choose Image:</label>
            <input type="hidden" id="existingImage" class="form-control" name="item_image" value="<?php echo $row1['item_image']  ?>" >
            <input type="file" id="item_image_input" name="item_NewImage" value="">
         </div>
    </div>
    <div class="form-group">
      <button type="submit" style="height:40px" name="update_btn" class="btn btn-primary">Update Item</button>
    </div>
    
  </form>

  <?php }
  }else{
    echo '<p class="empty">no product found!</p>';
  }

  ?>
    </div>

  </div>
</div>
<script>
  // Display image before adding product
    document.addEventListener('DOMContentLoaded', function () {
        var input = document.getElementById('item_image_input');
        var previewImage = document.getElementById('preview_image');

        input.addEventListener('change', function (e) {
            var file = e.target.files[0];
            var reader = new FileReader();

            reader.onload = function (event) {
                previewImage.src = event.target.result;
            };

            reader.readAsDataURL(file);
        });
    });


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


<?php include_once("./templates/footer.php"); ?>



