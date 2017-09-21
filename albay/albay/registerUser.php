<?php
	
	include('classes/connection.php');

    $con = new connection();



    	



?>


<!DOCTYPE html>
<html lang="">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Title Page</title>

		<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="style/style1.css">
        <script src="jquery.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script src="bootstrap/js/typeahead.js"></script>
		
	</head>

<style>
    
    .form-group
    {
      margin:0px;
    }
    .form-group select, input, button
    {
      margin-top:30px;
    }
    #selfForm
    {
      padding-bottom: 5%;
    }

</style>

	<body>

		<form action="" method="POST" class="selfForm" role="form">
		
		
		<div class='container' style=" margin-top:2%;">

			<div class="panel panel-default">
				<div class="panel-heading">
					<h2>Sign-up Form</h2>
				</div>
				<div class="panel-body">
					
				
							<div class='row'>

					            <div class="col-md-4">
					              
					              <div class="form-group">
					                <input type="text" class="form-control"  autocomplete="off" style='width:100%;'   id="fname" name="fname" required='required'>
					              </div>
					              <div class="form-group" style='text-align:center;'>
					                    <label for="inputType" class="control-label" >First Name</label>
					              </div>
					            </div>

					            <div class="col-md-4">        
					              <div class="form-group">
					                <input type="text" class="form-control" autocomplete="off" style='width:100%;' maxlength="1"  id="Middle" name="Middle" required='required' >
					              </div>
					              <div class="form-group" style='text-align:center;'>
					                    <label for="inputType" class="control-label">Middle Name</label>
					              </div>
					            </div>

					            <div class="col-md-4">          
					              <div class="form-group">
					                <input type="text" class="form-control"  style='width:100%;'   id="lname" name="lname" required='required'>
					              </div>
					              <div class="form-group" style='text-align:center;'>
					                    <label for="inputType" class="control-label">Last Name</label>
					             </div>
					            </div>  

					        </div>

					         <div class='row'>

					            <div class="col-md-8">
					              
					              <div class="form-group">
					                <input type="text" class="form-control"  autocomplete="off" style='width:100%;'   id="address" name="address" required='required'>
					              </div>
					              <div class="form-group" style='text-align:center;'>
					                    <label for="inputType" class="control-label">Address</label>
					              </div>
					            </div>

					            <div class="col-md-4">
					              
					              <div class="form-group">
					                <input type="date" class="form-control"  style='width:100%;'   id="Bday" name="Bday" required='required'>
					              </div>
					              <div class="form-group" style='text-align:center;'>
					                    <label for="inputType" class="control-label">Date of Birth</label>
					              </div>

					            </div>

					        </div>

					       <div class="row">

					       		<div class="col-md-4">
					              
					              <div class="form-group">
					                	<select class="form-control" id="gender">

					                		<option value="0" >Male</option>
					                		<option value="1" >Female</option>

					                	</select>
					              </div>

					              <div class="form-group" style='text-align:center;'>
					                    <label for="inputType" class="control-label">Gender</label>
					              </div>

					            </div>

					       		<div class="col-md-4">
					              
					              <div class="form-group">
					                <select name='branchNo' class="form-control" id='branchNo'>
                                      
                                        <?php 

       											
       												$queryString = "SELECT * from branch";
                                                                                    //echo $queryString;
	                                                 $sql = $con->query($queryString);


	                                                while($row = mysqli_fetch_array($sql))
	                                                {

	                                                echo "<option value='".$row['branch_no']."'>".$row['branch_name']."</option>";

	                                                }

                                          ?>

                                    </select>

					              </div>
					              <div class="form-group" style='text-align:center;'>
					                    <label for="inputType" class="control-label">Branch</label>
					              </div>

					            </div>
					      </div>

					      <div class='row'>
					            <div class="col-md-4">
					              <div class="form-group">
					                <input type="text" class="form-control" autocomplete="off" style='width:100%;' placeholder="Username"  id="username" name="username" required='required'>
					              </div>
					              <div class="form-group" style='text-align:center;'>
					                    <label for="inputType" class="control-label">Username</label>
					              </div>
					            </div>

					            <div class="col-md-4">
					              
					              <div class="form-group">
					                <input type="password" class="form-control" autocomplete="off" placeholder="Password" style='width:100%;'   id="password" name="password" required='required'>
					              </div>
					              <div class="form-group" style='text-align:center;'>
					                    <label for="inputType" class="control-label">Password</label>
					              </div>

					            </div>

					            <div class="col-md-4">
					              
					              <div class="form-group">
					                <input type="text" class="form-control" autocomplete="off"  style='width:100%;' placeholder="Verify Password"  id="verifyPass" name="verifyPass" required='required'>
					              </div>

					              <div class="form-group" style='text-align:center;'>
					                    <label for="inputType" class="control-label">Confirm Password</label>
					              </div>

					            </div>

					        </div>

					      <div class="row">
					      		<div class="col-md-4"></div>
					      		<div class="col-md-4">
					             	<button type="button" name='btnsubmit' id='btnsubmit' class="btn btn-primary" style='width:100%;'>Submit</button>
					            </div>

					      </div>

				</div>

			</div>
			
		</div>
		</form>

		 <div id="myModal" class="modal fade">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="hmsg">Error</h4>
              </div>
              <div class="modal-body">
                <label for="inputType" class="control-label" id="msg">Please complete fill-up the necessary data!</label>
              </div>
              <div class="modal-footer" style="margin-top:0%;">
                    <button type="button" style="margin-top:0%; width:80px;" name="bntok"  id='bntok' data-dismiss="modal" class="btn btn-primary">Ok</button>
              </div>
            </div>
          </div>
        </div>

	</body>

<script>
	$(document).ready(function() {

			$('#btnsubmit').click(function(){


				var fname = $("#fname").val();
		    	var Middle = $("#Middle").val();
		    	var lname = $("#lname").val();
		    	var address = $("#address").val();
		    	var branchNo = $("#branchNo").val();
		    	var Bday = $("#Bday").val();
		    	var username = $("#username").val();
		    	var password = $("#password").val();
		    	var verifyPass = $("#verifyPass").val();
		    	var gender = $("#gender").val();

		    	if(fname!="" && Middle!="" && lname!="" && Bday!="" && address!=""){


		    		if(password==verifyPass)
		    		{
		    		$.post('jsquery/saveUserProfile.php',{fname:fname,Middle:Middle,lname:lname,address:address,branchNo:branchNo,Bday:Bday,username:username,password:password,gender:gender},function(data){
		    			
			    		$('#msg').text(data);
			    		$('#hmsg').text("Success");
			    		$('#myModal').modal({show: 'false'});

				    		$("#bntok").click(function(){
				    			window.location.href='authorization.php';
				    		});

					 });

			    	}else{

			    		alert("The password could not be verified. Make sure both password match.");
			    	}

		    	

		    	}else{

		    		
		    		$('#myModal').modal({show: 'false'});

		    		//alert("");

		    	}

		    	

			});


$('#address').typeahead({
		        autoSelect: true,
		        minLength: 2,
		        delay: 400,

        source: function (query, process) {
            $.ajax({
                url: 'jsquery/autoCompleteAddress.php',
                data: {query: query},
                dataType: 'json'
            })
                .done(function(response) {
                    //console.log(response);                   
                    return process(response);
                });
        }
    });



	});
	
</script>

</html>

