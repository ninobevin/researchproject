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


	
if(isset($_REQUEST['delete']))
{
	$idDelete = $_REQUEST['delete'];
	
	$loadConnection->update("delete from request where req_no = $idDelete and read_server=0;");
	
	die("<br><br><br>Delete success <a href='viewLoadRequest.php'>RELOAD CLICK HERE</a> ");
	
}


if(isset($_REQUEST['dateFormValue'])){

	$date = addslashes($_REQUEST['dateFormValue']);

}

$branch_no = $my_branch_no;
 
$dateTitle = $date;
$branchName =	mysqli_fetch_array($loadConnection->query("Select account_name from tbl_payment_account where pay_account_no=$branch_no"))["account_name"];




?>	


			

			
	<div class="page-header">
	  <h1>Pending Request<?php echo $branchName; ?>
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
					<th id='dataCenter'>Mobile</th>
					<th id='dataCenter'>Amount</th>
					<th id='dataCenter'>User</th>
					<th id='dataCenter'>STATUS</th>
					<th id='dataCenter'></th>
				</tr>
			</thead>
			<tbody>

	<?php


	
   $queryStr = "Select a.*,if(a.read_server = 0,'PENDING','OK') as stat,b.account_name from request a join tbl_payment_account b
				on a.branch_code = b.pay_account_no where a.branch_code = ".$branch_no." and date_format(a.date,'%Y-%m-%d') = date_format(now(),'%Y-%m-%d') ";




		$resultSet = $loadConnection->query($queryStr);
 


		//#	Date	Date Paid	Recipient	Reference	Amount	Balance	SIM	User


	
		$resultSet = $loadConnection->query($queryStr);

	
		$rowCtr1=0;
	

		
	    while(	$row =  @mysqli_fetch_array($resultSet) ){

		//req_no, mobile_no, amount, date, read_client, read_server, branch_code, user, notified


	    	echo "<tr>
	    			<td>".++$rowCtr1."</td>
					<td >".$row['date']."</td>
					<td id='dataCenter'>".$row['mobile_no']."</td>
					<td id='dataRight'>".$row['amount']."</td>
					<td id='dataCenter'>".$row['user']."</td>
					<td id='dataCenter'>".$row['stat']."</td>
					<td id='dataCenter'><a href='viewLoadRequest.php?delete=".$row['req_no']."'>CANCEL</a></td>
				 </tr>";

				
				 			
	    }
	 

	?>					
				
		  	</tbody>
		</table>


	


	
</div>


	
    </body>
</html>