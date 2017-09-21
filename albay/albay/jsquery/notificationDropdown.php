<?php
session_start();
require('..\classes\connection.php');

  $con = new connection();
//echo "hahahahaha";




if($_SESSION['userz']['main']){


          $req = $con->query("select a.*,concat(b.fname,' ',b.mname,'. ',b.lastname)
           as name,c.username as user,d.branch_name as branchName from request a join customer b on a.cust_id=b.cust_id join users c on a.user_id=c.user_id
            join branch d on d.branch_no = a.branch_no  WHERE a.read_server=0 and a.read_client=0");
                        
                            
          while($row = mysqli_fetch_array($req))
          {



          		 echo "<li ><a href='viewRequest.php'>Request from ".$row['branchName']." </a></li>";

          }
          
            
 }else{



          $req = $con->query("select a.*,concat(b.fname,' ',b.mname,'. ',b.lastname)
           as name,c.username as user from request a join customer b on a.cust_id=b.cust_id join users c on a.user_id=c.user_id WHERE a.read_server=1 and a.read_client=0"
           ." and a.branch_no=".$_SESSION['userz']['branch_no'].";");
                        
                            
          while($row = mysqli_fetch_array($req))
          {

          		 echo "<li ><a href='viewNotification.php'>Money Transfer for ".$row['name']." </a></li>";

          }
          


 }

 ?>