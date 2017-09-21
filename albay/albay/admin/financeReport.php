
<?php



include('head.php');

	$user = $_SESSION['userz']['user_id'];

	$branch_no = $_SESSION['userz']['branch_no'];

	 $dateEntry =  "'".date('Y-m-d')."'";;

	  $dateEntryTo =  "'".date('Y-m-d')."'";


    if(isset($_REQUEST['dateEntry']) || isset($_REQUEST['dateEntryTo'])){

   $dateEntry = $_REQUEST['dateEntry'];
   $dateEntryTo = $_REQUEST['dateEntryTo'];
}

?>

<div class='container'>

          <div class="col-md-12">
        <h4>Financial Entry</h4>
        <div class="table-responsive">

                
              <table id="mytable" class="table table-bordred table-striped">
                   

                <thead>
                   
             
                   <th colspan="5">
                    
                        <span class="label label-primary">From: </span>
                      <input type="date" value=<?php echo $dateEntry; ?> style="min-width: 0; width: auto; display: inline;" class="form-control" name="dateEntry" id="dateEntry">
                        <span class="label label-primary">To: </span>
                      <input type="date" value=<?php echo $dateEntryTo; ?> style="min-width: 0; width: auto; display: inline;" class="form-control" name="dateEntryTo" id="dateEntryTo">
                      <button type="button" id='generate' class="btn btn-primary"> Generate </button>
                        

                    </th>

                   </thead>
                   <thead>
                    <th colspan="5">
                      <a href="sendSmsToAdmin.php"> Send SMS </a>

                    </th>
                   
                  
                   
                   
                
                   </thead>






    <tbody>
<?php

      


?>


    </tbody>
    </table>

</div>


    <iframe height="500" style="width: 100%" src="frprint.php"></iframe>


<script type="text/javascript">
  
$('#generate').click(function(){


     var dateEntry = $('#dateEntry').val();

     var dateEntryTo = $('#dateEntryTo').val();


     $('iframe').attr('src','frprint.php?dateEntry='+dateEntry+'&dateEntryTo='+dateEntryTo);


  });






</script>