

<?php



// include header.php file
include ('header.php');



if(isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
 }else{
    $user_id = '';

    header('location:./login.php');
    
 };
 


 


?>


<?php
    /*  include products */
    include ('./Template/_products.php');
    /*  include products */
    

    /*  include top sale section */
    include ('./Template/_top-sale.php');
    /*  include top sale section */


   
?>



<?php
// include footer.php file
include ('footer.php');
?>