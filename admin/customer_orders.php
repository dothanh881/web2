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

<br><br>
<div class="row">
  <div class="col-10">
  <h5><i class="fas fa-info"></i> Filter</h5>
        <hr>
  </div>

</div>


<div class="row">
    <div class="col-md-6 col-lg-4 form-group date-check">
        <label for="fromDate">From</label>
        <input type="date" id="fromDate" name="fromDate" class="form-control">
    </div>
    <div class="col-md-6 col-lg-4 form-group date-check">
        <label for="toDate">To</label>
        <input type="date" id="toDate" name="toDate" class="form-control">
    </div>
</div>

<div class="row">
    <div class="col-md-6 col-lg-4 search-p " >
        <div id="DataTables_Table_0_filter" class="dataTables_filter">
            <label>
                <select  id="myInput2" name="selectedStatus"  class="form-control"  >
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
                <select class="form-control" name="selectedDistrict" id="myInput1"   aria-controls="DataTables_Table_1">
                    <option value="All">All district</option>
                    <option value="district 1">District 1</option>
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
                    <!-- Thêm các tùy chọn khác tương ứng với các quận bạn muốn lọc -->
                </select>
            </label>
        </div>
    </div>
</div>


       
      


<br><br>

  
  

  <div class="row" id="customer_order_list">
    
    
  </div>

  
</div>
<br><br>



<?php include_once("./templates/footer.php"); ?>

<script>
    
$(document).on('click', '.page-link', function(e) {
    e.preventDefault(); // Ngăn chặn hành vi mặc định của trình duyệt

    var page = $(this).attr('href').split('page=')[1]; // Lấy số trang từ href

    // Thực hiện Ajax để tải dữ liệu mới
    $.ajax({
        url: 'show-data.php?page=' + page,
        method: 'GET',
        success: function(data) {
            $("#customer_order_list").html(data); // Hiển thị dữ liệu mới
        }
    });
});

</script>

