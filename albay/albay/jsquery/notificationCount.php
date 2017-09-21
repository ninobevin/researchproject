<?php

session_start();


require('..\classes\connection.php');





  $con = new connection();



if($_SESSION['userz']['main']){




  $query = $con->query("select count(request_no) as num from request where read_server=0 and read_client=0 "
                        ." ");

  $query2 = $con->query("select count(request_no) as num from request where read_server=0 and read_client=0 and notified=0 "
                        ."  ");

  $row = @mysqli_fetch_array($query);



  if($row['num'] > 0){

  echo $row['num'];
    

    if(@mysqli_fetch_array($query2)['num'] > 0){

           echo "<script> bleep.play();</script>";

    }

  

    

    $con->update("update request set notified=1 where  read_server=0 and read_client=0 and notified=0 ".
      " ");

  } 




exit(1);

}





  $query = $con->query("select count(request_no) as num from request where read_server=1 and read_client=0 "
  	                    ."  and branch_no=".@$_SESSION['userz']['branch_no'].";");

  $query2 = $con->query("select count(request_no) as num from request where read_server=1 and read_client=0 and notified=0 "
  	                    ."  and branch_no=".@$_SESSION['userz']['branch_no'].";");

  $row = @mysqli_fetch_array($query);



  if($row['num'] > 0){

  echo $row['num'];
  	

  	if(@mysqli_fetch_array($query2)['num'] > 0){

	         echo "<script> bleep.play();</script>";

  	}

  

  	

  	$con->update("update request set notified=1 where  read_server=1 and read_client=0 and notified=0 ".
  		"  and branch_no=".$_SESSION['userz']['branch_no'].";");

  }	







?>