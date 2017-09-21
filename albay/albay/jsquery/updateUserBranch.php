<?php

require('..\classes\connection.php');




  $con = new connection();

  $user_id = $_REQUEST['user_id'];
  $branch_no = $_REQUEST['branch_no'];

  $queryString = "update users set branch_no=$branch_no where user_id=$user_id";

  $result = $con->update($queryString);

  echo "$queryString";
  if($result)
  	echo true;
  else
  	echo  false;



?>
