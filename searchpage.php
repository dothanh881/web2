<?php
include ("header.php");

shuffle($product_shuffle);

?>


<style>
    .text_result_search {
        margin-top: 20px;
    }

    .text_result_search p {
        font-size: 16px;
        color: #333;
        font-weight: bold;
    }

    .advance_search {
        margin-left: 5%;
        margin-right: 5%;
    }

    .hd_box_search {
        font-weight: bold;
        font-size: 18px;
    }

    .b_inputOfSearch {
        margin-top: 20px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    #sCate,
    #sRom,
    #sScreen {
        width: 100%;
    }

    .btn-reset {
        background-color: #007bff;
        color: white;
        border: none;
        padding: 10px 20px;
        cursor: pointer;
    }

    .btn-sub {
        background-color: #007bff;
        color: white;
        border: none;
        padding: 10px 20px;
        cursor: pointer;
    }


    .btn-reset:hover {
        background-color: #0056b3;
    }

    .btn-sub:hover {
        background-color: #0056b3;
    }

    input[type="number"] {
        width: 100px;
        padding: 5px;
    }

    label {
        font-weight: bold;
    }

    .pagination-justify-content-center {
        display: flex;
        justify-content: center;
        margin-top: 20px;
        margin-bottom: 20px;
        font-size: 15px;
    }

    .pagination-justify-content-center .page-item {
        display: inline-block;
        margin-right: 5px;
        background-color: #ddd;
        /* Màu nền xám */
        padding: 15px 30px;
        /* Kích thước padding */
        border-radius: 2px;
    }

    .pagination-justify-content-center .page-item.disabled .page-link {
        color: #6c757d;
        pointer-events: none;
        background-color: #ddd;
        /* Màu nền xám */
    }

    .pagination-justify-content-center .page-item.active .page-link {
        /* color: #613d8a; màu nút khi được bấm */
        color: red;
    }

    .pagination-justify-content-center .page-link {
        color: black;
    }

    .pagination-justify-content-center .page-link:hover {
        color: purple;
        /* Màu chữ khi hover */
        text-decoration: none;

    }
</style>



<?php
// SEARCH FEATURES

if ($_SERVER['REQUEST_METHOD'] === 'POST') {  // Check for POST request
    $key = isset($_POST['search_box']) ? addslashes($_POST['search_box']) : '';
    $key_brand = $_POST['sCate'] ?? 'All categories';
    $key_maxPrice = $_POST['price_T'] ?? 100000;
    $key_minPrice = $_POST['price_F'] ?? 0;
    $key_rom = $_POST['sRom'] ?? 'All Rom';
    $key_screen = $_POST['sScreen'] ?? 'All Screen';
}
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $key = isset($_GET['search_box']) ? addslashes($_GET['search_box']) : '';
    $key_brand = $_GET['sCate'] ?? 'All categories';
    $key_maxPrice = $_GET['price_T'] ?? 100000;
    $key_minPrice = $_GET['price_F'] ?? 0;
    $key_rom = $_GET['sRom'] ?? 'All Rom';
    $key_screen = $_GET['sScreen'] ?? 'All Screen';
}
echo $key_minPrice;
echo $key_maxPrice;
$sql = "SELECT * FROM `product`,`category` WHERE 1 AND `product`.category_id = `category`.category_id  "; // Start with a base condition
$conditions = [];
if ($key !== '') {
    $conditions[] = "item_name LIKE '%$key%'"; // Search by keyword
}

if ($key_brand !== 'All categories') {
    $conditions[] = "category_name = '$key_brand'"; // Filter by brand
}

if ((int) $key_minPrice !== 0 && $key_minPrice != '') {
    $conditions[] = "item_price >= $key_minPrice "; // Filter by price range
}
if ((int) $key_maxPrice !== 100000 && $key_maxPrice != '') {
    $conditions[] = "item_price <= $key_maxPrice "; // Filter by price range
}

if ($key_rom !== 'All Rom') {
    $conditions[] = "item_rom = $key_rom"; // Filter by ROM
}
if ($key_screen !== 'All Screen') {
    $conditions[] = "size_screen = $key_screen"; // Filter by ROM
}
if (!empty($conditions)) {
    $sql .= " AND " . implode(' AND ', $conditions); // Combine conditions
}

echo $sql;
//paging nav
$products_per_page = 6;

$total_products = mysqli_num_rows(mysqli_query($conn, $sql));

$total_pages = ceil($total_products / $products_per_page);


$current_page = isset($_GET['page']) ? $_GET['page'] : 1;

$offset = ($current_page - 1) * $products_per_page;

$sql .= " LIMIT $products_per_page OFFSET $offset";

$stmt = $conn->prepare($sql);
$stmt->execute();
$list_result = $stmt->get_result();
$row_result = mysqli_num_rows($list_result);
// \SEARCH FEATURE
?>


<br><br><br>
<section id="bd_search_result" class="d-flex">

    <div class="advance_search col-md-3 ml-5  mr-5">
        <div class="hd_box_search text-center mt-2">
            SEARCH
        </div>
        <form class="b_inputOfSearch" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="get">
            <div class="form-group">
                Category
                <select name="sCate" class="form-control" id="sCate">
                    <option value="All categories">All categories</option>
                    <?php
                    $brand = $conn->prepare("SELECT category_name FROM `product`,`category` WHERE product.category_id = category.category_id group by category_name");
                    $brand->execute();
                    $result_brand = $brand->get_result();
                    ?>
                    <?php while ($brand_item = $result_brand->fetch_assoc()) { ?>
                        <option value="<?php echo $brand_item['category_name'] ?>" <?php if ($brand_item['category_name'] == $key_brand) {echo 'selected';} ?>> <?php echo $brand_item['category_name'] ?>
                        </option> <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="price_F">Price</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">$</span>
                    </div>
                    <input type="number" class="form-control" id="price_F" placeholder="<?php if ((int) $key_minPrice !== 0) {
                        echo $key_minPrice;
                    } else {
                        echo "From";
                    } ?>" min="0" name="price_F"
                        valueHidden="0">
                </div>
                <div class="input-group mt-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text">$</span>
                    </div>
                    <input type="number" class="form-control" id="price_T" placeholder="<?php if($key_maxPrice && (int)$key_maxPrice!==100000) {echo $key_maxPrice;} else {echo "To";} ?>" min="0" name="price_T">
                </div>
            </div>
            <div class="form-group">
                ROM
                <select class="form-control" name="sRom">
                    <option value="All Rom">All Rom</option>
                    <?php
                    $rom = $conn->prepare("SELECT item_rom FROM `product` group by item_rom");
                    $rom->execute();
                    $result_rom = $rom->get_result();
                    ?>
                    <?php while ($rom_item = $result_rom->fetch_assoc()) { ?>
                        <option value=" <?php echo $rom_item['item_rom'] ?>  " <?php if($rom_item['item_rom']==$key_rom) {echo "selected";} ?>> <?php echo $rom_item['item_rom'] ?> GB
                        </option> <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="sScreen">Screen</label>
                <select class="form-control" id="sScreen" name="sScreen">
                    <option value="All Screen">All Screen</option>
                    <?php
                    $screen = $conn->prepare("SELECT size_screen FROM `product` group by size_screen");
                    $screen->execute();
                    $result_screen = $screen->get_result();
                    ?>
                    <?php while ($screen_item = $result_screen->fetch_assoc()) { ?>
                        <option value=" <?php echo $screen_item['size_screen'] ?> " <?php if($screen_item['size_screen']==$key_screen) {echo "selected";} ?>>
                            <?php echo $screen_item['size_screen'] ?> ''
                        </option> <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <button type="submit" class="btn-sub">Search</button>
            </div>
        </form>
    </div>





    <div class="container ml-3">
        <div class="container"> <!-- Phần tử chứa phần tử được căn giữa -->
            <div class="row"> <!-- Dòng của Bootstrap -->
                <div class="col"> <!-- Cột của Bootstrap -->
                    <?php
                    if ($row_result === 0) {
                        ?>
                        <p class="notfound text-center text-danger" style="font-size: 24px;">
                            NOT FOUND PRODUCT
                        </p>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="grid-search d-flex align-content-end flex-wrap " style="background-color: white;">
                <?php while ($item = $list_result->fetch_assoc()) {
                    ?>
                    <div class="grid-item border" style="margin-top:30px">
                        <div class="item py-2" style="width: 250px;">
                            <div class="product font-rale">
                                <a href="<?php printf('%s?item_id=%s', 'product.php', $item['item_id']); ?>"><img
                                        src="<?php echo $item['item_image'] ?? "./assets/products/1.png"; ?>" alt="product1"
                                        class="img-fluid"></a>
                                <div class="text-center">
                                    <h6><?= $item['item_name'] ?? "Unknown"; ?></h6>
                                    <div class="price py-2">
                                        <span>$<?= $item['item_price'] ?? 0; ?></span>
                                    </div>
                                </div>
                                <form class="form-submit">
                                    <input type="hidden" name="pid" value="<?= $item['item_id']; ?>">
                                    <input type="hidden" name="name" value="<?= $item['item_name']; ?>">
                                    <input type="hidden" name="price" value="<?= $item['item_price']; ?>">
                                    <input type="hidden" name="image" value="<?= $item['item_image']; ?>">
                                    <input type="hidden" name="qty" value="1">
                                    <div class="text-center">
                                        <button type="button" class="btn btn-warning font-size-12 addItemBtn">Add to
                                            Cart</button>

                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>

        <br><br>

        <?php
        $output = "";
        if ($row_result !== 0 && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $output .= ' <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <li class="page-item ' . ($current_page == 1 ? 'disabled' : '') . '">
                    <a class="page-link" href="?page=1&search_box=' . $key . '" tabindex="-1">First</a>
                </li>
                <li class="page-item ' . ($current_page == 1 ? 'disabled' : '') . '">
                    <a class="page-link" href="' . ($current_page == 1 ? '#' : '?page=' . ($current_page - 1)) . '&search_box=' . $key . '">Previous</a>
                </li>';
            for ($i = 1; $i <= $total_pages; $i++) {
                $output .= '<li class="page-item ' . ($current_page == $i ? 'active' : '') . '">
                <a class="page-link" href="?page=' . $i . '&search_box=' . $key . '">' . $i . '</a>
            </li>';
            }
            $output .= '<li class="page-item ' . ($current_page == $total_pages ? 'disabled' : '') . '">
                    <a class="page-link" href="' . ($current_page == $total_pages ? '#' : '?page=' . ($current_page + 1)) . '&search_box=' . $key . '">Next</a>
                </li>
                <li class="page-item ' . ($current_page == $total_pages ? 'disabled' : '') . '">
                    <a class="page-link" href="?page=' . $total_pages . '&search_box=' . $key . '">Last</a>
                </li>
            </ul>
        </nav>';
        }
        if($row_result !== 0 && $_SERVER['REQUEST_METHOD'] === 'GET'){
            $output .= ' <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <li class="page-item ' . ($current_page == 1 ? 'disabled' : '') . '">
                    <a class="page-link" href="?page=1&sCate='.$key_brand.'&price_F='.$key_minPrice.'&price_T='.$key_maxPrice.'&sRom='.$key_rom.'&sScreen='.$key_screen.'" tabindex="-1">First</a>
                </li>
                <li class="page-item ' . ($current_page == 1 ? 'disabled' : '') . '">
                    <a class="page-link" href=" '.($current_page == 1 ? '#' : '?page=' . ($current_page - 1)).'&sCate='.$key_brand.'&price_F='.$key_minPrice.'&price_T='.$key_maxPrice.'&sRom='.$key_rom.'&sScreen='.$key_screen.'">Previous</a>
                </li>';
            for ($i = 1; $i <= $total_pages; $i++) {
                $output .= '<li class="page-item ' . ($current_page == $i ? 'active' : '') . '">
                <a class="page-link" href="?page=' . $i . '&sCate='.$key_brand.'&price_F='.$key_minPrice.'&price_T='.$key_maxPrice.'&sRom='.$key_rom.'&sScreen='.$key_screen.'">' . $i . '</a>
            </li>';
            }
            $output .= '<li class="page-item ' . ($current_page == $total_pages ? 'disabled' : '') . '">
                    <a class="page-link" href="' . ($current_page == $total_pages ? '#' : '?page=' . ($current_page + 1)).  '&sCate='.$key_brand.'&price_F='.$key_minPrice.'&price_T='.$key_maxPrice.'&sRom='.$key_rom.'&sScreen='.$key_screen.'">Next</a>
                </li>
                <li class="page-item ' . ($current_page == $total_pages ? 'disabled' : '') . '">
                    <a class="page-link" href="?page=' . $total_pages .  '&sCate='.$key_brand.'&price_F='.$key_minPrice.'&price_T='.$key_maxPrice.'&sRom='.$key_rom.'&sScreen='.$key_screen.'">Last</a>
                </li>
            </ul>
        </nav>';
        }
        echo $output;
        ?>




    </div>
</section>
<?php
$stmt->close();
$conn->close();
?>
<?php
include ("footer.php");
?>