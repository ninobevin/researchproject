<?php include('head.php'); ?>

<div class='container'>
			
        <?php

          if(isset($_REQUEST['btnupdate']))
          {

           // echo "hahahahahah";
            $customerfname = $_REQUEST['customerfname'];
            $customerMiddle = $_REQUEST['customerMiddle'];
            $lastname = $_REQUEST['customerlname'];
            $customeradd = $_REQUEST['customeradd'];
            $customerBday = $_REQUEST['customerBday'];
            $gender = $_REQUEST['gender'];

            //firstname, middlename, lastname, address
            $str = "update users set gender='$gender',firstname='$customerfname',middlename='$customerMiddle',lastname=' $lastname',
                     loc_id = (select loc_id from location where concat(barangay,', ',city,' ',province) = '$customeradd'),dob='$customerBday' where user_id=".$_SESSION['userz']['user_id']."";
                 // echo $str;
            $isSuccess = $con->update($str);

            if(!$isSuccess)
      {
          echo"<div class='alert alert-danger'>
    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
    <strong>Error! </strong> Problem with the connection, Please try again.
  </div>";

      }else{

          echo"<div class='alert alert-success'>
    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
    <strong>Success! </strong> Customer info. has been updated.
  </div>";
      } 

          }

           $str = "select a.*,concat(b.barangay,', ',b.city,' ',b.province) as address from users a join location b on a.loc_id=b.loc_id where user_id=".$_SESSION['userz']['user_id']."";
          //  echo $str;
            $sql = $con->query($str);

            $row=mysqli_fetch_array($sql);

        ?>


        <style>
    
    .form-group
    {
      margin:0px;
    }
    .form-group select, input
    {
      margin-top:30px;
    }
    #selfForm
    {
      padding-bottom: 5%;
    }

</style>

        <form action="" id="selfForm" method="POST" role="form">

        <div class="form-group">
            <legend>User Account</legend>
        </div>



        <div class='row'>

            <div class="col-md-4">
              
              <div class="form-group">
                <input type="text" class="form-control"  style='width:100%;'   id="customerfname" name="customerfname" required='required' value="<?php echo $row['firstname']  ?>">
              </div>
              <div class="form-group" style='text-align:center;'>
                    <label for="inputType" class="control-label">First Name</label>
              </div>
            </div>

            <div class="col-md-4">        
              <div class="form-group">
                <input type="text" class="form-control"  style='width:100%;' maxlength="1"  id="customerMiddle" name="customerMiddle" required='required' value="<?php echo $row['middlename']  ?>" >
              </div>
              <div class="form-group" style='text-align:center;'>
                    <label for="inputType" class="control-label">Middle Initial</label>
              </div>
            </div>

            <div class="col-md-4">          
              <div class="form-group">
                <input type="text" class="form-control"  style='width:100%;'   id="customerlname" name="customerlname" required='required' value="<?php echo $row['lastname']  ?>">
              </div>
              <div class="form-group" style='text-align:center;'>
                    <label for="inputType" class="control-label">Last Name</label>
             </div>
            </div>  

        </div>

         <div class='row'>

            <div class="col-md-8">
              
              <div class="form-group">
                <input type="text" class="form-control"  style='width:100%;'   id="customeradd" name="customeradd" required='required' value="<?php echo $row['address']  ?>">
              </div>
              <div class="form-group" style='text-align:center;'>
                    <label for="inputType" class="control-label">Address</label>
              </div>
            </div>

            <div class="col-md-4">
              
              <div class="form-group">
                <input type="date" class="form-control"  style='width:100%;'   id="customerBday" name="customerBday" required='required' value="<?php echo $row['dob']  ?>">
              </div>
              <div class="form-group" style='text-align:center;'>
                    <label for="inputType" class="control-label">Date of Birth</label>
              </div>

            </div>

        </div>

        <div class='row'>

            <div class="col-md-4">
              
              <div class="form-group">

                <select class="form-control" name="gender">

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
              <div class="form-group" style='text-align:center;'>
                    <label for="inputType" class="control-label">Gender</label>
              </div>
            </div>

        </div>


       <div class="row">

            <div class="col-md-4">
            
              <div class="form-group">
                <button type="submit"  name='btnupdate' class="btn btn-primary center-block" style='width:90%; margin-top:30px;'  id='btnupdate'>Save Change data</button>
              </div>
           
            </div>

      </div>
        
		</form>
	
  </div>

<script>

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
 


  });

</script>

<?php

include('foot.php');

?>