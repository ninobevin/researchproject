<?php

	include('head.php');




?>






<div class='container'>

<?php 
	
	if(isset($_REQUEST['btnFormSubmit']))
  {
  	

  	

  	$user = $_SESSION['userz']['user_id'];
  	$branch = $_SESSION['userz']['branch_no'];
  	$msgType = "";
    $desc = "";

 
      $customername = @$_REQUEST['customername'];
      $amount = @$_REQUEST['amount'];
      $mobileNo = @$_REQUEST['mobileNo'];
      $smartmoneynumber = @$_REQUEST['smartmoneynumber'];
     
//cust_id, fname, mname, lastname, loc_id, contact, ext, dob
      $queryString = "INSERT INTO request(cust_id,branch_no,amount,recipient,user_id,date,smartmoneynumber) values((select cust_id from customer where concat(fname,' ',mname,'. ',lastname) ='$customername'  limit 1),'$branch','$amount','$mobileNo','$user',now(),'$smartmoneynumber')";
    
  //  echo $queryString;

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
		<strong>Success! </strong> Request has been sent.
	</div>";
      } 

	//	header('location: ..\sentRequest.php');
 	}

?>
	
<?php include('registerCustomer.php') ?>

		<form method="POST" action='' class="form-horizontal" id='selfForm' role="form">
					<div class="form-group">
						<legend>Sent Request</legend>
					</div>
			
					
				<?php include('findCustomerSent.php') ?>


		<div class='row'>
		    <div class="col-md-4">
		        <div class="form-group">
		              <label for="amount" class="control-label">Smart Money Number: </label>
		        </div>
		    </div>
		</div>  			
			
 		
		<div class='row'>
		    <div class="col-md-4">
				<div class="form-group">
				      	  <input type="text" class="form-control" required='required' name='smartmoneynumber' id="smartmoneynumber" placeholder="Smart Money Number here"  autocomplete="off" disabled>
				</div>
			</div> 
		</div>

		<div class='row'>
		    <div class="col-md-4">
		        <div class="form-group">
		              <label for="amount" class="control-label">Amount: </label>
		        </div>
		    </div>
		</div>  			
			
 		
		<div class='row'>
		    <div class="col-md-4">
				<div class="form-group">
				      	  <input type="number" class="form-control" required='required' name='amount' id="amount" placeholder="Amount in peso" autocomplete="off" disabled>
				</div>
			</div> 
		</div>

		<div class='row'>
		    <div class="col-md-4">
		        <div class="form-group">
		              <label for="amount" class="control-label">Mobile Number for SMS Reference: </label>
		        </div>
		    </div>
		</div>  			
			
 		
		<div class='row'>
		    <div class="col-md-4">
				<div class="form-group">
				      	  <input type="number" class="form-control" required='required'  name='mobileNo' id="mobileNo" placeholder="Ex. 0919*******"   autocomplete="off">
				</div>
			</div> 
		</div>

		<div class='row' style='margin-top:5%; margin-bottom:10%;'>
			

				<div class="col-md-4">
		             <div class="form-group" >
		                <button type="submit" id='btnFormSubmit' name='btnFormSubmit' class="btn btn-primary" style='width:100%;'>Send this Now?</button>
		          	</div>

				</div>

				
		</div>


		
	</form>


	
</div>
<ul class="pager">
	<li><a href="#">Previous</a></li>
	<li><a href="#">Next</a></li>
</ul>


<?php

include('foot.php');

?>

