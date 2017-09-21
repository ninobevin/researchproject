<?php



class computation{
	
	private	$dbcon;

public function __construct($connection){

	$this->dbcon = $connection;




}


public function getClaimServiceCharge($amount, $account){


	if($amount <= 500)
		return 10;

	if($amount <= 999)
		return ceil($amount * 0.02);

	//echo 'select incoming from computation_sm where account_no='.$account;

	$res = $this->dbcon->query('select incoming from computation_sm where account_no='.$account);

	$row = mysqli_fetch_array($res);

	return  ceil($amount * $row['incoming']);

}
public function getSentServiceCharge($amount, $account){

	
	if($amount <= 500)
		return 10;

	if($amount <= 999)
		return ceil($amount * 0.02);

	//echo 'select incoming from computation_sm where account_no='.$account;

	$res = $this->dbcon->query('select outgoing from computation_sm where account_no='.$account);

	$row = mysqli_fetch_array($res);

	return  ceil($amount * $row['outgoing']);

}
public function getTransferCharge($amount){



	if($amount <= 500)
	{

		return 2.5;
	}

	$res = $this->dbcon->query("
	SELECT * FROM sm_net_charge
	where   $amount <= amount order by network_charge_no limit 1");

	$row = mysqli_fetch_array($res);

	return $row['charge'];

}






}








?>