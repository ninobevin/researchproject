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


	    $queryStr = "select * from sms where address='SMARTMoney' and date_format(from_unixtime(floor(date / 1000)),'%Y-%m-%d')
				 				     between
									 date_format('".$date."','%Y-%m-%d')
									 and 
									 date_format('".$dateTo."','%Y-%m-%d') ";

	  	/*  FPDF   */

	  	$pdf->b1 = "SMS Summary";
		$pdf->b2 = $date." to ".$dateTo;
		$pdf->AddPage('L','Legal');
	


		//data for table fpdf
			$dataFpdf =  array();


		$resultSet = $con->query($queryStr);


		$count = 1;
	    while(	$row =  @mysqli_fetch_array($resultSet) ){


	    	
	    		$dataFpdf[] =  array($count++,$row['address'],$row['body']);



			
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


		$header = array('#', 'Address', 'SMS');
		$sizes = array(10, 20,270);
		$right =  array(0);	 
		$pdf->SetFont('Arial','',7);
	
		
			$pdf->BasicTable2($header,$dataFpdf,$sizes,$right,30);
	    

		$pdf->Output();

	?>					
				







<?php

	include('foot.php');
?>