




<!-- Special Price -->
<?php
$brand = array_map(function ($pro) {
    return $pro['category_name'];
}, $product_shuffle);
$unique = array_unique($brand);
sort($unique);

shuffle($product_shuffle);





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
                <div class="grid-item border  <?php echo $item['category_name'] ?? "Brand"; ?>">
                    <div class="item py-2" style="width: 230px;">
                        <div class="product font-rubik">
                            <a href="<?php printf('%s?item_id=%s', 'product.php', $item['item_id']); ?>"><img
                                    src="<?php echo $item['item_image'] ?? "./assets/products/13.png"; ?>" alt="product1"
                                    class="img-fluid"></a>
                            <div class="text-center">
                                <h6><?php echo $item['item_name'] ?? "Unknown"; ?></h6>

                                <div class="price py-2">
                                    <span>$<?php echo $item['item_price'] ?? 0 ?></span>
                                </div>
                                <form action="" class="form-submit">
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
                </div>
            <?php }, $product_shuffle) ?>
        </div>
    </div>
</section>
<!-- !Special Price -->