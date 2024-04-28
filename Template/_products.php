<!--   product  -->
<?php 
   if(isset($_POST['top_sale_submit'])){
    if($user_id == ''){
        header('location: login.php');
    } else {
        $item_id = $_POST['pid'];
        $name = $_POST['name'];
        $cart_price = $_POST['price'];
        $cart_quantity = $_POST['qty'];
        $cart_image = $_POST['image'];

        $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE item_id = ? AND user_id = ?");
        $check_cart_numbers->bind_param("ii", $item_id, $user_id);
        $check_cart_numbers->execute();
        $check_cart_numbers->store_result();

        if($check_cart_numbers->num_rows > 0){
            $message = 'already added to cart!';
        } else {
            $check_cart_numbers->close();

            $insert_cart = $conn->prepare("INSERT INTO `cart`(user_id, item_id, cart_quantity, cart_price, name, cart_image) VALUES(?,?,?,?,?,?)");
            $insert_cart->bind_param("siidss", $user_id, $item_id, $cart_quantity, $cart_price, $name, $cart_image);
            $insert_cart->execute();
            $message = 'added to wishlist!';
        }
    }
}

if (isset($_POST['top_sale_submit'])){
    if(isset($_SESSION['cart'])){
        // Kiểm tra xem key 'item_id' có tồn tại trong mảng $_POST không
        if(isset($_POST['pid'])) {
            if(in_array($_POST['pid'], array_keys($_SESSION['cart']))){
                $_SESSION['cart'][$_POST['pid']] += 1;
                header("Location: " . $_SERVER['REQUEST_URI']);
                exit;
            }else{
                // Create new session variable
                $_SESSION['cart'][$_POST['pid']] = 1;
                header("Location: " . $_SERVER['REQUEST_URI']);
                exit; 
            }
        } else {
           
            echo "Không có 'item_id' trong form POST!";
            exit; 
        }
    } else {
        // Create new session variable
        $_SESSION['cart'][$_POST['pid']] = 1;
        header("Location: " . $_SERVER['REQUEST_URI']);
        exit;
    }
}
?>

<?php
    $item_id = $_GET['item_id'] ?? 1;
    foreach ($product->getData() as $item) :
        if ($item['item_id'] == $item_id) :


          


?>
<section id="product" class="py-3">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <img src="<?php echo $item['item_image'] ?? "./assets/products/1.png" ?>" alt="product" class="img-fluid">
                <div class="form-row pt-4 font-size-16 font-baloo">
                    <div class="col">
                        <button type="submit" class="btn btn-danger form-control">Proceed to Buy</button>
                    </div>
                    <div class="col">
                    <form method="post">
                            <input type="hidden" name="pid" value="<?= $item['item_id']; ?>">
                            <input type="hidden" name="name" value="<?= $item['item_name']; ?>">
                            <input type="hidden" name="price" value="<?= $item['item_price']; ?>">
                            <input type="hidden" name="image" value="<?= $item['item_image']; ?>">
                            <input type="hidden" name="qty" value="1">

                        <?php
                       
                            echo '<button type="submit" name="top_sale_submit" class="btn btn-warning font-size-16 form-control">Add to Cart</button>';
                        
                        ?>
                         </form>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 py-5">
                <h5 class="font-baloo font-size-20"><?php echo $item['item_name'] ?? "Unknown"; ?></h5>
                <small>by <?php echo $item['item_brand'] ?? "Brand"; ?></small>
                <div class="d-flex">
                    <div class="rating text-warning font-size-12">
                      
                    </div>
                  
                </div>
                <hr class="m-0">

                <!---    product price       -->
                <table class="my-3">
                    <!-- <tr class="font-rale font-size-14">
                        <td>M.R.P:</td>
                        <td><strike>$162.00</strike></td>
                    </tr> -->
                    <tr class="font-rale font-size-14">
                        <td>Price:</td>
                        <td class="font-size-20 text-danger">$<span><?php echo $item['item_price'] ?? 0; ?></span><small class="text-dark font-size-12">&nbsp;&nbsp;</small></td>
                    </tr>
                    
                </table>
                <!---    !product price       -->

                <!--    #policy -->
                <div id="policy">
                    <div class="d-flex">
                        <div class="return text-center mr-5">
                            <div class="font-size-20 my-2 color-second">
                                <span class="fas fa-retweet border p-3 rounded-pill"></span>
                            </div>
                            <a href="#" class="font-rale font-size-12">10 Days <br> Replacement</a>
                        </div>
                        <div class="return text-center mr-5">
                            <div class="font-size-20 my-2 color-second">
                                <span class="fas fa-truck  border p-3 rounded-pill"></span>
                            </div>
                            <a href="#" class="font-rale font-size-12">Daily Tuition <br>Deliverd</a>
                        </div>
                        <div class="return text-center mr-5">
                            <div class="font-size-20 my-2 color-second">
                                <span class="fas fa-check-double border p-3 rounded-pill"></span>
                            </div>
                            <a href="#" class="font-rale font-size-12">1 Year <br>Warranty</a>
                        </div>
                    </div>
                </div>
                <!--    !policy -->
                <hr>

                <!-- order-details -->
                <div id="order-details" class="font-rale d-flex flex-column text-dark">
                   
                </div>
                <!-- !order-details -->

                <div class="row">
                    <div class="col-6">
                        <!-- color -->
                        <div class="color my-3">
                            <div class="d-flex justify-content-between">
                                <h6 class="font-baloo">Color: <?php echo $item['item_color'] ?></h6>
                               
                            </div>
                        </div>
                        <div class="color my-3">
                            <div class="d-flex justify-content-between">
                                <h6 class="font-baloo">ROM: <?php echo $item['item_rom'] ?> GB</h6>
                               
                            </div>
                        </div>
                        <!-- !color -->
                    </div>
                    <div class="col-6">
                        <!-- product qty section -->
                        <!-- <div class="qty d-flex">
                            <h6 class="font-baloo">Qty</h6>
                            <div class="px-4 d-flex font-rale">
                                <button class="qty-up border bg-light" data-id="pro1"><i class="fas fa-angle-up"></i></button>
                                <input type="text" data-id="pro1" class="qty_input border px-2 w-50 bg-light" disabled value="1" placeholder="1">
                                <button data-id="pro1" class="qty-down border bg-light"><i class="fas fa-angle-down"></i></button>
                            </div>
                        </div> -->
                        <!-- !product qty section -->
                        <!-- <div class="color my-3">
                            <div class="d-flex justify-content-between">
                                <h6 class="font-baloo">ROM: <?php echo $item['item_rom'] ?></h6>
                               
                            </div>
                        </div> -->
                    </div>
                </div>

                <!-- size -->
                <div class="size my-3">
                    <h6 class="font-baloo">RAM : <?php echo $item['item_ram'] ?> GB</h6>
                    <div class="d-flex justify-content-between w-75">
                        <!-- <div class="font-rubik border p-2">
                            <button class="btn p-0 font-size-14">4GB RAM</button>
                        </div>
                        <div class="font-rubik border p-2">
                            <button class="btn p-0 font-size-14">6GB RAM</button>
                        </div>
                        <div class="font-rubik border p-2">
                            <button class="btn p-0 font-size-14">8GB RAM</button>
                        </div> -->
                    </div>
                </div>
                <!-- !size -->
                <h6 class="font-baloo">SIZE SCREEN : <?php echo $item['size_screen'] ?> inch</h6>
                    <div class="d-flex justify-content-between w-75">
                        <!-- <div class="font-rubik border p-2">
                            <button class="btn p-0 font-size-14">4GB RAM</button>
                        </div>
                        <div class="font-rubik border p-2">
                            <button class="btn p-0 font-size-14">6GB RAM</button>
                        </div>
                        <div class="font-rubik border p-2">
                            <button class="btn p-0 font-size-14">8GB RAM</button>
                        </div> -->
                    </div>

            </div>

            <div class="col-12">
                <hr>
                <br>
                <h6 class="font-rubik">Product Description</h6>
                <hr>
                <p class="font-rale font-size-14"><?php echo $item['item_discription'] ?></p>
              
            </div>
        </div>
    </div>
</section>
<!--   !product  -->
<?php
        endif;
        endforeach;
?>