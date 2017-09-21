<?php



include('classes/connection.php');
include('classes/computation.php');
include('fpdf/fpdf.php');


$con = new connection();




$comp = new computation($con->getConnection());




$pdf=new PDF_MC_Table();


	$date = date("Y-m-d");
	$dateTo = date("Y-m-d");




if(isset($_REQUEST['dateFormValue'])){

	$date = addslashes($_REQUEST['dateFormValue']);
	$dateTo = addslashes($_REQUEST['dateEntryTo']);

}




$daterep = date('Y-m-d', strtotime('-1 day', strtotime(preg_replace("/'/","",$date))));



$prevbalance = $comp->getBalance($daterep);

$totalbal = $comp->getBalance($dateTo);
		

		$pdf->b1 = 'MAIN';
		$pdf->b2 = "Financial Report ".$date." to ".$dateTo;
		$pdf->AddPage('P','Legal');
	

   
	  $Qry = "select * from transaction_sm 
	  			   where status=1 and date_format(date,'%Y-%m-%d') between  '$date' and '$dateTo' ";


	 $resultsum = $con->query($Qry);

	  $totalPending = 0;
	  $totalPendingCharge = 0;


	  while($rows = mysqli_fetch_array($resultsum)){


	  		$totalPending = $totalPending + $rows['amount'];
	  		$totalPendingCharge = $totalPendingCharge + $comp->getServiceCharge($rows['amount']);

	  }

	   $Qry1 = "select * from transaction_sm 
	  			   where status=2 and date_format(date_claimed,'%Y-%m-%d') between  '$date' and '$dateTo' ";


	 $resultsum1 = $con->query($Qry1);
	 
	  $totalClaim = 0;
	  $totalClaimCharge = 0;


	  while($rows1 = mysqli_fetch_array($resultsum1)){


	  		$totalClaim = $totalClaim + $rows1['amount'];
	  		$totalClaimCharge = $totalClaimCharge + $comp->getServiceCharge($rows1['amount']);

	  }
	 

   $queryStr = "call generateFinancialReport('$date','$dateTo');";





		$resultSet = $con->query($queryStr);

		$totalCredit = 0.00;
		$totalDebit = 0.00;
		$rowCtr1=0;
	

		//fpdf portion//

				$dataFpdf =  array();



		//end portion fpdf//
	$sizes = array(10, 30, 30, 30,30,30);
	$pdf->setWidths($sizes);

	$pdf->SetFont('Arial','B',10);
	$pdf->SetAligns(array('C','C','C','C','C','C'));
	$header = array('#', 'Date', 'Description', 'Ledger','Debit','Credit');
	$pdf->Row($header);
	$pdf->SetAligns(array('C','C','L','C','R','R'));
	$pdf->SetFont('Arial','',9);


	$pdf->Row(array('1',$daterep,'Cash Adjustment (Previous Balance)','3',$prevbalance,''));

	    while(	$row =  mysqli_fetch_array($resultSet) ){

	    	if($rowCtr1 > 0){

	    		 	if($rowCtr1 % 50== 0){


	    		$pdf->AddPage('P','Legal');
	    		$pdf->SetFont('Arial','B',10);
	    		$pdf->SetAligns(array('C','C','C','C','C','C'));
				$header = array('#', 'Date', 'Description', 'Ledger','Debit','Credit');
				$pdf->Row($header);
					$pdf->SetFont('Arial','',9);
				$pdf->SetAligns(array('C','C','L','C','R','R'));
				}

	    	}
	   
	    	$dataFpdf[] =  array($rowCtr1+2,$row['date'],$row['ledgername']."  ".$row['description'],$row['ledger'],$row['debit'],$row['credit']);

//$dataFpdf[] =  array('1','df','dfff','dfs','fsd','df');


				$pdf->Row(array($rowCtr1+2,$row['date'],$row['ledgername'].' ('.$row['description'].")",$row['ledger'],$row['debit'],$row['credit']));

				$totalDebit  = $totalDebit + $row['debit'];
				$totalCredit  = $totalCredit + $row['credit'];


				 $rowCtr1++;


	    }

        $pdf->Row(array($rowCtr1+2,preg_replace("/'/","",$dateTo),'Cash Adjustment (End Cash)','4','',$totalbal));

	



	


		
	  $pdf->SetFont('Arial','B',10);
	  $pdf->Row(array('','','','','P '.number_format($totalDebit + $prevbalance,2),'P '.number_format($totalCredit + $totalbal,2)));
	  $pdf->SetAligns(array('L','L','L','L','R','R'));
	  $sizes = array(60, 60, 10, 10,20,30);
	  $pdf->setWidths($sizes);

	  $pdf->Row(array('Total Pending: '.number_format($totalPending,2),'Total Claim: '.number_format($totalClaim,2),'','','',''));
	 $pdf->Row(array('Total Pending Charge: '.number_format($totalPendingCharge,2),'Total Claim Charge: '.number_format($totalClaimCharge,2),'','','',''));



	  $pdf->Row(array('BALANCE: P '.number_format($totalbal,2),'','','','',''));


	 

	
	  
	  // $pdf->Row(array($totalbal,'','','','',''));


	






	


		//$pdf->BasicTable($header,$dataFpdf,$sizes,$right,45);







		$pdf->Output();














?>