<?php

include('head.php');


?>


<div class='container' style='margin-top:2%;'>

	<?php

		if(isset($_REQUEST['btnrepair']))
		{
			$sql = $con->query("DELETE e1 FROM transaction_sm e1, transaction_sm e2 
				 WHERE e1.ref_no = e2.ref_no AND e1.account=e2.account AND e1.tran_id > e2.tran_id");


			echo"<div class='alert alert-success'>
				<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
				<strong>Success! </strong> Table has been repaired.
			</div>";
		}

		if(isset($_REQUEST['btnBlockIP']))
		{
			$sql = $con->query('update secureip set verified = 1');


			echo"<div class='alert alert-success'>
				<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
				<strong>Success! </strong> Blocked IP was reset.
			</div>";
		}

	?>

		<form action="" method="POST" role="form">

			<div class='row'>
	    		<div class="col-md-12">
			        <div class="form-group">
						<legend>Maintenance</legend>
					</div>
	    		</div>
			</div>
			<div class='row'>
	    		
	    		<div class="col-md-4">
	    			
	             	<p>Use repair table if you had encounter a duplicated record from the printable reports or real-time report. Any action is <span style='color:red;'>irreversible</span> or cannot do a roll-back.</p>
	          	</div>

			</div>

			<div class='row'>
	    		
	    		<div class="col-md-4">

	             	<div class="form-group">
	                	<button type="submit"  class="btn btn-primary center-block" style='width:100%;'  name='btnrepair'>Click this to repair table.</button>
	            	</div>
	          	</div>

			</div>

		</form>
		<form action="" method="POST" role="form">

			<div class='row'>
	    		<div class="col-md-12">
			        <div class="form-group">
						<legend>Secure IP</legend>
					</div>
	    		</div>
			</div>
			<div class='row'>
	    		
	    		<div class="col-md-4">
	    			
	             	<p>Allowing Blocked IP will reset all the blacklisted ip addresses. Please inform the assigned Database Administrator before taking this action. Action is <span style='color:red;'>irreversible</span> or cannot do a roll-back.</p>
	          	</div>

			</div>

			<div class='row'>
	    		
	    		<div class="col-md-4">

	             	<div class="form-group">
	                	<button type="submit"  class="btn btn-primary center-block" style='width:100%;'  name='btnBlockIP'>Click this to Allow.</button>
	            	</div>
	          	</div>

			</div>

		</form>
</div>

<?php

include('foot.php');

?>