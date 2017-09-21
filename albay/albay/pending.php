<?php


include('head.php');



	 $date = date("Y-m-d");
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
  <h3>Pending Transaction Summary</h3>
</div>
</div>
<form action="" method="POST"  class="form-inline" role="form">
	<div class='row'>
	
		
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
			<?php 

			echo "<a href='admin/fprintpending.php?dateFormValue=".$date."&dateTo=".$dateTo."'>";

			 ?>Print this now? Click here</a>
		</div>
		<hr>
	</div>




	

	
</form>





<h3><u>Pending</u></h3>
	<table class='table table-hover'>
			<thead >
				<tr >
					<th id='dataCenter'>#</th>
					<th id='dataCenter'>Date</th>
					<th id='dataCenter'>Reference</th>
					<th id='dataCenter'>PAmount</th>
				</tr>
			</thead>
			<tbody>

	<?php


	   $queryStr = "select date,ref_no,amount from transaction_sm 
	  			   where status=1 and date_format(date,'%Y-%m-%d') between  '$date' and '$dateTo'";





		$resultSet = $con->query($queryStr);

		$total = 0.00;
		$totalClaimedP = 0.00;
		$rowCtr1=0;
		$C_pamount=0;
		$C_amount=0;


		
	    while(	$row =  @mysqli_fetch_array($resultSet) ){



	    	echo "<tr>
	    			<td>".++$rowCtr1."</td>
					<td>".$row['date']."</td>
				
				
					<td id='dataCenter'>".$row['ref_no']."</td>
					<td id='dataRight'>".$row['amount']."</td>
				
				
				 </tr>";

				
				 $total += $row['amount'];
		
				
	    }
	    echo "<tr>
				<td></td><td></td> <td id='dataRight'><b>TOTAL:</b> </td><td id='dataRight'><b>".number_format($total,2)."</b></td>
			 </tr>";



	



	?>					
				
		  	</tbody>
		</table>



</div>









<?php

	include('foot.php');
?>