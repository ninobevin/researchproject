<?php

    require('..\classes\loadConnection.php');


//echo " <script> bleep.play();</script>";


    $loadConnection = new loadConnection();



    $loadConnection->query("select * from  request where read_server=0");


     $count = $loadConnection->getRowCount();


      if($count > 0)
    {

      echo  "<span class='badge'>$count</span>" ;

      
    }



    $loadConnection->query("select * from  request where notified=0");


     $count = $loadConnection->getRowCount();


    if($count > 0)
    {

      echo "<script> bleep.play();</script>";

      $loadConnection->update("update request set notified=1");
    }





?>