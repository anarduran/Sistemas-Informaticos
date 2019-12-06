	$(document).ready(function(){
		function aleatorio(){
	
			$.ajax({
				type: "POST",
				url: "aleatorio.php",
    				success: function(data){
    					$("#online").text(data);
    				}
			});
		}
		
		    setInterval(aleatorio,2000);
	    });