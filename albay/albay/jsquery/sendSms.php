<?php
  require('..\classes\connection.php');
  
    $con = new connection();
	
	$sms = $_REQUEST['smsbody'];
	$Contact = $_REQUEST['Contact'];


	
	
	//	$ip_req = $con->query("select ip_address from general_account_add where account_no=2;");

	//	$ips = mysqli_fetch_array($ip_req)['ip_address'];



	//$send =	exec("adb -s ".$ips.":5555 shell am startservice --user 0 -n com.android.shellms/.sendSMS -e contact $Contact  -e msg '$sms'");


	$ip_req = $con->query("insert into sms_stack(sms_body,mobile_no,status,reserve)
							values ('$sms','$Contact',0,0) ");



	
		echo true;


?>