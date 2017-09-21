<?php


include('head.php');



	$date = date("Y-m-d");
$dateTo = date("Y-m-d");





if(isset($_REQUEST['dateFormValue'])){

	$date = addslashes($_REQUEST['dateFormValue']);

	$dateTo = addslashes($_REQUEST['dateTo']);

}

	$comp = new computation($con->getConnection());





?>
<style>



</style>

<div class='container' style='padding-top:10px;'>


<div class='row'>
<div class="page-header">
  <h3>Transaction Summary</h3>
</div>
</div>
<form action="" method="POST" class="form-inline" role="form">
	<div class='row'>
		<div class="form-group">
			<span><h4>Select Branch </h4></span>
		</div>
		<div class="form-group">
			
			<select name="account_no" id="account_no" class="form-control" required="required">
				<?php

					$query =$con->query("select * from account_sm;");

					while($row = mysqli_fetch_array($query)){

							echo "<option value='".$row['account_no']."'>".$row['name']."</option>";

					}

				?>
			</select>
		</div>
		
	  	<div class="form-group">
	  		   <span class="label label-primary">From: </span>
                      <input type="date" value=<?php echo $date; ?> class="form-control" name="dateFormValue" id="input">
                       

	  	</div>

	  	<div class="form-group">
	  		 <span class="label label-primary">To: </span>
                      <input type="date" value=<?php echo $dateTo; ?>  class="form-control" name="dateTo" id="input">

	  	</div>

		<div class="form-group">
			<button type="submit" name='btnFindBranch' class="btn btn-primary">Generate</button>
		</div>
		


	</div>
	
	<hr>
	

	

	
</form>

<?php

	$account_no ="";
	
	if(!isset($_REQUEST['btnFindBranch'])){


	




	}else{

		$account_no =$_REQUEST['account_no'];
	}

?>

<p>The value of <u>difference</u> indicates that an sms was deleted or was not added to application filter.</p>
	<table class='table table-hover'>
			<thead >
				<tr >
					<th id='dataCenter'>#</th>
					<th id='dataCenter'>Date</th>
					<th id='dataCenter'>Status</th>
					<th id='dataCenter'>Reference</th>
					<th id='dataCenter'>PAmount</th>
					<th id='dataCenter'>Account</th>
					<th id='dataCenter'>Balance</th>
					<th id='dataCenter'>Difference</th>
				</tr>
			</thead>
			<tbody>

	<?php


	    $queryStr = "select a.balance,c.name as status,a.status as statusNum,b.name as accountname,a.date as date,a.date_claimed as date_claimed,a.ref_no as ref_no,a.amount as amount
	  			   from transaction_sm a join account_sm b on a.account=b.account_no
	  			    join status_sm c on a.status=c.sm_status_no where a.account=$account_no and date_format(a.date,'%Y-%m-%d') between '$date' and '$dateTo' and a.status > 3  
	  			    order by a.date;";





		$resultSet = $con->query($queryStr);


		$totalClaimedP = 0.00;
		$count = 1;
		 $balance =0.00;
		  $amountVar =0.00;
		  
		  $FirstBal = 0.00;
		  $LastBal = 0.00;
		  $totalDiff = 0.00;
	    while(	$row =  @mysqli_fetch_array($resultSet) ){


	    		if($count > 1){



	    			$statusCheck = mysqli_fetch_array($con->query("select incoming from status_sm where sm_status_no = ".$row['statusNum'].";"))['incoming'];


    				
		    		if($statusCheck == 1){

						$amountVar = $row['amount'];

					}else{

						$amountVar = ($row['amount'] + $comp->getTransferCharge($row['amount'])) * -1;
					}


	    		}else{
					
					$FirstBal = $row['balance'];
					
				}
				
				$totalClaimedP =  $totalClaimedP + $amountVar;

				
	    		$var = $row['balance'] - ($balance + $amountVar);
				
				$totalDiff = $totalDiff + $var;

	    	echo "<tr><td>".$count++."</td>
					<td>".$row['date']."</td><td>".$row['status']."</td><td>".$row['ref_no']."</td><td id='dataCenter'>".
					$row['amount']."</td><td id='dataRight'>".
					$row['accountname']."</td><td id='dataRight'>".$row['balance']."</td>
					<td id='dataRight'>";
					if( $var > 0)
						echo "<b style='color:green;'>$var</b>";
					else if($var == 0)
						echo "<b>$var</b>";
					else
						echo "<b style='color:red;'>$var</b>"."</td>";

				 echo "</tr>";

				$balance = $row['balance'];
				
				
				

	    }
	    

	?>				
				<tr >
					<th id='dataCenter'></th>
					<th id='dataCenter'></th>
					<th id='dataCenter'>TOTAL:</th>
					<th id='dataCenter'>PAmount</th>
					<th id='dataCenter'><?php echo number_format($totalClaimedP,2); ?></th>
					<th id='dataCenter'><?php echo number_format($balance - $FirstBal,2); ?></th>
					<th id='dataCenter'></th>
					<th id='dataCenter'><?php echo number_format($totalDiff - $FirstBal,2); ?></th>
				</tr>	
				
		  	</tbody>
		</table>




</div>









<?php

	include('foot.php');
?>