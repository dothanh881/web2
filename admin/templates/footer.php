	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js
"></script>
    <script type="text/javascript">

$(document).ready(function(){

showdata();

showreportFilter();



//  // Đặt sự kiện onchange cho select element
//  $('#myInput2').on('change', function() {
//       var selectedStatus = $(this).val(); // Lấy giá trị của option được chọn
//       selectdata(selectedStatus); // Gọi hàm selectdata với giá trị đã chọn
//     });

//     // Đặt sự kiện onchange cho select element
//  $('#myInput1').on('change', function() {
//       var selectedDistrict = $(this).val(); // Lấy giá trị của option được chọn
//       selectdistrict(selectedDistrict); // Gọi hàm selectdata với giá trị đã chọn
//     });


// 	$('#fromDate').on('change', function() {
//         var fromDate = $(this).val(); // Lấy giá trị của option được chọn
//         var toDate = $('#toDate').val(); // Lấy giá trị của toDate
//         filterData(fromDate, toDate); // Gọi hàm filterData với giá trị fromDate và toDate
//     });
    

//     $('#toDate').on('change', function() {
//         var fromDate = $('#fromDate').val(); // Lấy giá trị của fromDate
//         var toDate = $(this).val(); // Lấy giá trị của option được chọn
//         filterData(fromDate, toDate); // Gọi hàm filterData với giá trị fromDate và toDate
//     });


 
 $('#myInput2').on('change', function() {
        showdata(); 
    });

    $('#myInput1').on('change', function() {
        showdata(); 
    });

    $('#fromDate, #toDate').on('change', function() {
        showdata();
    });

  
  
	
function showdata() {
    var fromDate = $('#fromDate').val(); //  fromDate
    var toDate = $('#toDate').val(); //  toDate
    var selectedStatus = $('#myInput2').val(); //  myInput2
    var selectedDistrict = $('#myInput1').val(); //  myInput1

    $.ajax({
        url: 'show-data.php',
        method: 'get', 
        data: { fromDate: fromDate, toDate: toDate, selectedStatus: selectedStatus, selectedDistrict: selectedDistrict },
        success: function(data) {
            $("#customer_order_list").html(data);
        }
    });
}



$('#filter-date').on('click', function(event) {
        event.preventDefault(); 
        showreportFilter();
       
    });

function showreportFilter() {

    var fromDate1 = $('#fromDate1').val();
    var toDate1 = $('#toDate1').val();

    $.ajax({
        url: 'show_report_filter.php',
        method: 'post',
        data: {fromDate1: fromDate1, toDate1: toDate1},
        success: function(result) {
            $("#customer_report_list").html(result);
        }
    });
}


    showproduct();
$('#categoryFilter').on('change', function() {
        showproduct(); 
    });

    $('#statusFilter').on('change', function() {
        showproduct(); 
    });

    $('#searchForm').on('submit', function(event) {
        event.preventDefault(); // Prevent default form submission
        showproduct();
    });


function showproduct(){

  var selectedStatus = $('#statusFilter').val(); //  
    var selectedCategory = $('#categoryFilter').val(); // 
    var searchName = $('input[name="search_box"]').val();    

    $.ajax({
        url: 'show-product.php',
        method: 'get',
        data:{selectedStatus: selectedStatus, selectedCategory: selectedCategory, searchName: searchName},
        success: function(result){
            $("#product-list").html(result);
        }
    });

}

showcustomer();
    $('#statusFilterCustomer').on('change', function() {
        showcustomer(); 
    });

    $('#searchFormCustomer').on('submit', function(event) {
        event.preventDefault(); // Prevent default form submission
        showcustomer();
    });

    
function showcustomer(){

var selectedStatus = $('#statusFilterCustomer').val(); //  
 
  var searchName = $('input[name="search_box_customer"]').val();    
  
  $.ajax({
      url: 'show-customer.php',
      method: 'get',
      data:{selectedStatus: selectedStatus, searchName: searchName},
      success: function(result){
          $("#customer-list").html(result);
      }
  });

}

// function selectdata(status){

//   $.ajax({

//     url: 'select-data.php',
//     method: 'post',
//     data: 'status='+status,
//     success: function(response){
//       $("#customer_order_list").html(response);

//     }

//   });

// }

// function selectdistrict(district){
//   console.log(district);
//   $.ajax({

// url: 'select-district.php',
// method: 'post',
// data: 'district='+district,
// success: function(response){
//   $("#customer_order_list").html(response);

// }

// });
// }



// function filterData(fromDate, toDate) {
 

//     // Send AJAX request
//     var xhr = new XMLHttpRequest();
//     xhr.onreadystatechange = function() {
//         if (xhr.readyState === XMLHttpRequest.DONE) {
//             if (xhr.status === 200) {
//                 document.getElementById("customer_order_list").innerHTML = xhr.responseText;
//             } else {
//                 console.error("Error fetching data:", xhr.status);
//             }
//         }
//     };
//     xhr.open("GET", "filter_data.php?fromDate=" + fromDate + "&toDate=" + toDate, true);
//     xhr.send();
// }

});




</script>	
 </body>
</html>