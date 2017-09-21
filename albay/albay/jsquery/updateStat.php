<?php


require('..\classes\connection.php');


	$con = new connection();


	$update = $_REQUEST['exclude'];
	$ref = $_REQUEST['ref_no'];


	$con->update("update transaction_sm set status=".$update." where ref_no = ".$ref.";");

	echo "Status has been updated!";









?>