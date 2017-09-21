<?php





  require('..\classes\connection.php');

  require('..\classes\computation.php');




$con = new connection();


$compute = new computation($con->getConnection());




$refNo = explode("--",$_REQUEST['tran_id'])[0];



$queryComp = $con->query("select * from transaction_sm where ref_no = '$refNo' limit 1");

$tranInfo = mysqli_fetch_array($queryComp);





$serviceCharge =  $compute->getTransferCharge($tranInfo['amount']) + $compute->getTransferChargeService($tranInfo['amount']) ; 


$query = $con->query("select branch_no,branch_name from branch");


echo "<div class='panel panel-default'>
	<div class='panel-body'>

		".explode("--",$_REQUEST['tran_id'])[1]."
		
	</div>
</div>";




?>






<form method='GET'>

<input type='hidden' name='ref_no' value="<?php echo $refNo; ?>">	
<input type='hidden' name='sms_body' value="<?php echo explode("---",$_REQUEST['tran_id'])[1]; ?>">	

<div class='row' style="margin-top:2%;">
    <div class="col-md-4">
		<div class="form-group">
		      	  <label for="inputType" class="control-label">Branch: </label>
		</div>
	</div>        	  
</div>
<div class='row'>
    <div class="col-md-4">
		<div class="form-group">
		      	

			<select name="branchNo" id="branchNo" name="branchNo" class="form-control" required="required">


				<?php


					while($row = mysqli_fetch_array($query)){

						
					echo "	<option value='".$row['branch_no']."'>".$row['branch_name']."</option>";

					}


				?>

				
			</select>



		</div>
	</div> 
</div>

<div class='row'>
    <div class="col-md-4">
		<div class="form-group">
		      	  <label for="inputType" class="control-label">Customer: </label>
		</div>
	</div>        	  
</div>
<div class='row'>
    <div class="col-md-4">
		<div class="form-group">
		      	<input type="text" class="form-control" required='required' name="customerName" id="customerName" placeholder=""  autocomplete="off">
		</div>
	</div> 
</div>
<div class='row'>
    <div class="col-md-4">
		<div class="form-group">
		      	  <label for="inputType" class="control-label">Recipient: </label>
		</div>
	</div>        	  
</div>
<div class='row'>
    <div class="col-md-4">
		<div class="form-group">
		      	<input type="text" class="form-control" required='required' name="recipient" id="recipient" placeholder=""  autocomplete="off">
		</div>
	</div> 
</div>
<div class='row'>
    <div class="col-md-4">
		<div class="form-group">
		      	  <label for="inputType" class="control-label">Cash: </label>
		</div>
	</div>        	  
</div>
<div class='row'>
    <div class="col-md-4">
		<div class="form-group">
		      	<input type="text" value="<?php echo $tranInfo['amount'] + $serviceCharge  ?>" class="form-control" required='required' name="cashAmount" id="cashAmount" autocomplete="off">
		</div>
	</div> 
</div>
<div class='row'>
    <div class="col-md-4">
		<div class="form-group">
			  <button type="submit" id="btnAssign" name="btnAssign" style='width:100%;' class="btn btn-primary" style='width:90%;'>Assign Now</button>
		</div>
	</div> 
</div>



</form>
