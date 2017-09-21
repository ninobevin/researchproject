<?php

include('head.php');




?>



<div class='container'>


	<?php 

			if(isset($_REQUEST['id']))
			{






				$conn = new connection();

				$reqNo = base64_decode($_REQUEST['id']);

				//print_r($_REQUEST['reqNo']);

				
				$queryString = "delete from request where request_no='$reqNo'";
			    
			    $sql = $con->insert($queryString);

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

				
	<legend>View Request</legend>
					

		<div class="table-responsive">
			
	

		<table class="table table-hover">
			<thead >
				<tr id='tableHead'>
					<th>#</th><th>Date</th><th>Customer</th><th>Offline Customer</th><th>Amount</th><th>Recipient Mobile</th><th>Sender</th><th>Branch</th><th>SMARTMoney Number</th><th></th><?php if($main)echo "<th></th><th></th>"; ?>
				</tr>
			</thead>
			<tbody>
				
					<?php
						$req = "";
						
						if($main){

							$rem_raw =  $con->query("select * from request_remark");
			

							$req = $con->query(" select a.*,concat(b.fname,' ',b.mname,'. ',b.lastname) as name,c.username as user,d.branch_name as branch ".
							               " from request a join customer b on a.cust_id=b.cust_id join users c on a.user_id ".
							               " = c.user_id join branch d on a.branch_no = d.branch_no where a.read_server=0 and a.read_client=0;");


						}else{


							$req = $con->query(" select a.*,concat(b.fname,' ',b.mname,'. ',b.lastname) as name,c.username as user, d.branch_name as branch ".
							               " from request a join customer b on a.cust_id=b.cust_id join users c on a.user_id ".
							               " = c.user_id join branch d on a.branch_no=d.branch_no where a.read_server=0 and a.read_client=0 and a.branch_no = ". $_SESSION['userz']['branch_no'].";");

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

						 	if($main){
						 			echo "<td><button type='submit' class='btn btn-success' name='btnAssign'>Assign</button></td>";
									echo "<td>";
										
									echo "
										
										<select name='cboReport' class='form-control' style='width:auto;'>
											
											";
										mysqli_data_seek($rem_raw, 0);
										while($rem_res = mysqli_fetch_array($rem_raw)){
											
											echo "<option value='".$rem_res['req_rem_no']."'>".$rem_res['req_rem_desc']."</option>";
											
											
										}
										
											
											echo ";
										</select>
										</td>
									";
										
									
									
						 
						 	}
						 	echo "<td><button type='button' data-href='viewRequest.php?id=$loc' class='btn btn-danger' data-toggle='modal' data-target='#myModal' id='btnSubmit' name='btnSubmit'>Cancel</button></td>

						 	";

						 	echo "</tr></form>";
							$count++;
													
								
						 }



					?>


			<form action="" method="POST">

				<div id="myModal" class="modal fade">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h4 class="modal-title">Veryfication</h4>
							</div>
							<div class="modal-body">
								<label for="inputType" class="control-label">Are you sure do you want to cancel this Send Request?</label>
								
							</div>
							<div class="modal-footer">
								<button type="button" name="btnCancelRequest"  id='btn-ok' data-dismiss="modal" class="btn btn-primary" style="width:60px;">Yes</button>
								<button type="button" class="btn btn-primary"   data-dismiss="modal" style="width:60px;">No</button>
							</div>
						</div>
					</div>
				</div>

			</form>
				
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