<?php

	$qer = $_REQUEST['query'];

	$qer = explode(" ",$qer);
	$qer = "%".implode("%' and concat(fname,' ',mname,'. ',lastname) like '%", $qer)."%";

	//echo $qer;

//CREDENTIALS FOR DB
define ('DBSERVER', 'localhost');
define ('DBUSER', 'root');
define ('DBPASS','');
define ('DBNAME','mergesms');

$queryString = "SELECT concat(fname,' ',mname,'. ',lastname)  ". 
  							"as name FROM customer  where concat(fname,' ',mname,'. ',lastname) like '$qer' limit 10;";




//echo $queryString;

$arr = array() ;

    $con = mysqli_connect(DBSERVER,DBUSER,DBPASS,DBNAME);

   $sql = mysqli_query($con,$queryString);

   while($row = mysqli_fetch_array($sql)){

            $arr[] =array_map('utf8_encode',$row)[0] ;

   }

   echo json_encode($arr);
?>






