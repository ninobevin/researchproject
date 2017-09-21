<?php
	
	//session_start();

	require('..\classes\connection.php');

	require('..\classes\computation.php');

	$query =   addslashes($_REQUEST['query']);



	
	$custname  = $_REQUEST['custname'];


	$con = new connection();

	$compute = new computation($con->getConnection());



	$queryCheck = "SELECT * from transaction_sm where ref_no = '$query' and status=2";

	//echo $queryString;
	$check = $con->query($queryCheck);

	if ($con->getRowCount() == 1) {

		echo "<script>

		$('#customername').prop('disabled',true);
		//$('#btnCustomerFind').prop('disabled',true);
		//$('#amount').prop('disabled',true);
		//$('#amount').val('');
		$('#customername').val('');
		//$('#referenceNumber').val('');

		$('#response1').html('');
		
	</script>";



		die("<div class='alert alert-warning'>
			<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
			<strong>Warning! </strong> Reference '$query' was already claimed. Please inform the Main Branch.
		</div>");

	}





	$queryString = "SELECT * from transaction_sm where ref_no = '$query' and status=1";

	//echo $queryString;
	$sql = $con->query($queryString);

if($con->getRowCount() == 0){
	echo "<script>

		
		$('#customername').prop('disabled',true);
		//$('#btnCustomerFind').prop('disabled',true);
		//$('#amount').prop('disabled',true);
		//$('#amount').val('');
		$('#customername').val('');
		//$('#referenceNumber').val('');

		$('#response1').html('');
		
	</script>";

	die("<div class='alert alert-danger'>
		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
		<strong>Error! </strong> Cannot find this reference '$query'
	</div>");
}










  $row = mysqli_fetch_array($sql);

  $ActualTotal = $row['amount'] - $compute->getClaimServiceCharge($row['amount'],$row['account']);

  //echo $ActualTotal;

            
?>
	<script>

		$('#customername').prop("disabled",false);
		$('#cust_id_off').prop("disabled",false);
		
	</script>
	
	 <input type="hidden" name="referenceNumber" value="<?php echo $row['ref_no'] ?>">
	 <input type="hidden" name="amount" value="<?php echo $row['amount'] ?>">
	 <input type="hidden" name="account" value="<?php echo $row['account'] ?>">

	 <input type="hidden" name="custname" value="<?php echo $custname ?>">

	<div class='row' >
		<div class='col-md-12' >
			<table>
				<div class='row'>
					<div class="col-md-2" ><p>SMS Body :</p></div><div class="col-md-2"><?php echo $row['body_sms']  ?></div>
				</div>
				<div class='row'>
					<div class="col-md-2" ><p>Amount :</p></div><div class="col-md-2"><?php echo $row['amount']  ?></div>
				</div>
				<div class='row'>					
					<div class="col-md-2" ><p>Service Charge :</p></div><div class="col-md-2"><?php echo $compute->getClaimServiceCharge($row['amount'],$row['account']);  ?></div>
					<input type='hidden' name='serviceCharge' value="<?php echo $compute->getClaimServiceCharge($row['amount'],$row['account'])  ?>">
				</div>

				<div class='row'>
					<div class="col-md-2" ><p>Expected Total :</p></div><div class="col-md-2"><?php echo number_format($row['amount'] - $compute->getClaimServiceCharge($row['amount'],$row['account']),2);  ?></div>
					
				</div>

				<div class='row'>
					<div class="col-md-2" ><h4>Actual Total :</h4></div>
					<div class="col-md-3">
						<input type="number" class="form-control" id='actualTotal' name='actualTotal' value="<?php echo $ActualTotal;  ?>" required='required'>
					</div>
				</div>

				

			</table>
		</div>
	</div>


	







