<?php

require('..\classes\connection.php');

  $query = $_REQUEST['query'];



  $con = new connection();

	$query = $_REQUEST['query'];

	$query = explode(" ",$query);
	$query = "%".implode("%", $query)."%";

	//echo $qer;

  


  $queryString = "SELECT concat(barangay,' ',city,' ',province)  ". 
  							"as address FROM location  where concat(barangay,' ',city,' ',province) like '$query' limit 10;";




//echo $queryString;

$arr = array() ;

    

   $sql = $con->query($queryString);

   while($row = mysqli_fetch_array($sql)){

            $arr[] =array_map('utf8_encode',$row)[0] ;

   }

   echo json_encode($arr);
?>






