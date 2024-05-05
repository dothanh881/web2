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
.btn-sub{
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
        background-color: #ddd; /* Màu nền xám */
        padding: 15px 30px; /* Kích thước padding */
        border-radius: 2px;
    }

    .pagination-justify-content-center .page-item.disabled .page-link {
        color: #6c757d;
        pointer-events: none;
        background-color: #ddd; /* Màu nền xám */
    }

    .pagination-justify-content-center .page-item.active .page-link {
        /* color: #613d8a; màu nút khi được bấm */
        color: red;
    }

    .pagination-justify-content-center .page-link {
        color: black; 
    }

    .pagination-justify-content-center .page-link:hover {
        color: purple; /* Màu chữ khi hover */
        text-decoration: none;

    }

</style>



<?php
// SEARCH FEATURES
if($_SERVER['REQUEST_METHOD'] === 'POST')
    {
        $key_brand = $_GET['sCate'] ?? 'All categories';
        $key_maxPrice = $_GET['price_T'] ?? 100000;
        $key_minPrice = $_GET['price_F'] ?? 0;
        $key_rom = $_GET['sRom'] ?? 'All Rom';
        $key_screen = $_GET['sScreen'] ?? 'All Screen';
    }
    if ($_SERVER['REQUEST_METHOD'] === 'GET')
    {
        $key_brand = $_GET['sCate'] ?? 'All categories';
        $key_maxPrice = $_GET['price_T'] ?? 100000;
        $key_minPrice = $_GET['price_F'] ?? 0;
        $key_rom = $_GET['sRom'] ?? 'All Rom';
        $key_screen = $_GET['sScreen'] ?? 'All Screen';
    }
        $sql = "SELECT * FROM `product`,`category` WHERE  `product`.category_id = `category`.category_id  "; // Start with a base condition
        $conditions = [];
        if ($key_brand !== 'All categories') {
            $conditions[] = "category_name = '$key_brand'"; // Filter by brand
        }
        
        if ($key_minPrice > 0 && $key_minPrice<100000 || 0<$key_maxPrice && $key_maxPrice < 100000) {
            $conditions[] = "item_price BETWEEN $key_minPrice AND $key_maxPrice"; // Filter by price range
        }
        
        if ($key_rom !== 'All Rom') {
            $conditions[] = "item_rom = $key_rom"; // Filter by ROM
        }
        if ($key_screen !== 'All Screen') {
            $conditions[] = "size_screen = $key_screen"; // Filter by ROM
        }
        if (!empty($conditions)) {
            $sql .= " AND " . implode(' AND ', $conditions) ; // Combine conditions
        }
    



      
       
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $list_result = $stmt->get_result();
        $row_result = mysqli_num_rows($list_result);
       
        // \SEARCH FEATURE
        ?>

     
        
<br><br><br>
<section id="bd_search_result" class="d-flex">
    
    <div class="advance_search col-md-3 ml-5  mr-5">
        <div class="hd_box_search text-center mt-2" >
            SEARCH
        </div>
        <form class="b_inputOfSearch" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF'])?>" method="get">
            <div class="form-group">
                Category
                <select name="sCate" class="form-control" id="sCate" >
                    <?php
                    $brand = $conn->prepare("SELECT category_name FROM `product`,`category` WHERE product.category_id = category.category_id group by category_name");
                    $brand->execute();
                    $result_brand = $brand->get_result();
                    ?>
                    <?php while ($brand_item = $result_brand->fetch_assoc()) { ?>
                        <option value="<?php echo $brand_item['category_name'] ?>" <?php if($brand_item['category_name']==$key_brand){ echo 'selected';} ?> > <?php echo $brand_item['category_name'] ?>
                        </option> <?php } ?>
                </select>
            </div>
            <div class="form-group">
    <label for="price_F">Price</label>
    <div class="input-group">
        <div class="input-group-prepend">
            <span class="input-group-text">$</span>
        </div>
        <input type="number" class="form-control" id="price_F" placeholder="From" min="0" name="price_F">
    </div>
    <div class="input-group mt-2">
        <div class="input-group-prepend">
            <span class="input-group-text">$</span>
        </div>
        <input type="number" class="form-control" id="price_T" placeholder="To" min="0" name="price_T">
    </div>
</div>
            <div class="form-group">
                ROM
                <select class="form-control" name="sRom">
                    <option value="All Rom" >All Rom</option>
                    <?php
                    $rom = $conn->prepare("SELECT item_rom FROM `product` group by item_rom");
                    $rom->execute();
                    $result_rom = $rom->get_result();
                    ?>
                    <?php while ($rom_item = $result_rom->fetch_assoc()) { ?>
                        <option value=" <?php echo $rom_item['item_rom'] ?>  "> <?php echo $rom_item['item_rom'] ?> GB
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
                        <option value=" <?php echo $screen_item['size_screen'] ?> ">
                            <?php echo $screen_item['size_screen'] ?> '' </option> <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <button type="submit" class="btn-sub">Search</button>
            </div>
        </form>
    </div>
    
   
          
   
  
    <div class="container ml-3">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex p-2"> Have <?php echo "$row_result" ?> products.</div>
        </div>
       
    </div>
    <div class="container"> <!-- Phần tử chứa phần tử được căn giữa -->
    <div class="row"> <!-- Dòng của Bootstrap -->
        <div class="col"> <!-- Cột của Bootstrap -->
            <?php
            if($row_result === 0) {
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
            <?php

            while ($item = $list_result->fetch_assoc()) {
            ?>
                <div class="grid-item border" style="margin-top:30px">
                    <div class="item py-2" style="width: 250px;">
                        <div class="product font-rale">
                        <a href="<?php printf('%s?item_id=%s', 'product.php',  $item['item_id']); ?>"><img src="<?php echo $item['item_image'] ?? "./assets/products/1.png"; ?>" alt="product1" class="img-fluid"></a>
                            <div class="text-center">
                                <h6><?= $item['item_name'] ?? "Unknown"; ?></h6>
                                <div class="price py-2">
                                    <span>$<?= $item['item_price'] ?? 0; ?></span>
                                </div>
                            </div>
                            <form  class="form-submit">
                                <input type="hidden" name="pid" value="<?= $item['item_id']; ?>">
                                <input type="hidden" name="name" value="<?= $item['item_name']; ?>">
                                <input type="hidden" name="price" value="<?= $item['item_price']; ?>">
                                <input type="hidden" name="image" value="<?= $item['item_image']; ?>">
                                <input type="hidden" name="qty" value="1">
                                <div class="text-center">
                                <button type="button" class="btn btn-warning font-size-12 addItemBtn">Add to Cart</button>

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



</div>
        </section>
<?php
$stmt->close();
$conn->close();
?>
<?php
include ("footer.php");
?>