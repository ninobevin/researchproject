<?php

include('head.php');

?>

<div class='container' style='margin-top:2%;'>

		<form action="" method="POST" role="form">

			<div class='row'>
	    		<div class="col-md-12">
			        <div class="form-group">
						<legend>Search for transaction.</legend>
					</div>
	    		</div>
			</div>
			<div class='row'>
	    		<div class="col-md-4">
			        <div class="form-group">
			              <input type="number" name="ref_no" id='ref_no' placeholder='Input reference no.' id="Title" class="form-control" value="" required="required">
			        </div>
	    		</div>

	    		<div class="col-md-2">
	             	<div class="form-group">
	                	<button type="button"  class="btn btn-primary center-block" style='width:90%;'  id='btnSearch'>Find</button>
	            	</div>
	          	</div>

			</div>


			<div id='searchResult'></div>

		</form>
</div>

<script>

$(document).ready(function(){

		$("#btnSearch").click(function(){

			var ref_no = $('#ref_no').val();

	 		$.post('../jsquery/searchDetails.php',{ref_no:ref_no},function(data){

			 			$('#searchResult').html(data);
			 		
			 });

//		alert(ref_no);


		});

});

</script>


<?php

include('foot.php');

?>