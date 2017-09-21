
<?php 
  

  if(isset($_REQUEST['btnSubmitCustomer']))
  {



      

      $customerfname1 = $_REQUEST['customerfname'];
      $customerMiddle1 = $_REQUEST['customerMiddle'];
      $customerlname1 = $_REQUEST['customerlname'];
      $customerContact = $_REQUEST['customerContact'];
      $customerBday = $_REQUEST['customerBday'];
      $customerAdd = $_REQUEST['customeradd'];
      $gender = $_REQUEST['gender'];




      $customerfname =  strtoupper($customerfname1);
      $customerMiddle = strtoupper($customerMiddle1);
      $customerlname = strtoupper($customerlname1);

    
      $identification_type_no = $_REQUEST['identification_type_no'];
      $customerIdNO = $_REQUEST['customerIdNO'];

      $sql = $con->query("Select count(cust_id) as count from customer where concat(fname,' ',mname,' ',lastname) = concat('$customerfname',' ','$customerMiddle',' ','$customerlname')");
      
      $row = mysqli_fetch_array($sql);

      if($row['count']==0)
      {


        $queryString = "INSERT INTO  customer(fname, mname, lastname, loc_id, contact,dob,gender)".
        " values('$customerfname','$customerMiddle','$customerlname',(select loc_id from location where concat(barangay,' ',city,' ',province) = '$customerAdd'),".
        "'$customerContact','$customerBday','$gender');";
    

        $sql = $con->insert($queryString);

        $cust_id = mysqli_insert_id($con->getConnection());

        //echo $cust_id;

        $insertId = "Insert into customer_identification(cust_id,identification_type_no,idcard_no) values('$cust_id','$identification_type_no','$customerIdNO')";
        $con->insert($insertId);


        $data = @$_REQUEST['imgArea'];
        $data = @base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $data));
        file_put_contents("customer/".$cust_id.".jpeg", $data);



      }

      if(!$sql)
      {




          echo "<div class='alert alert-danger'>
            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
            <strong>System Error</strong> There is a problem with the System. Please contact the Admin (Critical) or This customer is already registered in the database.
          </div>";
          exit(1);
      }else{

         
          echo "<div class='alert alert-success'>
            <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
            <strong>Success</strong> Customer has been added.
          </div>";
      }



  }

  
?>

 <form action="" name='registerCustomerForm' method="POST">
  
<div id="myModal" class="modal fade" role="dialog">

                <div class="modal-dialog modal-lg">
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <h4 class="modal-title">Customer info.</h4>
                    </div>
                   
                      <div class="modal-body">
                       <div class="container-fluid">
                       <!--   <div class="panel-body">-->

                    <div class='row'>
                     

                           <div class="col-md-6">

                              <div class='row'>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="customerfname" class="control-label">First Name :</label>
                                    </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-md-12">
                                  <div class="form-group">
                                    <input type="text" class="form-control"   id="customerfname" name="customerfname" required='required' placeholder="Firstname" autocomplete="off">
                                  </div>
                                </div>
                              </div>



                               <div class='row'>
                                  <div class="col-md-12">
                                    <div class="form-group">
                                          <label for="customerMiddle"  class="control-label">Middle Initial :</label>
                                    </div>
                                  </div>
                              </div>

                              <div class="row">
                                  <div class="col-md-12">
                                  <div class="form-group">
                                    <input type="text" class="form-control" maxlength="1"   id="customerMiddle" name="customerMiddle" required='required' placeholder="MI" autocomplete="off">
                                  </div>
                                </div>
                               </div>

                               <div class='row'>
                                  <div class="col-md-12">
                                    <div class="form-group">
                                          <label for="customerlname" class="control-label">Last Name :</label>
                                    </div>
                                </div>
                              </div>
                              <div class="row">
                                  <div class="col-md-12">
                                  <div class="form-group">
                                    <input type="text" class="form-control"   id="customerlname" name="customerlname" required='required' placeholder="Lastname" autocomplete="off">
                                  </div>
                                </div>
                               </div>

                               <div class='row'>
                                  <div class="col-md-12">
                                    <div class="form-group">
                                          <label for="gender" class="control-label">Gender :</label>
                                    </div>
                                </div>
                              </div>

                                <div class='row'>
                                   <div class="col-md-12">
                                  <div class="form-group">
                                    <select class="form-control" id="gender" name="gender">

                                      <?php

                                      echo $row['gender'];

                                          if($row['gender']==0){
                                            echo "<option value='0' >Male</option>
                                            <option value='1' >Female</option>";
                                          }else{
                                            echo "<option value='1' >Female</option>
                                            <option value='0' >Male</option>";
                                          }

                                      ?>
                                      

                                    </select>
                                  </div>
                                </div>
                              </div>


                               <div class='row'>
                                   <div class="col-md-12">
                                    <div class="form-group">
                                          <label for="customerBday" class="control-label">Date of birth :</label>
                                    </div>
                                </div>
                              </div>

                              <div class="row">
                                 <div class="col-md-12">
                                  <div class="form-group">
                                    <input type="date" class="form-control"   id="customerBday" name="customerBday" required='required' placeholder="Birth day" autocomplete="off">
                                  </div>
                                </div>
                               </div>

                               <div class='row'>
                                   <div class="col-md-12">
                                    <div class="form-group">
                                          <label for="customerContact" class="control-label">Contact No. :</label>
                                    </div>
                                </div>
                              </div>

                              <div class="row">
                                 <div class="col-md-12">
                                  <div class="form-group">
                                    <input type="text" class="form-control"   id="customerContact" name="customerContact" required='required' placeholder="Contact No.">
                                  </div>
                                </div>
                              </div>

                                <div class='row'>
                                   <div class="col-md-12">
                                    <div class="form-group">
                                          <label for="customeradd" class="control-label">Address :</label>
                                    </div>
                                </div>
                              </div>

                              <div class="row">
                                <div class="col-md-12">
                                  <div class="form-group">
                                    <input type="text" class="form-control"  id="customeradd" name="customeradd" required='required' placeholder="Customer address" autocomplete="off">
                                  </div>
                                </div>
                              </div>

                              <div class='row'>
                                <div class="col-md-12">
                                    <div class="form-group">
                                          <label for="optionId" class="control-label">Identification card :</label>
                                    </div>
                                </div>
                              </div>

                              <div class="row">
                                  <div class="col-md-12">
                                  <div class="form-group">
                                    <select name='identification_type_no' class="form-control" id='optionId'>
                                      
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
                                </div>
                               </div>

                               <div class='row'>
                                  <div class="col-md-12">
                                    <div class="form-group">
                                          <label for="customerIdNO" class="control-label">ID No.:</label>
                                    </div>
                                </div>
                              </div>
                              <div class="row">
                               <div class="col-md-12">
                                  <div class="form-group">
                                    <input type="text" class="form-control"   id="customerIdNO" name="customerIdNO" required='required' placeholder="ID No. " autocomplete="off">
                                  </div>
                                </div>
                               </div>
                        <!--  </div> -->

                        </div>

                         <div class="col-md-6">
                          
                          <div id="my_camera" ></div>

                         <input type=button value="Take Snapshot" id='takeShot' style="margin-top:1%;" onClick="take_snapshot()">
  
                       
                          <script type="text/javascript" src="bootstrap/js/webcam.js"></script>
                          
                          <!-- Configure a few settings and attach camera -->
                          <script language="JavaScript">
                            Webcam.set({
                              width: 320,
                              height: 240,
                              image_format: 'jpeg',
                              jpeg_quality: 90
                            });
                            Webcam.attach( '#my_camera' );
                          </script>

                        </div>


                        </div>

                       </div>
                      </div>
                   

                    <div class="modal-footer">
                      <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                      <button type="submit" id='btnSubmitCustomer' name='btnSubmitCustomer' class="btn btn-primary" >Submit</button>
                    </div>
                  </div>
                </div>
            </div>
      </form>


<script>



function take_snapshot() {
      // take snapshot and get image data
      Webcam.snap( function(data_uri) {
        // display results in page
        document.getElementById('my_camera').innerHTML =
           "<img  name='imgArea' src='"+data_uri+"'/> <input type='hidden'  name='imgArea' value='"+data_uri+"'/>";


        //  saveImage(data_uri);

      } );

      $("#takeShot").hide();

    }


    function saveImage(data_uri){

      $remote_img = data_uri;
      $img = imagecreatefromjpeg($remote_img);
      $path = 'img/';
      imagejpeg($img, $path);

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

  

  $('#btnSubmitCustomer').click(function() {
    // get all the inputs into an array.
    var $inputs = $('#registerCustomerForm :input');

    // not sure if you wanted this, but I thought I'd add it.
    // get an associative array of just the values.
    var values = {};
    $inputs.each(function() {
        values[this.name] = $(this).val();
    });

    $.post('jsquery/insertCustomer.php',$('#registerCustomerForm').serialize(),function(data){

       alert(data);

    });

});




   
      


  });

</script>