<?php

include('head.php');

            
?>


	<div class='container' >

		<?php

			//print_r($_REQUEST);

			if(isset($_REQUEST['btnSave']))
			{//id, formColor, headColor, tableHeadColor, user_id
				$formColor=$_REQUEST['formColor'];
				$headColor=$_REQUEST['headeColor'];
				$tableHeadColor=$_REQUEST['tableHeadColor'];

				$sql = $con->update("update usersettings set formColor='$formColor',headColor='$headColor',
				tableHeadColor='$tableHeadColor' where user_id=".$_SESSION['userz']['user_id']."");

			if(!$sql)
                      {
                          echo"<div class='alert alert-danger'>
                		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                		<strong>Error! </strong> Problem with the connection, Please try again.
                	</div>";

                      }else{

                          echo"<div class='alert alert-success'>
                		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                		<strong>Success! </strong>Interface has been updated.
                	</div>";
                      } 

			}

			$sql = $con->query("select * from usersettings where user_id=".$_SESSION['userz']['user_id']."");
			$row = mysqli_fetch_array($sql);

		?>
		
			<form method="POST" action='' id='selfForm' role="form" name="updateACC">
				<div class="form-group">
					<legend>Settings</legend>
				</div>

			<div class="row">

				<div class="col-sm-2">
					<label for="formColor" class="control-label">Header Color <input type="color" id="headeColor" name="headeColor" display="<?php echo $row['headColor'] ?>"></label>
				</div>

				<div class="col-sm-2">
					<label for="formColor" class="control-label">Form Color <input type="color" id="formColor" name="formColor" display="<?php echo $row['formColor'] ?>"></label>
				</div>

				<div class="col-sm-3">
					<label for="formColor" class="control-label">Table Head Color <input type="color" id="tableHeadColor" name="tableHeadColor" display="<?php echo $row['tableHeadColor'] ?>"></label>
				</div>

			</div>	

			<br>

			<div class="row">

				<div class="col-sm-2"></div>

				<div class="col-sm-8" >

					<div class="row" id="header1" style="background-color:black;">
						<h4>SMARTpadala Online</h4>
					</div>

					<div class="row" id="frmColor" style="margin-right:7%; margin-left:7%; margin-top:2%;">

							<div class="table-responsive" style="margin-right:9%; margin-left:9%; margin-top:5%;">
									<table class="table table-hover">
										<thead id="tableHead">
											<tr>
												<th>Date</th><th>Amount</th><th>Status</th><th>User</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>2016/08/13</td><td>5000</td><td>Claimed</td><td>Mike</td>
											</tr>
											<tr>
												<td>2016/08/13</td><td>3000</td><td>Sent</td><td>Joeny</td>
											</tr>
											<tr>
												<td>2016/08/13</td><td>4000</td><td>Claimed</td><td>Tap</td>
											</tr>
										</tbody>
									</table>
								</div>	
					</div>

					<br>

				</div>


				
			</div>

			<div class="row">
				<div class="col-sm-8"></div>
				<div class="col-sm-2">
					<button type="submit" name="btnSave" class="btn btn-primary" style="width:100%;">Save</button>
				</div>
			</div>

		
			</form>

	</div>


<script>

$(document).ready(function() {

	jQuery('#headeColor').on('change',function(){
		var colorCode = $('#headeColor').val();
		$("#header1").css("background-color",colorCode);
	});

	jQuery('#formColor').on('change',function(){
		var colorCode = $('#formColor').val();
		$("#frmColor").css("background-color",colorCode);
	});

	jQuery('#tableHeadColor').on('change',function(){
		var colorCode = $('#tableHeadColor').val();
		$("#tableHead").css("background-color",colorCode);
	});


});


</script>

<?php

include('foot.php');

?>
