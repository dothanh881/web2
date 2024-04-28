<?php 





function checkStatus($id)
    
{
  include("./../connect.php");

    $query = "SELECT item_status FROM `product` WHERE item_id = ?";

    $stmt = $conn->prepare($query);
    $stmt ->bind_param('i', $id);
    $stmt ->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
   
      $row = $result->fetch_assoc();
      $status = $row['item_status'];
     
      return $status;
  } else {
     
      return "Product not found";
  }
  
}



?>