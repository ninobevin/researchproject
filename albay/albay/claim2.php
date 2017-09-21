<?php



include('head.php');


?>

<div class='container'>

<?php

	

if(isset($_REQUEST['btnFormSubmit'])){


	@$cust_id_off = trim($_REQUEST['cust_id_off']) == "" ? 0 :trim($_REQUEST['cust_id_off']) ;

	//echo $cust_id_off;

	$customerId = $_REQUEST['customerId'];
	$ref_no = $_REQUEST['referenceNumber'];
	$cash = $_REQUEST['actualTotal'];
	$branch = $_REQUEST['branchNo'];
	$amount = $_REQUEST['amount'];
	$account = $_REQUEST['account'];
	$user = $_SESSION['userz']['user_id'];


	$comp = new computation($con->getConnection());

	//echo "hahahah";
	$service_charge = $comp->getClaimServiceCharge($amount,$account);

	$sql = $con->update("UPDATE transaction_sm set branch_no=$branch,user_id=$user,status=2,
						cust_id=$customerId,date_claimed=now(),cash_amount=$cash,service_charge='$service_charge',off_cust_id='$cust_id_off' where 
						ref_no = '$ref_no' and status=1");

		//echo "UPDATE transaction_sm set branch_no=$branch,user_id=$user,status=2,
						//cust_id=$customerId,date_claimed=now(),cash_amount=$cash,service_charge='$service_charge',off_cust_id=$cust_id_off where 
						//ref_no = '$ref_no' and status=1";
	 if(!$sql)
      {

          echo"<div class='alert alert-danger'>
		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
		<strong>Error! </strong> Problem with the connection, Please try again.
	</div>";

      }else{

          echo"<div class='alert alert-success'>
		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
		<strong>Success! </strong> Pending transaction has been claimed.
	</div>";
      } 



}


?>	

	
 <?php include('registerCustomer.php') ?>
	

			<form method="POST" action='' id='selfForm' role="form">
					<div class="form-group">
						<legend>Claim Form</legend>
					</div>	
				
				<?php include('findReference.php') ?>
				<?php include('findCustomer.php') ?>
				

			</form>

	</div>
</div>


<?php

include('foot.php');

?>
