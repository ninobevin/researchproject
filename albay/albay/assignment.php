<?php

	include('head.php');
	$page = 0;

	if(isset($_REQUEST['page']))
	{
		$page = $_REQUEST['page'];
	}

	$cust_id = $_REQUEST['cust_id'];
	$off_cust_id = $_REQUEST['off_cust_id'];
	$branch_no = $_REQUEST['branch_no'];
	$user = $_SESSION['userz']['user_id'];
	$request_no = $_REQUEST['reqNo'];
	$cboReport = @$_REQUEST['cboReport'];

//	echo $cust_id;

	if(@$_REQUEST['cboReport'] != 1){
		$isSuccess = '';
		$cboReport = $_REQUEST['cboReport'];
		
		if($cboReport == 4)
		{
			echo "Update request set remarks=".$cboReport." where request_no=$request_no";
			
			$isSuccess = $con->query("Update request set remarks=".$cboReport." where request_no=$request_no");
			die("Updated click <a href='viewRequest.php'>HERE</a> to refresh...");
			
		}else{
			$isSuccess = $con->query("Update request set read_server=1,remarks=".$cboReport." where request_no=$request_no");
			echo "Update request set read_server=1,remarks=".$cboReport." where request_no=$request_no";
			die("Updated click <a href='viewRequest.php'>HERE</a> to refreshlll.");
		}
		
		
		
		
		
	}


	if(isset($_REQUEST['btnSubmit']))
	{
		$tranId = $_REQUEST['tranId'];
		$rec = $_REQUEST['mobileRecipient'];
		$bodySMS = $_REQUEST['bodySMS'];



		$ip_req = $con->query("select ip_address from general_account_add where account_no=2;");

		$ips = mysqli_fetch_array($ip_req)['ip_address'];

		
		$isSuccess = $con->query("Update transaction_sm set cust_id='$cust_id',off_cust_id='$off_cust_id',branch_no='$branch_no',user_id='$user' where ref_no='$tranId'
		and cust_id is null and branch_no is null and user_id=0");
		
		
		


		$con->query("insert into sms_stack(sms_body,mobile_no) values('$bodySMS','$rec');");

		if(!$isSuccess)
      {
      	echo"<div class='alert alert-danger'>
		<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
		<strong>Error! </strong> Problem with the connection, Please try again.
	</div>";



      }else{

			$con->update("update request set date_end = now() where request_no = ". $request_no);
          echo "<script>alert('Successfully Assigned...');
          			
          			window.location.href='viewRequest.php';	
          </script>";
     $con->update("update request set read_server=1,notified=0 where request_no='$request_no'");
         // header("location: viewRequest.php");

		

		
      } 

	}

?>

<style>


#link<?php

	
?>{

	background-color: #337ab7;
	color:white;

}


</style>




<div class='container'>

	<div id='selfForm'>

		<div class="form-group">
				<legend>Request details</legend>
		</div>
			
		<?php
						

						$requesDeatails = $con->query(" select a.*,concat(b.fname,' ',b.mname,'. ',b.lastname) as name,c.username as user".
									               " from request a join customer b on a.cust_id=b.cust_id join users c on a.user_id ".
									               " = c.user_id where a.request_no='$request_no'");

						$row = mysqli_fetch_array($requesDeatails);

		?>

	<div class='row' >
		<div class='col-md-12' >
			<table>
				<div class='row'>
					<div class="col-md-3" ><p>Date :</p></div><div class="col-md-4"><?php echo $row['date']  ?></div>
				</div>
				<div class='row'>
					<div class="col-md-3" ><p>Customer :</p></div><div class="col-md-4"><?php echo $row['name']  ?></div>
				</div>
				<div class='row'>
					<div class="col-md-3" ><p>Offline Details :</p></div><div class="col-md-4"><?php echo $row['off_cust_id']  ?></div>
				</div>
				<div class='row'>
					<div class="col-md-3" ><p>Amount :</p></div><div class="col-md-4"><?php echo $row['amount']  ?></div>
				</div>
				<div class='row'>
					<div class="col-md-3" ><p>Recipient Mobile :</p></div><div class="col-md-4"><?php echo $row['recipient']  ?></div>
				</div>
				<div class='row'>
					<div class="col-md-3" ><p>SMARTMoney Number :</p></div><div class="col-md-4"><?php echo $row['smartmoneynumber']  ?></div>
				</div>
				<div class='row'>
					<div class="col-md-3" ><p>Sender :</p></div><div class="col-md-4"><?php echo $row['user']  ?></div>
				</div>
			</table>
		</div>
		
	</div>

	

	<?php

		$request_no = $_REQUEST['reqNo'];

		$mobileRecipient =  $row['recipient'];

		$query = $con->query("select body_sms from transaction_sm where cust_id is null
		and branch_no is null and user_id=0 and status=3");
		$rowCount = $con->getRowCount();

		$sms = $con->query("select body_sms,ref_no,tran_id from transaction_sm where cust_id is null
		and branch_no is null and user_id=0 and status=3 limit ".($page*10)." ,10 ");
		

	

		while($row = mysqli_fetch_array($sms))
		{	
			$tranId = $row['ref_no'];
			echo "<form method='GET' action='assignment.php' class='form-horizontal'  role='form'>
			<input type='hidden' name='reqNo' value='$request_no'>
			<input type='hidden' name='cboReport' value='$cboReport'>
			<input type='hidden' name='branch_no' value='$branch_no'>
			<input type='hidden' name='cust_id' value='$cust_id'>
			<input type='hidden' name='off_cust_id' value='$off_cust_id'>
			<input type='hidden' name='tranId' value='$tranId'>
			<input type='hidden' name='mobileRecipient' value='$mobileRecipient'>
			<input type='hidden' name='bodySMS' value='".$row['body_sms']."'>";
			echo "<div class='row'>";
			echo "<div class='panel panel-default'>";
			echo 	"<div class ='col-md-9'>";
			echo 		"<div class='panel-body'>";
			echo			$row['body_sms'];
			echo 		"</div>";
			echo 	"</div>";
			echo "</div>";
			echo 	"<div class ='col-md-3'> <button type='submit' class='btn btn-success' id='btnSubmit' name='btnSubmit'>Assign</button> </div>";
			echo "</div>";
			echo "</form>";
		}
		echo "<ul class='pager'>";

		for($i=0; $i<($rowCount / 10); $i++)
		{
			
				echo "<li><a  id='link".$i."' class='linkbtn' role='button' href='assignment.php?reqNo=$request_no&page=$i&cust_id=$cust_id&branch_no=$branch_no'>".($i+1)."</a></li>";
			
		}
		echo "</ul>";

	?>
	


	</div>

	
</div>

<?php

include('foot.php');

?>

