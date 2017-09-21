<?php
           session_start();
	
	

	require('..\classes\connection.php');

	$query = $_REQUEST['query'];

	


	$con = new connection();


	$queryString = "SELECT a.cust_id as custId,concat(a.fname,' ',a.mname,'. ',a.lastname)  ". 
  							"as name,concat(b.barangay,', ',b.city,' ',b.province) as address, a.contact as contactNo,a.gender as gender FROM customer a join location b on a.loc_id=b.loc_id  where concat(a.fname,' ',a.mname,'. ',a.lastname) = '$query' limit 10;";

	//echo $queryString;
	$sql = $con->query($queryString);


if(!$con->getRowCount()){


	echo "<script>

		//$('#referenceNumber').prop('disabled',true);
		//$('#smartmoneynumber').prop('disabled',true);
		//$('#amount').prop('disabled',true);
		//$('#amount').val('');
		//$('#smartmoneynumber').val('');
		//$('#referenceNumber').val('');

		//$('#response2').html('');
		
	</script>";

	echo"<div class='alert alert-danger'>
		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
		<strong>Error! </strong> Cannot find record of '$query'
	</div>";
exit(1);

}



  $row = mysqli_fetch_array($sql);
  $custId = $row['custId'];
  $custName = $row['name'];



            
?>
	
	

	<input type='hidden' required='required' name='customerId' id='customerId' value="<?php echo $row['custId'] ?>">

	<div class='row'>
		<div class='col-md-7' >
			<?php echo "<a href='customerProfile.php?edit=".base64_encode($custName)."'><strong>Edit Customer</strong></a>"; ?>
    	</div>
    </div>
    <br>
	<div class='row' >
		<div class='col-md-7' >

					<div class='row' >
						<div class="col-md-3" ><p>Name:</p></div><div name='custName' class="col-md-6"><?php echo $row['name']  ?></div>
					</div>
					<div class='row' >
						<div class="col-md-3" ><p>Gender:</p></div><div class="col-md-6">
						<?php 
							if ($row['gender']=='0') 
								echo "Male"; 
							else 
								echo "Female";  ?>
						</div>
					</div>
					<div class='row'>
						<div class="col-md-3"><p>Address: </p></div><div class="col-md-6"><?php echo $row['address']  ?></div>
					</div>

					<div class='row'>
						<div class="col-md-3"><p>Contact No.: </p></div><div class="col-md-6"><?php echo $row['contactNo']  ?></div>
					</div>
					
					<div class='row'>
						<div class="col-md-3"><p>Identification Card</p> </div><div class="col-md-6"><p>Card No.</p></div>
					</div>

					
					<?php 


					$req = $con->query("select b.description as description,a.idcard_no as idcard_no from customer_identification a join identification_type b on a.identification_type_no=b.identification_type_no where cust_id='$custId'");
		               $count = 1;

		               while($row = mysqli_fetch_array($req))
		               {
		               	echo "<div class='row'>";
		                echo "<div class='col-md-3'>".$row['description']."</div><div class='col-md-6'>".$row['idcard_no']."</div>";
		               	echo "</div>";           
		               }

		    

		             

					?>

					<div class='row'>
					<div class="col-md-3" ><h4>Branch :</h4></div>
						<div class="col-md-4">

								<select name='branchNo' class="form-control" id='branchNo'>
                                      
                                        <?php
       											
       											if($_SESSION['userz']['main'])
       											{
       												$queryString = "SELECT * from branch";

	                                                 $sql = $con->query($queryString);


	                                                while($row1 = mysqli_fetch_array($sql))
	                                                {

	                                                echo "<option value='".$row1['branch_no']."'>".$row1['branch_name']."</option>";

	                                                }


       											}
       											else
       												echo "<option value='".$_SESSION['userz']['branch_no']."'>".$_SESSION['userz']['branch_name']."</option>";
                                                 
                                           ?>

                                    </select>

						</div>
				</div>


			<div class='row' style='margin-top:5%; margin-bottom:5%;'>
				<div class="col-md-12">
				
					<div class="col-md-4">
			             <div class="form-group" >
			                <button type="submit" id='btnFormSubmit' name='btnFormSubmit' class="btn btn-primary" style='width:100%;'>Claim this now</button>
			          	</div>
					</div>


				</div>

			</div>

					</div>


				<div class='col-md-5' >
					<div class='row'>
						<?php

							echo "<img src='customer/".$custId.".jpeg' style='margin-bottom:1%; margin-top:1%;'>";

							//echo "<img src='customer/3798.jpeg' >";
						?>
				
					</div>
				</div>

			

	
		</div>
	</div>








