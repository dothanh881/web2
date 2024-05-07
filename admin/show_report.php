<?php
session_name('admin_session');
session_start();
include("./../functions.php");









$order_per_page = 5;
$total_orders = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM (
    SELECT 
        `user`.user_id, 
        `user`.username, 
        `user`.email, 
        `user`.`phone_number`, 
        SUM(`order`.order_total_price) AS total_order_price
    FROM 
        `order`, 
        `user`
    WHERE   
        `order`.user_id = `user`.`user_id` 
        AND `order`.`order_status` = 'Complete'
    GROUP BY 
        user_id
) AS subquery
LIMIT 0, 25"));

$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($current_page - 1) * $order_per_page;
$total_pages = ceil($total_orders / $order_per_page);










$sql = "SELECT `user`.user_id, `user`.username , `user`.email, `user`.`phone_number`, 
SUM(`order`.order_total_price) AS total_order_price,
(SELECT COUNT(*) FROM `order` AS inner_order
WHERE inner_order.user_id = `order`.user_id
AND inner_order.order_status = 'Complete') AS amount_order
FROM `order`, `user`
WHERE   `order`.user_id = `user`.`user_id` AND `order`.`order_status` = 'Complete'
GROUP BY user_id
ORDER BY amount_order desc
LIMIT $order_per_page OFFSET $offset
";


$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$output = "";

if ($result -> num_rows > 0) {
    
    $output .= '<div class="table-responsive">
    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th scope="col">Customer </th>
                <th scope="col">Email</th>
                <th scope="col">Phone</th>
                <th scope="col">Orders Total</th>
                <th scope="col">Amount Order</th>
                <th scope="col">View</th>
            </tr>
        </thead>
        <tbody>';
  

    while ($row = $result->fetch_assoc()) {
        
        $output .=
        '<tr>
       <td>' . $row['username'] . '</td>
       <td>' . $row['email'] . '</td>
       <td>' . $row['phone_number'] . '</td>
       <td>$ ' . $row['total_order_price'] . '</td>
       <td>' . $row['amount_order'] . '</td>
       <td>
       <a href="orders_statistic.php?userId=' . $row['user_id'] . '" class="btn btn-primary">
                       <i class="far fa-eye"></i> View
                   </a>        
   </td>
   </tr>';
     
    }

    $output .= '</tbody>
    </table>
</div>';

// Hiển thị phân trang
$output .= '<div class="container">
<div class="row mt-3 d-flex justify-content-center ">
    <div class="col-12 d-flex justify-content-center">
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <li class="page-item ' . ($current_page == 1 ? 'disabled' : '') . '">
                    <a class="page-link" href="?page=1">First</a>
                </li>
                <li class="page-item ' . ($current_page == 1 ? 'disabled' : '') . '">
                    <a class="page-link" href="?page=' . ($current_page - 1) . '">Previous</a>
                </li>';

// Tạo các liên kết phân trang
for ($i = 1; $i <= $total_pages; $i++) {
    $output .= '<li class="page-item ' . ($current_page == $i ? 'active' : '') . '">
    <a class="page-link" href="?page=' . $i . '">' . $i . '</a>
</li>';
}

$output .= '<li class="page-item ' . ($current_page == $total_pages ? 'disabled' : '') . '">
<a class="page-link" href="?page=' . ($current_page + 1) . '">Next</a>
</li>
<li class="page-item ' . ($current_page == $total_pages ? 'disabled' : '') . '">
<a class="page-link" href="?page=' . $total_pages . '">Last</a>
</li>
</ul>
</nav></div>
</div>
</div>';


  

} else {
  // Hiển thị thông báo nếu không có dữ liệu
  $output .= "<tr><td colspan='7'>No data available</td></tr>";
}

echo $output;
?>
