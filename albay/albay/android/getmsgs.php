<?php


include("connection.php");





$con = new connection();


$raw = $con->query("select * from sms_stack where status = 0;");





//echo 'sfdkjshdfjhasdjfhkja dfhjahsdfj hasjdh f kjash';

$flags = array();

while($row = mysqli_fetch_array($raw)){


	$flags[] = $row;


}


echo json_encode($flags);

 $con->update("update sms_stack set status = 1;");


?>