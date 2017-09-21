<?php



include('../classes/connection.php');
include('../classes/computation.php');
include('../fpdf/fpdf.php');


$con = new connection();




$comp = new computation($con->getConnection());




$pdf=new PDF_MC_Table();



if(isset($_REQUEST['dateFormValue'])){

	$date = addslashes($_REQUEST['dateFormValue']);
	$dateTo = addslashes($_REQUEST['dateTo']);

}


		$pdf->b1 = 'MAIN';
		$pdf->b2 = "Pending Transaction ".$date." to ".$dateTo;
		$pdf->AddPage('P','Legal');
	


   $queryStr = "select date,ref_no,amount from transaction_sm 
	  			   where status=1 and date_format(date,'%Y-%m-%d') between  '".$date."' and '".$dateTo."'";





		$resultSet = $con->query($queryStr);

		$totalCredit = 0.00;
		$totalDebit = 0.00;
		$rowCtr1=0;
		$total = 0;
	

		//fpdf portion//

				$dataFpdf =  array();



		//end portion fpdf//
	$sizes = array(10, 50, 30, 30);
	$pdf->setWidths($sizes);

	$pdf->SetFont('Arial','B',10);
	$pdf->SetAligns(array('C','C','C','C'));
	$header = array('#', 'Date', 'Rerefence', 'Amount');
	$pdf->Row($header);
	$pdf->SetAligns(array('C','C','C','R'));
	$pdf->SetFont('Arial','',9);
	    while(	$row =  mysqli_fetch_array($resultSet) ){

	    	if($rowCtr1 > 0){

	    		 	if($rowCtr1 % 50== 0){
	    		$pdf->AddPage('P','Legal');
	    		$pdf->SetFont('Arial','B',10);
	    		$pdf->SetAligns(array('C','C','C','C'));
				$header = array('#', 'Date', 'Rerefence', 'Amount');
				$pdf->Row($header);
					$pdf->SetFont('Arial','',9);
				$pdf->SetAligns(array('C','C','C','R'));
				}

	    	}
	   
	    	$dataFpdf[] =  array($rowCtr1+1,$row['date'],$row['ref_no'],$row['amount']);

//$dataFpdf[] =  array('1','df','dfff','dfs','fsd','df');


				$pdf->Row(array($rowCtr1+1,$row['date'],$row['ref_no'],$row['amount']));

				$total = $total + $row['amount'];


				 $rowCtr1++;


	    }


	


		
	 
	  $sizes = array(60, 10, 30, 30,30,30);
	  $pdf->setWidths($sizes);
	  $pdf->Row(array('Pending Total: P '.number_format($total,2),'','','','',''));





		$sizes = array(10, 30, 30, 30,30,30);
		$right =  array(4,5);	 
		

	


		//$pdf->BasicTable($header,$dataFpdf,$sizes,$right,45);







		$pdf->Output();














?>