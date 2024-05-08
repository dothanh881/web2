
</main>
<!-- !start #main-site -->

<!-- start #footer -->
<footer  id="footer" class="bg-dark text-white py-5 footer mt-5">
    
    <div class="container ">
        <div class="row">
            <div class="col-lg-3 col-12">
                <h4 class="font-rubik font-size-20">Mobile Shopee</h4>
                <p class="font-size-14 font-rale text-white-50">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Repellendus, deserunt.</p>
            </div>
            <div class="col-lg-4 col-12">
                <h4 class="font-rubik font-size-20">Newslatter</h4>
                <form class="form-row">
                    <div class="col">
                        <input type="text" class="form-control" placeholder="Email *">
                    </div>
                    <div class="col">
                        <button type="submit" class="btn btn-primary mb-2">Subscribe</button>
                    </div>
                </form>
            </div>
            <div class="col-lg-2 col-12">
                <h4 class="font-rubik font-size-20">Information</h4>
                <div class="d-flex flex-column flex-wrap">
                    <a href="#" class="font-rale font-size-14 text-white-50 pb-1">About Us</a>
                    <a href="#" class="font-rale font-size-14 text-white-50 pb-1">Delivery Information</a>
                    <a href="#" class="font-rale font-size-14 text-white-50 pb-1">Privacy Policy</a>
                    <a href="#" class="font-rale font-size-14 text-white-50 pb-1">Terms & Conditions</a>
                </div>
            </div>
            <div class="col-lg-2 col-12">
                <h4 class="font-rubik font-size-20">Account</h4>
                <div class="d-flex flex-column flex-wrap">
                    <a href="#" class="font-rale font-size-14 text-white-50 pb-1">My Account</a>
                    <a href="#" class="font-rale font-size-14 text-white-50 pb-1">Order History</a>
                    <a href="#" class="font-rale font-size-14 text-white-50 pb-1">Wish List</a>
                    <a href="#" class="font-rale font-size-14 text-white-50 pb-1">Newslatters</a>
                </div>
            </div>
        </div>
    </div>
   
    
</footer>

<!-- !start #footer -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.min.js" integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

<!-- Owl Carousel Js file -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js" integrity="sha256-pTxD+DSzIwmwhOqTFN+DB+nHjO4iAsbgfyFq5K5bcE0=" crossorigin="anonymous"></script>

<!--  isotope plugin cdn  -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.isotope/3.0.6/isotope.pkgd.min.js" integrity="sha256-CBrpuqrMhXwcLLUd5tvQ4euBHCdh7wGlDfNz8vbu/iI=" crossorigin="anonymous"></script>

<!-- Custom Javascript -->
<script src="index.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $(".addItemBtn").click(function(e){
            e.preventDefault();
            var $form = $(this).closest(".form-submit");
            var pid = $form.find("input[name='pid']").val();
            var name = $form.find("input[name='name']").val();
            var price = $form.find("input[name='price']").val();
            var image = $form.find("input[name='image']").val();
            var qty = $form.find("input[name='qty']").val();

            $.ajax({
                url: 'get_cart_count.php',
                method: 'post',
                data: {pid:pid, name:name, price:price, image:image, qty:qty},
                success:function(response){
                    $("#message").html(response);
               load_cart_item_number();
                 // Thêm setTimeout để ẩn thông báo sau một khoảng thời gian
            const alertElement = $("#alertMessage");
            const timeoutDuration = 3000; // 5 giây

            const hideAlert = () => {
                alertElement.removeClass('show');
                setTimeout(() => {
                    alertElement.hide();
                }, 200); // Thời gian chuyển đổi trong mili giây
            };

            setTimeout(hideAlert, timeoutDuration);
        }
                
            });
        });


        $("#placeOrder").submit(function(e){

            e.preventDefault();
            $.ajax({
                url: 'get_cart_count.php',
                method: 'post',
                data: $( 'form' ).serialize()+"&action=order",
                success: function(response){
                    $("#order").html(response);
                    load_cart_item_number();

                }
            });
        });







        load_cart_item_number();
       
        function load_cart_item_number(){
            $.ajax({
                url: 'get_cart_count.php',
                method: 'get',
                data: {cartItem: "cart-item"},
                success:function(response){
                    $("#cart-item").html(response);
                }
            });
        }

    });


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
<!-- Đưa vào cuối trang HTML -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Chọn radio buttons
        var availableAddressRadio = document.getElementById("available-address-radio");
        var newAddressRadio = document.getElementById("new-address-radio");

       
        var shipingDetails = document.querySelector(".shiping-details");
        var shipingDetailsAvailable = document.querySelector(".shiping-details-available");
        // Ẩn phần shipping-details ban đầu
        shipingDetails.style.display = "none";
        shipingDetailsAvailable.style.display = "none";

        // Bắt sự kiện click trên radio buttons
        availableAddressRadio.addEventListener("click", function() {
            shipingDetailsAvailable.style.display = "block"; 
            shipingDetails.style.display = "none";

        });

        newAddressRadio.addEventListener("click", function() {
            shipingDetails.style.display = "block"; 
            shipingDetailsAvailable.style.display = "none";

        });
    });
</script>


</body>
</html>