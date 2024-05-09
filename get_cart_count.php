<?php
// get_cart_count.php
session_name('customer_session');

session_start();
include('functions.php');
include('code-generator.php');

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
  
    
} else {
    $user_id = '';
}



if (isset($_POST['pid'])) {
    if ($user_id == '') {
        echo "<script>
            alert('Login, please!');
        </script>";
    } else {
        $pid = $_POST['pid'];
        $name = $_POST['name'];
        $price = $_POST['price'];
        $qty = $_POST['qty'];
        $image = $_POST['image'];

        $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE item_id = ? AND user_id = ?");
        $check_cart_numbers->bind_param("is", $pid, $user_id);
        $check_cart_numbers->execute();
        $check_cart_numbers->store_result();

        if ($check_cart_numbers->num_rows > 0) {
            
                 echo '<div id="alertMessage" class="alert alert-danger alert-dismissible fade show " role="alert">
                 <strong class="text-dark">Item already added to your cart!</strong>
                 <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                   <span aria-hidden="true">&times;</span>
                 </button>
               </div>';
     
        } else {
            $check_cart_numbers->close();

            $insert_cart = $conn->prepare("INSERT INTO `cart`(user_id, item_id, cart_quantity, cart_price, name, cart_image) VALUES(?,?,?,?,?,?)");
            $insert_cart->bind_param("siidss", $user_id, $pid, $qty, $price, $name, $image);
            try {
                $insert_cart->execute();
                echo '<div id="alertMessage" class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>Item added to your cart!</strong> 
                      </div>';
            } catch (mysqli_sql_exception $e) {
                echo 'An error occurred: ' . $e->getMessage();
               
            }
        }
    }
}

    if(isset($_GET['cartItem']) && isset($_GET['cartItem']) == 'cart-item' ){
        $stmt = $conn->prepare("SELECT * FROM cart where user_id = ?");
        $stmt ->bind_param("s", $user_id);
        $stmt ->execute();
        $stmt ->store_result();
        $rows = $stmt->num_rows;

        echo $rows;
    }

    if(isset($_GET['clear'])){
        $stmt = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
        $stmt -> bind_param("s", $user_id);
        $stmt -> execute();
        $_SESSION['showAlert'] = 'block';
        $_SESSION['message'] = 'All Item removed from the cart';
        header("location: cart.php");
    }

    function input_filter($data){
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
      }

    if(isset($_POST['action']) && isset($_POST['action']) == 'order'){
          // Kiểm tra session user_id
   
        $newName = input_filter($_POST['newFullname']);
        $newPhone = input_filter($_POST['newPhone']);
        $newEmail = input_filter($_POST['newEmail']);
        $newStreet = input_filter($_POST['newStreet']);
        $newCity = input_filter($_POST['newCity']);
        $newDistrict = input_filter($_POST['newDistrict']);
        $grand_total = input_filter($_POST['grand_total']);
        $orderid = input_filter($_POST['order_id']);
        $payment_method = isset($_POST['payment']) ? $_POST['payment'] : '';
        $address_checked = isset($_POST['address']) ? $_POST['address'] : '';
        $newWard = $_POST['new_Ward'];
        $allItems = input_filter($_POST['allItems']);

        $data ='';


        if( empty($newName)){


         
            $sql = "SELECT * FROM `user` WHERE user_id = ? AND is_admin = 0";
            $stmt = $conn->prepare($sql);
            $stmt -> bind_param("s", $user_id);
            $stmt -> execute();
            $result = $stmt -> get_result();
      

            if($result -> num_rows == 1){

                $row1= $result-> fetch_assoc();

                $query = " INSERT INTO `order` (order_id, user_id, order_total_price, method, city, district, street, fullname, email, phone_number, ward) VALUE(?,?,?,?,?,?,?,?,?,?,?)";

                $insert_order = $conn->prepare($query);
                $insert_order -> bind_param("ssdssssssss", $orderid, $user_id, $grand_total, $payment_method, $row1['city'], $row1['district'], $row1['street'], $row1['fullname'], $row1['email'] , $row1['phone_number'], $row1['ward'] );
               
               
               if(!empty($payment_method) && !empty($address_checked)){
                $insert_order -> execute();
               }
               
               
                   
            
                


              
                
                // INSERT DETAIL-order
                $sql1 = "SELECT item_id, cart_price, cart_quantity, name  FROM `cart` Where user_id = ?";
                $select = $conn->prepare($sql1);
                $select -> bind_param("s", $user_id);
                $select ->execute();
                $result = $select -> get_result();
                if($result -> num_rows > 0){
                    while( $row2 = $result -> fetch_assoc()){
                        $sum = ($row2['cart_price'] * $row2['cart_quantity']);
                        $insert_order_detail = $conn -> prepare("INSERT INTO `order_detail` (order_detail_price, order_detail_quantity, order_id, item_id, total_price) 
                        VALUES(?,?,?,?,?)
                        ");
    
                        $insert_order_detail -> bind_param("disid", $row2['cart_price'] , $row2['cart_quantity'], $orderid, $row2['item_id'], $sum );
                      
                    }  
                    if(!empty($payment_method) && !empty($address_checked)){
                        $insert_order_detail -> execute();
                    }
                  
                
                }
                /*\INSERT DETAIL-order*/ 


                /* UPDATE QUANTITY WHEN CHECK OUT */

                    $sql2 = "SELECT * FROM `order_detail` 
                    INNER JOIN  `product` ON `order_detail`.item_id = `product`.item_id 
                    INNER JOIN  `order` ON `order_detail`.order_id = `order`.order_id 
                    WHERE `order`. user_id = ?";
                    $stmt = $conn-> prepare($sql2);
                    $stmt -> bind_param("s", $user_id);
                    $stmt -> execute();
                    $result  = $stmt->get_result();

                    if($result -> num_rows >0){
                            while($row = $result -> fetch_assoc()){
                                $item_id = $row['item_id'];
                                $order_quantity = $row['order_detail_quantity'];
                                $current_quantity = $row['item_quantity'];
                                $new_quantity = $current_quantity - $order_quantity;

                                $update_quantity = $conn->prepare("UPDATE `product` SET item_quantity = ? WHERE item_id = ? ");
                                $update_quantity->bind_param("ii", $new_quantity, $item_id); // Assuming item_id is an integer
                                
                                 if(!empty($payment_method) && !empty($address_checked)){
                                    $update_quantity->execute();
                                }
                               
                                 

                                 $update_status = $conn->prepare("UPDATE `product` SET item_status = 2 WHERE item_id = ?");
                                 $update_status -> bind_param("i", $item_id);
                                
                                 if(!empty($payment_method) && !empty($address_checked)){
                                    $update_status -> execute();
                                }
                               

                            }
                    }


                /*\ UPDATE QUANTITY WHEN CHECK OUT */












                    // DELETE CART WHEN CHECKOUT SUCCESS
                $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
                $delete_cart -> bind_param("s", $user_id);

              
                    // \ DELETE CART WHEN CHECKOUT SUCCESS
                 if(!empty($payment_method) && !empty($address_checked)){
                    $delete_cart -> execute();
                                }
                                

                                 
                                if(!empty($payment_method) && !empty($address_checked)){
                                    $data .= '<div class="text-center">
                                    <h1 class="display-4 mt-2 text-danger">Thank You!</h1>
                                    <h2 class="text-success">Your Order Placed Successfully! </h2>
                                    <h4>Order Number: '.$orderid.' </h4>
                                    <h4 class="bg-warning text-light rounded p-2">Items Purchased: '.$allItems.' </h4>
                                    <h4>Your Name: '.$row1['fullname'].' </h4>
                                    <h4>Your E-mail: '.$row1['email'].' </h4>
                                    <h4>Your Phone: '.$row1['phone_number'].' </h4>
                                    <h4>Total Amount Paid: $'.$grand_total.' </h4>
                                    <h4>Payment method: '.$payment_method.' </h4>
                                    
                                    
                                  </div>';

                                  echo $data;
                                 } 
                                             
                                 
             

            }
           
        }
        else{
            
            $query = " INSERT INTO `order` (order_id, user_id, order_total_price, method, city, district, street, fullname, email, phone_number, ward) VALUE(?,?,?,?,?,?,?,?,?,?, ?)";
            $stmt1 = $conn->prepare($query);
            $stmt1 -> bind_param("ssdssssssss", $orderid, $user_id, $grand_total, $payment_method, $newCity, $newDistrict, $newStreet, $newName, $newEmail , $newPhone, $newWard);
            if(!empty($payment_method) && !empty($address_checked)){
                $stmt1 -> execute();
               }
               else{
                echo '<div id="alertMessage" class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Please select a payment method or delivery address option!</strong> 
              </div>';
               }


            
            $sql1 = "SELECT item_id, cart_price, cart_quantity, name  FROM `cart` Where user_id = ?";
            $select = $conn->prepare($sql1);
            $select -> bind_param("s", $user_id);
            $select ->execute();
            $result = $select -> get_result();
            if($result -> num_rows > 0){
                while( $row2 = $result -> fetch_assoc()){
                    $sum = ($row2['cart_price'] * $row2['cart_quantity']);
                    $insert_order_detail = $conn -> prepare("INSERT INTO `order_detail` (order_detail_price, order_detail_quantity, order_id, item_id, total_price) 
                    VALUES(?,?,?,?,?)
                    ");

                    $insert_order_detail -> bind_param("disid", $row2['cart_price'] , $row2['cart_quantity'], $orderid, $row2['item_id'], $sum );
                    $insert_order_detail -> execute();
                }





            }




 /* UPDATE QUANTITY WHEN CHECK OUT */

 $sql2 = "SELECT * FROM `order_detail` 
 INNER JOIN  `product` ON `order_detail`.item_id = `product`.item_id 
 INNER JOIN  `order` ON `order_detail`.order_id = `order`.order_id 
 WHERE `order`. user_id = ?";
 $stmt = $conn-> prepare($sql2);
 $stmt -> bind_param("s", $user_id);
 $stmt -> execute();
 $result  = $stmt->get_result();

 if($result -> num_rows > 0){
         while($row = $result -> fetch_assoc()){
             $item_id = $row['item_id'];
             $order_quantity = $row['order_detail_quantity'];
             $current_quantity = $row['item_quantity'];
             $new_quantity = $current_quantity - $order_quantity;

             $update_quantity = $conn->prepare("UPDATE `product` SET item_quantity = ? WHERE item_id = ? ");
             $update_quantity->bind_param("ii", $new_quantity, $item_id); // Assuming item_id is an integer
              $update_quantity->execute();

              $update_status = $conn->prepare("UPDATE `product` SET item_status = 2 WHERE item_id = ?");
              $update_status -> bind_param("i", $item_id);
              $update_status -> execute();

         }
 }


/*\ UPDATE QUANTITY WHEN CHECK OUT */



            $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
            $delete_cart -> bind_param("s", $user_id);
            $delete_cart -> execute();

            $data .= '<div class="text-center">
            <h1 class="display-4 mt-2 text-danger">Thank You!</h1>
            <h2 class="text-success">Your Order Placed Successfully! </h2>
            <h4>Order Number: '.$orderid.' </h4>
            <h4 class="bg-warning text-light rounded p-2">Items Purchased: '.$allItems.' </h4>
            <h4>Your Name: '.$newName.' </h4>
            <h4>Your E-mail: '.$newEmail.' </h4>
            <h4>Your Phone: '.$newPhone.' </h4>
            <h4>Total Amount Paid: $'.$grand_total.' </h4>
            <h4>Payment method: '.$payment_method.' </h4>
            
            
          </div>';

          echo $data;
        }

    }

















?>
