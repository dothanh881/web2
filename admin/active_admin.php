<?php
include("./../functions.php");

if (isset($_GET['user_id'], $_GET['status'])) {
    $user_id = mysqli_real_escape_string($conn, $_GET['user_id']);
    $status = mysqli_real_escape_string($conn, $_GET['status']);

    // Update the user status
    $updateQuery = "UPDATE `user` SET status = '$status' WHERE user_id = '$user_id'";
    
    if (mysqli_query($conn, $updateQuery)) {
        header('location: index_admin.php');
        exit; 
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }
} else {
    echo "user_id or status is missing.";
}
?>