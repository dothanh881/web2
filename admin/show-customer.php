<?php
session_name('admin_session');
session_start();
include("./../functions.php");

$status = isset($_GET['selectedStatus']) ? $_GET['selectedStatus'] : 'select';
$searchbox = isset($_GET['searchName']) ? $_GET['searchName'] : '';


//paging nav

$customers_per_page = 4;
  

$total_customers = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `user` WHERE is_admin = 0"));




// Kiểm tra xem session đã lưu trữ giá trị current_page hay chưa
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;

$offset = ($current_page - 1) * $customers_per_page;
$sql = "SELECT * FROM `user` WHERE is_admin = 0  ";


$filter = [];
   if( $status !== 'select'){

      $filter[] = "`status` =  '$status'";

   }
    
   if ($searchbox !== ''){
    $filter[] = " fullname LIKE  '%$searchbox%'";
 }
    
   if(!empty($filter)){
    
    $sql .= " AND " . implode(' AND ', $filter) ; 


   }


   $sql .= " LIMIT $customers_per_page OFFSET $offset";
 

if (!empty($filter)) {
    $sql_count = "SELECT COUNT(*) as total FROM  `user` WHERE is_admin = 0 AND " . implode(' AND ', $filter);
    $result_count = mysqli_query($conn, $sql_count);
    $row_count = mysqli_fetch_assoc($result_count);
    $total_filtered_customers = $row_count['total'];
    $total_pages = ceil($total_filtered_customers / $customers_per_page);
} else {
    $total_pages = ceil($total_customers / $customers_per_page);
}






$stmt = $conn ->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$output = "";

if ($result->num_rows > 0) {
   $output .= '<div class="table-responsive">
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
     <tbody >';

   // displays dữ liệu đơn hàng
   while ($cust = $result->fetch_object()) {
    $output .= '<tr>
    <td>'. $cust->fullname .'</td>
    <td>'.  $cust->email .'</td>
    <td>'. $cust->phone_number .'</td>
    <td>';

    // Check status and generate appropriate button
    if($cust->status == 1) {
        $output .= '<p><a href="active.php?user_id='.$cust->user_id.'&status=0" class="btn btn-success"><i class="fas fa-lock-open"></i>&nbsp;&nbsp;Active</a></p>';
    } else {
        $output .= '<p><a href="active.php?user_id='.$cust->user_id.'&status=1" class="btn btn-danger"><i class="fas fa-lock"></i>&nbsp;Inactive</a></p>';
    }

    $output .= '</td>
    <td>
        <a href="edit_customer.php?customer='.$cust->user_id.'" class="btn btn-sm btn-primary"><i class="far fa-eye"></i>&nbsp;&nbsp;View</a>
    </td>
  </tr>';
}

   $output .= '</tbody>
               </table>
           </div>';

   //  phân trang
   $output .= '<div class="container">
   <div class="row mt-3 d-flex justify-content-center ">
       <div class="col-12 d-flex justify-content-center">
           <nav aria-label="Page navigation">
               <ul class="pagination justify-content-center">
                   <li class="page-item ' . ($current_page == 1 ? 'disabled' : '') . '">
                       <a class="page-link" href="?page=1' . ($status != 'select' ? '&selectedStatus=' . $status : '')  . ($searchbox !='' ? '&searchName=' .$searchbox : '' ).'" tabindex="-1">First</a>
                   </li>
                   <li class="page-item ' . ($current_page == 1 ? 'disabled' : '') . '">
                       <a class="page-link" href="' . ($current_page == 1 ? '#' : '?page=' . ($current_page - 1) . ($status != 'select' ? '&selectedStatus=' . $status : '')  . ($searchbox !='' ? '&searchName=' .$searchbox : '' )). '">Previous</a>
                   </li>';
for ($i = 1; $i <= $total_pages; $i++) {
   $output .= '<li class="page-item ' . ($current_page == $i ? 'active' : '') . '">
       <a class="page-link" href="?page=' . $i . ($status != 'select' ? '&selectedStatus=' . $status : '')  . ($searchbox !='' ? '&searchName=' .$searchbox : '' ). '">' . $i . '</a>
   </li>';
}

$output .= '<li class="page-item ' . ($current_page == $total_pages ? 'disabled' : '') . '">
   <a class="page-link" href="' . ($current_page == $total_pages ? '#' : '?page=' . ($current_page + 1) . ($status != 'select' ? '&selectedStatus=' . $status : '')  . ($searchbox !='' ? '&searchName=' .$searchbox : '' )). '">Next</a>
</li>
<li class="page-item ' . ($current_page == $total_pages ? 'disabled' : '') . '">
   <a class="page-link" href="?page=' . $total_pages . ($status != 'select' ? '&selectedStatus=' . $status : '')   . ($searchbox !='' ? '&searchName=' .$searchbox : '' ). '">Last</a>
</li>
</ul>
</nav></div>
</div>
</div>';
}else{
   echo '
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
                       <tbody>
                     <tr><td class="text-center"  colspan="7">No data available</td></tr>
                     </tbody>
               </table>
           </div>

   ';
}
echo $output;

    ?>
<script>
    
    $(document).on('click', '.page-link', function(e) {
        e.preventDefault(); 
    
        var page = $(this).attr('href').split('page=')[1]; // Lấy  trang từ href
    
        $.ajax({
            url: 'show-customer.php?page=' + page,
            method: 'GET',
            success: function(data) {
                $("#customer-list").html(data);
            }
        });
    });
    
    </script>
    