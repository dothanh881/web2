<?php
session_name('customer_session');
session_start();
include("./functions.php");

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
};

$status = isset($_GET['selectedStatus']) ? $_GET['selectedStatus'] : 'select';
$fromDate = isset($_GET['fromDate']) ? $_GET['fromDate'] : '';
$toDate = isset($_GET['toDate']) ? $_GET['toDate'] : '';

//paging nav
$order_per_page = 8;

$sql1 = "SELECT * FROM `order` WHERE user_id = ?";
$stmt_count = $conn->prepare($sql1);
$stmt_count->bind_param("s", $user_id);
$stmt_count->execute();
$result_count = $stmt_count->get_result();
$total_orders = $result_count->num_rows;

$current_page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($current_page - 1) * $order_per_page;
$sql = "SELECT * FROM `order`";

$filter = [];
if($status !== 'select') {
    $filter[] = "order_status = '$status'";
}
if($fromDate !== $toDate) {
    $filter[] = "order_date BETWEEN '$fromDate' AND '$toDate'";
}
if(!empty($filter)) {
    $sql .= " WHERE " . implode(' AND ', $filter) . " AND user_id = ?";
} else {
    $sql .= " WHERE user_id = ?";
}

$sql .= " LIMIT $order_per_page OFFSET $offset";

if (!empty($filter)) {
    $sql_count = "SELECT COUNT(*) as total FROM `order` WHERE " . implode(' AND ', $filter) . " AND user_id = ?";
    $stmt_count = $conn->prepare($sql_count);
    $stmt_count->bind_param("s", $user_id);
    $stmt_count->execute();
    $result_count = $stmt_count->get_result();
    $row_count = $result_count->fetch_assoc();
    $total_filtered_order = $row_count['total'];
    $total_pages = ceil($total_filtered_order / $order_per_page);
} else {
    $total_pages = ceil($total_orders / $order_per_page);
}

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_id);
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
                               <th scope="col">Created On</th>
                               <th scope="col">Order Total</th>
                               <th scope="col">Detail</th>
                           </tr>
                       </thead>
                       <tbody>';

    // Hiển thị dữ liệu đơn hàng
    while ($order = $result->fetch_object()) {
        $output .= '<tr>
                       <th scope="row">' . $order->order_id . '</th>
                       <td>' . $order->order_status . '</td>
                       <td>' . $order->order_date . '</td>
                       <td>$' . $order->order_total_price . '</td>
                       <td>
                           <a href="order-detail.php?order=' . $order->order_id . '" class="btn btn-primary">
                               <i class="far fa-eye"></i> View
                           </a>
                       </td>
                   </tr>';
    }
    // a

    $output .= '</tbody>
               </table>
           </div>';

    // Phân trang
    $output .= '<div class="container">
                    <div class="row mt-3 d-flex justify-content-center ">
                        <div class="col-12 d-flex justify-content-center">
                            <nav aria-label="Page navigation">
                                <ul class="pagination justify-content-center">
                                    <li class="page-item ' . ($current_page == 1 ? 'disabled' : '') . '">
                                        <a class="page-link" href="?page=1' . ($status != 'select' ? '&selectedStatus=' . $status : '') . ($fromDate != '' && $toDate != '' ? '&fromDate=' . $fromDate . '&toDate=' . $toDate : '') . '" tabindex="-1">First</a>
                                    </li>
                                    <li class="page-item ' . ($current_page == 1 ? 'disabled' : '') . '">
                                        <a class="page-link" href="' . ($current_page == 1 ? '#' : '?page=' . ($current_page - 1) . ($status != 'select' ? '&selectedStatus=' . $status : '') . ($fromDate != '' && $toDate != '' ? '&fromDate=' . $fromDate . '&toDate=' . $toDate : '')) . '">Previous</a>
                                    </li>';

    for ($i = 1; $i <= $total_pages; $i++) {
        $output .= '<li class="page-item ' . ($current_page == $i ? 'active' : '') . '">
                        <a class="page-link" href="?page=' . $i . ($status != 'select' ? '&selectedStatus=' . $status : '') . ($fromDate != '' && $toDate != '' ? '&fromDate=' . $fromDate . '&toDate=' . $toDate : '') . '">' . $i . '</a>
                    </li>';
    }

    $output .= '<li class="page-item ' . ($current_page == $total_pages ? 'disabled' : '') . '">
                    <a class="page-link" href="' . ($current_page == $total_pages ? '#' : '?page=' . ($current_page + 1) . ($status != 'select' ? '&selectedStatus=' . $status : '') . ($fromDate != '' && $toDate != '' ? '&fromDate=' . $fromDate . '&toDate=' . $toDate : '')) . '">Next</a>
                </li>
                <li class="page-item ' . ($current_page == $total_pages ? 'disabled' : '') . '">
                    <a class="page-link" href="?page=' . $total_pages . ($status != 'select' ? '&selectedStatus=' . $status : '') . ($fromDate != '' && $toDate != '' ? '&fromDate=' . $fromDate . '&toDate=' . $toDate : '') . '">Last</a>
                </li>
            </ul>
        </nav>
    </div>
</div>
</div>';
} else {
    echo '<div class="table-responsive">
              <table class="table table-striped table-sm">
                  <thead>
                      <tr>
                          <th scope="col">Order #</th>
                          <th scope="col">Order Status</th>
                          <th scope="col">Created On</th>
                          <th scope="col">Order Total</th>
                          <th scope="col">Detail</th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr><td class="text-center"  colspan="7">No data available</td></tr>
                  </tbody>
              </table>
          </div>';
}
echo $output;
?>
