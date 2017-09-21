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



	$dbReply = $con->update("update transaction_sm set date=now(),branch_no=$branch_no,cash_amount=$cashAmount,off_cust_id='$off_cust_id',cust_id=$cust_id,user_id=$user where status=3 and ref_no =$ref_no");

echo "update transaction_sm set date=now(),branch_no=$branch_no,cash_amount=$cashAmount,off_cust_id='$off_cust_id',cust_id=$cust_id,user_id=$user where status=3 and ref_no =$ref_no";

		$con->query("insert into sms_stack(sms_body,mobile_no) values('$smsSend','$recipient');");




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

		
				<h3>Current</h3>
	
			
	
	
		<div id='resultArea'>				

			<?php



				$query = $con->query("select * from sms where address in ('SMARTMoney','SmartPadala') ORDER BY date desc");
				$rowCount = $con->getRowCount();

				$sms = $con->query("select * from sms where address in ('SMARTMoney','SmartPadala') ORDER BY date desc limit ".($page*100)." ,100 ");
				

				 $rowCount;

				
				
				 $rownum = 1;
				while($row = mysqli_fetch_array($sms))
				{	
					
					
				
					echo "<div class='panel panel-default'>";
				

					echo 		"<div class='panel-title'>";
					echo			'<B>'.$rownum++.'</B>';
					echo 		"</div>";

					echo 		"<div class='panel-body'>";
					echo			$row['body'];
					echo 		"</div>";
				
					echo "</div>";
				
					
				}
				echo "<ul class='pager'>";

				for($i=0; $i<($rowCount / 100); $i++)
				{
					
						echo "<li><a  id='link".$i."' class='linkbtn' role='button' href='smsCurrent.php?page=$i'>".($i+1)."</a></li>";
					
				}
				echo "</ul>";

			?>
			


		</div>

	</div>

	
</div>
<script>

	$(document).ready(function(){



		






	});


</script>


<?php

include('foot.php');

?>

