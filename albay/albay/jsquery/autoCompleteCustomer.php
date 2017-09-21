<?php

require('..\classes\connection.php');

  $query = $_REQUEST['query'];

  


  $con = new connection();

	$query = $_REQUEST['query'];

	$query = explode(" ",$query);
	$query = "%".implode("%' and concat(fname,' ',mname,'. ',lastname) like '%", $query)."%";

	//echo $qer;



$queryString = "SELECT concat(fname,' ',mname,'. ',lastname)  ". 
  							"as name FROM customer  where concat(fname,' ',mname,'. ',lastname) like '$query' limit 10;";




//echo $queryString;

$arr = array() ;

    

   $sql = $con->query($queryString);

   while($row = mysqli_fetch_array($sql)){

            $arr[] =array_map('utf8_encode',$row)[0] ;

   }

   echo json_encode($arr);
?>






