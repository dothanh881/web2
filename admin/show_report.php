<?php
session_name('admin_session');
session_start();
include("./../functions.php");

$total_price = array(); // Mảng để lưu trữ tổng giá trị đơn hàng của từng user_id
$total_amount = 0; // Khởi tạo biến tổng số đơn hàng

$sql = "SELECT `user`.user_id, `user`.username , `user`.email, `user`.`phone_number`, 
SUM(`order`.order_total_price) AS total_order_price,
(SELECT COUNT(*) FROM `order` AS inner_order
 WHERE inner_order.user_id = `order`.user_id
   AND inner_order.order_status = 'Complete') AS amount_order
FROM `order`, `user`
WHERE   `order`.user_id = `user`.`user_id` AND `order`.`order_status` = 'Complete'
GROUP BY user_id;";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $user_id = $row['user_id'];
        $username = $row['username'];
        $email = $row['email'];
        $phone_number = $row['phone_number'];
        $order_total_price = $row['total_order_price'];
        $amount_order = $row['amount_order'];

      
?>

        <tr>
            <td> <?php echo $username  ?></td>
            <td> <?php echo $email  ?></td>
            <td> <?php echo $phone_number  ?></td>
            <td> <?php echo $order_total_price  ?></td>
            <td> <?php echo $amount_order  ?></td>
            <td>
            <a href="orders_statistic.php?userId=<?= $user_id ?> " class="btn btn-primary">
                               <i class="far fa-eye"></i> View
                           </a>        
        </td>
           
        </tr>
        <?php
    }
} else {
    // Hiển thị thông báo nếu không có dữ liệu
    echo "<tr><td colspan='7'>No data available</td></tr>";
}
?>
