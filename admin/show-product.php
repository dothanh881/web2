<?php
session_name('admin_session');
session_start();
include("./../functions.php");

$status = isset($_GET['selectedStatus']) ? $_GET['selectedStatus'] : 'select';
$category = isset($_GET['selectedCategory']) ? $_GET['selectedCategory'] : 'select';
$searchbox = isset($_GET['searchName']) ? $_GET['searchName'] : '';


//paging nav

$products_per_page = 6;
  

$total_products = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `product`"));
// Khi người dùng thực hiện truy vấn mới
// Khi người dùng thực hiện truy vấn mới
$current_page = isset($_GET['page']) ? $_GET['page'] : 1;


$offset = ($current_page - 1) * $products_per_page;
$sql = "SELECT * FROM `product`, `category` WHERE `product`.category_id = `category`.category_id   ";


$filter = [];
   if( $status !== 'select'){

      $filter[] = "`item_status` =  '$status'";

   }
    if ($category !== 'select'){
      $filter[] = "`category`.`category_name` =  '$category'";

   }
   if ($searchbox !== ''){
    $filter[] = "`product`.`item_name` LIKE  '%$searchbox%'";

 }
    
   if(!empty($filter)){
    
    $sql .= " AND " . implode(' AND ', $filter) ; 


   }


   $sql .= " LIMIT $products_per_page OFFSET $offset";
 

if (!empty($filter)) {
    $sql_count = "SELECT COUNT(*) as total FROM `product`,`category` WHERE `product`.category_id = `category`.category_id AND " . implode(' AND ', $filter);
    $result_count = mysqli_query($conn, $sql_count);
    $row_count = mysqli_fetch_assoc($result_count);
    $total_filtered_products = $row_count['total'];
    $total_pages = ceil($total_filtered_products / $products_per_page);
} else {
    $total_pages = ceil($total_products / $products_per_page);
}






$stmt = $conn ->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$output = "";

if ($result->num_rows > 0) {
   $output .= ' <div class="table-responsive">
   <table class="table table-striped table-sm">
     <thead>
       <tr>
       
         <th>Image</th>
         <th>Name</th>
         <th>Price</th>
         <th>Status</th>
         <th>Quantity</th> 
         <th>Action</th>
       </tr>
     </thead>
     <tbody>';

   // displays dữ liệu đơn hàng
   while ($product = $result->fetch_object()) {
    $output .= '<tr>
    <td><img height="100px" src="./../'.$product->item_image.'"></td>
    <td>'.$product->item_name.'</td>
    <td>$'.$product->item_price.'</td>
    <td>'.$product->item_status.'</td>
    <td>'.$product->item_quantity.'</td>
    <td>
        <a href="editproduct.php?update='.$product->item_id.'" class="btn btn-sm btn-info"><i class="far fa-eye"> </i>&nbsp; View</a>
        <a href="products.php?delete='.$product->item_id.'" onclick="return confirm(\'Delete this product?\');" class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"> </i>&nbsp;&nbsp;Delete</a>
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
                        <a class="page-link" href="?page=1' . ($status != 'select' ? '&selectedStatus=' . $status : '') . ($category != 'select' ? '&selectedCategory=' . $category : '')  . ($searchbox !='' ? '&searchName=' .$searchbox : '' ).'" tabindex="-1">First</a>
                    </li>
                    <li class="page-item ' . ($current_page == 1 ? 'disabled' : '') . '">
                        <a class="page-link" href="' . ($current_page == 1 ? '#' : '?page=' . ($current_page - 1) . ($status != 'select' ? '&selectedStatus=' . $status : '') . ($category != 'select' ? '&selectedCategory=' . $category : '') ) . ($searchbox !='' ? '&searchName=' .$searchbox : '' ). '">Previous</a>
                    </li>';
    for ($i = 1; $i <= $total_pages; $i++) {
    $output .= '<li class="page-item ' . ($current_page == $i ? 'active' : '') . '">
        <a class="page-link" href="?page=' . $i . ($status != 'select' ? '&selectedStatus=' . $status : '') . ($category != 'select' ? '&selectedCategory=' . $category : '') . ($searchbox !='' ? '&searchName=' .$searchbox : '' ). '">' . $i . '</a>
    </li>';
    }

    $output .= '<li class="page-item ' . ($current_page == $total_pages ? 'disabled' : '') . '">
    <a class="page-link" href="' . ($current_page == $total_pages ? '#' : '?page=' . ($current_page + 1) . ($status != 'select' ? '&selectedStatus=' . $status : '') . ($category != 'select' ? '&selectedCategory=' . $category : '') ) . ($searchbox !='' ? '&searchName=' .$searchbox : '' ). '">Next</a>
    </li>
    <li class="page-item ' . ($current_page == $total_pages ? 'disabled' : '') . '">
    <a class="page-link" href="?page=' . $total_pages . ($status != 'select' ? '&selectedStatus=' . $status : '') . ($category != 'select' ? '&selectedCategory=' . $category : '')  . ($searchbox !='' ? '&searchName=' .$searchbox : '' ). '">Last</a>
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
            url: 'show-product.php?page=' + page,
            method: 'GET',
            success: function(data) {
                $("#product-list").html(data);
            }
        });
    });
    
    </script>
    