<!DOCTYPE html>
<html lang="">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Claim</title>

	</head>
	<body>
		<?php


    include('head.php');

    $smsbody = "";
    $amount = 0.00;
	$serviceCharge = 0.00; 
	$amount = 0.00;
	$ref_no = null;
	$responseMsg = "";
		                       




    if(isset($_REQUEST['ref_no']))
    {




    	$row = mysqli_fetch_array( $con->query("select * from transaction_sm where 
    						   ref_no = ".$_REQUEST['ref_no']."  limit 1;"));


    	if($con->getRowCount() < 1)
    	{


    		$responseMsg = "<font color='red'>No record Found!</font>";

    	}else{


    		if($row['status'] == 2)
    		{
    			$responseMsg = "<font color='red'>Reference is already in claimed status! Please Contact the ADMIN.</font>";
    			
    		}else if($row['status'] == 1){
    			

    				$smsbody = $row['body_sms'];
					$amount = $row['amount'];
					$serviceCharge = $comp->getClaimServiceCharge($row['amount'],$row['account']);
					$cashtotal = $row['amount'] - $serviceCharge;
					$ref_no = $row['ref_no'];


    		}else{

    			$responseMsg = "<font color='red'>No record Found!</font>";
    		
    		}

    		echo $ref_no;

    	}


    }
     if(isset($_REQUEST['claim-submit']))
    {



    		if($_REQUEST['reference_no']){

    			$ref = $_REQUEST['reference_no'];
    			$customername = $_REQUEST['customername'];
    			$serviceCharge = $_REQUEST['serviceCharge'];
    			$cash = $_REQUEST['cashtotal'];

    			
    			$resultQuery = $con->update("Update transaction_sm set status=2,cust_id=3808,off_cust_id='$customername',
    						date_claimed=now(),branch_no=$branchNo,service_charge=$serviceCharge,cash_amount=$cash,user_id=$userId where status=1 and ref_no='$ref' ");


    			if($resultQuery)
    			{

    				$responseMsg = "<font color='green'>Successfully Claimed!</font>";
    			}else{

					$responseMsg = "<font color='red'>Sorry! We encountered a problem while processing. Please try again.</font>";    				
    			}


    		}
    		

    }


?>

	<style>

table { border-collapse: collapse; }
tr:nth-child(1) { border-bottom: solid gray thick; line-height: 40px;}
tr{
	line-height: 40px;
}

	</style>
		
		<div style='width:100%;'>


		       <div>
		       		<div style='margin-top:10%;'>
		       			<div style='text-align:center;'>
			       			
			       				<?php echo $responseMsg; ?>
			       			
		       			</div>
		       			<div style='text-align:center;'>
		       				<div>
		       				<?php	echo $branchName; ?>
		       				</div>
			       			<h3>
			       				Claim Form
			       			</h3>
		       			</div>
		       		</div>
		            <form action='' method='post'>
		                    <table style='margin:0 auto; width:40%;'>


		                        <tr id='tr-ref'>

		                            <td style='width:50%;' >Reference:<td/>
		                            <td><input type='number' required='required' style='text-align:center;' name='ref_no'><td/>
		                        </tr>
		            </form>
		            <form action='' method='post'>            
		                        <tr>
		                            <td style=' vertical-align: baseline;'>Sms:<td/>
		                            <td><?php echo @$smsbody ?><input type='hidden' name='reference_no' value='<?php echo @$ref_no ?>'><td/>
		                        </tr>
		                        <tr>
		                            <td>Amount:<td/>
		                            <td><b><?php echo number_format(@$amount,2) ?></b><td/>
		                        </tr>
		                        <tr>
		                            <td>Service Charge:<td/>
		                            <td><b><?php echo  number_format(@$serviceCharge,2)  ?><input type='hidden' name='serviceCharge' value='<?php echo @$serviceCharge ?>'></b><td/>
		                        </tr>
		                        <tr>
		                            <td>Cash Total:<td/>
		                            <td><input type='number' value='<?php echo @$cashtotal ?>' style='text-align:center;' name='cashtotal'><td/>
		                        </tr>
		                         <tr>
		                            <td>Customer Name:<td/>
		                            <td><input type='text' required='required' style="text-transform:uppercase; text-align:center;"  placeholder='First,Middle,Last'  s name='customername'><td/>
		                        </tr>
		                        <tr>
		                        	<td>
		                                <input type='submit' value='Claim' style='width:40%;'  name='claim-submit'>
		                                <input type='submit' value='Cancel' style='width:40%;' name='btn-cancel'>
		                            <td/>
		                           
		                             <td><td/>
		                           
		                        </tr>


		                    <table>
		            </form>
		        </div>

		<div>

	</body>
</html>