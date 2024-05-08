<?php 
session_name('admin_session');

session_start(); ?>

<?php include_once("./templates/top.php"); ?>
<?php include_once("./templates/navbar.php"); ?>



<div class="container-fluid">
  <div class="row">
    
    <?php include "./templates/sidebar.php";
          include "./../functions.php";
    ?>
   <div class="container p-5">

<h4>Orders</h4>
<hr>


<br><br>


<?php





   if(isset($_GET['userId'])){

    $user_id = $_GET['userId'];
    $fromDate = isset($_GET['fromDate']) ? $_GET['fromDate'] : '';
$toDate = isset($_GET['toDate']) ? $_GET['toDate'] : '';


   
 $sql = "SELECT * FROM `order`
 WHERE  order_status = 'Complete' AND order_date BETWEEN ? AND  ? AND user_id  = ?  
ORDER BY order_total_price desc";

    $stmt = $conn->prepare($sql);
    
    
    $stmt -> bind_param("sss", $fromDate, $toDate, $user_id );
   
    if(!  $stmt->execute()){
     
    }
  

   
 
    $result = $stmt->get_result();
    $output = "";

 
    if($result->num_rows  > 0 ){


      $output = '
      <div class="row">
          <h5>From: '.$fromDate.'     To: '.$toDate.'</h5>
         
      </div>
      <br>
      <div class="row">

      <div class="table-responsive">
                         <table class="table table-striped table-sm">
                             <thead>
                                  <tr>
                                      <th scope="col">Order # </th>
                                      <th scope="col">Order Status</th>
                                      <th scope="col">Receiver</th>
                                      <th scope="col">Create On</th>
                                      <th scope="col">Total Orders</th>
                                      <th scope="col">Delivery Address</th>
                                      <th scope="col">View</th>
                                  </tr>
                             </thead>
                             <tbody >
      
                           ';
      
      while($orders = $result->fetch_object()){
    
        $output .= '<tr>
                       <th scope="row">' . $orders->order_id . '</th>
                       <td>' . $orders->order_status . '</td>
                       <td>' . $orders->fullname . '<br>' . $orders->email . '</td>
                       <td>' . $orders->order_date . '</td>
                       <td>$' . $orders->order_total_price . '</td>
                       <td>' . $orders->street . ', ' . $orders->ward . ', ' . $orders->district . ', ' . $orders->city . '</td>
                       <td>
                           <a href="edit_order.php?order=' . $orders->order_id . '" class="btn btn-primary">
                               <i class="far fa-eye"></i> View
                           </a>
                       </td>
                   </tr>';

      } 
  // \getdb

          $output .= '</tbody>
          </table>
        </div>';
        ?>




   


          
           

       


  <?php }
  }else{
    echo '<p class="empty">no success</p>';
  }

  echo $output;
  ?>
  
   
    </div>

  </div>
</div>


<?php include_once("./templates/footer.php"); ?>
