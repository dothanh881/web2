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
    
        <h2>Customers</h2>
      </div>
    </div>

    <br><br>
    <div class="row">
  <div class="col-10">
  <h5><i class="fas fa-filter"></i> Filter</h5>
        <hr>
  </div>

</div>
    <div class="row">
    <div class="col-md-6 col-lg-4 search-p " >
        <div id="DataTables_Table_0_filter" class="dataTables_filter">
            <label>
                <select  id="statusFilterCustomer" name="selectedStatusCustomer"  class="form-control"  >
                    <option value="select">Filter Status Customer</option>
                    <option value="0">0 (Inactive - Blocked)</option>
                    <option value="1">1 (Active)</option>
                 
                   
                </select>
            </label>
        </div>
    </div>
    </div>

    <br>    <hr>
    <div class="row">
  <div class="col-10">
  <h5><i class="fas fa-search"></i> Search</h5>
    
  </div>

</div>

<form id="searchFormCustomer" action="show-customer.php" method="get">
<div class="row">
  <div class="col-md-4">
  <input type="text" name="search_box_customer" placeholder="Search name's customer here..." class="form-control " id="search">
  </div>
  <div class="col-md-2"> 
                      <button class="btn btn-primary" type="submit" name="search_box_customer" id="search_box_customer"><i class="fas fa-search"></i> Search</button>
</div>
</div>

</form>

    <br><br>

<div class="row" id="customer-list">

</div>


   

<?php include("./templates/footer.php"); ?>
