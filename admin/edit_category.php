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

<h4>Edit Category Detail</h4>



<?php
      function input_filter($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
     
    if(isset($_POST['edit_btn'])){
      
    $category_id = $_POST['category_id'];
    $cate_name = input_filter($_POST['category_name']);
    $cate_name = mysqli_real_escape_string($conn, $cate_name);
   
     
    
      $sql = "UPDATE `category` SET category_name = ? WHERE category_id =?";
     
    
      $stmt = $conn->prepare($sql);
     
      $stmt->bind_param("si", $cate_name, $category_id);
     
      $stmt->execute();
     
      
  }
     ?>




<?php
// Get db for each product to edit
   if(isset($_GET['update'])){

    $category_id = $_GET['update'];
    $sql = "SELECT * FROM `category` WHERE `category_id` = ?";

    $select = $conn->prepare($sql);
    
    $select -> bind_param("s", $category_id);
   
    $select->execute();
 
    $result = $select->get_result();

 
    if($result ->num_rows == 1){
      $row1 = $result->fetch_assoc();
    
     
        
  // \getdb
?>

<form method="post" method="post"  enctype='multipart/form-data'>

<div class="form-group">
      <input type="text" class="form-control" name="category_id" value="<?php echo $row1['category_id']  ?>" hidden>
    </div>
    
<div class="row">


            <div class="col-12">
             
              <div class="form-group">
                <label>Category Name</label>
                <input type="text" name="category_name" class="form-control" placeholder="Enter Brand Name" value="<?php echo $row1['category_name'] ?>">
              </div>
            </div>
            
            <div class="col-12">
              <button type="submit" name="edit_btn" class="btn btn-primary edit-category-btn">Update Category</button>
            </div>
          </div>
    
  </form>

  <?php }
  }else{
    echo '<p class="empty">Error!</p>';
  }

  ?>
    </div>

  </div>
</div>


<?php include_once("./templates/footer.php"); ?>

<script>


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