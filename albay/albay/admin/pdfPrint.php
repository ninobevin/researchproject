<?php



include('../classes/connection.php');
include('../fpdf/fpdf.php');


$con = new connection();

$pdf = new fpdf();


	$date = date("Y-m-d");
	$dateTo = date("Y-m-d");



	

 	




if(isset($_REQUEST['dateFormValue'])){

	$date = addslashes($_REQUEST['dateFormValue']);
	$dateTo = addslashes($_REQUEST['dateTo']);

}



		$branch_no =$_REQUEST['branch_no'];


	$query = "select branch_name from branch where branch_no=$branch_no";
	
	$res = mysqli_fetch_array($con->query($query));

		$pdf->b1 = $res['branch_name'];
		$pdf->b2 = "Claimed ".$date." To ".$dateTo;
		$pdf->AddPage('P','Legal');
	


	  $queryStr = "select a.date as date,a.date_claimed as date_claimed,a.ref_no as ref_no,a.amount as amount,a.cash_amount as cash_amount,b.username as user
	  			   from view_claimed_sm a join users b on a.user_id=b.user_id where date_format(a.date_claimed,'%Y-%m-%d') between '$date' and '$dateTo' and a.branch_no=$branch_no;";





		$resultSet = $con->query($queryStr);

		$totalClaimed = 0.00;
		$totalClaimedP = 0.00;
		$rowCtr1=0;
		$C_pamount=0;
		$C_amount=0;


		//fpdf portion//

				$dataFpdf =  array();



		//end portion fpdf//

	    while(	$row =  @mysqli_fetch_array($resultSet) ){


	    	$dataFpdf[] =  array($rowCtr1+1,$row['date'],$row['date_claimed'],$row['ref_no'],$row['amount'],$row['cash_amount'],$row['user']);;


				 $totalClaimed += $row['cash_amount'];
				 $totalClaimedP += $row['amount'];
				 $C_pamount+= $totalClaimedP;
				 $C_amount+=$totalClaimed;
				 $rowCtr1++;


				
	    }
	  




		$header = array('#', 'Date', 'Date Claimed', 'Reference','PAmount','Cash','User');
		$sizes = array(10, 30, 30, 30,30,30,30);
		$right =  array(4,5);	 
		$pdf->SetFont('Arial','',7);
	
		$pdf->BasicTable($header,$dataFpdf,$sizes,$right,45);








	  $queryStr = "select a.date as date,a.ref_no as ref_no,a.amount as amount,a.cash_amount as cash_amount
	  			   from view_sent2 a where date_format(a.date,'%Y-%m-%d') between '$date' and '$dateTo' and a.branch_no=$branch_no;";



		$resultSet = $con->query($queryStr);

		$totalSent = 0.00;
		$totalSentP = 0.00;
		$rowCtr2=0;
		$S_pamount=0.00;
		$S_amount=0.00;

		$dataFpdf =  array();

	    while(	$row =  @mysqli_fetch_array($resultSet) ){


	    	$dataFpdf[] =  array($rowCtr2+1,$row['date'],$row['ref_no'],$row['amount'],$row['cash_amount']);;

	    	
				$totalSent += $row['cash_amount'];
			$totalSentP += $row['amount'];

			$S_pamount+=$totalSentP;
		$S_amount+=$totalSent;
		$rowCtr2++;

	    }


	   	$pdf->b1 = $res['branch_name'];
		$pdf->b2 = "Sent ".$date." To ".$dateTo;
		$pdf->AddPage('P','Legal');

		$header = array('#', 'Date', 'Reference','PAmount','Cash');
		$sizes = array(10, 30, 30, 30,30);
		$right =  array(3,4);	 
		$pdf->SetFont('Arial','',8);
	
	$pdf->BasicTable($header,$dataFpdf,$sizes,$right,40);


		//$pdf->SetY(-40);

	
		//$pdf->AddPage();

		$pdf->Ln();

		$dataFpdf = array(array(0=>$rowCtr1,1 =>'Claimed', 2=>number_format($totalClaimedP,2),3=> number_format($totalClaimed,2) ) ,array(0=>$rowCtr2,1 =>'Sent', 2=>number_format($totalSentP,2),3=>number_format($totalSent,2) ) );
		$header = array('#', 'Type', 'PAmount','Cash');
		$sizes = array(10, 30, 30, 30,30);
		$right =  array(3,4);	 
		$pdf->SetFont('Arial','',8);
	
		$pdf->BasicTable($header,$dataFpdf,$sizes,$right,40);

 		








		//print_r($dataFpdf);

		$pdf->Output();














?>