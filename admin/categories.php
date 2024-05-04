<?php 
session_name('admin_session');

session_start(); ?>
<?php include_once("./templates/top.php"); ?>
<?php include_once("./templates/navbar.php"); ?>
<div class="container-fluid">
  <div class="row">
    
    <?php include "./templates/sidebar.php"; 
    include("./../functions.php");
    ?>


<?php

function input_filter($data){
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

if(isset($_POST['add_cate'])){
  // Form submission
  if(isset($_POST['category_name'])){
      $cate_name = input_filter($_POST['category_name']);
      $cate_name = mysqli_real_escape_string($conn, $cate_name);

      // Check if category already exists
      $check_sql = "SELECT * FROM `category` WHERE category_name = ?";
      $check_stmt = $conn->prepare($check_sql);

      if (!$check_stmt) {
          die("Error: " .$conn->error);
      }
    
      $check_stmt->bind_param("s", $cate_name);
      $check_stmt->execute();
    
      $result = $check_stmt->get_result();
    
      if($result->num_rows > 0 ){

        echo '<div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Category already exist!</strong> 
        
      </div>';

      } else {
          // Insert new category
          $insert_sql = "INSERT INTO `category` (category_name) VALUES (?)";
          $insert_stmt = $conn->prepare($insert_sql);

          if (!$insert_stmt) {
              die("Error: " .$conn->error);
          }

          $insert_stmt->bind_param("s", $cate_name);
          if($insert_stmt->execute()){
            echo '<div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Add category successfully!</strong> 
          </div>';

          } else {
              echo "Error adding category: " . $insert_stmt->error;
          }
      }
  } else {
      echo "Category name not provided.";
  }
}


// DELETE category
if(isset($_GET['delete'])) {
  $delete_id = $_GET['delete'];
  

      $sql = "DELETE FROM `category` WHERE category_id = ?";
      $stmt = $conn->prepare($sql);
      $stmt->bind_param("i", $delete_id);
      $stmt->execute();
 
}


// EDIT CATEGORY



?>

      <div class="row">
      	<div class="col-10">
      		<h2>Manage Category</h2>
      	</div>
      	<div class="col-2">
      		<a href="#" data-toggle="modal" data-target="#add_category_modal" class="btn btn-warning btn-sm">Add Category</a>
      	</div>
      </div>
      
      <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
           
              <th>Name</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody id="category_list">
            <?php 
            $sql = "SELECT * FROM `category`";
            $stmt = $conn->prepare($sql);
            $stmt->execute();

            $res = $stmt->get_result();
            while($category = $res->fetch_object()){

            
            
            ?>
            <tr>
             
              <td> <?php echo $category->category_name ?> </td>
            
             
              <td>
              <a href="edit_category.php?update=<?= $category->category_id?>"  class="btn btn-sm btn-info">Edit</a>
                  <a href="categories.php?delete=<?= $category->category_id?>" class="btn btn-sm btn-warning" onclick="return confirm('Delete this category?');" >Delete</a>
              </td>
            </tr>
          </tbody>
          <?php } ?>
        </table>
      </div>
    </main>
  </div>
</div>



<!-- Modal -->
<div class="modal fade" id="add_category_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="add-category-form" method="post" enctype="multipart/form-data">
        	<div class="row">
        		<div class="col-12">
        			<div class="form-group">
		        		<label>Category Name</label>
		        		<input type="text" name="category_name" class="form-control" placeholder="Enter Brand Name">
		        	</div>
        		</div>
        	
        		<div class="col-12">
        			<input type="submit" name="add_cate" class="btn btn-primary add-category" value="Add Category">
        		</div>
        	</div>
        	
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->



<!--Edit category Modal -->
<div class="modal fade" id="edit_category_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="edit-category-form" method="post" enctype="multipart/form-data">
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
       
      </div>
    </div>
  </div>
</div>
<!-- Modal -->

<?php include_once("./templates/footer.php"); ?>



<script type="text/javascript" src="./js/categories.js"></script>