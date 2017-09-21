<?php

include('head.php');




?>



<div class='container'>


	<?php 

			if(isset($_REQUEST['delete']))
			{






				$conn = new connection();

				$reqNo = $_REQUEST['delete'];

				//print_r($_REQUEST['reqNo']);

				
				$queryString = "delete from request where request_no='$reqNo' and read_server=0;";
			    
			    $sql = $con->update($queryString);

							     if(!$sql)
				      {
				          	echo"<div class='alert alert-danger'>
								 <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
						         <strong>Error! </strong> Problem with the connection, Please try again.
						         </div>";

				      }else{

				            echo"<div class='alert alert-success'>
						        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
						        <strong>Success! </strong> Request has been deleted.
					            </div>";
				      } 





			}


	?>


<style>


	#tableDetails th
	{

		padding: 20px;

	}

	#tableDetails td
	{

		text-align: center;

	}

</style>
				
	<legend style='margin-top:30px; margin-bottom:50px;'>View Request</legend>
					

		<div class="table-responsive">
			
	

		<table id="tableDetails" style='font-size:14px;' border='1'>
			<thead >
				<tr id='tableHead'>
					<th>#</th><th>Date</th><th>Customer</th><th>Offline Customer</th><th>Amount</th><th>Recipient Mobile</th><th>Sender</th><th>Branch</th><th>SMARTMoney Number</th><th>STATUS</th><th>DURATION</th><th>REMARK</th><th></th>
				</tr>
			</thead>
			<tbody>
				
					<?php
						$req = "";
						
						if($main){

			

							$req = $con->query(" select TIMEDIFF(a.date_end,a.date) as durations, a.*,if(a.read_server = 0,'PENDING','SEEN') as stats,
							e.req_rem_no,if(e.req_rem_desc = 'NONE' or null,'',e.req_rem_desc) as remark,
							concat(b.fname,' ',b.mname,'. ',b.lastname) as name,c.username as user,d.branch_name as branch ".
							               " from request a join customer b on a.cust_id=b.cust_id join users c on a.user_id ".
							               " = c.user_id join branch d on a.branch_no = d.branch_no where date_format(a.date,'%Y-%m-%d') = date_format(now(),'%Y-%m-%d')");


						}else{


							$req = $con->query(" select TIMEDIFF(a.date_end,a.date) as durations,a.*,if(a.read_server = 0,'PENDING','SEEN') as stats, 
											e.req_rem_no,if(e.req_rem_desc = 'NONE' or null,'',e.req_rem_desc) as remark,
											concat(b.fname,' ',b.mname,'. ',b.lastname) as name,c.username as user, d.branch_name as branch ".
							               " from request a join customer b on a.cust_id=b.cust_id join users c on a.user_id ".
							               " = c.user_id join branch d on a.branch_no=d.branch_no 
											  left join request_remark e on a.remarks = e.req_rem_no 
										   where date_format(a.date,'%Y-%m-%d') = date_format(now(),'%Y-%m-%d') and a.branch_no = ". $_SESSION['userz']['branch_no'].";");

						}


						
						 $count = 1;
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
							echo "<td>".$row['stats']."</td>";
							echo "<td>".$row['durations']."</td>";
							echo "<td style='color:red;'>".$row['remark']."</td>";
							echo "<td><a href='viewRequest.php?delete=".$row['request_no']."'>CANCEL</a></td>";
						

						 	echo "</tr></form>";
							$count++;					 	

						 }



					?>


			</tbody>

		</table>
	</div>


	

					
				


	
</div>
	
    </body>
</html>