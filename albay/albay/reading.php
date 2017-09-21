
<?php



include('head.php');

	$user = $_SESSION['userz']['user_id'];

	$branch_no = $_SESSION['userz']['branch_no'];

  $dateEntry =  date('Y-m-d');

	  $dateEntryTo =  "'".date('Y-m-d')."'";;
?>

<div class='container'>

<?php

if(isset($_REQUEST['btnSave'])){


   // $amount = $_REQUEST['']

 $diff =  $_REQUEST['difference'];
 $actualamount =  $_REQUEST['totalCash2'];

 if($diff < 0)
 {
$diff = ($diff * -1);




//$con->query("insert into fr_entry(description,fr_type_no,date,branch_no,user_id,amount)
  //         values('End Cash',4,now(),$branch_no,$user,$actualamount)");


$con->query("insert into fr_entry(description,fr_type_no,date,branch_no,user_id,amount)
             values('Short Cash Count',4,now(),$branch_no,$user,$diff)");

 }else if($diff > 0){

  



$con->query("insert into fr_entry(description,fr_type_no,date,branch_no,user_id,amount)
             values('Over Cash Count',3,now(),$branch_no,$user,$diff)");


 }


  

}

	
$comp = new computation($con->getConnection());


$currBalance = $comp->getBalance($dateEntry);




?>	

  <form method="POST" action='' id='selfForm' role="form">
          <div class="form-group">
            <legend>TOTAL: <input type="text" id='totalCash'></legend>
          </div> 

  <table class="table">

    <tbody>
      <tr>
        <td><label class="">1000</label></td>
        <td><input type='number' id='inputs' value='0' class="form-control" name="1000"></td>
         <td><label class="">10</label></td>
        <td><input type='number' id='inputs' value='0' class="form-control" name="10"></td>
      </tr>
        <tr>
        <td><label class="">500</label></td>
        <td><input type='number' id='inputs' value='0' class="form-control" name="500"></td>
         <td><label class="">5</label></td>
        <td><input type='number' id='inputs' value='0' class="form-control" name="5"></td>
      </tr>
      <tr>
        <td><label class="">200</label></td>
        <td><input type='number' id='inputs' value='0' class="form-control" name="200"></td>
         <td><label class="">1</label></td>
        <td><input type='number' id='inputs' value='0' class="form-control" name="1"></td>
      </tr>
        <tr>
        <td><label class="">100</label></td>
        <td><input type='number' id='inputs' value='0' class="form-control" name="100"></td>
         <td><label class="">25C</label></td>
        <td><input type='number' id='inputs' value='0' class="form-control" name="0.25"></td>
      </tr>
        <tr>
        <td><label class="">50</label></td>
        <td><input type='number' id='inputs' value='0' class="form-control" name="50"></td>
         <td></td>
        <td></td>
      </tr>
        <tr>
        <td><label class="">20</label></td>
        <td><input type='number' id='inputs' value='0' class="form-control" name="20"></td>
        <td></td>
        <td><button type="button" data-title='Add' id="btnAdd"  data-toggle='modal' data-target='#add'  class="btn btn-primary">Save as End Day Cash</button></td>
      </tr>
      
        
   
    </tbody>
  </table>
        
        

  </form>





<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="add" aria-hidden="true">
      <div class="modal-dialog">
    <div class="modal-content">
          <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
        <h4 class="modal-title custom_align" id="Heading">Add Entry Detail</h4>
      </div>
        <form  method="get" >
          <div class="modal-body">

    



        <label>Expected</label>
        <div class="form-group">
          <input type='text'     value="<?php echo $currBalance; ?>"   name='expected' class="form-control" 
              placeholder="Amount"  id="expected" > 
        </div>
        <label>Actual</label>
        <div class="form-group">
        	<input type='text'  name='totalCash2' id='totalCash2'  class="form-control" 
              placeholder="Amount"  > 
        </div>

        <label>Difference</label>
        <div class="form-group">
          <input type='text'   value="0" name='difference' class="form-control" 
              placeholder="Amount" id="difference"> 
        </div>

        <small>This will be added to financial item entry</small>

      </div>
      <div class="modal-footer ">
        <button type="submit" id='btnSave' name='btnSave' class="btn btn-warning btn-lg" style="width: 100%;"><span class="glyphicon glyphicon-ok-sign"></span>Save</button>
     
      </div>
   
        </div>


    <!-- /.modal-content --> 
  </div>
      <!-- /.modal-dialog --> 


</div>
    
    
    
<?php

include('foot.php');

?>


<script>



	$(document).ready(function(){

      var x = {'1000': 0,'500':0,'200':0,'100':0,'50':0,'20':0,'10':0,'5':0,'1':0,'0.25':0};

      var y = ['1000','500','200','100','50','20','10','5','1','0.25'];

      

      $('[id="inputs"]').keyup(function(){
        var sum = 0;
          
        var num =   $(this).attr('name');

        x[num] = ($(this).val() * num);

        //console.log(x['500']);

        for(var i =0;i < 10;i++){

           // sum = (sum + x[i]); 

          

           console.log((sum = sum + (x[y[i]])));
        }

     var cash =   $('#totalCash').val(sum);
       var expected = $('#totalCash2').val(sum);

 $('#difference').val( ($('#totalCash2').val() - $('#expected').val()) );

      });

     

	})


</script>

