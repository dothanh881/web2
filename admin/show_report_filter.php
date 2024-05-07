<?php
session_name('admin_session');
session_start();
include("./../functions.php");

$fromDate = isset($_GET['fromDate']) ? $_GET['fromDate'] : '';
$toDate = isset($_GET['toDate']) ? $_GET['toDate'] : '';

$sql = "SELECT `user`.user_id, `user`.username , `user`.email, `user`.`phone_number`, 
SUM(`order`.order_total_price) AS total_order_price,
(SELECT COUNT(*) FROM `order` AS inner_order
 WHERE inner_order.user_id = `order`.user_id
   AND inner_order.order_status = 'Complete') AS amount_order
FROM `order`, `user`
WHERE   `order`.user_id = `user`.`user_id` AND `order`.`order_status` = 'Complete'
";

$filter = [];

if ($fromDate !== $toDate){
    $filter[] = "`order_date` BETWEEN '$fromDate' AND '$toDate'";
 }

 if(!empty($filter)){
    
    $sql .= " AND " . implode(' AND ', $filter) ; 
    
    

   }

   $sql .= " GROUP BY user_id
            ORDER BY amount_order desc
            LIMIT 5";



$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
$output = '';

if ($result->num_rows > 0) {

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

} else {
    // Hiển thị thông báo nếu không có dữ liệu
    $output .= "<tr><td colspan='7'>No data available</td></tr>";
}
echo $output;
?>
