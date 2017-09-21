<?php include('head.php'); ?>

<div class='container'>

<?php

 
 // print_r($_REQUEST);
      if(isset($_REQUEST['btnupdate']))
        {
           // echo $_REQUEST['imgArea'];
            



                	   $cust_id = $_REQUEST['customerId'];

                      $customerfname = $_REQUEST['customerfname'];
                      $customerMiddle = $_REQUEST['customerMiddle'];
                      $customerlname = $_REQUEST['customerlname'];
                      $customerContact = $_REQUEST['customerContact'];
                      $customerBday = $_REQUEST['customerBday'];
                      $customerAdd = $_REQUEST['customeradd'];
                      $gender = $_REQUEST['gender'];

                      $queryString = "update customer set gender='$gender',fname='$customerfname', mname='$customerMiddle', lastname='$customerlname', loc_id = (select loc_id from location where concat(barangay,', ',city,' ',province) = '$customerAdd') , contact='$customerContact',dob='$customerBday' where cust_id='$cust_id'";
                    

                      $sql = $con->updateAffected($queryString);


                      $data = @$_REQUEST['imgArea'];



                        if($data){

                              $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data));
                              file_put_contents("customer/".$cust_id.".jpeg", $data);
                        }
  
                      

                      if($sql == "Error" )
                      {
                          echo"<div class='alert alert-danger'>
                		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                		<strong>Error! </strong> Problem with the connection, Please try again.
                	</div>";

                      }elseif($sql > 0 || !($data == "")){

                          echo"<div class='alert alert-success'>
                		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                		<strong>Success! </strong> Customer info. has been updated.
                	</div>";
                      }else{

                        echo"<div class='alert alert-warning'>
                        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                        <strong>Warning! </strong> No data has been replace or updated.
                      </div>";

                      } 

            }


?>





		<form action="" id="selfForm" method="POST" role="form">
			<div class="form-group">
				<legend>Customer Profile</legend>
			</div>


			<?php

      if(isset($_REQUEST['edit'])){

         
          $GLOBALS['ids'] = base64_decode($_REQUEST['edit']);





      }else{

          $GLOBALS['ids'] = 0;

      }

         include 'findCustomerProfile.php';

   

       ?>
      
			
		</form>
	
  </div>
<?php

include('foot.php');

?>