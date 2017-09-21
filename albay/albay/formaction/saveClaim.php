

<!DOCTYPE html>
<html lang="">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Title Page</title>

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->
	</head>
	<body>
<?php

	require('..\classes\connection.php');


	//print_r($_REQUEST);

	$customerId = $_REQUEST['customerId'];
	$ref_no = $_REQUEST['referenceNumber'];

	print_r($_REQUEST);



	$con = new connection();


	if ($con->update("UPDATE transaction_sm set status=2,cust_id=$customerId,date_claimed=now() where ref_no = '$ref_no' and status=1"))
		echo "Success";
	else
		echo "Error";



?>

	

		<!-- jQuery -->
		<script src="../jquery.js"></script>
		<!-- Bootstrap JavaScript -->
		<script src="../bootstrap/js/bootstrap.min.js"></script>
		<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
 		
	</body>
</html>



