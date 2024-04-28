<?php

// php cart class
class Cart
{
    public $conn = null;
    public function __construct($conn)
    {
        if (!$conn || $conn->connect_error) {
            throw new Exception("Database connection failed: " . $conn->connect_error);
        }
        $this->conn = $conn;
    }

    // insert into cart table
    public  function insertIntoCart($params = null, $table = "cart"){
        if ($this->conn != null){
            if ($params != null){
                // "Insert into cart(user_id) values (0)"
                // get table columns
                $columns = implode(',', array_keys($params));

                $values = implode(',' , array_values($params));

                // create sql query
                $query_string = sprintf("INSERT INTO %s(%s) VALUES(%s)", $table, $columns, $values);

                // execute query
                $result = $this->conn->query($query_string);
                return $result;
            }
        }
    }

    // to get user_id and item_id and insert into cart table
public function addToCart($userid, $itemid, $quantity = 1)
{
    if (isset($userid) && isset($itemid)) {
        // Check if the item is already in the cart
        $existingCart = $this->getExistingCartItem($userid, $itemid);

        if ($existingCart) {
            // If item already exists in cart, update cart_quantity
            $cartQuantity = $existingCart['cart_quantity'] + $quantity;
            $this->updateCartQuantity($userid, $itemid, $cartQuantity);
        } else {
            // If item does not exist in cart, add it to cart
            $params = array(
                "user_id" => $userid,
                "item_id" => $itemid,
                "cart_quantity" => $quantity // Set initial quantity to $quantity
            );

            // insert data into cart
            $result = $this->insertIntoCart($params);
            if ($result) {
                // Reload Page
                header("Location: " . $_SERVER['PHP_SELF']);
            }
        }
    }
}

// Update cart_quantity for an existing cart item
private function updateCartQuantity($userid, $itemid, $quantity)
{
    $query = "UPDATE cart SET cart_quantity = $quantity WHERE user_id = $userid AND item_id = $itemid";
    $result = $this->conn->query($query);
    if ($result) {
        // Reload Page or handle success message
        header("Location: " . $_SERVER['PHP_SELF']);
    } else {
        // Handle update failure
        // Redirect or display an error message
    }
}

    private function getExistingCartItem($userid, $itemid)
    {
        $query = "SELECT * FROM cart WHERE user_id = $userid AND item_id = $itemid";
        $result = $this->conn->query($query);
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc(); // Return cart item if it exists
        }
        return false; // Return false if cart item does not exist
    }

    // delete cart item using cart item id
    public function deleteCart($item_id = null, $table = 'cart'){
        if($item_id != null){
            $result = $this->conn->query("DELETE FROM {$table} WHERE item_id={$item_id}");
            if($result){
                header("Location:" . $_SERVER['PHP_SELF']);
            }
            return $result;
        }
    }

    public function getSum($arr){
        if(isset($arr)){
            $sum = 0;
            foreach ($arr as $item){
                if(isset($item[0])) { // Kiểm tra xem phần tử thứ nhất của mảng con có tồn tại hay không
                    $sum += floatval($item[0]);
                }
            }
            return sprintf('%.2f' , $sum);
        }
    }
    // get item_it of shopping cart list
    public function getCartId($user_id, $cartArray = null, $key = "item_id"){
        if ($cartArray != null){
            $cart_id = array_map(function ($value) use($key){
                return $value[$key];
            }, $cartArray);
            return $cart_id;
        }
    }
  
    // Save for later
    public function saveForLater($item_id = null, $saveTable = "wishlist", $fromTable = "cart"){
        if ($item_id != null){
            $query = "INSERT INTO {$saveTable} SELECT * FROM {$fromTable} WHERE item_id={$item_id};";
            $query .= "DELETE FROM {$fromTable} WHERE item_id={$item_id};";

            // execute multiple query
            $result = $this->conn->multi_query($query);

            if($result){
                header("Location :" . $_SERVER['PHP_SELF']);
            }
            return $result;
        }
    }


}