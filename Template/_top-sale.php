<?php

    shuffle($product_shuffle);

    
    // if(isset($_POST['top_sale_submit'])){
    //     if($user_id == ''){
    //         header('location: login.php');
    //     } else {
    //         $item_id = $_POST['pid'];
    //         $name = $_POST['name'];
    //         $cart_price = $_POST['price'];
    //         $cart_quantity = $_POST['qty'];
    //         $cart_image = $_POST['image'];
    
    //         $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE item_id = ? AND user_id = ?");
    //         $check_cart_numbers->bind_param("is", $item_id, $user_id);
    //         $check_cart_numbers->execute();
    //         $check_cart_numbers->store_result();
    
    //         if($check_cart_numbers->num_rows > 0){
    //             $message = 'already added to cart!';
    //         } else {
    //             $check_cart_numbers->close();
    
    //             $insert_cart = $conn->prepare("INSERT INTO `cart`(user_id, item_id, cart_quantity, cart_price, name, cart_image) VALUES(?,?,?,?,?,?)");
    //             $insert_cart->bind_param("siidss", $user_id, $item_id, $cart_quantity, $cart_price, $name, $cart_image);
    //             $insert_cart->execute();
    //             $message = 'added to wishlist!';
    //         }
    //     }
    // }

    // if (isset($_POST['top_sale_submit'])) {
    //     if (isset($_SESSION['cart'])) {
    //         if (in_array($_POST['pid'], array_keys($_SESSION['cart']))) {
    //             $_SESSION['cart'][$_POST['pid']] += 1;
    //         } else {
    //             // Create new session variable
    //             $_SESSION['cart'][$_POST['pid']] = 1;
    //         }
    //     } else {
    //         // Create new session variable
    //         $_SESSION['cart'][$_POST['pid']] = 1;
    //     }
    
    //     // Reload the page at the same URL
    //     header("Location: {$_SERVER['PHP_SELF']}");
    //     exit; // Ensure that no further PHP code is executed after redirection
    // }
  

?>


<section id="top-sale">
    <div class="container py-5">
        <h4 class="font-rubik font-size-20">Top Sale</h4>
        <hr>
        <!-- owl carousel -->
        <div class="owl-carousel owl-theme">
            <?php foreach ($product_shuffle as $item) { ?>
           
               
                <div class="item py-2">
                <div class="product font-rale">
                    <a href="<?php printf('%s?item_id=%s', 'product.php',  $item['item_id']); ?>"><img src="<?php echo $item['item_image'] ?? "./assets/products/1.png"; ?>" alt="product1" class="img-fluid"></a>
                    <div class="text-center">
                        <h6><?php echo $item['item_name'] ?? "Unknown"; ?></h6>
                        <div class="price py-2">
                            <span>$<?php echo $item['item_price'] ?? '0'; ?></span>
                        </div>

                        <form  action="" class="form-submit">
                            <input type="hidden" name="pid" value="<?= $item['item_id']; ?>">
                            <input type="hidden" name="name" value="<?= $item['item_name']; ?>">
                            <input type="hidden" name="price" value="<?= $item['item_price']; ?>">
                            <input type="hidden" name="image" value="<?= $item['item_image']; ?>">
                            <input type="hidden" name="qty" value="1">
                    
                           
                          
                           
                            <button type="button" class="btn btn-warning font-size-12 addItemBtn">Add to Cart</button>
                          
                       

                            
                        
                          
                            
                        
                    </form>
                       
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
        <!-- !owl carousel --> 
    </div>
</section>
<!-- !Top Sale -->
