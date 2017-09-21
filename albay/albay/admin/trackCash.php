<?php


include('head.php');



	$date = date("Y-m-d");





if(isset($_REQUEST['dateFormValue'])){

	$date = addslashes($_REQUEST['dateFormValue']);

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
			<div class='form-group'>
		  	<input type="date" name="dateFormValue" id="input" class="form-control" value="" required="required" title="">
		  	
	  	</div>
		<div class="form-group">
			<button type="submit" name='btnFindBranch' class="btn btn-primary">Generate</button>
		</div>

		<hr>
	</div>

	

	
</form>

<?php

	$account_no ="";
	
	if(isset($_REQUEST['btnFindBranch'])){


	
$account_no =$_REQUEST['account_no'];



	}else{

		
	}

?>

<p>The value of <u>difference</u> indicates that an sms was deleted or was not added to application filter.</p>
	<table class='table table-hover'>
			<thead >
				<tr >
					<th id='dataCenter'>#</th>
					<th id='dataCenter'>Date</th>
					<th id='dataCenter'>Status</th>
					<th id='dataCenter'>Branch</th>
					<th id='dataCenter'>User</th>
					<th id='dataCenter'>Reference</th>
					<th id='dataCenter'>PAmount</th>
					<th id='dataCenter'>Service Charge</th>
					<th id='dataCenter'>Expected</th>
					<th id='dataCenter'>Actual</th>
					<th id='dataCenter'>Difference</th>
				</tr>
			</thead>
			<tbody>

	<?php


	     $queryStr = "select a.service_charge,branch_name,b.username,a.balance,a.cash_amount,c.name as status,a.status as
 statusNum,a.date as date,a.date_claimed as date_claimed,a.ref_no as ref_no,a.amount as amount 
 from transaction_sm a join status_sm c on a.status=c.sm_status_no
 left join users b on a.user_id=b.user_id left join branch e on a.branch_no = e.branch_no where 
a.account=$account_no and date_format(a.date,'%Y-%m-%d')='$date' order by a.date;";





		$resultSet = $con->query($queryStr);


		$count = 1;
	
	    while(	$row =  @mysqli_fetch_array($resultSet) ){


	    	
	    		

	    		$expected = 0.00;
				$var  =0.00;

				if($row['statusNum'] == 2){

					$expected = $row['amount'] - $row['service_charge'] ;
					$var = $expected - $row['cash_amount'];	


				}elseif ($row['statusNum'] == 3) {
					$expected = $row['amount'] + $row['service_charge'] ;
					$var = $expected - $row['cash_amount'];	

				}elseif ($row['statusNum'] == 1) {
					
				}


	    	echo "<tr><td>".$count++."</td>
					<td>".$row['date']."</td><td>".$row['status']."</td><td>".$row['branch_name']."</td><td>".$row['username']."</td><td>".$row['ref_no']."</td><td id='dataCenter'>".
					$row['amount']."</td><td id='dataRight'>".
					$row['service_charge']."</td><td id='dataRight'>".$expected."</td><td id='dataRight'>".($row['cash_amount'])."</td>
					<td id='dataRight'>";
					if( $var > 0)
						echo "<b style='color:green;'>".number_format($var,2)."</b>";
					else if($var == 0)
						echo "<b>$var</b>";
					else
						echo "<b style='color:red;'>".number_format($var,2)."</b>"."</td>";

				 echo "</tr>";

				
				
				

	    }
	    

	?>					
				
		  	</tbody>
		</table>




</div>









<?php

	include('foot.php');
?>