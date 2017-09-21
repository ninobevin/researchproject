<?php









	include('head.php');
	$page = 0;

	if(isset($_REQUEST['page']))
	{
		$page = $_REQUEST['page'];
	}

	
	$branch_no = $_SESSION['userz']['branch_no'];
	$user = $_SESSION['userz']['user_id'];


	//	echo $cust_id;

	

?>

<style>


#link<?php

	echo $page;
?>{

	background-color: #337ab7;
	color:white;

}


</style>




<div class='container'>
	<?php

	include('registerCustomer.php');
	?>



	<form id='selfForm' action='' method='GET'>

		<div class="form-group">
				<legend>Request details</legend>
		</div>
			
	
	<?php

	include('findCustomerSent.php');
	?>

	

	<?php



		$query = $con->query("select body_sms from transaction_sm where cust_id is null
		and branch_no is null and user_id=0 and status=3");
		$rowCount = $con->getRowCount();

		$sms = $con->query("select body_sms,tran_id,ref_no from transaction_sm where cust_id is null
		and branch_no is null and user_id=0 and status=3 limit ".($page*10)." ,10 ");
		

		 $rowCount;

		echo "<input type='hidden' id='branch_no' value='$branch_no'>";
		echo "<input type='hidden' id='user_id' value='$user'>";

		while($row = mysqli_fetch_array($sms))
		{	
			$tranId = $row['ref_no'];
			
		
			echo "<input type='hidden' name='tranId' id='tranId' value='$tranId'>";
			echo "<div class='row' id='$tranId'>";
			echo "<div class='panel panel-default'>";
			echo 	"<div class ='col-md-9'>";
			echo 		"<div class='panel-body'>";
			echo			$row['body_sms'];
			echo 		"</div>";
			echo 	"</div>";
			echo "</div>";
			echo 	"<div class ='col-md-3'>
			 <button type='button' class='btn btn-success' id='btnSubmit' value='".$tranId."---".$row['body_sms']."'>Assign</button> </div>";
			echo "</div>";
			
		}
		echo "<ul class='pager'>";

		for($i=0; $i<($rowCount / 10); $i++)
		{
			
				echo "<li><a  id='link".$i."' class='linkbtn' role='button' href='assignToMain.php?page=$i&branch_no=$branch_no'>".($i+1)."</a></li>";
			
		}
		echo "</ul>";

	?>
	


	</form>

	
</div>
<script>

	$(document).ready(function(){


		$(" button[id='btnSubmit'] ").click(function(e){




			var mobile_no = prompt("Recipient");



			if(mobile_no){	
		

			 	var user_id =	$("#user_id").val();
			 	var branch_no =	$("#branch_no").val();
			 	var customer_id =	$("#customerId").val();
			 	var cust_id_off =	$("#cust_id_off").val();
			 	
			 	var tran_id =	e.currentTarget.value;

				$.post('jsquery/saveToMain.php',{user_id:user_id,
												cust_id_off:cust_id_off,
												mobile_no:mobile_no,
												branch_no:branch_no,
												customer_id:customer_id,
												tran_id:tran_id},function(data){

						alert(data);

						location.href="assignToMain.php";

				});


			}





		});


	});


</script>


<?php

include('foot.php');

?>

