<?php 
$cus_id = bin2hex(random_bytes('6'));
$prod_id  = bin2hex(random_bytes('5'));
$orderid = "";

for($i = 0; $i < 5; $i++){
    $orderid .= mt_rand(0, 9); 
}

?>