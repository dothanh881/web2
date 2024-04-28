<?php 




$host = 'localhost';
$user = 'root';
$password = '';
$database = "shoppee";

$conn = new mysqli( $host, $user, $password, $database);

// Check connection
// if ($conn->connect_error) {
//   die("Connection failed: " . $conn->connect_error);
// }
// else{
//     echo "Connected successfully";
// }
if(!$conn) {
    die("Connection Failed:".mysqli_connect_error());
}
?>



