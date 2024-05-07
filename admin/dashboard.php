<?php 
session_name('admin_session');

session_start(); ?>
<?php include_once("./templates/top.php"); ?>
<?php include_once("./templates/navbar.php"); ?>

<style>
.card:nth-child(1) .card-header {
    background: linear-gradient(87deg, #b9c3cd 0, #b9c3cd 80%);
}

.card:nth-child(2) .card-header {
    background: linear-gradient(87deg, #a7d1a2 0, #a7d1a2 80%);
}

.card:nth-child(3) .card-header {
    background: linear-gradient(87deg, #a6c7ff 0, #a6c7ff 80%);
}

.card:nth-child(4) .card-header {
    background: linear-gradient(87deg, #77a9f8 0, #77a9f8 80%);
}
    .card {
  position: relative;
  display: flex;
  flex-direction: column;
  min-width: 0;
  word-wrap: break-word;
  background-color: #fff;
  background-clip: border-box;
  border: 0 solid rgba(0, 0, 0, 0.125);
  border-radius: 0.75rem; }
  .card > hr {
    margin-right: 0;
    margin-left: 0; }
  .card > .list-group {
    border-top: inherit;
    border-bottom: inherit; }
    .card > .list-group:first-child {
      border-top-width: 0;
      border-top-left-radius: 0.75rem;
      border-top-right-radius: 0.75rem; }
    .card > .list-group:last-child {
      border-bottom-width: 0;
      border-bottom-right-radius: 0.75rem;
      border-bottom-left-radius: 0.75rem; }
  .card > .card-header + .list-group,
  .card > .list-group + .card-footer {
    border-top: 0; }



.card-body {
  flex: 1 1 auto;
  padding: 1rem 1rem; }

.card-title {
  margin-bottom: 0.5rem; }

.card-subtitle {
  margin-top: -0.25rem;
  margin-bottom: 0; }

.card-text:last-child {
  margin-bottom: 0; }

.card-link + .card-link {
  margin-left: 1rem; }

.card-header {
  padding: 0.5rem 1rem;
  margin-bottom: 0;
  background-color: #fff;
  border-bottom: 0 solid rgba(0, 0, 0, 0.125); }
  .card-header:first-child {
    border-radius: 0.75rem 0.75rem 0 0; }


  .card-footer:last-child {
    border-radius: 0 0 0.75rem 0.75rem; }

.card-header-tabs {
  margin-right: -0.5rem;
  margin-bottom: -0.5rem;
  margin-left: -0.5rem;
  border-bottom: 0; }

</style>

<div class="container-fluid">
  <div class="row">



 
    
    <?php include "./templates/sidebar.php";
    include("./../functions.php");
    include("checkstatus.php");
    ?>


<div class="container">
  
<div class="row">
    <div class="col-10">
        <h2>DashBoard </h2>
    </div>
</div>

<div class="row">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-header p-3 pt-2">
             
              <div class="text-end pt-1">
                <h4 class="text-sm mb-0 text-capitalize">Customers</h4>
                <?php
                        $stmt = $conn -> prepare("SELECT COUNT(*) as total_user FROM `user` WHERE is_admin = 0");
                        $stmt -> execute();
                        $res = $stmt-> get_result();

                        if($res -> num_rows == 1){
                            $row = $res-> fetch_assoc();
                            $total_user = $row['total_user'];
                        }
                ?>
                <h4 class="mb-0"><?php echo $total_user ?></h4>
              </div>
            </div>
            <hr class="dark horizontal my-0">
            
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-header p-3 pt-2">
              
              <div class="text-end pt-1">
                <h4 class="text-sm mb-0 text-capitalize">Orders</h4>
                <?php
                        $stmt = $conn -> prepare("SELECT COUNT(*) as total_order FROM `order`");
                        $stmt -> execute();
                        $res = $stmt-> get_result();

                        if($res -> num_rows == 1){
                            $row = $res-> fetch_assoc();
                            $total_order = $row['total_order'];
                        }
                ?>
                
                <h4 class="mb-0"><?php echo $total_order ?></h4>
              </div>
            </div>
            <hr class="dark horizontal my-0">
           
          </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          <div class="card">
            <div class="card-header p-3 pt-2">
             
              <div class="text-end pt-1">
                <h4 class="text-sm mb-0 text-capitalize">Products</h4>
                <?php
                        $stmt = $conn -> prepare("SELECT COUNT(*) as total_product FROM `product`");
                        $stmt -> execute();
                        $res = $stmt-> get_result();

                        if($res -> num_rows == 1){
                            $row = $res-> fetch_assoc();
                            $total_product = $row['total_product'];
                        }
                ?>
                
                <h4 class="mb-0"><?php echo $total_product ?></h4>
                
              </div>
            </div>
            <hr class="dark horizontal my-0">
           
          </div>
        </div>
        <div class="col-xl-3 col-sm-6">
          <div class="card">
            <div class="card-header p-3 pt-2">
             
              <div class="text-end pt-1">
                <h4 class="text-sm mb-0 text-capitalize">Sales</h4>
                <?php 
                    $sql = "SELECT SUM(`order`.order_total_price) AS total_order_price
                    FROM `order`, `user`
                    WHERE   `order`.user_id = `user`.`user_id` AND `order`.`order_status` = 'Complete'";

                    $stmt = $conn -> prepare($sql);
                    $stmt -> execute();
                    $res = $stmt -> get_result();
                    if($res -> num_rows == 1){
                        $row = $res -> fetch_assoc();
                        $sales = $row['total_order_price'];
                    }

                ?>
                <h4 class="mb-0">$<?php echo $sales ?></h4>
              </div>
            </div>
            <hr class="dark horizontal my-0">
            
          </div>
        </div>
      </div>


<br><br>
<div class="row">
  <div class="col-10">
  <h5><i class="fas fa-filter"></i> Filter</h5>
        <hr>
  </div>

</div>

<form action="show_report_filter.php" method="post"> 
<div class="row">
  



  <div class="col-md-4 form-group date-check">
      <label for="fromDate1">From</label>
      <input type="date" id="fromDate1" name="fromDate1" class="form-control">
  </div>
  <div class="col-md-4 form-group date-check">
      <label for="toDate1">To</label>
      <input type="date" id="toDate1" name="toDate1" class="form-control">
  </div>
  


  
</div>

<div class="row">
<div class="col-md-4  ">
    <button type="submit" name="submit" class="btn btn-primary">Filter</button>
  </div>
</div>

</form>





       
      


<br><br>

  
  

  <div class="row" id="customer_report_list" >


  
  
</div>



  </div>
</div>
</div>


<?php include_once("./templates/footer.php"); ?>

<script>
    
$(document).on('click', '.page-link', function(e) {
    e.preventDefault(); // Ngăn chặn hành vi mặc định của trình duyệt

    var page = $(this).attr('href').split('page=')[1]; // Lấy số trang từ href

    // Thực hiện Ajax để tải dữ liệu mới
    $.ajax({
        url: 'show_report_filter.php?page=' + page,
        method: 'GET',
        success: function(data) {
            $("#customer_report_list").html(data); // Hiển thị dữ liệu mới
        }
    });
});

</script>
