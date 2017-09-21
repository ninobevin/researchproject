<?php

	$qer = $_REQUEST['query'];

//CREDENTIALS FOR DB
define ('DBSERVER', 'localhost');
define ('DBUSER', 'root');
define ('DBPASS','');
define ('DBNAME','mergesms');



$arr = array();

    $con = mysqli_connect(DBSERVER,DBUSER,DBPASS,DBNAME);

   $sql = mysqli_query($con,"SELECT concat(b.fname,' ',b.mname,'. ',b.lastname)  ". 
   							"as name FROM transaction_sm a join customer b on a.cust_id=b.cust_id where concat(b.fname,' ',b.mname,'. ',b.lastname) like '%$qer%'");

   while($row = mysqli_fetch_array($sql)){

            $arr[] = $row['body_sms'];

   }

   echo json_encode($arr);
?>






