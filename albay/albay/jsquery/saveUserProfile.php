<?php
    
    require('..\classes\connection.php');

    $con = new connection();

    	$fname = $_REQUEST['fname'];
    	$Middle = $_REQUEST['Middle'];
    	$lname = $_REQUEST['lname'];
    	$address = $_REQUEST['address'];
    	$branchNo = $_REQUEST['branchNo'];
    	$Bday = $_REQUEST['Bday'];
    	$username= $_REQUEST['username'];
    	$password = $_REQUEST['password'];
        $gender = $_REQUEST['gender'];
    	
    	$sql = $con->insert("Insert into users(username,password,firstname,middlename,lastname,loc_id,dob,branch_no,status,auth_level,gender) 
            values('".$username."','".$password."','$fname','$Middle','$lname',(select loc_id from location where concat(barangay,' ',city,' ',province) = '$address'),
    					'$Bday',$branchNo,0,0,'$gender')");


        if($sql){
            echo "Registration Success! Please wait for activation..";

        }
        else{

            echo "Error! Connection problem.";

        }




?>