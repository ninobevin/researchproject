


<?php 

session_start();

if(isset($_REQUEST['btnFormSubmit']))
  {
  	

  	require('..\classes\connection.php');

  	$user = $_SESSION['userz']['user_id'];
  	$branch = $_SESSION['userz']['branch_no'];
  	$msgType = "";
    $desc = "";

  	$con = new connection();

      $customername = $_REQUEST['customername'];
      $amount = $_REQUEST['amount'];
      $mobileNo = $_REQUEST['mobileNo'];
     
//cust_id, fname, mname, lastname, loc_id, contact, ext, dob
      $queryString = "INSERT INTO request(cust_id,branch_no,amount,recipient,user_id,date) values((select cust_id from customer where concat(fname,' ',mname,'. ',lastname) ='$customername'  limit 1),'$branch','$amount','$mobileNo','$user',now())";
    
    echo $queryString;

      $sql = $con->insert($queryString);

      if(!$sql)
      {
          $msgType = 'Success';
          $desc = 'New send request has Been Sent!';

      }else{

          $msgType = 'Error';
          $desc = 'Error while Sending sent request, Transaction field!';
      } 

	//	header('location: ..\sentRequest.php');
 	}
 	

?>