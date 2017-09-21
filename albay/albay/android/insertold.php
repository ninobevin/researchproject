<?php


include("connection.php");





if(isset($_REQUEST['body']) || 1){



$con = new connection();

$body = $_REQUEST['body'];
//$body ='01Aug 1227:Remittance of PHP500.00 & fee of PHP18.50 was deducted from your account.Avail bal:PHP246,879.56.Ref:a9e2382c7483';

$date = $_REQUEST['date'];
//$date = '1501553664312';
$address = $_REQUEST['address'];
//$address = 'smartmoney';



	





	$con->query("insert into sms(date,body,address) values('$date','$body','$address')");


	 $fil = new FilterMsg();


	 if( $fil->filter1($body,$date,$address) )
	 		exit();
	 	
	  if($fil->filter2($body,$date,$address))
	  		exit();
	  if($fil->filter3($body,$date,$address))
	  		exit();






/*

tran_id int(45) AI PK 
date datetime 
smart_money varchar(45) 
account int(45) 
ref_no varchar(100) 
amount decimal(20,2) 
status int(45) 
balance decimal(20,2) 
cash_amount decimal(20,2) 
network_charge_no int(45) 
computation_no int(45) 
date_claimed datetime 
service_charge decimal(20,2) 
cust_id int(45) 
body_sms varchar(300) 
branch_no int(10) UN 
user_id int(10) UN 
off_cust_id varchar(45)




*/




	
	//$con->query("insert into transaction_sm()")



//echo 'sfdkjshdfjhasdjfhkja dfhjahsdfj hasjdh f kjash';






}



class FilterMsg 
{
	

    public $con;

    public function __construct(){
    	$this->con = new connection();
    }

    public function filter1($raw_body,$date,$address){

		$body = explode(" ",$raw_body);

		    $atr = [
		    			//regular incomming
						[
								[3,'of'],
								[5,	'&'],
								[6,	'commission'],
								[7,	'of'],
								[9,	'was'],
								[10, 'received'],
								['status','1']
						]
				    ];

	//filter before insert
				foreach ($atr[0] as $key => $value) {				
						if($value[0] == 'status'){


							$date = $date;
							$ref_no = explode(':',$body[17])[1];
							$amount = str_replace(',','',str_replace("PHP",'',$body[4]));
							$status = $value[1];

							if($this->checkRef($ref_no))
								return 0;
							$this->con->query("

									insert into transaction_sm(
										date,
										ref_no,
										amount,
										status,
										account,
										smart_money,
										balance,
										cash_amount,
										network_charge_no,
										service_charge,
										body_sms

									)values(

										from_unixtime(".$date."/1000),
										'".$ref_no."',
										'".$amount."',
										'".$status."',
										'1',
										'SMARTMONEY',
										'0.00',
										'0.00',
										'102',
										'0.00',
										'".$raw_body."'


									)

									   ");

							return 1;

						}
						if($body[$value[0]] == $value[1]){
						

						}else{

							return 0;
						}		

				}



		}
		public function filter2($raw_body,$date,$address){

		$body = explode(" ",$raw_body);

		    $atr = [
		    			//regular incomming
						[
								[2,'of'],
								[4,	'&'],
								[5,	'commission'],
								[6,	'of'],
								[8,	'was'],
								[9, 'added'],
								['status','1']
						]
				    ];

	//filter before insert
				foreach ($atr[0] as $key => $value) {				
						if($value[0] == 'status'){


							$date = $date;
							$ref_no = explode(':',$body[13])[2];
							$amount = str_replace(',','',str_replace("PHP",'',$body[3]));
							$status = $value[1];


							if($this->checkRef($ref_no))
								return 0;

							$this->con->query("

									insert into transaction_sm(
										date,
										ref_no,
										amount,
										status,
										account,
										smart_money,
										balance,
										cash_amount,
										network_charge_no,
										service_charge,
										body_sms

									)values(

										from_unixtime(".$date."/1000),
										'".$ref_no."',
										'".$amount."',
										'".$status."',
										'1',
										'SMARTMONEY',
										'0.00',
										'0.00',
										'102',
										'0.00',
										'".$raw_body."'


									)

									   ");

							return 1;

						}
						if($body[$value[0]] == $value[1]){
						

						}else{

							return 0;
						}		

				}

			



		}
		public function filter3($raw_body,$date,$address){



//$body ='01Aug 1227:Remittance of PHP500.00 & fee of PHP18.50 was deducted from your account.Avail bal:PHP246,879.56.Ref:a9e2382c7483';

		$body = explode(" ",$raw_body);

		    $atr = [
		    			//regular incomming
						[
								[2,'of'],
								[4,	'&'],
								[5,	'fee'],
								[6,	'of'],
								[8,	'was'],
								[9, 'deducted'],
								['status','3']
						]
				    ];

	//filter before insert

				foreach ($atr[0] as $key => $value) {	

				    echo ">>>>>";			
						if($value[0] == 'status'){


							$date = $date;
							$service = str_replace("PHP",'',str_replace(",",'',$body[7]));
							$ref_no = explode(':',$body[13])[2];
						    $bal =  str_replace("PHP",'',str_replace(",",'',str_replace(".Ref",'',explode(':',$body[13])[1])));
							$amount = str_replace(',','',str_replace("PHP",'',$body[3]));
							$status = $value[1];


							if($this->checkRef($ref_no))
								return 0;

							
							$this->con->query("

									insert into transaction_sm(
										date,
										ref_no,
										amount,
										status,
										account,
										smart_money,
										balance,
										cash_amount,
										network_charge_no,
										service_charge,
										body_sms

									)values(

										from_unixtime(".$date."/1000),
										'".$ref_no."',
										'".$amount."',
										'".$status."',
										'1',
										'SMARTMONEY',
										'$bal',
										'0.00',
										'102',
										'$service',
										'".$raw_body."'


									)

									   ");
									


							return 1;

						}
						if($body[$value[0]] == $value[1]){
								

						}else{

							return 0;
						}		

				}

			



		}
		public function checkRef($ref){

					$ct = mysqli_fetch_array($this->con
					->query("select tran_id as ct from transaction_sm where ref_no='$ref'"))['ct'];

					//echo $this->con->getRowCount();
					return  $this->con->getRowCount();

		}





}

?>