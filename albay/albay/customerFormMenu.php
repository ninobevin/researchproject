

<div role="tabpanel">
  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active">
      <a href="#Profile" aria-controls="Profile" role="tab" data-toggle="tab">Profile</a>
    </li>
    <li role="presentation">
      <a href="#Transaction" aria-controls="Transaction" role="tab" data-toggle="tab">Transaction History</a>
    </li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="Profile">


        <?php
  
      require('classes/connection.php');
      $con = new connection();

      $query = $_REQUEST['query'];

      


      $queryString = "SELECT a.cust_id as custId,a.fname as fname,a.mname as mname,a.lastname as lname, ". 
                    " a.gender as gender,concat(b.barangay,', ',b.city,' ',b.province) as address, a.contact as contactNo, a.dob as bday FROM customer a join location b on a.loc_id=b.loc_id  where concat(a.fname,' ',a.mname,'. ',a.lastname) = '$query' limit 10;";

     // echo $queryString;
      $sql = $con->query($queryString);

    if(!$con->getRowCount()){

      echo"<div class='alert alert-danger'>
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <strong>Error! </strong> Cannot find record of '$query'
      </div>";
      
    exit(1);

    }


      $row = mysqli_fetch_array($sql);
      $cust_id = $row['custId'];


            
?>
<style>
    
    
    .form-group #labels
    {
      margin-top:30px;
    }
    #selfForm
    {
      padding-bottom: 5%;
    }

</style>
  
  <br>

  <input type='hidden' required='required' name='customerId' id='customerId' value="<?php echo $row['custId'] ?>">


        <div class='row'>

            <div class="col-md-4">
              
              <div class="form-group">
                <input type="text" class="form-control"  style='width:100%;'   id="customerfname" name="customerfname" required='required' value="<?php echo $row['fname']  ?>">
              </div>
              <div class="form-group" id='labels'  style='text-align:center;'>
                    <label for="inputType" class="control-label">First Name</label>
              </div>
            </div>

            <div class="col-md-4">        
              <div class="form-group">
                <input type="text" class="form-control"  style='width:100%;' maxlength="1"  id="customerMiddle" name="customerMiddle" required='required' value="<?php echo $row['mname']  ?>" >
              </div>
              <div class="form-group"  id='labels' style='text-align:center;'>
                    <label for="inputType" class="control-label">Middle Initial</label>
              </div>
            </div>

            <div class="col-md-4">          
              <div class="form-group">
                <input type="text" class="form-control"  style='width:100%;'   id="customerlname" name="customerlname" required='required' value="<?php echo $row['lname']  ?>">
              </div>
              <div class="form-group"  id='labels' style='text-align:center;'>
                    <label for="inputType" class="control-label">Last Name</label>
             </div>
            </div>  

        </div>

      <div class='row'>

          <div class="col-md-8">
            
            <div class="form-group">
              <input type="text" class="form-control"  style='width:100%;'   id="customeradd" name="customeradd" required='required' value="<?php echo $row['address']  ?>" >
            </div>
            <div class="form-group"  id='labels' style='text-align:center;'>
                  <label for="inputType"  class="control-label">Address</label>
            </div>

          </div>

           <div class="col-md-4">
            
              <div class="form-group">
                  <select class="form-control" id="gender" name="gender">

                  <?php

                      if($row['gender']=='0'){
                        echo "<option value='0'>Male</option>";
                        echo "<option value='1'>Female</option>";
                      }else{
                        echo "<option value='1'>Female</option>";
                        echo "<option value='0'>Male</option>"; 
                      }

                  ?>

                  </select>
              </div>
            <div class="form-group" id='labels'  style='text-align:center;'>
                  <label for="inputType" class="control-label">Gender</label>
            </div>

          </div>

      </div>


      <div class='row'>


          <div class="col-md-4">
            
            <div class="form-group">
              <input type="text" class="form-control"  style='width:100%;'   id="customerContact" name="customerContact" required='required' value="<?php echo $row['contactNo']  ?>" >
            </div>
            <div class="form-group"  id='labels' style='text-align:center;'>
              <label for="inputType"   class="control-label">Contact</label>
            </div>

          </div>

          <div class="col-md-4">
            
            <div class="form-group">
              <input type="date" class="form-control"  style='width:100%;'   id="customerBday" name="customerBday" required='required' value="<?php echo $row['bday']  ?>">
            </div>
            <div class="form-group" id='labels'  style='text-align:center;'>
                  <label for="inputType"  class="control-label">Date of Birth</label>
            </div>

          </div>

          

      </div>

    <div  class='row'>


          <div class="col-md-4">
            
               <div class="form-group">
                
                    <select name='identification_no' id='identification_no' class="form-control" id='optionId'>
                                      
                                        <?php 

       
                                                 $queryString = "SELECT * from identification_type";

                                                                                    //echo $queryString;
                                                 $sql = $con->query($queryString);


                                                while($row = mysqli_fetch_array($sql))
                                                {

                                                echo "<option value='".$row['identification_type_no']."'>".$row['description']."</option>";

                                                }

                                           ?>

                                    </select>

              </div>

              <div class="form-group" style='text-align:center;'>
                    <label for="inputType" class="control-label">Identification card</label>
              </div>

          </div>

           <div class="col-md-4">
            
            <div class="form-group">

              <input type="text" class="form-control"  style='width:100%;'   id="idcard_no" name="idcard_no" placeholder="ID No. here" autocomplete="off">
            </div>
            <div class="form-group" style='text-align:center;'>
                  <label for="inputType" class="control-label">ID No.</label>

        </div>

        </div>

          <div class="col-md-2">
            
            <div class="form-group">
              <button type="button"  name='btnAddId' class="btn btn-primary center-block" style='width:90%;'   id='btnAddId'>Add</button>
            </div>
           
          </div>

      </div>

    <div class='row' style="margin-top:2%;">
         <div class="col-md-4">
              <div class="form-group">
                   <label for="customername" class="control-label">List of Identification card</label>
              </div>
          </div>
</div>

<div class="row">

      <div class="col-md-8">

    <div class="table-responsive">

      <table class="table table-hover">

        <thead >
          <tr id='tableHead'>
            <th>#</th><th>Description</th><th>ID No.</th>
          </tr>
        </thead>
        <tbody id="idRow">
          
            <?php

              
              //$cust_id =i $_REQUEST['customerId'];
              
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
            </tbody>

        </table>

      </div>

    </div>

        <div class="col-md-4">
            
            <div class="form-group">
               
              <div id="my_camera1" >
              

                <?php

                  if(!file_exists("customer/".$cust_id.".jpeg")){


                      echo "NO PHOTO AVAILABLE";


                  }else{

                      echo "<img  src='customer/".$cust_id.".jpeg' />" ;

                  }

                ?>


                </div>



                         <input type=button value="Change Image" id='Change' style="margin-top:1%;" onClick="changeImage()">
                          <input type=button value="Cancel" id='cancel' style="margin-top:1%; display:none;" onClick="">
                         <input type=button value="Take Snapshot" id='takeShot2' style="margin-top:1%;" onClick="take_snapshot2()">

                          <!-- Configure a few settings and attach camera -->

                              <script language="JavaScript">

                

                           
                          function changeImage(){

                        


                            Webcam.set({
                              width: 320,
                              height: 240,
                              image_format: 'jpeg',
                              jpeg_quality: 90
                            });
                            Webcam.attach( '#my_camera1' );

                          }
                            

                 
                 function take_snapshot2() {
      // take snapshot and get image data
                          Webcam.snap( function(data_uri) {
                            // display results in page
                            document.getElementById('my_camera1').innerHTML =
                            "<img  name='imgArea' src='"+data_uri+"'/> <input type='hidden'  name='imgArea' value='"+data_uri+"'/>";

                            //  saveImage(data_uri);



                          } );

                          $("#takeShot2").hide();

                 }


                </script>
                          

            </div>



        </div>

    

  </div>

  <div class="row">

    <div class="col-md-4">
            
            <div class="form-group">
              <button type="submit"  name='btnupdate' class="btn btn-primary center-block" style='width:90%;'  id='btnupdate'>Save Change data</button>
            </div>
           
          </div>

  </div>

          <div id="myModal2" class="modal fade">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Note</h4>
              </div>
              <div class="modal-body">
                <label for="inputType" class="control-label">Please input the ID No. then click Add button</label>
              </div>
              <div class="modal-footer" style="margin-top:0%;">
                    <button type="button" style="margin-top:0%; width:80px;" name="btnNote"  id='btnNote' data-dismiss="modal" class="btn btn-primary">Ok</button>
              </div>
            </div>
          </div>
        </div>

    </div>

    <div role="tabpanel" class="tab-pane" id="Transaction">

    <div class="row"  style="margin-top:2%;">

      <div class="table-responsive">
      
  

    <table class="table table-hover">
          <thead >
            <tr id='tableHead'>
              <th>#</th><th>Transaction Date</th><th>Reference Number</th><th>Amount</th><th>Status</th><th>User</th>
            </tr>
          </thead>

          <tbody>

            <?php 

              
             // $cust_id = $_REQUEST['customerId'];

              $req = $con->query("Select a.*,ifnull(a.date_claimed,a.date) as date_tran,b.username as user,c.name as TransactionType from transaction_sm a
                                 join users b on a.user_id=b.user_id join status_sm c on c.sm_status_no=a.status 
                                 where cust_id = '$cust_id' ");

           

             $count = 1;

             while($row = mysqli_fetch_array($req))
             {

              echo "<tr>";
              
              echo "<td>$count</td>";
              echo "<td>".$row['date_tran']."</td>";
              echo "<td>".$row['ref_no']."</td>";
              echo "<td>".$row['amount']."</td>";
              echo "<td>".$row['TransactionType']."</td>";
              echo "<td>".$row['user']."</td>";
              echo "</tr>";

              $count++;           

             }




            ?>
            
              
          </tbody>

    </table>


      </div>

  </div>


    </div>

  </div>
</div>



<script>

function take_snapshot2() {
      // take snapshot and get image data
      Webcam.snap( function(data_uri2) {
        // display results in page
        document.getElementById('my_camera1').innerHTML =
        "<img  name='imgArea' src='"+data_uri2+"'/> <input type='hidden'  name='imgArea' value='"+data_uri2+"'/>";

      } );

   
    }



  $(document).ready(function(){

$('#customeradd').typeahead({
            autoSelect: true,
            minLength: 2,
            delay: 400,

        source: function (query, process) {
            $.ajax({
                url: 'jsquery/autoCompleteAddress.php',
                data: {query: query},
                dataType: 'json'
            })
                .done(function(response) {
                    //console.log(response);

                   
                    return process(response);
                });
        }
    });
   

    $("#btnAddId").click(function(){


        var cust_id = $("#customerId").val();
        var identification_no =  $("#identification_no").val();
        var idcard_no = $("#idcard_no").val();

        $("#idcard_no").val("");

        if(idcard_no!="")
        {
            $.post('jsquery/viewIdentificationCard.php',{cust_id:cust_id,identification_no:identification_no,idcard_no:idcard_no},function(data){


              $("#idRow").html(data);

            });
        }
        else
        {

         $('#myModal2').modal({show: 'false'});

           // $('#myModal2').on('show.bs.modal', function(e) {

              //   alert("Please Input the ID No.");

           // });
        }
     // alert(cust_id + " - " + identification_no + " - " + idcard_no);

       

    });
      
   

  });

</script>


