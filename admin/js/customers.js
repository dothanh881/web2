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

	

});