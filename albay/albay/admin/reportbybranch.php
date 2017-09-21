<?php


include('head.php');



	echo $date = date("Y-m-d");
	$dateTo = date("Y-m-d");





if(isset($_REQUEST['dateFormValue'])){

	$date = addslashes($_REQUEST['dateFormValue']);

	$dateTo = addslashes($_REQUEST['dateTo']);

}





/*


                        <span class="label label-primary">From: </span>
                      <input type="date" value=<?php echo $dateEntry; ?> style="min-width: 0; width: auto; display: inline;" class="form-control" name="dateEntry" id="dateEntry">
                        <span class="label label-primary">To: </span>
                      <input type="date" value=<?php echo $dateEntryTo; ?> style="min-width: 0; width: auto; display: inline;" class="form-control" name="dateEntryTo" id="dateEntryTo">



*/




?>
<style>



</style>

<div class='container' style='padding-top:10px;'>


<div class='row'>
<div class="page-header">
  <h3>Sales Summary</h3>
</div>
</div>
<form action="" method="POST" class="form-inline" role="form">
	<div class='row'>
		<div class="form-group">
			<span><h4>Select Branch </h4></span>
		</div>
		<div class="form-group">
			
			<select name="branch_no" id="branch_no" class="form-control" required="required">
				<?php

					$selectedBranch = @$_REQUEST['selectedBranch'];

					$query =$con->query("select * from branch;");

					while($row = mysqli_fetch_array($query)){

							echo "<option value='".$row['branch_no']."'>".$row['branch_name']."</option> 
							<inpu type='hidden' name='branch_name' value='".$row['branch_name']."'> ";

					}

				?>
			</select>
		

	  	<div class="form-group">
	  		   <span class="label label-primary">From: </span>
                      <input type="date" value=<?php echo $date; ?> class="form-control" name="dateFormValue" id="input">
                       

	  	</div>

	  	<div class="form-group">
	  		 <span class="label label-primary">To: </span>
                      <input type="date" value=<?php echo $dateTo; ?>  class="form-control" name="dateTo" id="input">

	  	</div>


		<div class="form-group">
			<button type="submit" name='btnFindBranch' class="btn btn-primary" href='reportbybranch.php?selectedBranch=$i' >Generate</button>
		</div>

	</div>
	<div class='row'>
		<div class="form-group">
			 <a href="pdfPrint.php?branch_no=<?php echo @$_REQUEST['branch_no'].'&dateFormValue='.$date.'&dateTo='.$dateTo;?>">Print this now? Click here</a>
		</div>
		<hr>
	</div>




	

	
</form>

<?php

	$branch_no ="";
	
	
	if(!isset($_REQUEST['btnFindBranch'])){


	




	}else{

	$branch_no =$_REQUEST['branch_no'];
 
	$dateTitle = $date;
	$branchName =	mysqli_fetch_array($con->query("Select branch_name from branch where branch_no=$branch_no"))["branch_name"];

echo "
		<div style='text-align:center; color:white; background-color:#337AB7;'>
			<h3>".@$branchName."<br>".$date."</h3>
		</div>
	";

	}

?>



<h3><u>Claimed</u></h3>
	<table class='table table-hover'>
			<thead >
				<tr >
					<th id='dataCenter'>#</th>
					<th id='dataCenter'>Date</th>
					<th id='dataCenter'>Date Claimed</th>
					<th id='dataCenter'>SM No</th>
					<th id='dataCenter'>Reference</th>
					<th id='dataCenter'>PAmount</th>
					<th id='dataCenter'>Cash</th>
					<th id='dataCenter'>User</th>
				</tr>
			</thead>
			<tbody>

	<?php


	  $queryStr = "select a.date as date,a.smart_money,a.date_claimed as date_claimed,a.ref_no as ref_no,a.amount as amount,a.cash_amount as cash_amount,b.username as user
	  			   from view_claimed_sm a join users b on a.user_id=b.user_id where date_format(a.date_claimed,'%Y-%m-%d') between  '$date' and '$dateTo' and a.branch_no=$branch_no;";





		$resultSet = $con->query($queryStr);

		$totalClaimed = 0.00;
		$totalClaimedP = 0.00;
		$rowCtr1=0;
		$C_pamount=0;
		$C_amount=0;


		
	    while(	$row =  @mysqli_fetch_array($resultSet) ){



	    	echo "<tr>
	    			<td>".++$rowCtr1."</td>
					<td>".$row['date']."</td>
					<td>".$row['date_claimed']."</td>
					<td id='dataCenter'>".$row['smart_money']."</td>
					<td id='dataCenter'>".$row['ref_no']."</td>
					<td id='dataRight'>".$row['amount']."</td>
					<td id='dataRight'>".$row['cash_amount']."</td>
					<td id='dataCenter'>".$row['user']."</td>
				 </tr>";

				 $totalClaimed += $row['cash_amount'];
				 $totalClaimedP += $row['amount'];
				 $C_pamount+= $totalClaimedP;
				 $C_amount+=$totalClaimed;
				
	    }
	    echo "<tr>
					<td></td><td></td><td id='dataRight'><b>TOTAL:</b> </td><td id='dataRight'><b>".number_format($totalClaimedP,2)."</b></td><td id='dataRight'><b>".number_format($totalClaimed,2)."</b></td><td></td>
			 </tr>";



	



	?>					
				
		  	</tbody>
		</table>

	<h3><u>Sent</u></h3>
	<table class='table table-hover'>
			<thead >
				<tr >
					<th id='dataCenter'>#</th>
					<th id='dataCenter'>Date</th>
					<th id='dataCenter'>SM No</th>
					<th id='dataCenter'>Reference</th>
					<th id='dataCenter'>PAmount</th>
					<th id='dataCenter'>Cash</th>
					
				</tr>
			</thead>
			<tbody>

	<?php


	  $queryStr = "select a.date as date,smart_money as smno,a.ref_no as ref_no,a.amount as amount,a.cash_amount as cash_amount
	  			   from view_sent2 a where date_format(a.date,'%Y-%m-%d') between '$date' and '$dateTo' and a.branch_no=$branch_no;";



		$resultSet = $con->query($queryStr);

		$totalSent = 0.00;
		$totalSentP = 0.00;
		$rowCtr2=0;
		$S_pamount=0.00;
		$S_amount=0.00;
	    while(	$row =  @mysqli_fetch_array($resultSet) ){


	    	echo "<tr>
	    			<td>".++$rowCtr2."</td>
					<td>".$row['date']."</td>
					<td id='dataCenter'>".$row['smno']."</td>
					<td id='dataCenter'>".$row['ref_no']."</td>
					<td id='dataRight'>".$row['amount']."</td>
					<td id='dataRight'>".$row['cash_amount']."</td>
				 </tr>";

				$totalSent += $row['cash_amount']; 
			$totalSentP += $row['amount'];

			$S_pamount+=$totalSentP;
		$S_amount+=$totalSent;

	    }

	    	echo "<tr>
					<td></td><td id='dataRight'><b>TOTAL:</b></td><td id='dataRight'><b>".number_format($totalSentP,2)."</b></td><td id='dataRight'><b>".number_format($totalSent,2)."</b></td>
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
					<th>Claimed</th><th><?php echo $rowCtr1; ?></th><th><?php echo number_format($C_pamount,2); ?></th><th><?php echo number_format($C_amount,2); ?></th>
				</tr>
				<tr >
					<th>Sent</th><th><?php echo $rowCtr2; ?></th><th><?php echo number_format($S_amount,2); ?></th><th><?php echo number_format($S_amount,2); ?></th>
				</tr>
			</tbody>
		</table>






</div>









<?php

	include('foot.php');
?>