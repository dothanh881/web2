<?php 
session_name('admin_session');

session_start();  



include "./templates/top.php"; 
include("./../functions.php");
?>
 
<?php include "./templates/navbar.php"; ?>








<?php

//paging nav
  $products_per_page = 4;
  
  $total_products = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `user` where is_admin = 1"));

  $total_pages = ceil($total_products / $products_per_page);


  $current_page = isset($_GET['page']) ? $_GET['page'] : 1;

  $offset = ($current_page - 1) * $products_per_page;


?>









<div class="container-fluid">
  <div class="row">
    
    <?php include "./templates/sidebar.php"; ?>

      <!-- <canvas class="my-4 w-100" id="myChart" width="900" height="380"></canvas> -->

      <h2><center>Admin Details</center></h2>
      <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
             
              <th>Name</th>
              <th>Email</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody id="admin_list">
          <?php
          $sql = "SELECT * FROM `user` WHERE is_admin = 1 LIMIT $products_per_page offset $offset";
          $stmt = $conn->prepare($sql);
          $stmt->execute();
          $res = $stmt->get_result();
          while ($admin = $res->fetch_object()) {
            if(isset($_SESSION['user_id']) && $_SESSION['user_id'] != $admin->user_id){

            
          ?>
            <tr>
            
              <td> <?php echo $admin->fullname ?></td>
              <td> <?php echo $admin->email ?></td>
              <td> 
  <?php 
    if (isset($_SESSION['user_id']) && $_SESSION['user_id'] != $admin->user_id) { 
      // Checking if session variable is set and not equal to current admin's ID
      if($admin->status == 1){
        echo '<p><a href="active_admin.php?user_id='.$admin->user_id.'&status=0" class="btn btn-success">Active</a></p>';
      } else {
        echo '<p><a href="active_admin.php?user_id='.$admin->user_id.'&status=1" class="btn btn-danger">Inactive</a></p>';
      } 
    } else {
      // Disabling options for the current admin
      if($admin->status == 1){
        echo '<p><button class="btn btn-success" disabled>Active</button></p>';
      } else {
        echo '<p><button class="btn btn-danger" disabled>Inactive</button></p>';
      } 
    }
  ?>
</td>
              

        <td>
                <?php
                if (isset($_SESSION['user_id']) && $_SESSION['user_id'] != $admin->user_id) { // Checking if session variable is set and not equal to current admin's ID
                  ?>
                  <a href="edit_admin.php?admin=<?= $admin->user_id?>" class="btn btn-sm btn-primary"> <i class="far fa-eye"></i>View</a>
                  <?php
                } else {
                  // Disabling options for the current admin
                  ?>
                  <a href="edit_admin.php?admin=<?= $admin->user_id?>" class="btn btn-sm btn-primary"  > <i class="far fa-eye"></i>View</a>
                  <button class="btn btn-sm btn-danger"   disabled>Delete</button>
                  <?php
                }
                ?>
              </td>
            </tr>
          </tbody>
          <?php
          } 
        }?>
        </table>
      </div>
    </main>
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

<?php include "./templates/footer.php"; ?>

<script type="text/javascript" src="./js/admin.js"></script>
