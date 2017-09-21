<?php

require('..\classes\connection.php');




  $con = new connection();


  $val = $_REQUEST['val'];
  $user_idUpdate = $_REQUEST['user_idUpdate'];


  $queryString = "update users set status=$val where user_id=$user_idUpdate";

  $result = $con->update($queryString);

  if($result)
  	echo true;
  else
  	echo  false;



?>






