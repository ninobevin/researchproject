<?php


require('..\classes\connection.php');

  $con = new connection();

  $id=$_REQUEST['id'];
  $val = $_REQUEST['val'];


  $con->update("update announcement set status='$val' where id='$id' ");



?>