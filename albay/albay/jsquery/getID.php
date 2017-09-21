<?php 

       
       $queryString = "SELECT * from identification_type";

                                          //echo $queryString;
       $sql = $con->query($queryString);


      while($row = mysqli_fetch_array($sql))
      {

      	echo "<option value='".$row['description']."'></option>";

      }




 ?>