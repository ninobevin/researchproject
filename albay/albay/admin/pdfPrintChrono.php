<?php


include('../classes/connection.php');
include('../classes/computation.php');
include('../fpdf/fpdf.php');


$con = new connection();

$pdf = new fpdf();



	$date = date("Y-m-d");
	$dateTo = date("Y-m-d");





if(isset($_REQUEST['dateFormValue'])){

	$date = addslashes($_REQUEST['dateFormValue']);

	$dateTo = addslashes($_REQUEST['dateTo']);

}


	$comp = new computation($con->getConnection());





?>
	


<?php


		$account_no =$_REQUEST['account_no'];

		


/*
<p>The value of <u>difference</u> indicates that an sms was deleted or was not added to application filter.</p>
	<table class='table table-hover'>
			<thead >
				<tr >
					<th id='dataCenter'>#</th>
					<th id='dataCenter'>Date</th>
					<th id='dataCenter'>Status</th>
					<th id='dataCenter'>Reference</th>
					<th id='dataCenter'>PAmount</th>
					<th id='dataCenter'>Account</th>
					<th id='dataCenter'>Balance</th>
					<th id='dataCenter'>Difference</th>
				</tr>
			</thead>

			<tbody>
*/


	    $queryStr = "select a.body_sms as body,a.balance,ifnull(d.branch_name,'N/A') as branch_name,c.name as status,a.status as statusNum,b.name as accountname,a.date as date,a.ref_no as ref_no,a.amount as amount
	  			   from transaction_sm a left join account_sm b on a.account=b.account_no
	  			    left join status_sm c on a.status=c.sm_status_no left join branch d on a.branch_no = d.branch_no where a.account=$account_no and date_format(a.date,'%Y-%m-%d') between '$date' and '$dateTo' 
	  			    order by a.date;";

	  	/*  FPDF   */

	  	$pdf->b1 = "Account Summary";
		$pdf->b2 = $date." to ".$dateTo;
		$pdf->AddPage('L','Legal');
	


		//data for table fpdf
			$dataFpdf =  array();


		$resultSet = $con->query($queryStr);


		$totalClaimedP = 0.00;
		$count = 1;
		 $balance =0.00;
		  $amountVar =0.00;
	    while(	$row =  @mysqli_fetch_array($resultSet) ){


	    		if($count > 1){


	    			$statusCheck = mysqli_fetch_array($con->query("select incoming from status_sm where sm_status_no = ".$row['statusNum'].";"))['incoming'];


    				
		    		if($statusCheck == 1){

						$amountVar = $row['amount'];

					}else{

						$amountVar = ($row['amount'] + $comp->getTransferCharge($row['amount'])) * -1;
					}


	    		}
	    		$var = $row['balance'] - ($balance + $amountVar);

	    		$dataFpdf[] =  array($count++,$row['date'],$row['branch_name'],$row['status'],$row['body'],$var);



				$balance = $row['balance'];
	    		/* row content 

	    		$count++;
				$row['date'];
				$row['status'];
				$row['ref_no'];
				$row['amount'];
				$row['accountname'];
				$row['balance'];
	    		*/
	    }


	    /*

			<tr >
					<th id='dataCenter'>#</th>
					<th id='dataCenter'>Date</th>
					<th id='dataCenter'>Status</th>
					<th id='dataCenter'>Reference</th>
					<th id='dataCenter'>PAmount</th>
					<th id='dataCenter'>Account</th>
					<th id='dataCenter'>Balance</th>
					<th id='dataCenter'>Difference</th>
				</tr>
			

	    */


		$header = array('#', 'Date', 'Branch', 'Status','BODY SMS','Difference');
		$sizes = array(10, 30,30, 20,200,20);
		$right =  array(6);	 
		$pdf->SetFont('Arial','',7);
	
		
			$pdf->BasicTable2($header,$dataFpdf,$sizes,$right,30);
	    

		$pdf->Output();

	?>					
				







<?php

	include('foot.php');
?>