<?php

include('head.php');


	$date = date("Y-m-d");
	$dateTo = date("Y-m-d");





if(isset($_REQUEST['dateFormValue'])){

	$date = addslashes($_REQUEST['dateFormValue']);

	$dateTo = addslashes($_REQUEST['dateTo']);

}

?>

<div class='container' style='margin-top:2%;'>

		<form  method="POST" action='smspdf.php' role="form">

			<div class='row'>
	    		<div class="col-md-12">
			        <div class="form-group">
						<legend>Search for transaction.</legend>
					</div>
	    		</div>
			</div>
			<div class='row'>
				<div class="col-md-6">
				    <div class="form-group">
				  		   <span class="label label-primary">From: </span>
			                      <input type="date" value=<?php echo @$date; ?> class="form-control" name="dateFormValue" id="input">
			                       

				  	</div>

				  	<div class="form-group">
				  		 <span class="label label-primary">To: </span>
			                      <input type="date" value=<?php echo @$dateTo; ?>  class="form-control" name="dateTo" id="input">

				  	</div>

					<div class="form-group">
						<button type="submit" name='btnSmsPrint' class="btn btn-primary">SMS PRINT</button>
					</div>
			</div>

			</div>


			<div id='searchResult'></div>

		</form>
</div>

<div class="row">
	
	<div class="col-md-6">
			<?php  
			if(isset($date))
			{

				$rows = $con->query("select * from sms where date_format(from_unixtime(floor(date / 1000)),'%Y-%m-%d')
				 				     between
									 date_format('".$date."','%Y-%m-%d')
									 and 
									 date_format('".$dateTo."','%Y-%m-%d') ");

				while($row = mysqli_fetch_array($rows) ){

					echo $row['body']."<br>";

				}

				//SELECT from_unixtime(floor(date / 1000)),body FROM `sms`

			}


					?>
	</div>

</div>

<script>

$(document).ready(function(){

		
});

</script>


<?php

include('foot.php');

?>