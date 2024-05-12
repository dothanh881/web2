<?php

class Product
{
    public $conn = null;

    public function __construct($conn)
    {
        if (!$conn || $conn->connect_error) {
            throw new Exception("Database connection failed: " . $conn->connect_error);
        }
        $this->conn = $conn;
    }

    // fetch product data using getData Method
    public function getData($table = 'product')
    {
        $result = $this->conn->query("SELECT * FROM {$table} ");

        $resultArray = array();

        if ($result) {
            // fetch product data one by one
            while ($item = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $resultArray[] = $item;
            }
        }

        return $resultArray;
    }

    public function getData2($table = 'product', $table1 ='category')
    {
        $result = $this->conn->query("SELECT * FROM {$table},{$table1} WHERE $table.category_id = $table1.category_id AND (item_status = 1 or item_status = 2) AND {$table}.item_quantity > 1"  );

        $resultArray = array();

        if ($result) {
            // fetch product data one by one
            while ($item = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $resultArray[] = $item;
            }
        }

        return $resultArray;
    }
  
    public function getData3($table = 'product', $table1 ='category')
    {
        $result = $this->conn->query("SELECT * FROM {$table},{$table1} WHERE $table.category_id = $table1.category_id AND item_status = 1 " );

        $resultArray = array();

        if ($result) {
            // fetch product data one by one
            while ($item = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $resultArray[] = $item;
            }
        }

        return $resultArray;
    }


    public function getData1($table = 'cart', $table1 = 'product'  ,$user_id)
{
    // Prepare the SQL statement with a placeholder for user_id
    $stmt = $this->conn->prepare("SELECT * FROM {$table}, {$table1} WHERE  {$table}.item_id = {$table1}.item_id AND user_id = ?  AND {$table1}.item_quantity > 0");
    
    // Bind the user_id parameter to the prepared statement
    $stmt->bind_param("s", $user_id);

   
    
    // Execute the prepared statement
    $stmt->execute();
    
    // Get the result set
    $result = $stmt->get_result();

    $resultArray = array();

    if ($result) {
        // fetch product data one by one
        while ($item = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $resultArray[] = $item;
        }
    }

    return $resultArray;
}

public function getProduct1($user_id, $item_id = null, $table = 'cart')
{
    // Check if $item_id is set
    if (isset($item_id)) {
        // Prepare the SQL statement with placeholders for user_id and item_id
        $stmt = $this->conn->prepare("SELECT * FROM {$table} WHERE user_id = ? AND item_id = ? ");
        
        // Bind the user_id and item_id parameters to the prepared statement
        $stmt->bind_param("ss", $user_id, $item_id);
        
        // Execute the prepared statement
        $stmt->execute();
        
        // Get the result set
        $result = $stmt->get_result();

        $resultArray = array();

        if ($result) {
            // fetch product data one by one
            while ($item = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $resultArray[] = $item;
            }
        }

        return $resultArray;
    }
}

    // get product using item id
    public function getProduct($item_id = null, $table = 'product')
    {
        if (isset($item_id)) {
            $result = $this->conn->query("SELECT * FROM {$table} WHERE item_id={$item_id}");

            $resultArray = array();

            if ($result) {
                // fetch product data one by one
                while ($item = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    $resultArray[] = $item;
                }
            }

            return $resultArray;
        }
    }
}
?>
