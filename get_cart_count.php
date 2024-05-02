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
            echo '<div class="alert alert-danger alert-dismissible">
                   <button type="button" class="close" data-dismiss="alert">&times;</button>
                   <strong>Item already added to your cart!</strong> 
                 </div>';
        } else {
            $check_cart_numbers->close();

            $insert_cart = $conn->prepare("INSERT INTO `cart`(user_id, item_id, cart_quantity, cart_price, name, cart_image) VALUES(?,?,?,?,?,?)");
            $insert_cart->bind_param("siidss", $user_id, $pid, $qty, $price, $name, $image);
            try {
                $insert_cart->execute();
                echo '<div class="alert alert-success alert-dismissible">
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
        $payment_method = input_filter($_POST['payment']);
        $allItems = input_filter($_POST['allItems']);

        $data ='';


        if( empty($newName) && empty($newStreet) && empty($newCity) && empty($newDistrict)){

            $sql = "SELECT * FROM `user` WHERE user_id = ? AND is_admin = 0";
            $stmt = $conn->prepare($sql);
            $stmt -> bind_param("s", $user_id);
            $stmt -> execute();
            $result = $stmt -> get_result();
      

            if($result -> num_rows == 1){

                $row1 = $result-> fetch_assoc();

                $query = " INSERT INTO `order` (order_id, user_id, order_total_price, method, city, district, street, fullname, email, phone_number) VALUE(?,?,?,?,?,?,?,?,?,?)";

                $insert_order = $conn->prepare($query);
                $insert_order -> bind_param("ssdsssssss", $orderid, $user_id, $grand_total, $payment_method, $row1['city'], $row1['district'], $row1['street'], $row1['fullname'], $row1['email'] , $row1['phone_number']);
                $insert_order -> execute();

                $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
                $delete_cart -> bind_param("s", $user_id);
                $delete_cart -> execute();



                $data .= '<div class="text-center">
                <h1 class="display-4 mt-2 text-danger">Thank You!</h1>
                <h2 class="text-success">Your Order Placed Successfully! </h2>
                <h4>Order Number: '.$orderid.' </h4>
                <h4 class="bg-warning text-light rounded p-2">Items Purchased: '.$allItems.' </h4>
                <h4>Your Name: '.$row1['fullname'].' </h4>
                <h4>Your E-mail: '.$row1['email'].' </h4>
                <h4>Your Phone: '.$row1['phone_number'].' </h4>
                <h4>Total Amount Paid: '.$grand_total.' </h4>
                <h4>Payment method: '.$payment_method.' </h4>
                
                
              </div>';
                echo $data;

            }
           
        }
        else{
            $query = " INSERT INTO `order` (order_id, user_id, order_total_price, method, city, district, street, fullname, email, phone_number) VALUE(?,?,?,?,?,?,?,?,?,?)";
            $stmt1 = $conn->prepare($query);
            $stmt1 -> bind_param("ssdsssssss", $orderid, $user_id, $grand_total, $payment_method, $newCity, $newDistrict, $newStreet, $newName, $newEmail , $newPhone);
            $stmt1 -> execute();
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
            <h4>Total Amount Paid: '.$grand_total.' </h4>
            <h4>Payment method: '.$payment_method.' </h4>
            
            
          </div>';

          echo $data;
        }

    }

















?>
