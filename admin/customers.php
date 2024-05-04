<?php
session_name('admin_session');

session_start();
include_once("./templates/top.php");
include_once("./templates/navbar.php");
include("./../functions.php");
?>


<?php

//paging nav
  $products_per_page = 4;
  
  $total_products = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `user` where is_admin = 0"));

  $total_pages = ceil($total_products / $products_per_page);


  $current_page = isset($_GET['page']) ? $_GET['page'] : 1;

  $offset = ($current_page - 1) * $products_per_page;


?>




<div class="container-fluid">
  <div class="row">
    <?php include "./templates/sidebar.php"; ?>
  
      <div class="col-10">
      <div class="row">
    
        <h2>Customers</h2>
      </div>
    </div>
    <div class="table-responsive">
      <table class="table table-striped table-sm">
        <thead>
          <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Mobile</th>
            <th>Status</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody id="customer_list">
          <?php
          $sql = "SELECT * FROM `user` WHERE is_admin = 0 LIMIT $products_per_page offset $offset";
          $stmt = $conn->prepare($sql);
          $stmt->execute();
          $res = $stmt->get_result();
          while ($cust = $res->fetch_object()) {
          ?>
            <tr>
              <td><?php echo $cust->fullname ?></td>
              <td><?php echo $cust->email ?></td>
              <td><?php echo $cust->phone_number ?></td>
              <td>
                <?php 
                if($cust->status == 1){
                  echo '<p><a href="active.php?user_id='.$cust->user_id.'&status=0" class="btn btn-success">Active</a></p>';
                  
                }
                else{
                  echo '<p><a href="active.php?user_id='.$cust->user_id.'&status=1" class="btn btn-danger">Inactive</a></p>';
                }
                ?>
              </td>
              <td>
                <a href="edit_customer.php?customer=<?php echo $cust->user_id ?>" class="btn btn-sm btn-info">Edit</a>
               
              </td>
            </tr>
          <?php
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
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


<?php include_once("./templates/footer.php"); ?>
<script type="text/javascript" src="./js/customers.js"></script>
