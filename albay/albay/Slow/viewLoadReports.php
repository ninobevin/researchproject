<?php



include('head.php');







?>

<style>


	#tableDetails th
	{

		padding-left: 50px;
		padding-right: 50px;

	}

	#tableDetails td
	{

		text-align: center;

	}

</style>

<div class='container'>

<?php


	$date = date("Y-m-d");




if(isset($_REQUEST['dateFormValue'])){

	$date = addslashes($_REQUEST['dateFormValue']);

}

$branch_no = $my_branch_no;
 
$dateTitle = $date;
$branchName =	mysqli_fetch_array($loadConnection->query("Select account_name from tbl_payment_account where pay_account_no=$branch_no"))["account_name"];




?>	


			

			
	<div class="page-header">
	  <h1>Today's Transaction Summary <?php echo $branchName; ?>
	  	<br><small><?php echo date('F d Y (l)',strtotime($date)) ?></small>
	  </h1>
	
	
	  <form name='dateForm' class="form-inline" role="form">


	  	<div class='form-group'>
		  	<input type="date" name="dateFormValue" id="input" class="form-control" value="" required="required" title="">
		  	
	  	</div>
	  	<button type="submit" class="btn btn-primary">Go</button>

	  </form>

	</div>
	<h3><u>LOADWALLET </u></h3>
	<table id='tableDetails'>
			<thead >
				<tr >
					<th id='dataCenter'>#</th>
					<th id='dataCenter'>Date</th>
					<th id='dataCenter'>Date Paid</th>
					<th id='dataCenter'>Recipient</th>
					<th id='dataCenter'>Reference</th>
					<th id='dataCenter'>Amount</th>
					<th id='dataCenter'>Balance</th>
					<th id='dataCenter'>SIM</th>
					<th id='dataCenter'>User</th>
				</tr>
			</thead>
			<tbody>

	<?php


	
   $queryStr = "select balance,date as dates,sim_slot,date_paid as datepaid, recipient as recipient, reference_no as ref_no, amount as amount, user_account as users
					from tbl_transaction where date_format(date,'%Y-%m-%d')='$date' and pay_account_no=$branch_no;";




		$resultSet = $loadConnection->query($queryStr);



		//#	Date	Date Paid	Recipient	Reference	Amount	Balance	SIM	User


	
		$resultSet = $loadConnection->query($queryStr);

		$totalAmount = 0.00;
		$totalClaimedP = 0.00;
		$rowCtr1=0;
		$C_pamount=0;
		$C_amount=0;


		
	    while(	$row =  @mysqli_fetch_array($resultSet) ){



	    	echo "<tr>
	    			<td>".++$rowCtr1."</td>
					<td>".$row['dates']."</td>
					<td>".$row['datepaid']."</td>
					<td id='dataCenter'>".$row['recipient']."</td>
					<td id='dataCenter'>".$row['ref_no']."</td>
					<td id='dataRight'>".$row['amount']."</td>
					<td id='dataRight'>".$row['balance']."</td>
					<td id='dataRight'>".$row['sim_slot']."</td>
					<td id='dataRight'>".$row['users']."</td>
				 </tr>";

				 $totalAmount += $row['amount'];
				 			
	    }
	    echo "<tr>
					<td></td><td></td><td></td></td><td><td id='dataRight'><b>TOTAL:</b> </td><td id='dataRight'><b>".number_format($totalAmount,2)."</b></td><td id='dataRight'></td><td id='dataRight'></td><td></td>
			 </tr>";

	?>					
				
		  	</tbody>
		</table>


<table id = 'tableDetails'>

		<?php


	$queryStr = "select count(*) as counts,sim_slot,sum(amount) as total from tbl_transaction where date_format(date,'%Y-%m-%d')='$date' and pay_account_no=$branch_no group by sim_slot;";


	$resultSet = $loadConnection->query($queryStr);



    while(	$row =  @mysqli_fetch_array($resultSet) ){



	    	echo "<tr>
	    			<td style='padding:5px;'><b>".$row['counts']."</b></td>

					<td style='padding:5px;'><b>SIM (".$row['sim_slot'].")</b></td>
					<td style='padding:5px;'><b>".$row['total']."</b></td>	
				 </tr>";

				
				 			
	    }
	   

	?>

	

</table>



	</div>
	
</div>


	
    </body>
</html>