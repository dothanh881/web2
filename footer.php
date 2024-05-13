
</main>
<!-- !start #main-site -->

<!-- start #footer -->
<footer  id="footer" class="bg-footer text-white py-5 footer mt-5">
    
    <div class="container ">
        <div class="row">
            <div class="col-lg-3 col-12">
                <h4 class="font-rubik font-size-20">Mobile Shopee</h4>
                <p class="font-size-14 font-rale text-white-50">Your Ultimate Mobile Destination.</p>
            </div>
            <div class="col-lg-4 col-12">
                <h4 class="font-rubik font-size-20">Newslatter</h4>
                <form class="form-row">
                    <div class="col">
                        <input type="text" class="form-control" placeholder="Email *">
                    </div>
                    <div class="col">
                        <button type="submit" class="btn btnd mb-2">Subscribe</button>
                    </div>
                </form>
            </div>
            <div class="col-lg-2 col-12">
                <h4 class="font-rubik font-size-20">Information</h4>
                <div class="d-flex flex-column flex-wrap">
                    <a href="#" class="font-baloo font-size-14 text-white-50 pb-1">About Us</a>
                    <a href="#" class="font-baloo font-size-14 text-white-50 pb-1">Delivery Information</a>
                    <a href="#" class="font-baloo font-size-14 text-white-50 pb-1">Privacy Policy</a>
                    <a href="#" class="font-baloo font-size-14 text-white-50 pb-1">Terms & Conditions</a>
                </div>
            </div>
            <div class="col-lg-2 col-12">
    <h4 class="font-rubik font-size-20">Account</h4>
    <div class="d-flex flex-column flex-wrap">
        <?php
        if(isset($_SESSION['user_id'])) {
            // Nếu user_id đã tồn tại trong session, hiển thị các liên kết
            ?>
            <a href="profile.php" class="font-baloo font-size-14 text-white-50 pb-1">My Account</a>
            <a href="order.php" class="font-baloo font-size-14 text-white-50 pb-1">Order History</a>
            <a href="#" class="font-baloo font-size-14 text-white-50 pb-1">Wish List</a>
            <a href="#" class="font-baloo font-size-14 text-white-50 pb-1">Newsletters</a>
            <?php
        } else {
            // Nếu không có user_id trong session, hiển thị thông báo cần đăng nhập
            ?>
            <a href="#" onclick="alert('Please login to access your account.');" class="font-baloo font-size-14 text-white-50 pb-1">My Account</a>
            <a href="#"  onclick="alert('Please login to access your account.');" class="font-baloo font-size-14 text-white-50 pb-1">Order History</a>
            <a href="#"  onclick="alert('Please login to access your account.');" class="font-baloo font-size-14 text-white-50 pb-1">Wish List</a>
            <a href="#"  onclick="alert('Please login to access your account.');" class="font-baloo font-size-14 text-white-50 pb-1">Newsletters</a>
            <?php
        }
        ?>
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
        showdata();
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


        $("#placeOrder").submit(function(e) {
    e.preventDefault();

    // Lấy giá trị của $orderid từ input hidden trong form
    var orderid = $("input[name='order_id']").val();

    // Tạo dữ liệu gửi đi kèm với yêu cầu Ajax
    var formData = $('form').serialize() + "&action=order";
    $.ajax({
        url: 'get_cart_count.php',
        method: 'post',
        data: formData, // Đã bao gồm dữ liệu form, không cần thêm formData vào đây
        success: function(response) {
            // Phản hồi từ get_cart_count.php
            // Thay vì sử dụng biến orderid mới, chúng ta sử dụng biến orderid đã lấy được từ input hidden
            window.location.href = `success-checkout.php?order=${orderid}`;
            load_cart_item_number(); // Bạn cần đảm bảo rằng hàm load_cart_item_number() đã được định nghĩa và hoạt động đúng
        },
        error: function(xhr, status, error) {
            console.error(xhr.responseText);
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



function validateForm() {
    var paymentMethod = document.querySelector('input[name="payment"]:checked');
    var deliveryAddress = document.querySelector('input[name="address"]:checked');

    if (!paymentMethod) {
        alert('Please select a payment method.');
        window.location.href = "checkout.php";
        return false; 
       
    }

    if (!deliveryAddress) {
        alert('Please select a delivery address option.');
        window.location.href = "checkout.php";
        return false; // Prevent form submission
    }

    

   
    return true;
}
 
 
</script>



<script>
    document.addEventListener("DOMContentLoaded", function() {
          
    var checkout = document.getElementById("checkout");
    
    var infoCheckout = document.querySelector("#info-checkout");
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
           
        // Lấy các phần tử input radio có name là "payment"
      
                    
                    // Lấy thông tin khác và hiển thị ra màn hình
                    var fullName = shipingDetailsAvailable.dataset.fullname;
                    var phone = shipingDetailsAvailable.dataset.phone;
                    var email = shipingDetailsAvailable.dataset.email;
                    var street = shipingDetailsAvailable.dataset.street;
                    var ward = shipingDetailsAvailable.dataset.ward;
                    var city = shipingDetailsAvailable.dataset.city;
                    var district = shipingDetailsAvailable.dataset.district;
                    var currentDate = new Date();
                    var day = currentDate.getDate();
                    var month = currentDate.getMonth() + 1; 
                    var year = currentDate.getFullYear();
                    var formattedDate = year + '/' + month + '/' + day;
                    
                    // Hiển thị thông tin trên giao diện
                    infoCheckout.innerHTML = `
                        <div class="row">
                        <div class="col-md-6">
                                <h6>Receiver Name:</h6>
                                <p>${fullName}</p>
                            </div>
                            <div class="col-md-6">
                                <h6>Create Date: </h6>
                                <p>${formattedDate}</p>
                            </div>
                        </div>
                        <div class="row">
                          
                            <div class="col-md-6">
                                <h6>Email: </h6>
                                <p>${email}</p>
                            </div>
                            <div class="col-md-6">
                                <h6>Phone:</h6>
                                <p>${phone}</p>
                            </div>
                        </div>
                        <div class="row">
                            <h6>Address:</h6>
                            <p>${street}, ${ward}, ${district}, ${city}</p>
                        </div>`;
              
       
    

        });



      newAddressRadio.addEventListener("click", function() {
    shipingDetails.style.display = "block"; 
    shipingDetailsAvailable.style.display = "none";
    var infoCheckout = document.querySelector("#info-checkout");

    document.getElementById("newFullname").addEventListener("input", updateInfo);
    document.getElementById("newEmail").addEventListener("input", updateInfo);
    document.getElementById("newPhone").addEventListener("input", updateInfo);
    document.getElementById("newStreet").addEventListener("input", updateInfo);
    document.getElementById("newWard").addEventListener("change", updateInfo);
    document.getElementById("newCity").addEventListener("change", updateInfo);
    document.getElementById("newDistrict").addEventListener("change", updateInfo);

    // Lấy dữ liệu từ các input và select
    function updateInfo() {
        var infoCheckout = document.querySelector("#info-checkout");

        // Kiểm tra nếu radio "new-address-radio" đã được chọn
        if (newAddressRadio.checked) {
            // Lấy dữ liệu từ các input và select
            var newFullname = document.getElementById("newFullname").value;
            var newEmail = document.getElementById("newEmail").value;
            var newPhone = document.getElementById("newPhone").value;
            var newStreet = document.getElementById("newStreet").value;
            var newWard = document.getElementById("newWard").value;
            var newCity = document.getElementById("newCity").value;
            var newDistrict = document.getElementById("newDistrict").value;
          
          
            // Lấy ngày hiện tại
            var currentDate = new Date();
            var day = currentDate.getDate();
            var month = currentDate.getMonth() + 1;
            var year = currentDate.getFullYear();
            var formattedDate = year + '/' + month + '/' + day;

            // Hiển thị thông tin mới trên giao diện
            infoCheckout.innerHTML = `
                <div class="row">
                    <div class="col-md-6">
                        <h6>Receiver Name:</h6>
                        <p>${newFullname}</p>
                    </div>
                    <div class="col-md-6">
                        <h6>Create Date:</h6>
                        <p>${formattedDate}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <h6>Email:</h6>
                        <p>${newEmail}</p>
                    </div>
                    <div class="col-md-6">
                        <h6>Phone:</h6>
                        <p>${newPhone}</p>
                    </div>
                </div>
                <div class="row">
                    <h6>Address:</h6>
                    <p>${newStreet}, ${newWard}, ${newDistrict}, ${newCity}</p>
                </div>`;
        }
    }
});



// Hàm reset các giá trị của new address về rỗng
function resetNewAddressFields() {
    document.getElementById('newFullname').value = '';
    document.getElementById('newEmail').value = '';
    document.getElementById('newPhone').value = '';
    document.getElementById('newStreet').value = '';
    document.getElementById('newWard').value = '';
    document.getElementById('newCity').value = '';
    document.getElementById('newDistrict').value = '';
}






availableAddressRadio.addEventListener("click", function() {
    shipingDetails.style.display = "none"; 
    shipingDetailsAvailable.style.display = "block";
    var infoCheckout = document.querySelector("#info-checkout");

    if(availableAddressRadio.checked){
        // Retrieve data attributes từ shipping-details-available
        var userId = document.querySelector(".shiping-details-available").getAttribute("data-user-id");
        var fullname = document.querySelector(".shiping-details-available").getAttribute("data-fullname");
        var email = document.querySelector(".shiping-details-available").getAttribute("data-email");
        var phone = document.querySelector(".shiping-details-available").getAttribute("data-phone");
        var street = document.querySelector(".shiping-details-available").getAttribute("data-street");
        var ward = document.querySelector(".shiping-details-available").getAttribute("data-ward");
        var city = document.querySelector(".shiping-details-available").getAttribute("data-city");
        var district = document.querySelector(".shiping-details-available").getAttribute("data-district");

        // Hiển thị thông tin trong infoCheckout
        infoCheckout.innerHTML = `
            <div class="row">
                <div class="col-md-6">
                    <h6>Receiver Name:</h6>
                    <p>${fullname}</p>
                </div>
                <div class="col-md-6">
                    <h6>Create Date:</h6>
                    <p>${formattedDate}</p> <!-- Nếu cần lấy thông tin ngày hiện tại thì cần khai báo biến formattedDate -->
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <h6>Email:</h6>
                    <p>${email}</p>
                </div>
                <div class="col-md-6">
                    <h6>Phone:</h6>
                    <p>${phone}</p>
                </div>
            </div>
            <div class="row">
                <h6>Address:</h6>
                <p>${street}, ${ward}, ${district}, ${city}</p>
            </div>`;


            resetNewAddressFields();
    }
    // Nếu không chọn availableradio, có thể xử lý theo ý muốn, ví dụ, xóa dữ liệu đã hiển thị trước đó trong infoCheckout
    else {
        infoCheckout.innerHTML = ""; // Xóa dữ liệu hiển thị trong infoCheckout
    }
    
});



const orderPlaceButton = document.getElementById('btn-checkout');
orderPlaceButton.addEventListener('click', function(event) { 
    if (newAddressRadio.checked) {
        if (!checkNewAddressInputs()) {
            alert("Please fill out all fields for the new address.");
            if (!check()) {
                focusOnFirstEmptyField();
                return;
            }
            return; // Thêm câu lệnh return ở đây để ngăn không hiện modal khi có lỗi
        }
    }
        $('#mi-modal').modal('toggle');
    
});

document.getElementById('modal-btn-no').addEventListener('click', function() {
    $('#mi-modal').modal('hide'); // Hide the modal when the "Cancel" button is clicked
});

function focusOnFirstEmptyField() {
    const inputs = document.querySelectorAll('#newFullname, #newEmail, #newPhone, #newStreet, #newWard, #newCity, #newDistrict');
    for (const input of inputs) {
        if (!input.value.trim()) {
            input.focus();
            break;
        }
    }
}

const usernameElement = document.getElementById('newFullname');
usernameElement.addEventListener('blur', function() {
    const username = usernameElement.value.trim();
    if (!username) {
        setError(usernameElement, "Please re-enter the recipient's name !");
    } else {
        setSuccess(usernameElement);
    }
});

const emailElement = document.getElementById('newEmail');
emailElement.addEventListener('blur', function() {
    const email = emailElement.value.trim();
    const emailRegex = /^\s*[^@\s]+@[^\s@\s]+\.[^\s@\s]*\s*$/;
    if (!email || !emailRegex.test(email)) {
        setError(emailElement, "Please enter your email again ! It is not the correct format");
    } else {
        setSuccess(emailElement);
    }
});

const mobileElement = document.getElementById('newPhone');
mobileElement.addEventListener('blur', function() {
    const mobile = mobileElement.value.trim();
    const phoneRegex = /^0[1-9]{9}$/;
    if (!mobile || !phoneRegex.test(mobile)) {
        setError(mobileElement, "The phone number is not in the correct format !");
    } else {
        setSuccess(mobileElement);
    }
});

const streetElement = document.getElementById('newStreet');
streetElement.addEventListener('blur', function() {
    const street = streetElement.value.trim();
    if (!street) {
        setError(streetElement, "Please enter street again !");
    } else {
        setSuccess(streetElement);
    }
});

function check() {
    let hasErrors = false; // Flag to track if errors are found

    // Get all input elements in the form (assuming you have a form element)
    const inputs = document.querySelectorAll('input');

    for (const input of inputs) {
        if (input.style.borderColor === 'red') { // Check if border color is red
            hasErrors = true;
            break; // Exit the loop if an error is found (optional)
        }
    }

    if (hasErrors) {
      
        return false; // Prevent form submission (optional)
    }
}

function setError(ele, message) {
    let parentEle = ele.parentNode;
    parentEle.querySelector('small').innerText = message;
    ele.style.borderColor = "red";
    parentEle.querySelector('small').style.color = "red";
}

function setSuccess(ele) {
    ele.style.borderColor = "green";
    ele.parentNode.querySelector('small').innerText = "";
}

function checkNewAddressInputs() {
    const newFullname = document.getElementById('newFullname').value.trim();
    const newEmail = document.getElementById('newEmail').value.trim();
    const newPhone = document.getElementById('newPhone').value.trim();
    const newStreet = document.getElementById('newStreet').value.trim();
    const newWard = document.getElementById('newWard').value.trim();
    const newCity = document.getElementById('newCity').value.trim();
    const newDistrict = document.getElementById('newDistrict').value.trim();

    // Check if any input field is empty
    if (!newFullname || !newEmail || !newPhone || !newStreet || !newWard || !newCity || !newDistrict) {
        return false;
    }
    
    // Kiểm tra định dạng email
    const emailRegex = /^\s*[^@\s]+@[^\s@\s]+\.[^\s@\s]*\s*$/;
    if (!emailRegex.test(newEmail)) {
        alert("Please enter a valid email address.");
        return false;
    }

    // Kiểm tra định dạng số điện thoại
    const phoneRegex = /^0[1-9]{9}$/;
    if (!phoneRegex.test(newPhone)) {
        alert("Please enter a valid phone number.");
        return false;
    }

    // Nếu tất cả đều hợp lệ, trả về true
    return true;
}












        // Chọn radio buttons
        var cod = document.getElementById("payment-1");
        var onlinebanking = document.getElementById("payment-2");
        var inforPayment = document.querySelector("#info-payment");
       
       
        cod.addEventListener("click", function(){
            
            inforPayment.innerHTML = `  <div class="row">
               
                <div class="col-md-6">
                    <h6>Payment: Cash On Delivery</h6>
                   
                </div>
            </div>`;

        });


        onlinebanking.addEventListener("click", function(){
            
            inforPayment.innerHTML = `  <div class="row">
               
                <div class="col-md-6">
                    <h6>Payment: Online Banking</h6>
                   
                </div>
            </div>`;

        });


      




    });

    

    $('#myInput2').on('change', function() {
        showdata(); 
    });

  

    $('#fromDate, #toDate').on('change', function() {
        showdata();
    });

  

	
function showdata() {
    var fromDate = $('#fromDate').val(); //  fromDate
    var toDate = $('#toDate').val(); //  toDate
    var selectedStatus = $('#myInput2').val(); //  myInput2
    
    console.log(selectedStatus);
    $.ajax({
        url: 'show-data.php',
        method: 'get', 
        data: { fromDate: fromDate, toDate: toDate, selectedStatus: selectedStatus },
        success: function(data) {
            $("#order_list").html(data);
        }
    });
}



</script>


</body>
</html>