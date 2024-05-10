
<?php 
include('header.php');
?>
<?php 

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
 }else{
    $user_id = '';

    header('location:login.php');   
 }; 



 



?>

<br>
<br><br> 
<br>
<div class="container ">
			
<div class="row">
  <div class="col-10">
  <h5><i class="fas fa-info"></i> Filter</h5>
      <br>
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

        <div class=" col-md-6 col-lg-3 search-p ">
        <div id="DataTables_Table_0_filter" class="dataTables_filter">
            <label>
                <select  id="myInput2" name="selectedStatus"  class="form-control"  >
                    <option value="select">Filter Order Status here</option>
                    <option value="Pending">Pending</option>
                    <option value="Processing">Processing</option>
                    <option value="Complete">Complete</option>
                    <option value="Cancelled">Cancelled</option>
                </select>
            </label>
        </div>
          
        </div>

      
       
      </div>
</div>
      <br>
    

<div class="container">
   <div class="row" id="order_list">
   
   </div>
</div>





<br><br>









<?php
include("footer.php");
?>
<script>
    
$(document).on('click', '.page-link', function(e) {
    e.preventDefault(); // Ngăn chặn hành vi mặc định của trình duyệt

    var page = $(this).attr('href').split('page=')[1]; // Lấy số trang từ href

    // Thực hiện Ajax để tải dữ liệu mới
    $.ajax({
        url: 'show-data.php?page=' + page,
        method: 'GET',
        success: function(data) {
            $("#order_list").html(data); // Hiển thị dữ liệu mới
        }
    });
});

</script>
