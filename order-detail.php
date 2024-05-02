<?php 
include('header.php');
?>
<?php 

if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
 }else{
    $user_id = '';

    header('location:login.php');   
 }; 



 



?>
<br>
<br><br> 
<br>


































<br><br>









<?php
include("footer.php");
?>