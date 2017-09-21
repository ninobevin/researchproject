<?php



include('../classes/connection.php');
include('../classes/computation.php');
include('../fpdf/fpdf.php');


$con = new connection();




$comp = new computation($con->getConnection());




$pdf=new PDF_MC_Table();


	$date = date("Y-m-d");
	$dateTo = date("Y-m-d");




if(isset($_REQUEST['dateEntry'])){

	$date = addslashes($_REQUEST['dateEntry']);
	$dateTo = addslashes($_REQUEST['dateEntryTo']);

}


$totalbal = $comp->getBalance($dateTo);
		

		$pdf->b1 = 'MAIN';
		$pdf->b2 = "Financial Report ".$date." to ".$dateTo;
		$pdf->AddPage('P','Legal');
	


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
	   
	    	$dataFpdf[] =  array($rowCtr1+1,$row['date'],$row['ledgername']."  ".$row['description'],$row['ledger'],$row['debit'],$row['credit']);

//$dataFpdf[] =  array('1','df','dfff','dfs','fsd','df');


				$pdf->Row(array($rowCtr1+1,$row['date'],$row['ledgername'].' ('.$row['description'].")",$row['ledger'],$row['debit'],$row['credit']));

				$totalDebit  = $totalDebit + $row['debit'];
				$totalCredit  = $totalCredit + $row['credit'];


				 $rowCtr1++;


	    }


	


		
	  $pdf->SetFont('Arial','B',10);
	  $pdf->Row(array('','','','','P '.number_format($totalDebit,2),'P '.number_format($totalCredit,2)));
	  $pdf->SetAligns(array('L','C','L','C','R','R'));
	  $sizes = array(60, 10, 30, 30,30,30);
	  $pdf->setWidths($sizes);
	  $pdf->Row(array('BALANCE: P '.number_format($totalbal,2),'','','','',''));





		$sizes = array(10, 30, 30, 30,30,30);
		$right =  array(4,5);	 
		

	


		//$pdf->BasicTable($header,$dataFpdf,$sizes,$right,45);







		$pdf->Output();














?>