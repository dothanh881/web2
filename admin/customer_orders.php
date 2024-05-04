<?php
session_name('admin_session');
session_start();


?>
<?php include_once("./templates/top.php"); ?>
<?php include_once("./templates/navbar.php"); 
    include("./../functions.php");

?>
  <?php include "./templates/sidebar.php"; ?>

<div class="container">
  
<div class="row">
    <div class="col-10">
        <h2>Order Management</h2>
    </div>
</div>

<div class="row">
    <div class="col-md-6 col-lg-4 form-group date-check">
        <label for="datefrom">From</label>
        <input type="date" id="datefrom" name="datefrom" class="form-control">
    </div>
    <div class="col-md-6 col-lg-4 form-group date-check">
        <label for="dateto">To</label>
        <input type="date" id="dateto" name="dateto" class="form-control">
    </div>
</div>

<div class="row">
    <div class="col-md-6 col-lg-4 search-p " >
        <div id="DataTables_Table_0_filter" class="dataTables_filter">
            <label>
                <select  class="form-control" onchange="selectdata(this.options[this.selectedIndex].value);" >
                    <option value="select">Order Status</option>
                    <option value="pending">Pending</option>
                    <option value="processing">Processing</option>
                    <option value="complete">Complete</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </label>
        </div>
    </div>

    <div class="col-md-6 col-lg-4 search-p">
        <div id="DataTables_Table_1_filter" class="dataTables_filter">
            <label>
                <select id="myInput2" class="form-control"   aria-controls="DataTables_Table_1">
                    <option value="All">Select all</option>
                    <option value="district1">District 1</option>
                    <option value="district2">District 2</option>
                    <option value="district3">District 3</option>
                    <option value="district4">District 4</option>
                    <option value="district5">District 5</option>
                    <option value="district6">District 6</option>
                    <option value="district7">District 7</option>
                    <option value="district8">District 8</option>
                    <option value="district9">District 9</option>
                    <option value="district10">District 10</option>
                    <option value="district11">District 11</option>
                    <option value="district12">District 12</option>
                    <option value="TanPhu">Tan Phu</option>
                    <!-- Thêm các tùy chọn khác tương ứng với các quận bạn muốn lọc -->
                </select>
            </label>
        </div>
    </div>
</div>


       
      


<br><br>

  
  <div class="row">
    

  
  

      
      <div class="table-responsive">
        <table class="table table-striped table-sm">
          <thead>
            <tr>
			<th scope="col">Order #</th>
      <th scope="col">Order Status</th>
      <th scope="col">Customer</th>
      <th scope="col">Created On</th>
      <th scope="col">Order Total</th>
      <th scope="col">Address</th>
      <th scope="col">View</th>
            </tr>
          </thead>
          <tbody id="customer_order_list">
           
          </tbody>
        </table>
      </div>
    </main>
  </div>
</div>





<?php include_once("./templates/footer.php"); ?>



