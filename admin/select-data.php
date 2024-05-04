<?php
session_name('admin_session');
session_start();
include("./../functions.php");

$status = $_POST['status'];

// Sử dụng prepared statement để tránh lỗ hổng SQL injection
$stmt = null;
if ($status == 'select' || empty($status)) {
    $stmt = $conn->prepare("SELECT * FROM `order`");
} else {
    $stmt = $conn->prepare("SELECT * FROM `order` WHERE order_status = ?");
    $stmt->bind_param("s", $status);
}

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($order = $result->fetch_object()) {
?>
        <tr>
            <th scope="row">#<?php echo $order->order_id ?></th>
            <td><?php echo $order->order_status ?></td>
            <td><?php echo $order->fullname ?><br><?php echo $order->email ?></td>
            <td><?php echo $order->order_date ?></td>
            <td>$<?php echo $order->order_total_price ?></td>
            <td><?php echo $order->street . ", " . $order->district . ", " . $order->city ?></td>
            <td><a href="edit_order.php?order=<?php echo $order->order_id ?>" class="btn btn-primary"><i class="far fa-eye"></i> View</a></td>
        </tr>
<?php
    }
} else {
    // Hiển thị thông báo nếu không có dữ liệu
    echo "<tr><td colspan='7'>No data available</td></tr>";
}
?>
