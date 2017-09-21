<?php

//session_start();

?>

<div class='row' style="margin-top:2%;">
    <div class="col-md-4">
		<div class="form-group">
		      	  <label for="inputType" class="control-label">Reference Number: </label>
		</div>
	</div>        	  
</div>
<div class='row'>
    <div class="col-md-4">
		<div class="form-group">
		      	<input type="text" class="form-control" required='required' id="referenceNumber" placeholder="Input reference number"  autocomplete="off">
		</div>
	</div> 

	 <div class="col-md-2">
		<div class="form-group">
			  <button type="button" id="btnfindFerence" class="btn btn-primary center-block" style='width:90%;'>Find</button>
		</div>
	</div> 
</div>


	 
<div id='response2'></div>


<script>

	$(document).ready(function(){

<?php

	if($_SESSION['userz']['main']){

		echo "	
				$('#referenceNumber').typeahead({
					        autoSelect: true,
					        minLength: 1,
					        delay: 400,

			        source: function (query, process) {
			            $.ajax({
			                url: 'jsquery/autoCompleteReference.php',
			                data: {query: query},
			                dataType: 'json'
			            })
			                .done(function(response) {
			                    //console.log(response);                   
			                    return process(response);
			                });
			        }
			    });";



	}


?>
	

		$("#btnfindFerence").click(function(){

			var query = $("#referenceNumber").val();
			var custname = $("#customername").val();

			$.post('jsquery/referenceDetails.php',{query:query,custname:custname},function(data){


					$("#response2").html(data);

			});


		});
			


	});

</script>
				