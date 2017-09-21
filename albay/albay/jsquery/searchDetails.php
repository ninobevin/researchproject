<?php
	
	require('..\classes\connection.php');

	require('..\classes\computation.php');

	
	$con = new connection();

	$compute = new computation($con->getConnection());

	$ref_no = $_REQUEST['ref_no'];



	$sql_srch = $con->query("SELECT a.*,b.name as status_name,b.sm_status_no as sm_status_no,c.branch_no as b_no,ifnull(c.branch_name,'Not assign') as b_name,d.*,concat(d.fname,' ',d.mname,'. ',d.lastname)
as name,concat(e.barangay,', ',e.city,' ',e.province) as address from transaction_sm a join status_sm b on a.status=b.sm_status_no
left outer join branch c on a.branch_no=c.branch_no left outer join customer d on d.cust_id=a.cust_id left outer join location e on d.loc_id=e.loc_id
where a.ref_no = '$ref_no'");

	if(!$con->getRowCount()){

		die("<div class='alert alert-danger'>
			<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
			<strong>Error! </strong> Cannot find this reference '$ref_no'
		</div>");

	}

	$row = mysqli_fetch_array($sql_srch);


	echo "<input type='hidden' id='reference_no' value='".$row['ref_no']."'>";

	

?>

<div class='row' >
		<div class='col-md-12' >
			<table>
				<div class='row'>
					<div class="col-md-2" align='right' ><p>SMS Body :</p></div><div class="col-md-5" ><?php echo $row['body_sms']  ?><input type='hidden' id='smsbody' value="<?php echo $row['body_sms']  ?>"></div>
				</div>
				<div class='row'>
					<div class="col-md-2" align='right'><p>Amount :</p></div><div class="col-md-2"><?php echo $row['amount']  ?></div>
				</div>
				<div class='row'>					
					<div class="col-md-2" align='right'><p>Service Charge :</p></div><div class="col-md-2"><?php echo $compute->getClaimServiceCharge($row['amount'],$row['account']);  ?></div>
					<input type='hidden' name='serviceCharge' value="<?php echo $compute->getClaimServiceCharge($row['amount'],$row['account'])  ?>">
				</div>

				<div class='row'>
					<div class="col-md-2" align='right'><p>Expected Total :</p></div><div class="col-md-2"><?php echo number_format($row['amount'] - $compute->getClaimServiceCharge($row['amount'],$row['account']),2);  ?></div>
					
				</div>

				<div class='row'>
					<div class="col-md-2" align='right'><p>Actual Total :</p></div><div class="col-md-2"><?php echo number_format($row['cash_amount'],2);  ?></div>
					
				</div>

				<div class='row'>
					<div class="col-md-2" align='right'><p>Status :</p></div><div class="col-md-2"><?php echo $row['status_name'];  ?></div>
					
				</div>
				<div class='row'>
					<div class="col-md-2" align='right'><p>Offline Cust :</p></div><div class="col-md-2"><?php echo $row['off_cust_id'];  ?></div>
					
				</div>


				<?php

					$isDisplay = 0;

						if($row['sm_status_no']==1){
							echo "<div class='row'>
									<div class='col-md-2' align='right'><p>Date Recieve :</p></div><div class='col-md-2'>".$row['date']."</div>	
								 </div>";
						}
						else if($row['sm_status_no']==2){
							echo "<div class='row'>
									<div class='col-md-2' align='right'><p>Date Claimed :</p></div><div class='col-md-2'>".$row['date_claimed']."</div>	
								 </div>";
								 $isDisplay = 1;
						}
						else if($row['sm_status_no']==3){
							echo "<div class='row'>
									<div class='col-md-2' align='right'><p>Date Sent :</p></div><div class='col-md-2'>".$row['date']."</div>	
								 </div>";
								 $isDisplay = 1;
						}

				?>

				<div class='row'>
					<div class="col-md-2" align='right'><p>Branch :</p></div>
					<div class="col-md-2">
						<select name='branchNo' class="form-control" id='branchNo'>
                            <?php 	
       							$queryString = "SELECT * from branch";
	                            $sql = $con->query($queryString);
	                            while($row1 = mysqli_fetch_array($sql))
	                            {
	                               echo "<option value='".$row1['branch_no']."'>".$row1['branch_name']."</option>";
	                            }
	                            
	                            echo "<option value='".$row['b_no']."' selected>".$row['b_name']."</option>";
	                        ?>

                    	</select>
                    </div>


                    <?php

                    	if($row['b_name']=='Not assign')
                    	{
                    		echo "<div class='col-md-2'>
					             	<div class='form-group'>
					                	<button type='button'  class='btn btn-primary center-block' style='width:90%;'  id='btnAssign' Disabled>Assign?</button>
					            	</div>
				          		</div>";
                    	}else
                    	{
                    		echo "<div class='col-md-2'>
					             	<div class='form-group'>
					                	<button type='button'  class='btn btn-primary center-block' style='width:90%;'  id='btnAssign'>Assign?</button>
					            	</div>
				          		</div>";
                    	}

                    ?>
                    					
				</div>

				<div class='row'>
					<div class="col-md-2" align='right'><p>Exclude Status:</p></div>
					<div class="col-md-2">
						<select name='exclude' class="form-control" id='exclude'>
                           
                           <?php
                           if ($row['status'] == 1 || $row['status'] == 2) {
                          

                           	 echo "<option value='4'>Payment IN</option>";
                           	 echo "<option value='6'>Return IN</option>";
	                           


                           }else{


                           		 echo "<option value='5'>Payment OUT</option>";
                           	 	 echo "<option value='7'>Return OUT</option>";
	                         


                           }

                           		

                           ?>

                    	</select>
                    </div>


                    <?php

                    
                    		echo "<div class='col-md-2'>
					             	<div class='form-group'>
					                	<button type='button'  class='btn btn-primary center-block' style='width:90%;'  id='btnExclude'>Exclude</button>
					            	</div>
				          		</div>";
                    	
                    ?>
                    					
				</div>





				<?php

					if($isDisplay == 1){

						echo "<div class='row'>
					    		<div class='col-md-12'>
							        <div class='form-group'>
										<legend>Customer info.</legend>
									</div>
					    		</div>
							</div>";
							$gen='';
							if($row['gender']==0)
								$gen='Male';
							else
								$gen='Female';

						echo "<div class='row'>
								<div class='col-md-2' align='right' ><p>Name :</p></div><div class='col-md-5'>".$row['name']."</div>
							</div>
							<div class='row'>
								<div class='col-md-2' align='right' ><p>Gender :</p></div><div class='col-md-5'>".$gen."</div>
							</div>
							<div class='row'>
								<div class='col-md-2' align='right' ><p>Address :</p></div><div class='col-md-5'>".$row['address']."</div>
							</div>
							<div class='row'>
								<div class='col-md-2' align='right' ><p>Contact no. :</p></div><div class='col-md-5'>".$row['contact']."</div>
							</div>";

							$isDisplay=0;

					}

				?>


				<div class='row'>
					<div class="col-md-2" align='right'><p>Send this Message :</p></div>
					<div class="col-md-4">
				        <div class="form-group">
				              <input type="number" name="Contact" id='Contact' placeholder='Contact no.' class="form-control" value="" required="required">
				        </div>
	    			</div>					
				</div>

				<div class='row'>
					<div class="col-md-2" align='right'></div>
						<div class="col-md-4">
					        <div class="form-group">
					              <button type='button'  class='btn btn-primary center-block' style='width:90%;'  id='btnSend'>Send this now?</button>
					        </div>
		    			</div>					
					</div>
				</div>
			</table>
		</div>
	</div>


	<div id="myModal2" class="modal fade">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id='headers'>Note</h4>
              </div>
              <div class="modal-body">
                <label for="inputType" class="control-label" id='bodys'>Please input the ID No. then click Add button</label>
              </div>
              <div class="modal-footer" style="margin-top:0%;">
                    <button type="button" style="margin-top:0%; width:80px;" name="btnNote"  id='btnNote' data-dismiss="modal" class="btn btn-primary">Ok</button>
              </div>
            </div>
          </div>
        </div>


<script>

$(document).ready(function(){

		$("#btnAssign").click(function(){

			var ref_no = $('#ref_no').val();
			var branchNo = $('#branchNo').val();
			
	 		$.post('../jsquery/reAssign.php',{ref_no:ref_no,branchNo:branchNo},function(data){

			 	var headers = '';
	 			var body = '';

			 			if(data){
			 				headers = 'Success';
	 						body = 'Successfully transfered.';
			 			}else
			 			{
			 				headers = 'Error';
	 						body = 'Cannot transfer, Check your internet connection.';
			 			}

			 			$('#headers').html(headers);
			 			$('#bodys').html(body);

			 			$('#myModal2').modal({show: 'false'});
			 		
			 });



		});



		$("#btnSend").click(function(){

			var smsbody = $('#smsbody').val();
			var Contact = $('#Contact').val();

			//alert(smsbody);
			//alert(Contact);
			
	 		$.post('../jsquery/sendSms.php',{Contact:Contact,smsbody:smsbody},function(data){

	 			var headers = '';
	 			var body = '';

			 			if(data){
			 				headers = 'Success';
	 						body = 'Message has been sent';
			 			}else
			 			{
			 				headers = 'Error';
	 						body = 'Message not sent, Check your cellphone if connected.';
			 			}

			 			$('#headers').html(headers);
			 			$('#bodys').html(body);

			 			$('#myModal2').modal({show: 'false'});
			 		
			 });



		});

		$("#btnExclude").click(function(){

			var exclude = $('#exclude').val();
			var ref_no = $('#reference_no').val();
			
			
		 		$.post('../jsquery/updateStat.php',{ref_no:ref_no,exclude:exclude},function(data){

				 		alert(data);
			



				});



		});








});

</script>