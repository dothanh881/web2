	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js
"></script>
    <script type="text/javascript">

$(document).ready(function(){

showdata();



function showdata(){
$.ajax({
url : 'show-data.php',
method : 'post',
success : function(response){
  

    $("#customer_order_list").html(response);



}
});

}



function selectdata(status) {
    
    console.log(status);

}

});
</script>	
 </body>
</html>