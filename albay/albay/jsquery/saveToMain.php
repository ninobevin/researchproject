<?php


	if(!@$_REQUEST['customer_id']){

		die("Error! Please select a customer first.");

	}





	$user =	$_REQUEST['user_id'];
	$branch_no = $_REQUEST['branch_no'];
	$customer_id =	$_REQUEST['customer_id'];
	$tranId =	explode("---", $_REQUEST['tran_id'])[0];
	$bodySMS =	explode("---", $_REQUEST['tran_id'])[1];
	$rec =	$_REQUEST['mobile_no'];
	$cust_id_off = $_REQUEST['cust_id_off'];




	




require('..\classes\connection.php');


		
	$con = new connection();


	
		$isSuccess = $con->update("Update transaction_sm set cust_id='$customer_id',branch_no='$branch_no',user_id='$user' where ref_no='$tranId'
		and cust_id is null and branch_no is null and user_id=0");

		

		$ip_req = $con->query("select ip_address from general_account_add where account_no=2 limit 1");

		$ips = mysqli_fetch_array($ip_req)['ip_address'];

		
		if(!trim($rec) == ''){

			 exec("adb -s ".$ips.":5555 shell am startservice --user 0 -n com.android.shellms/.sendSMS -e contact $rec  -e msg '$bodySMS'");

		}

		



		if($isSuccess){

			echo "Success! Transaction has been assigned to MAIN.";

		}else{

			echo "Error! Already assigned or Connection Problem";
		}


		


?>