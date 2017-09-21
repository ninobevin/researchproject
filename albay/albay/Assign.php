<?php












	include('head.php');
	$page = 0;

	if(isset($_REQUEST['page']))
	{
		$page = $_REQUEST['page'];
	}


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

	if(isset($_REQUEST['branchNo'])){

	$ref_no = $_REQUEST['ref_no'];
	$branch_no = $_REQUEST['branchNo'];
	$cashAmount = $_REQUEST['cashAmount'];
	$cust_id = '3808';
	$off_cust_id = $_REQUEST['customerName'];
	$recipient = $_REQUEST['recipient'];
	$smsSend = $_REQUEST['sms_body'];

	//echo "update transaction_sm set branch_no=$branch_no,cash_amount=$cashAmount,off_cust_id='$off_cust_id',cust_id=$cust_id,user_id=$user where ref_no =$ref_no";

	$dbReply = $con->update("update transaction_sm set branch_no=$branch_no,cash_amount=$cashAmount,off_cust_id='$off_cust_id',cust_id=$cust_id,user_id=$user where ref_no ='$ref_no'");


		$varSMS = "CONFIRM Ref:".$ref_no." Customer Cellphone#: ".$off_cust_id." Receiver Cellphone#: ".$recipient;

//put smart number here to forward

		//echo "insert into sms_stack(sms_body,mobile_no) values('$varSMS','$recipient');";
		$con->query("insert into sms_stack(sms_body,mobile_no) values('$varSMS','8890');");




	 if(!$dbReply)
      {

          echo"<div class='alert alert-danger'>
		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
		<strong>Error! </strong> Problem with the connection, Please try again.
	</div>";

      }else{

          echo"<div class='alert alert-success'>
		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
		<strong>Success! </strong> Transaction has been assigned.
	</div>";
      } 



	}
	?>



	<div id='selfForm'>

		
				<h3>Unassigned SMS</h3>
	
			
	
	
		<div id='resultArea'>				

			<?php



				$query = $con->query("select body_sms from transaction_sm where cust_id is null
				and branch_no is null and user_id=0 and status=3");
				$rowCount = $con->getRowCount();

				$sms = $con->query("select body_sms,tran_id,ref_no from transaction_sm where cust_id is null
				and branch_no is null and user_id=0 and status=3 order by date desc limit ".($page*10)." ,10 ");
				

				 $rowCount;

				
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
					
						echo "<li><a  id='link".$i."' class='linkbtn' role='button' href='Assign.php?page=$i'>".($i+1)."</a></li>";
					
				}
				echo "</ul>";

			?>
			


		</div>

	</div>

	
</div>
<script>

	$(document).ready(function(){


		$(" button[id='btnSubmit'] ").click(function(e){







	




			 	
			 	var tran_id =	e.currentTarget.value;

				$.post('jsquery/saveAssign.php',{tran_id:tran_id},function(data){

						//alert(data);

						//location.href="assignToMain.php";

						$("#resultArea").html(data);

				});


		





		});


	});


</script>


<?php

include('foot.php');

?>

