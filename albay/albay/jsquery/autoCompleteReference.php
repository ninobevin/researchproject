<?php

session_start();

require('..\classes\connection.php');

  $query = $_REQUEST['query'];



  $con = new connection();

	$query = $_REQUEST['query'];


	//echo $qer;

$queryString = "SELECT ref_no from transaction_sm where ref_no like '%$query%' and status=1 limit 10;";




//echo $queryString;

$arr = array() ;

    

   $sql = $con->query($queryString);

   while($row = mysqli_fetch_array($sql)){

            $arr[] =array_map('utf8_encode',$row)[0] ;

   }





   echo json_encode($arr);
?>