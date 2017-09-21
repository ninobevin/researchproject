<?php

		
	require('..\classes\connection.php');

	require('..\classes\computation.php');

	
	$con = new connection();

	$compute = new computation($con->getConnection());

	$ref_no = $_REQUEST['ref_no'];
	$branchNo = $_REQUEST['branchNo'];

	//echo "'update transaction_sm set branch_no=$branchNo where ref_no=$ref_no '";

	$slq=$con->query("update transaction_sm set branch_no=$branchNo where ref_no=$ref_no");

	if($slq)
	{
		echo true;
	}else{
		echo false;
	}



?>