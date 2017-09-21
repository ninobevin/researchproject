<?php


include("connection.php");




$con = new connection();




$raw = $con->query("select * from transaction_sm limit 5;");



$falgs =  array();;

while ($row = mysqli_fetch_array($raw))
{

	$falgs[]  = $row;
	 
}

echo json_encode($falgs);

//echo 'sfdkjshdfjhasdjfhkja dfhjahsdfj hasjdh f kjash';



?>