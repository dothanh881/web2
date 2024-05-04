<?php 
session_name('admin_session');

session_start(); ?>
<?php include_once("./templates/top.php"); ?>
<?php include_once("./templates/navbar.php"); ?>
<div class="container-fluid">
  <div class="row">
 
    
    <?php include "./templates/sidebar.php";
    include("./../functions.php");
    include("checkstatus.php");
    ?>

<style>
    .pagination-justify-content-center {
        display: flex;
        justify-content: center;
        margin-top: 20px;
        margin-bottom: 20px;
        font-size: 15px;
    }

    .pagination-justify-content-center .page-item {
        display: inline-block;
        margin-right: 5px;
        background-color: #ddd; /* Màu nền xám */
        padding: 15px 30px; /* Kích thước padding */
        border-radius: 2px;
    }

    .pagination-justify-content-center .page-item.disabled .page-link {
        color: #6c757d;
        pointer-events: none;
        background-color: #ddd; /* Màu nền xám */
    }

    .pagination-justify-content-center .page-item.active .page-link {
        /* color: #613d8a; màu nút khi được bấm */
        color: red;
    }

    .pagination-justify-content-center .page-link {
        color: black; 
    }

    .pagination-justify-content-center .page-link:hover {
        color: purple; /* Màu chữ khi hover */
        text-decoration: none;

    }

</style>





<?php

   


    if(isset($_GET['delete'])) {
      $delete_id = $_GET['delete'];
      
      // Kiểm tra trạng thái của sản phẩm
      $status = checkStatus($delete_id);
      
      // Nếu trạng thái là 0 hoặc 1, xóa sản phẩm
      if ($status == 0 || $status == 1) {

        $delCart = "DELETE FROM `cart` WHERE item_id = ?";
        $stmt = $conn->prepare($delCart);
        $stmt ->bind_param("i", $delete_id);
        $stmt ->execute();



          $sql = "DELETE FROM `product` WHERE item_id = ?";
          $stmt = $conn->prepare($sql);
          $stmt->bind_param("i", $delete_id);
          $stmt->execute();


      } elseif ($status == 2) {
          // Nếu trạng thái là 2, cập nhật lại trạng thái thành 0 thay vì xóa
          $sql1 = "UPDATE `product` SET item_status = 0 WHERE item_id = ?";
          $stmt1 = $conn->prepare($sql1);
          $stmt1->bind_param("i", $delete_id);
          $stmt1->execute();
      }
  }



?>











<?php

//paging nav
  $products_per_page = 4;
  
  $total_products = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `product`"));

  $total_pages = ceil($total_products / $products_per_page);


  $current_page = isset($_GET['page']) ? $_GET['page'] : 1;

  $offset = ($current_page - 1) * $products_per_page;


?>


      <div class="row">
      	<div class="col-10">
      
      		<h2>Product List</h2>
      	</div>
       
      	<div class="col-2">
      		<a href="#" data-toggle="modal" data-target="#add_product_modal" class="btn btn-warning btn-sm">Add Product</a>
      	</div>
      </div>
      
      <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
            
              <th>Image</th>
              <th>Name</th>
              <th>Price</th>
              <th>Quantity</th> 
              <th>Action</th>
            </tr>
          </thead>
          <tbody id="product_list">
            <?php 

            $sql = "SELECT * FROM `product`,`category` WHERE `product`.category_id = `category`.category_id LIMIT $products_per_page offset $offset";
            $stmt = $conn->prepare($sql);

            $stmt-> execute();

            $result = $stmt ->get_result();

            while($product = $result->fetch_object()){
            ?>
            <tr>
             
              <td><img height='100px' src='./../<?= $product->item_image ?>'></td>
              <td> <?php echo $product->item_name ?></td>
              <td> <?php echo $product->item_price ?></td>
              <td> <?php echo $product->item_quantity ?></td>
           
              <td>
              <a href="editproduct.php?update=<?= $product->item_id ?>" class="btn btn-sm btn-info">Edit</a>
                  <a href="products.php?delete=<?php echo $product->item_id ?>" onclick="return confirm('Delete this product?');" class="btn btn-sm btn-warning">Delete</a>
              </td>
            </tr>
          </tbody>
          <?php } ?>
        </table>
      </div>
    </main>
  </div>
</div>


<?php

function input_filter($data){
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

if(isset($_POST['add-product'])){
  // Xử lý tên file hình ảnh
  $tmp_name =  $_FILES["item_image"]["tmp_name"];
  $fldimageurl = "./assets/products/" . basename($_FILES["item_image"]["name"]);

  // Di chuyển tệp tải lên vào thư mục đích
  if(move_uploaded_file($tmp_name, __DIR__ . "/../" . $fldimageurl)){
      // Lấy dữ liệu từ form và tiến hành xử lý
      $item_name =   input_filter($_POST['item_name']);
      $item_category =  input_filter($_POST['category']);
      $item_desc =  input_filter($_POST['item_desc']);
      $item_qty =  input_filter($_POST['item_qty']);
      $item_price = $_POST['item_price'];
      $item_rom =  input_filter($_POST['item_rom']);
      $item_ram =  input_filter($_POST['item_ram']);
      $item_color =  input_filter($_POST['item_color']);
      $item_screen =  input_filter($_POST['item_screen']);
      $item_image =  mysqli_real_escape_string($conn, $fldimageurl);

      // Tiến hành thêm sản phẩm vào cơ sở dữ liệu
      $sql = "INSERT INTO `product` (category_id, item_name, item_quantity, item_price, item_color, item_image, item_discription, item_rom, item_ram, size_screen) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
      $stmt = $conn->prepare($sql);

      if($stmt){
          $stmt->bind_param("isidsssiii", $item_category, $item_name, $item_qty, $item_price, $item_color, $item_image, $item_desc, $item_rom, $item_ram, $item_screen);
          if($stmt->execute()) {
            echo '<script> alert("Add product successfully!");</script>';
              
          } else {
              echo "Error " . $stmt->error;
          }
      } 
  } else {
      echo '<script> alert("Image up failed!!");</script>';
  }
}
  


?>




<!-- Add Product Modal start -->
<div class="modal fade" id="add_product_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Product</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form   action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post"  id="add-product-form" enctype="multipart/form-data">
        	<div class="row">
        		<div class="col-12">
        			<div class="form-group">
		        		<label>Product Name</label>
		        		<input type="text" name="item_name" class="form-control" placeholder="Enter Product Name">
		        	</div>
        		</div>
        	
        		<div class="col-12">
        			<div class="form-group">
		        		<label>Category Name</label>
		        		<select class="form-control category_list" name="category">
		        			<option value="">Select Category</option>
		        		<?php
                    $sql="SELECT * from category";
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
        		<div class="col-12">
        			<div class="form-group">
		        		<label>Product Description</label>
		        		<textarea class="form-control" name="item_desc" placeholder="Enter product desc"></textarea>
		        	</div>
        		</div>
            <div class="col-6">
              <div class="form-group">
                <label>Product Qty</label>
                <input type="number" min="0" name="item_qty" class="form-control" placeholder="Enter Product Quantity">
              </div>
            </div>
        		<div class="col-6">
        			<div class="form-group">
		        		<label>Product Price</label>
		        		<input type="number" min="0" step="0.01"  name="item_price" class="form-control" placeholder="Enter Product Price">
		        	</div>
        		</div>
        		<div class="col-6">
        			<div class="form-group">
		        		<label>ROM</label>
		        		<select class="form-control rom_list" name="item_rom">
		        			<option value="">Select ROM</option>
		        			<option value="32">32 GB</option>
		        			<option value="64">64 GB</option>
		        			<option value="128">128 GB</option>
		        			<option value="256">256 GB</option>
		        			<option value="512">512 GB</option>
		        			<option value="1024">1 T</option>
		        	
		        		</select>
		        	</div>
        		</div>
            <div class="col-6">
        			<div class="form-group">
		        		<label>RAM</label>
		        		<select class="form-control ram_list" name="item_ram">
		        			<option value="">Select RAM</option>
		        			<option value="2">2 GB</option>
		        			<option value="4">4 GB</option>
		        			<option value="6">6 GB</option>
		        			<option value="8">8 GB</option>
		        			<option value="12">12 GB</option>
		        		</select>
		        	</div>
        		</div>
            <div class="col-6">
        			<div class="form-group">
		        		<label>Color</label>
		        		<select class="form-control color_list" name="item_color">
		        			<option value="">Select Color</option>
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
		        			<option value="">Select Screen</option>
                 <script>
                  var opt;
                  for(var i = 5.1; i < 7.1; i+=0.1){
                    document.write(`<option value="${i.toFixed(1)}">${i.toFixed(1)} inches</option>`)
                  }
                 </script>

		        		</select>
		        	</div>
        		</div>
           
        		<div class="col-12">
        			<div class="form-group">

		        		<label>Product Image <small>(format: jpg, jpeg, png)</small></label>
		        		<input type="file" name="item_image" id="item_image_input" class="form-control">
		        	</div>
              <img id="preview_image" width='200px' height='150px' src='' alt="Preview Image">
        		</div>
        		
        		<div class="col-12">
        			<input type="submit" name="add-product" value="Add Product" class="btn btn-primary add-product"></input>
        		</div>
        	</div>
        	
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Add Product Modal end -->




<nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">
        <li class="page-item <?php echo $current_page == 1 ? 'disabled' : ''; ?>">
            <a class="page-link" href="?page=1" tabindex="-1">First</a>
        </li>
        <li class="page-item <?php echo $current_page == 1 ? 'disabled' : ''; ?>">
            <a class="page-link" href="<?php echo $current_page == 1 ? '#' : '?page=' . ($current_page - 1); ?>">Previous</a>
        </li>
        <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
            <li class="page-item <?php echo $current_page == $i ? 'active' : ''; ?>">
                <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
            </li>
        <?php } ?>
        <li class="page-item <?php echo $current_page == $total_pages ? 'disabled' : ''; ?>">
            <a class="page-link" href="<?php echo $current_page == $total_pages ? '#' : '?page=' . ($current_page + 1); ?>">Next</a>
        </li>
        <li class="page-item <?php echo $current_page == $total_pages ? 'disabled' : ''; ?>">
            <a class="page-link" href="?page=<?php echo $total_pages; ?>">Last</a>
        </li>
    </ul>
</nav>

<!-- Edit Product Modal end -->

<?php include_once("./templates/footer.php"); ?>

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
</script>

<script type="text/javascript" src="./js/products.js"></script>