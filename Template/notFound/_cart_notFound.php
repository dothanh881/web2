<!-- Shopping cart section  -->
<br><br><br>
<section id="cart" class="py-3 mb-5">
    <div class="container-fluid w-75">
    <div style="display:
    <?php 
    if(isset($_SESSION['showAlert']))
    { echo $_SESSION['showAlert']; } 
    else{
        echo 'none';
    } 
    unset($_SESSION['showAlert']);
    
    ?>;" class=" id='alertMessage' alert alert-success alert-dismissible ">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong> <?php if(isset($_SESSION['message'])){ echo $_SESSION['message']; }else{ echo 'none'; } unset($_SESSION['message']); ?></strong> 
                      </div>
        <h5 class="font-baloo font-size-20">Shopping Cart</h5>

        <!--  shopping cart items   -->
        <div class="row">
            <div class="col-sm-9">
                <!-- Empty Cart -->
                    <div class="row border-top py-3 mt-3">
                        <div class="col-sm-12 text-center py-2">
                            <img src="./assets/blog/empty_cart.png" alt="Empty Cart" class="img-fluid" style="height: 200px;">
                            <p class="font-baloo font-size-16 text-black-50">Empty Cart</p>
                        </div>
                    </div>
                <!-- .Empty Cart -->
            </div>
            <!-- subtotal section-->
            <div class="col-sm-3">
                <div class="sub-total border text-center mt-2">
                    <h6 class="font-size-12 font-rale text-success py-3"><i class="fas fa-check"></i> Your order is eligible for FREE Delivery.</h6>
                    <div class="border-top py-4">
                        <h5 class="font-baloo font-size-20">Subtotal ( <?php echo isset($subTotal) ? count($subTotal) : 0; ?> item):&nbsp; <span class="text-danger">$<span class="text-danger" id="deal-price"><?php echo isset($subTotal) ? $Cart->getSum($subTotal) : 0; ?></span> </span> </h5>
                        <a href="get_cart_count.php?clear=all" > <button type="button" onclick="return confirm('Are you sure want to remove all item?');" class="btn btn-danger mt-3 clearbtn"><i class='fas fa-trash-alt'></i>
                &nbsp;  Clear Cart </button></a> 
                        <a href="checkout.php" class="btn btn-primary mt-3 checkoutbtn <?=($subTotal > 1)? "": "disabled" ?>"><i class='fas fa-credit-card'></i>
&nbsp;&nbsp;Proceed to Buy</a> 

               

                      <a href="index.php"><button type="button" class="btn btn-success mt-3 shoppingbtn"><i class="fas fa-cart-plus"></i>&nbsp; Continue Shopping</button></a>  

                    </div>

                </div>
            </div>
            <!-- !subtotal section-->
        </div>
        <!--  !shopping cart items   -->
    </div>
</section>
<!-- !Shopping cart section  -->
<script>
        const timeoutDuration = 5000;

// Get the alert element
const alertElement = document.getElementById('alertMessage');

// Function to hide the alert after a timeout
const hideAlert = () => {
    alertElement.classList.remove('show');
    setTimeout(() => {
        alertElement.style.display = 'none';
    }, 200); // Transition duration in milliseconds
};

// Hide the alert after the specified duration
setTimeout(hideAlert, timeoutDuration);

// Add event listener to close button to hide alert immediately if clicked
alertElement.querySelector('.close').addEventListener('click', hideAlert);

</script>