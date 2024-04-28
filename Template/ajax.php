<?php

// require MySQL Connection
require ('connect.php');

// require Product Class
require ('../database/Product.php');

// DBController object


// Product object
$product = new Product($conn);

if (isset($_POST['itemid'])){
    $result = $product->getProduct($_POST['itemid']);
    echo json_encode($result);
}