<?php

include('head.php');

$date = @$_REQUEST['date'];


?>



<div class='container'>



				
	<legend>View Request</legend>
	<form action="" method="GET" class="form-inline" role="form">

		<div class="form-group">
			<label  for="date">Date of Request</label>
			<input type="date" name="date" id="date" class="form-control" value="" required="required" title="">
		</div>

		<button type="submit" name='search' class="btn btn-primary">Search</button>
	</form>
	<br>
					

		<div class="table-responsive">
			
	

		<table class="table table-hover">
			<thead >
				<tr id='tableHead'>
					<th>#</th><th>Date</th><th>Customer</th><th>Offline Customer</th><th>Amount</th><th>Recipient Mobile</th><th>Sender</th><th>Branch</th><th>SMARTMoney Number</th><th>Duration</th><th></th><?php if($main)echo "<th>REMARK</th>"; ?>
				</tr>
			</thead>
			<tbody>
				
					<?php
						$req = "";
						
						if($main){

			

							$req = $con->query("  SELECT TIMEDIFF(a.date_end,a.date) as durations, if(a.read_server=0,'PENDING','OK') as stats,e.req_rem_no,if(e.req_rem_desc = 'NONE' or null,'',e.req_rem_desc) as remark,a.*,concat(b.fname,' ',b.mname,'. ',b.lastname) as name,c.username as user,d.branch_name as branch ".
							               " from request a join customer b on a.cust_id=b.cust_id join users c on a.user_id ".
							               " = c.user_id join branch d on a.branch_no = d.branch_no 
										   left join request_remark e on a.remarks = e.req_rem_no 
										 where date_format(a.date,'%Y-%m-%d') = '$date';");


						}else{


							$req = $con->query(" select TIMEDIFF(a.date_end,a.date) as durations,if(a.read_server=0,'PENDING','OK') as stats,e.req_rem_no,if(e.req_rem_desc = 'NONE' or null,'',e.req_rem_desc) as remark,a.*,concat(b.fname,' ',b.mname,'. ',b.lastname) as name,c.username as user, d.branch_name as branch ".
							               " from request a join customer b on a.cust_id=b.cust_id join users c on a.user_id ".
							               " = c.user_id join branch d on a.branch_no=d.branch_no
											 left join request_remark e on a.remarks = e.req_rem_no 
										   where  a.branch_no = ". $_SESSION['userz']['branch_no']." and date_format(a.date,'%Y-%m-%d') = '$date';");

						}


						
						 $count = 1;
						 $total = 0;
						 while($row = mysqli_fetch_array($req))
						 {

						 	$loc = base64_encode($row['request_no']);

						 	//request_no, cust_id, branch_no, read_server, read_client, amount, recipient, user_id
						 	echo "<form action='assignment.php'><tr>";
						 	
						 	echo "<td>$count<input type='hidden' name='reqNo' value='".$row['request_no']."'>
						 	<input type='hidden' name='cust_id' value='".$row['cust_id']."'></td>
						 	<input type='hidden' name='branch_no' value='".$row['branch_no']."'></td>
						 	<input type='hidden' name='off_cust_id' value='".$row['off_cust_id']."'></td>";

						 	echo "<td>".$row['date']."</td>";
						 	echo "<td>".$row['name']."</td>";
						 	echo "<td>".$row['off_cust_id']."</td>";
						 	echo "<td>".$row['amount']."</td>";
						 	echo "<td>".$row['recipient']."</td>";
						 	echo "<td>".$row['user']."</td>";
						 	echo "<td>".$row['branch']."</td>";
						 	echo "<td>".$row['smartmoneynumber']."</td>";

							echo "<td>".$row['durations']."</td>";
						 	echo "<td>".$row['stats']."</td>";
							echo "<td style='color:red;'>".$row['remark']."</td>";
						 
				
						 	

						 	echo "</tr></form>";
							
						 if(($row['req_rem_no'] == 1 || $row['req_rem_no'] == '')  || $row['req_rem_no'] == 4){
							
								 $total = $total + $row['amount'];
							
							}
							$count++;					 	

						 }

	echo "<th></th><th></th><th></th><th>TOTAL: </th><th>".number_format($total,2)."</th><th></th><th></th><th></th><th></th><th></th><th></th>"; ?>



		
			</tbody>

		</table>
	</div>


	

					
				


	
</div>
<script>
/*
$("#btnSubmit").click(function(){

alert();

});
*/




$('#myModal').on('show.bs.modal', function(e) {
  //  $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));

  var loc = $(e.relatedTarget).data('href');

  		$("#btn-ok").click(function(){


  			$(location).attr('href', loc);

  		});

});
</script>

<?php

include('foot.php');

?>