<?php



include('head.php');







?>
<style>
	
	
</style>

<div class='container'>

<?php


	$date = date("Y-m-d");



if(isset($_REQUEST['btnFormSubmit'])){



	$customerId = $_REQUEST['customerId'];
	$ref_no = $_REQUEST['referenceNumber'];

	

	$sql = $con->update("UPDATE transaction_sm set status=2,cust_id=$customerId,date_claimed=now() where ref_no = '$ref_no' and status=1");
		

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


if(isset($_REQUEST['dateFormValue'])){

	$date = addslashes($_REQUEST['dateFormValue']);

}


?>	


			

			
	<div class="page-header">
	  <h1>Today's Transaction Summary
	  	<br><small><?php echo date('F d Y (l)',strtotime($date)) ?></small>
	  </h1>
	
	
	  <form name='dateForm' class="form-inline" role="form">


	  	<div class='form-group'>
		  	<input type="date" name="dateFormValue" id="input" class="form-control" value="" required="required" title="">
		  	
	  	</div>
	  	<button type="submit" class="btn btn-primary">Go</button>

	  </form>

	</div>
	<h3><u>Claimed</u></h3>
	<table class='table table-hover'>
			<thead id='tableHead'>
				<tr >
					<th id='dataCenter'>#</th>
					<th id='dataCenter'>Date</th>
					<th id='dataCenter'>Date Claimed</th>
					<th id='dataCenter'>Reference</th>
					<th id='dataCenter'>PAmount</th>
					<th id='dataCenter'>Cash</th>
					<th id='dataCenter'>User</th>
				</tr>
			</thead>
			<tbody>

	<?php


	  $queryStr = "select a.date as date,a.date_claimed as date_claimed,a.ref_no as ref_no,a.amount as amount,a.cash_amount as cash_amount,b.username as user
	  			   from view_claimed_sm a join users b on a.user_id=b.user_id where date_format(a.date_claimed,'%Y-%m-%d')='$date' and a.branch_no=".$_SESSION['userz']['branch_no'].";";




		$resultSet = $con->query($queryStr);


		$totalClaimed = 0.00;
		$totalClaimedP = 0.00;
		$rowctr1=0;

		$C_pamount=0.00;
		$C_amount=0.00;

	    while(	$row =  mysqli_fetch_array($resultSet) ){


	    	echo "<tr>
	    			<td>".++$rowctr1."</td>".
					"<td>".$row['date']."</td>
					<td>".$row['date_claimed']."</td>
					<td id='dataCenter'>".$row['ref_no']."</td>
					<td id='dataRight'>".$row['amount']."</td>
					<td id='dataRight'>".$row['cash_amount']."</td>
					<td id='dataCenter'>".$row['user']."</td>
				 </tr>";
				 $totalClaimed = $totalClaimed + $row['cash_amount'];
				 $totalClaimedP += $row['amount'];

				 $C_pamount= $totalClaimedP;
				 $C_amount=$totalClaimed;
	    }
	   	   	echo "<tr>
					<td></td>
					<td></td>
					<td></td>
					<td id='dataRight'></td>
					<td id='dataRight'><b>".number_format($totalClaimedP,2)."</b></td>
					<td id='dataRight'><b>".number_format($totalClaimed,2)."</b></td>
					<td></td>
				 </tr>";


	?>					
				
		  	</tbody>
		</table>

	<h3><u>Sent</u></h3>
	<table class='table table-hover'>
			<thead id='tableHead'>
				<tr >
					<th id='dataCenter'>#</th>
					<th id='dataCenter'>Date</th>
					<th id='dataCenter'>Reference</th>
					<th id='dataCenter'>PAmount</th>
					<th id='dataCenter'>Net Charge</th>
					<th id='dataCenter'>Cash</th>
					<th id='dataCenter'>Balance</th>
					
				</tr>
			</thead>
			<tbody>

	<?php


	  $queryStr = "select a.date as date,a.balance as bal,a.service_charge,a.ref_no as ref_no,a.amount as amount,a.cash_amount as cash_amount
	  			   from view_sent2 a where a.status=3 and date_format(a.date,'%Y-%m-%d')='$date' and a.branch_no=".$_SESSION['userz']['branch_no']." order by a.date asc;";


		$resultSet = $con->query($queryStr);

		$totalSent = 0.00;
		$totalSentP = 0.00;
		$rowctr2=0;

		$S_pamount=0.00;
		$S_amount=0.00;
		
		$service = 0;

	    while(	$row =  mysqli_fetch_array($resultSet) ){


	    	echo "<tr>
	    			<td>".++$rowctr2."</td>".
					"<td>".$row['date']."</td>
					<td id='dataCenter'>".$row['ref_no']."</td>
					<td id='dataRight'>".$row['amount']."</td>
					<td id='dataRight'>".$row['service_charge']."</td>
					<td id='dataRight'>".$row['cash_amount']."</td>
					<td id='dataRight'>".$row['bal']."</td>
				 </tr>";
			$totalSent += $row['cash_amount'];
			$totalSentP += $row['amount'];
			$service += $row['service_charge'];

			$S_pamount=$totalSentP;
			$S_amount=$totalSent;
			

	    }

	    	echo "<tr>
					<td></td>
					<td></td>
					<td></td>
					<td id='dataRight'><b>".number_format($totalSentP,2)."</b></td>
					<td id='dataRight'><b>".number_format($service,2)."</b></td>
					<td id='dataRight'><b>".number_format($totalSent,2)."</b></td>
					<td></td>															
				 </tr>";


	?>					
				
		  	</tbody>
		</table>
			

			<table class='table table-hover'>
			<thead>
				<tr >
					<th></th><th>Total Transaction</th><th>Total PAmount</th><th>Total Amount</th>
				</tr>
			</thead>
			<tbody >
				<tr >
					<th>Claimed</th><th><?php echo $rowctr1; ?></th><th><?php echo number_format($C_pamount,2); ?></th><th><?php echo number_format($C_amount,2); ?></th>
				</tr>
				<tr >
					<th>Sent</th><th><?php echo $rowctr2; ?></th><th><?php echo number_format($S_amount,2); ?></th><th><?php echo number_format($S_amount,2); ?></th>
				</tr>
			</tbody>
		</table>
	

	</div>
	
</div>


<?php

include('foot.php');

?>
