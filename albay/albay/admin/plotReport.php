<?php

 require('..\classes\connection.php');


$con = new connection();


	$query = "SELECT sum(amount) as amount,monthname(date_claimed) as month
			FROM transaction_sm where status=2 and year(date_claimed)=year(now()) group by month(date_claimed)";

	$row = $con->query($query);

	$arr = [1,2,3,4];

	echo json_encode($arr);




?>