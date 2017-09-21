<?php

	include('head.php');




?>





<div class='container'>

<?php 
	
	if(isset($_REQUEST['btnFormSubmit']))
  {
  	

  	

 
 // mobile_no, amount, branch_code, user
 
      $amount = @$_REQUEST['amount'];


      $recipient = @$_REQUEST['recipient'];
     
//cust_id, fname, mname, lastname, loc_id, contact, ext, dob
       $queryString = "INSERT INTO request(mobile_no,amount,branch_code,user) 
      			values('$recipient','$amount',$my_branch_no,$userID)";
    
  //  echo $queryString;


      $sql = $loadConnection->insert($queryString);

      if(!$sql)
      {
          echo"<div style='background-color:red;'>
				
				<strong>Error! </strong> Problem with the connection, Please try again.
			  </div>";

      }else{

          echo"<div  style='background-color:green;'>
	
		<strong>Success! </strong> Request has been sent.
	</div>";
      } 

	//	header('location: ..\sentRequest.php');
 	}

?>
	
<style>

	input {


		width: 100%;
		height: 40px;
		text-align: center;
	}

</style>


			<div style='text-align:center; margin-top:10%;'>
						LoadWallet Request
			</div>

		<form method="POST" action='' style=' width:50%; margin:0 auto;' class="form-horizontal" id='selfForm' role="form">
				
			
					
				


		<div class='row'>
		    <div class="col-md-4">
		        <div class="form-group">
		              <label for="amount" class="control-label">Recipient Number: </label>
		        </div>
		    </div>
		</div>  			
			
 		
		<div class='row'>
		    <div class="col-md-4">
				<div class="form-group">
				      	  <input type="number" class="form-control" required='required' name='recipient' id="recipient" placeholder="Mobile Number here"  autocomplete="off">
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
				      	  <input type="number" class="form-control" required='required' name='amount' id="amount" placeholder="Amount in peso" autocomplete="off">
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

</body>

</html>
