<?php
include("./../functions.php");
session_start();

// Check if user_id and status are set in the URL
if (isset($_GET['user_id'], $_GET['status'])) {
    // Get user_id and status from the URL
    $user_id = mysqli_real_escape_string($conn, $_GET['user_id']);
    $status = mysqli_real_escape_string($conn, $_GET['status']);

    // Update the user status
    $updateQuery = "UPDATE `user` SET status = ? WHERE user_id = ?";

    $stmt = $conn-> prepare($updateQuery);
    $stmt -> bind_param("is", $status, $user_id);

    
    // Perform the update query
    if ($stmt-> execute()) {
        // Redirect to customers.php if update is successful

  
        header('location: customers.php');
       
      
   

  
    exit; // Stop further execution
    } else {
        
        // Handle the error if the update query fails
        echo "Error updating record: " . mysqli_error($conn);
    }
} else {
    // Handle the case when user_id or status is not set in the URL
    echo "user_id or status is missing.";
}
?>