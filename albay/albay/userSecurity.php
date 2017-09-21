<?php

include('head.php');

            
?>

<style>
    
    .form-group
    {
      margin:0px;
    }
    .form-group select, input
    {
      margin-top:30px;
    }
    #selfForm 
    {
      padding-bottom: 5%;
    }
    .row
    {
    	float: center;
    }

</style>

	<div class='container' >

		<?php


			//print_r($_REQUEST);

			if(isset($_REQUEST['updatAccount']))
            {

            	$username = $_REQUEST['username'];
            	$newPassword = $_REQUEST['newPassword'];
            	$verifyPassword = $_REQUEST['verifyPassword'];
            	$olpPassword = $_REQUEST['olpPassword'];
            	$password = $_REQUEST['passwords'];

            	$isMatch = false;
            	$isValid = false;



            	if($newPassword!=$verifyPassword){
            		$isMatch = false;
            		 echo "<div class='alert alert-danger'>
					<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
					<strong>Error! </strong>The password could not be verified. Make sure both password match.
				</div>";
            	}else{
            		$isMatch = true;
            	}

            	if($olpPassword!=$password){
            		$isValid = false;
            		echo "<div class='alert alert-danger'>
					<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
					<strong>Error! </strong>Make sure old password is correct.
				</div>";
            	}else{
            		$isValid = true;
            	}

            

			      if($isMatch==true && $isValid==true)
			      {

			      		$sql=$con->update("Update users set username='$username',password='$newPassword' where user_id=".$_SESSION['userz']['user_id']."");

			      		if(!$sql)
					      {
					          echo"<div class='alert alert-danger'>
							<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
							<strong>Error! </strong> Problem with the connection, Please try again.
						</div>";

					      }else{

					          echo"<div class='alert alert-success'>
							<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
							<strong>Success! </strong> Customer Security Account. has been updated.
						</div>";

						$_SESSION['userz']['username'] = $username;
						$_SESSION['userz']['password'] = $newPassword;
					  } 


			      }

            }



            $str = "select a.*,concat(b.barangay,', ',b.city,' ',b.province) as address from users a join location b on a.loc_id=b.loc_id where user_id=".$_SESSION['userz']['user_id']."";
          //  echo $str;
            $sql = $con->query($str);

            $row=mysqli_fetch_array($sql);


		?>

			<form method="POST" action='' id='selfForm' role="form" name="updateACC">
				<div class="form-group">
					<legend>User Security Details</legend>
				</div>

				

				<div class="row">
						<div class="col-md-4">
						</div>
						<div class="col-md-4">
				              <div class="form-group">
				                <input type="text" class="form-control"  style='width:100%;' required='required' value="<?php echo $row['username']  ?>">
				              </div>
				              <div class="form-group" style='text-align:center;'>
				                    <label for="inputType" class="control-label">Username</label>
				              </div>
	            		</div>
            		
				</div>



				<div class="row">
					<div class="col-md-4">
						</div>
					<div class="col-md-4">
			              <div class="form-group">
			                <input type="text" placeholder="New Username here..." class="form-control"  style='width:100%;'   id="username" name="username" required='required'>
			              </div>
			              <div class="form-group" style='text-align:center;'>
			                    <label for="inputType" class="control-label">New Username</label>
			              </div>
            		</div>

				</div>

				
				<div class="row">
					<div class="col-md-4">
						</div>
					<div class="col-md-4">
			              <div class="form-group">
			                <input type="text" placeholder="New password here..." class="form-control"  style='width:100%;'   id="newPassword" name="newPassword" required='required'>
			              </div>
			              <div class="form-group" style='text-align:center;'>
			                    <label for="inputType"  class="control-label">New Password</label>
			              </div>
            		</div>

				</div>

				<div class="row">
					<div class="col-md-4">
						</div>
					<div class="col-md-4">
			              <div class="form-group">
			                <input type="text" class="form-control" placeholder="Input again..." style='width:100%;'   id="verifyPassword" name="verifyPassword" required='required'>
			              </div>
			              <div class="form-group" style='text-align:center;'>
			                    <label for="inputType" class="control-label">Verify Password</label>
			              </div>
            		</div>

				</div>

				<div class="row">
					<div class="col-md-4">
						</div>
					<div class="col-md-4">
			              <div class="form-group">
			                <input type="text" class="form-control" placeholder="Input old Password" style='width:100%;'   id="olpPassword" name="olpPassword" required='required'>
			              </div>
			              <div class="form-group" style='text-align:center;'>
			                    <label for="inputType" class="control-label">Old Password</label>
			              </div>
            		</div>

				</div>

				<input type="hidden" id="passwords" name="passwords" value="<?php echo $row['password']; ?>">

				<div class="row">

					<div class="col-md-4">
					</div>
					<div class="col-md-4">
			              <button style='width:100%;' type="submit" id="btn" name="updatAccount" id="updatAccount" class="btn btn-primary">Save</button>
            		</div>
				</div>

				<div class="row">
					<div class="col-md-4">
					</div>
					<div class="col-md-4">
			              <button style='width:100%; margin-top:3%;' type="button" id="resetAccount" name="resetAccount" class="btn btn-primary">Reset</button>
            		</div>

				</div>


		
			</form>

	</div>

<script>

$(document).ready(function(){




  });


</script>

<?php

include('foot.php');

?>
