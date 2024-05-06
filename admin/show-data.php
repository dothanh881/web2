<?php
session_name('admin_session');
session_start();
include("./../functions.php");

$status = isset($_POST['selectedStatus']) ? $_POST['selectedStatus'] : 'select';
$district = isset($_POST['selectedDistrict']) ? $_POST['selectedDistrict'] : 'All';
$fromDate = isset($_POST['fromDate']) ? $_POST['fromDate'] : '';
$toDate = isset($_POST['toDate']) ? $_POST['toDate'] : '';

//paging nav

$order_per_page = 4;
  



$current_page = isset($_GET['page']) ? $_GET['page'] : 1;

$offset = ($current_page - 1) * $order_per_page;
$sql = "SELECT * FROM `order`   ";

$filter = [];
   if( $status !== 'select'){

      $filter[] = "`order_status` =  '$status'";

   }
    if ($district !== 'All'){
      $filter[] = "`district` =  '$district'";
   }
    if ($fromDate !== $toDate){
      $filter[] = "`order_date` BETWEEN '$fromDate' AND '$toDate'";
   }
   if(!empty($filter)){
      $sql .= " WHERE " . implode(' AND ', $filter) ; 
   }


   $sql .= " LIMIT $order_per_page OFFSET $offset";




$total_orders = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `order`"));

if (!empty($filter)) {
    $total_filtered_order = mysqli_num_rows(mysqli_query($conn, $sql));
    $total_pages = ceil($total_filtered_order / $order_per_page);
   
} else {
    $total_pages = ceil($total_orders / $order_per_page);
}
// Hiển thị giá trị của total_pages trước và sau khi filter
echo 'Total Pages after filter: ' . $total_pages;

$stmt = $conn ->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$output = "";

if ($result->num_rows > 0) {
   $output .= '<div class="table-responsive">
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
                       <tbody>';

   // Hiển thị dữ liệu đơn hàng
   while ($order = $result->fetch_object()) {
       $output .= '<tr>
                       <th scope="row">' . $order->order_id . '</th>
                       <td>' . $order->order_status . '</td>
                       <td>' . $order->fullname . '<br>' . $order->email . '</td>
                       <td>' . $order->order_date . '</td>
                       <td>$' . $order->order_total_price . '</td>
                       <td>' . $order->street . ', ' . $order->district . ', ' . $order->city . '</td>
                       <td>
                           <a href="edit_order.php?order=' . $order->order_id . '" class="btn btn-primary">
                               <i class="far fa-eye"></i> View
                           </a>
                       </td>
                   </tr>';
   }

   $output .= '</tbody>
               </table>
           </div>';

   // Hiển thị phân trang
   $output .= '   <div class="container">

   <div class="row mt-3 d-flex justify-content-center ">
   <div class="col-12  d-flex justify-content-center">
   <nav aria-label="Page navigation">
   <ul class="pagination justify-content-center">
       <li class="page-item ' . ($current_page == 1 ? 'disabled' : '') . '">
           <a class="page-link" href="?page=1" tabindex="-1">First</a>
       </li>
       <li class="page-item ' . ($current_page == 1 ? 'disabled' : '') . '">
           <a class="page-link" href="' . ($current_page == 1 ? '#' : '?page=' . ($current_page - 1)) . '">Previous</a>
       </li>';
for ($i = 1; $i <= $total_pages; $i++) {
$output .= '<li class="page-item ' . ($current_page == $i ? 'active' : '') . '">
       <a class="page-link" href="?page=' . $i . '">' . $i . '</a>
   </li>';

}
$output .= '<li class="page-item ' . ($current_page == $total_pages ? 'disabled' : '') . '">
   <a class="page-link" href="' . ($current_page == $total_pages ? '#' : '?page=' . ($current_page + 1)) . '">Next</a>
</li>
<li class="page-item ' . ($current_page == $total_pages ? 'disabled' : '') . '">
   <a class="page-link" href="?page=' . $total_pages . '">Last</a>
</li>
</ul>
</nav></div>
           
       </div>
   </div>
   

       ';
}else{
   echo '
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
                       <tbody>
                     <tr><td class="text-center"  colspan="7">No data available</td></tr>
                     </tbody>
               </table>
           </div>

   ';
}
echo $output;

    ?>
