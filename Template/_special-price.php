<!-- Special Price -->
<?php
$brand = array_map(function ($pro) {
    return $pro['category_name'];
}, $product_shuffle);
$unique = array_unique($brand);
sort($unique);
shuffle($product_shuffle);

// request method post
// if($_SERVER['REQUEST_METHOD'] == "POST"){
//     if (isset($_POST['special_price_submit'])){
//         // call method addToCart
//         $Cart->addToCart($_POST['user_id'], $_POST['item_id']);
//     }
// }

if (isset($_POST['top_sale_submit'])) {
    if ($user_id == '') {
        header('location: login.php');
    } else {
        $item_id = $_POST['pid'];
        $name = $_POST['name'];
        $cart_price = $_POST['price'];
        $cart_quantity = $_POST['qty'];
        $cart_image = $_POST['image'];

        $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE item_id = ? AND user_id = ?");
        $check_cart_numbers->bind_param("is", $item_id, $user_id);
        $check_cart_numbers->execute();
        $check_cart_numbers->store_result();

        if ($check_cart_numbers->num_rows > 0) {
            $message = 'already added to cart!';
        } else {
            $check_cart_numbers->close();

            $insert_cart = $conn->prepare("INSERT INTO `cart`(user_id, item_id, cart_quantity, cart_price, name, image) VALUES(?,?,?,?,?,?)");
            $insert_cart->bind_param("siidss", $user_id, $item_id, $cart_quantity, $cart_price, $name, $cart_image);
            $insert_cart->execute();
            $message = 'added to wishlist!';
        }
    }
}


$in_cart = $Cart->getCartId($user_id, $product->getData('cart'));

?>
<section id="special-price">
    <div class="container">
        <h4 class="font-rubik font-size-20">Special Price</h4>
        <div id="filters" class="button-group text-right font-baloo font-size-16">
            <button class="btn is-checked" data-filter="*">All Brand</button>
            <?php
            array_map(function ($brand) {
                printf('<button class="btn" data-filter=".%s">%s</button>', $brand, $brand);
            }, $unique);
            ?>
        </div>

        <div class="grid">
            <?php array_map(function ($item) use ($in_cart) { ?>
                <div class="grid-item border <?php echo $item['category_name'] ?? "Brand"; ?>">
                    <div class="item py-2" style="width: 200px;">
                        <div class="product font-rale">
                            <a href="<?php printf('%s?item_id=%s', 'product.php', $item['item_id']); ?>"><img
                                    src="<?php echo $item['item_image'] ?? "./assets/products/13.png"; ?>" alt="product1"
                                    class="img-fluid"></a>
                            <div class="text-center">
                                <h6><?php echo $item['item_name'] ?? "Unknown"; ?></h6>

                                <div class="price py-2">
                                    <span>$<?php echo $item['item_price'] ?? 0 ?></span>
                                </div>
                                <form method="post">
                                    <input type="hidden" name="pid" value="<?= $item['item_id']; ?>">
                                    <input type="hidden" name="name" value="<?= $item['item_name']; ?>">
                                    <input type="hidden" name="price" value="<?= $item['item_price']; ?>">
                                    <input type="hidden" name="image" value="<?= $item['item_image']; ?>">
                                    <input type="hidden" name="qty" value="1">
                                    <?php




                                    echo '<button type="submit" name="top_sale_submit" class="btn btn-warning font-size-12">Add to Cart</button>';




                                    ?>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php }, $product_shuffle) ?>
        </div>
    </div>
</section>
<!-- !Special Price -->