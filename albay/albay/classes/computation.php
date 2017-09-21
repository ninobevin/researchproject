<?php



class computation{
	
	private	$dbcon;

public function __construct($connection){

	$this->dbcon = $connection;




}


public function getClaimServiceCharge($amount, $account){




return $totalCharge = 0.00;

	if($amount <= 500)
		return 10;

	if($amount <= 999)
		return ceil($amount * 0.02);

	//echo 'select incoming from computation_sm where account_no='.$account;

	$res = $this->dbcon->query('select incoming from computation_sm where account_no='.$account);

	$row = mysqli_fetch_array($res);

	return  ceil($amount * $row['incoming']);






return $totalCharge;




}
public function getServiceCharge($amount){



$res = $this->dbcon->query("
	SELECT * FROM agent_charge
	where   $amount <= amount order by id limit 1");

	$row = mysqli_fetch_array($res);

	return $amount2 =  $row['charge'];


}
public function getSentServiceCharge($amount, $account){

	if($amount <= 500)
		return 15;

	if($amount <= 999)
		return ceil($amount * 0.02 + $this->getTransferCharge($amount));

	//echo 'select incoming from computation_sm where account_no='.$account;

	$res = $this->dbcon->query('select outgoing from computation_sm where account_no='.$account);

	$row = mysqli_fetch_array($res);

	return  ceil($amount * $row['outgoing']+ $this->getTransferCharge($amount));

	





}
public function getTransferChargeId($amount){


	 $amount;


	$res = $this->dbcon->query("
	SELECT * FROM sm_net_charge
	where   $amount <= amount order by network_charge_no limit 1");

	$row = mysqli_fetch_array($res);

	return array($row['charge'],$row['network_charge_no']);

}




public function getBalance($date){


	//echo $this->getTransferCharge(12000);






	 $queryStart = mysqli_fetch_array($this->dbcon->query("select date as datestart 
					from fr_entry limit 1"))['datestart'];

    $sumClaimed = mysqli_fetch_array($this->dbcon->query("select sum(cash_amount) as sumtotal from transaction_sm where date_format(date_claimed,'%Y-%m-%d') 
		   		   between '$queryStart' and '$date' and status=2"))['sumtotal'];

    $sumSent = mysqli_fetch_array($this->dbcon->query("select sum(cash_amount) as sumtotal from transaction_sm where date_format(date,'%Y-%m-%d') 
		   		   between '$queryStart' and '$date' and status=3"))['sumtotal'];

	$sumDebit = mysqli_fetch_array($this->dbcon->query("select sum(a.amount) as sumtotal from fr_entry a join fr_type b on 
				a.fr_type_no = b.fr_type_no where date_format(date,'%Y-%m-%d') <= '$date' 
				and b.type = 1;"))['sumtotal'];

	$sumCredit = mysqli_fetch_array($this->dbcon->query("select sum(a.amount) as sumtotal from fr_entry a join fr_type b on 
				a.fr_type_no = b.fr_type_no where date_format(date,'%Y-%m-%d') <= '$date' 
				and b.type = 0;"))['sumtotal'];


		//return "select sum(cash_amount) as sumtotal from transaction_sm where date_format(date,'%Y-%m-%d') 
		   	//	   between '$queryStart' and '$date' and status=3";
				
	return  $sumSent + $sumDebit - $sumCredit - $sumClaimed;


}

public function getTransferCharge($amount){



	$res = $this->dbcon->query("
	SELECT * FROM network_charge
	where   $amount <= amount order by id limit 1");

	$row = mysqli_fetch_array($res);

	$amount1 =  $row['charge'];



	$res = $this->dbcon->query("
	SELECT * FROM agent_charge
	where   $amount <= amount order by id limit 1");

	$row = mysqli_fetch_array($res);

	$amount2 =  $row['charge'];

	return ($amount1 + $amount2); 



}
public function getTransferChargeService($amount){



	$res = $this->dbcon->query("
	SELECT * FROM tservice_charge
	where   $amount <= amount order by id limit 1");

	$row = mysqli_fetch_array($res);

	return $row['charge'];

}





}








?>