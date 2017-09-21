
 <?php 



      require('..\classes\connection.php');
              
      $con = new connection();


      $idcard_no = $_REQUEST['idcard_no'];
      $identification_type_no = $_REQUEST['identification_no'];
      $cust_id =  $_REQUEST['cust_id'];

      $insertId = "Insert into customer_identification(cust_id,identification_type_no,idcard_no) values('$cust_id','$identification_type_no','$idcard_no')";
   
      $sql = $con->insert($insertId);



              
              $cust_id = $_REQUEST['cust_id'];
              
              $req = $con->query("select b.description as description,a.idcard_no as idcard_no from customer_identification a join identification_type b on a.identification_type_no=b.identification_type_no where cust_id='$cust_id'");




               $count = 1;

               while($row = mysqli_fetch_array($req))
               {

                echo "<tr>";
                
                echo "<td>$count<input type='hidden'</td>";
                echo "<td>".$row['description']."</td>";
                echo "<td>".$row['idcard_no']."</td>";
                echo "</tr>";
                $count++;           

               }


               

  ?>
 