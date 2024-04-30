<?php
// get_cart_count.php
session_name('customer_session');

session_start();
include('functions.php');

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

?>
