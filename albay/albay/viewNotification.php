<?php

include('head.php');





?>


<div class='container'>

	<legend>Notification List</legend>
					
					<?php

							$req = $con->query("select a.*,concat(b.fname,' ',b.mname,'. ',b.lastname)
							 as name,c.username as user from request a join customer b on a.cust_id=b.cust_id join users c on a.user_id=c.user_id WHERE a.read_server=1 and a.read_client=0"
							 ." and a.branch_no=".$_SESSION['userz']['branch_no'].";");
					
						 $count = 1;
						 while($row = mysqli_fetch_array($req))
						 {

						 	echo "<div class='alert alert-success'>
								<strong>Money transfer <br> </strong>Sent Request Successfuly Transfered to ".$row['name']." with Amount of ".$row['amount']." and Mobile Number ".$row['recipient']."
							</div>";

						 }


						 $con->update("update request set read_client=1 where  read_server=1 and read_client=0 and".
  		" branch_no=".$_SESSION['userz']['branch_no'].";");
						 


					?>

	</div>


	

					
				


	
</div>
<script>
/*
$("#btnSubmit").click(function(){

alert();

});
*/




$('#myModal').on('show.bs.modal', function(e) {
  //  $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));

  var loc = $(e.relatedTarget).data('href');

  		$("#btn-ok").click(function(){


  			$(location).attr('href', loc);

  		});

});
</script>

<?php

include('foot.php');

?>