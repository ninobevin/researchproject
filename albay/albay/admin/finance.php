
<?php



include('head.php');

	$user = $_SESSION['userz']['user_id'];

	$branch_no = $_SESSION['userz']['branch_no'];

	 $dateEntry =  "'".date('Y-m-d')."'";;

	  $dateEntryTo =  "'".date('Y-m-d')."'";;
?>

<div class='container'>

<?php

if(isset($_REQUEST['dateEntry']) || isset($_REQUEST['dateEntryTo'])){

	 $dateEntry = $_REQUEST['dateEntry'];
	 $dateEntryTo = $_REQUEST['dateEntryTo'];
}

	

if(isset($_REQUEST['btnAdd'])){



	 $queryEntry = "insert into fr_entry(date,description,fr_type_no,branch_no,user_id,amount) 
					values('".$_REQUEST['date']."','".$_REQUEST['description']."',".$_REQUEST['ledger'].",$branch_no,$user,".$_REQUEST['amount'].")";

	$sqlEntry = $con->query($queryEntry);

}
if(isset($_REQUEST['deleteSubmit'])){



	 $queryEntry = "delete from fr_entry where fr_entry_no=".$_REQUEST['idDelete'];

	$sqlEntry = $con->query($queryEntry);



}
if(isset($_REQUEST['btnUpdate'])){



	$hId = $_REQUEST['hId'];
	$ledger = $_REQUEST['ledger'];
	$date = $_REQUEST['date'];
	$amount = $_REQUEST['amount'];
	$description = $_REQUEST['description'];


	 $queryEntry = "update  fr_entry set fr_type_no=$ledger,date='$date',amount=$amount,description='$description'
						 where fr_entry_no=$hId";

	$sqlEntry = $con->query($queryEntry);

}
?>	

<?php

	   $queryEntry = "select a.*,b.*,if(b.type = 1,'Debit','Credit') as type from fr_entry a join fr_type b on a.fr_type_no=b.fr_type_no where date_format(a.date,'%Y-%m-%d') between $dateEntry and $dateEntryTo";

	$sqlEntry = $con->query($queryEntry);

 ?>

	
	<div class="row">
		
        
        <div class="col-md-12">
        <h4>Financial Entry</h4>
        <div class="table-responsive">

                
              <table id="mytable" class="table table-bordred table-striped">
                   

              	<thead>
                   
                   <th colspan="7"><button  data-toggle='modal' data-target='#add' type="button" class="btn btn-success">Add Item</button>
                    
                  			<span class="label label-primary">From: </span>
                   		<input type="date" value=<?php echo $dateEntry; ?> style="min-width: 0; width: auto; display: inline;" class="form-control" name="dateEntry" id="dateEntry">
                   			<span class="label label-primary">To: </span>
                   		<input type="date" value=<?php echo $dateEntryTo; ?> style="min-width: 0; width: auto; display: inline;" class="form-control" name="dateEntryTo" id="dateEntryTo">		
                   	</th>
                  
                   
                   
                
                   </thead>






                   <thead>
                   
                   <th>#</th>
                   <th>Date</th>
                    <th>Type</th>
                    <th>Ledger</th>
                     <th>Description</th>
                     <th>Amount</th>
                      <th>Edit</th>
                      
                       <th>Delete</th>
                   </thead>
    <tbody>


    <?php

    $ct = 1;
    while($row = mysqli_fetch_array($sqlEntry))

    {


    	echo "<tr>
    <td>".($ct++)."</td>
    <td id='date'>".$row['date']."</td>
    <td id='type'>".$row['type']."</td>
    <td id='name'>".$row['name']."</td>
    <td id='desc'>".$row['description']."</td>
    <td id='amount'>".$row['amount']."</td>
    <td><p data-placement='top' data-toggle='tooltip'  title='Edit'><button class='btn btn-primary btn-xs'   data-title='Edit'   data-toggle='modal' data-target='#edit' name='".$row['fr_entry_no']."' id='editbtn' ><span class='glyphicon glyphicon-pencil'></span></button></p></td>
    <td><p data-placement='top' data-toggle='tooltip' title='Delete'><button id='btnDelete' name='".$row['fr_entry_no']."'  class='btn btn-danger btn-xs' data-title='Delete' data-toggle='modal' data-target='#delete' ><span class='glyphicon glyphicon-trash'></span></button></p></td>
    </tr>";


    }

    ?>
    
 
   
    
    </tbody>
        
</table>

<div class="clearfix"></div>
<!--
<ul class="pagination pull-right">
  <li class="disabled"><a href="#"><span class="glyphicon glyphicon-chevron-left"></span></a></li>
  <li class="active"><a href="#">1</a></li>
  <li><a href="#">2</a></li>
  <li><a href="#">3</a></li>
  <li><a href="#">4</a></li>
  <li><a href="#">5</a></li>
  <li><a href="#"><span class="glyphicon glyphicon-chevron-right"></span></a></li>
</ul>
                
            </div>
            
        </div>
	</div>
</div>
-->

<div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
      <div class="modal-dialog">
    <div class="modal-content">
          <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
        <h4 class="modal-title custom_align" id="Heading">Edit Your Detail</h4>
      </div>
          <div class="modal-body">
        				

        <form class='edit_form' method="post" action="">

        <input type="hidden" name="hId" id="hId">

        <div class="form-group">
        	<input class="form-control" required="required" name='date' id="date" type="date">
        </div>


       
        <div class="form-group">




        	<select class="form-control" name='ledger' id="ledger">
        	 <?php

        	$queryType = "select *,if(type=1,'Debit','Credit') as typeFr from fr_type";

        	$sqlType = $con->query($queryType); 


         while ($row = mysqli_fetch_array($sqlType)) {
         		
         		echo "	<option value='".$row['fr_type_no']."'>".$row['name']." (".$row['typeFr'].")</option>";
         	}	

         ?>

        	</select>
        </div>
        <div class="form-group">
        	<textarea rows="2" class="form-control"  required="required" name='description'  id='description' placeholder="Description here..."></textarea>
        </div>
        <div class="form-group">
        	<input type="number" class="form-control"  required="required" placeholder="Amount" name="amount"  id="amount"> 
        </div>

 
     	 </div>
          <div class="modal-footer ">
        <button type="submit" name='btnUpdate' class="btn btn-warning btn-lg" style="width: 100%;"><span class="glyphicon glyphicon-ok-sign"></span> Update</button>
      </div>

      </form>
        </div>


    <!-- /.modal-content --> 
  </div>
      <!-- /.modal-dialog --> 
</div>
<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="add" aria-hidden="true">
      <div class="modal-dialog">
    <div class="modal-content">
          <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
        <h4 class="modal-title custom_align" id="Heading">Add Entry Detail</h4>
      </div>
          <div class="modal-body">

          	 <form  method="get">


        <div class="form-group">
        	<input class="form-control" required="required" name='date' type="date">
        </div>


       
        <div class="form-group">




        	<select class="form-control" name='ledger'>
        	 <?php

        	$queryType = "select *,if(type=1,'Debit','Credit') as typeFr from fr_type";

        	$sqlType = $con->query($queryType); 


         while ($row = mysqli_fetch_array($sqlType)) {
         		
         		echo "	<option value='".$row['fr_type_no']."'>".$row['name']." (".$row['typeFr'].")</option>";
         	}	

         ?>

        	</select>
        </div>
        <div class="form-group">
        	<textarea rows="2" class="form-control"  required="required" name='description' placeholder="Description here..."></textarea>
        </div>
        <div class="form-group">
        	<input type="number" class="form-control"  required="required" placeholder="Amount" name="amount"> 
        </div>


      </div>
          <div class="modal-footer ">
        <button type="submit" name='btnAdd' class="btn btn-warning btn-lg" style="width: 100%;"><span class="glyphicon glyphicon-ok-sign"></span>Save</button>
      </div>
      </form>
        </div>
    <!-- /.modal-content --> 
  </div>
      <!-- /.modal-dialog --> 
</div>
    
    
    
    <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
      <div class="modal-dialog">
    <div class="modal-content">
          <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
        <h4 class="modal-title custom_align" id="Heading">Delete this entry</h4>
      </div>
          <div class="modal-body">
       
       <div class="alert alert-danger"><span class="glyphicon glyphicon-warning-sign"></span> Are you sure you want to delete this Record?</div>

       <form class="deleteForm" method=post action="">
       	
       		<input type="hidden" id='idDelete' name="idDelete">
      
       
      </div>
        <div class="modal-footer ">
        <button type="submit" name='deleteSubmit' class="btn btn-success" ><span class="glyphicon glyphicon-ok-sign"></span> Yes</button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> No</button>
      </div>
       </form>
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


		$('[id="editbtn"]').click(function(e){

			var id = $(this).attr('name');


			$.post('jsquery/getfrdetails.php',{id:id},function(data){


					var dataParse = data;

					
					 var obj = jQuery.parseJSON( data );

					 $(".edit_form #date").val(obj.date);
					 $(".edit_form #description").val(obj.description);

					  $(".edit_form #ledger").val(obj.fr_type_no);
					   $(".edit_form #amount").val(obj.amount);

					   $(".edit_form #hId").val(obj.fr_entry_no);



			})

				//$(".edit_form #description").val("3");

		 



		})

		$('[id="btnDelete"]').click(function(e){

			var id = $(this).attr('name');

			$(".deleteForm #idDelete").val(id);


		 



		})

 			

		$("#dateEntry").change(function(e){


			
				var date = $("#dateEntry").val();

				var dateTo = $("#dateEntryTo").val();


				if(date > dateTo)
				{
					alert("Date must be valid, From must be lower To end Date");
					return;
				}

				location.href = "finance.php?dateEntry='"+date+"'&dateEntryTo='"+dateTo+"'"; 

		})

		$("#dateEntryTo").change(function(e){


				var date = $("#dateEntry").val();

				var dateTo = $("#dateEntryTo").val();


				if(date > dateTo)
				{
					alert("Date must be valid, From must be lower To end Date");
					return;
				}

				location.href = "finance.php?dateEntry='"+date+"'&dateEntryTo='"+dateTo+"'"; 

		})
	//	var values = $("input[id='task']")
      //        .map(function(){return $(this).val();}).get();



	})


</script>

