<?php


include("connection.php");





if(isset($_REQUEST['body']) || 1){



$con = new connection();
$con2 = new connection();

//$body = addslashes($_REQUEST['body']);
$body ='1/2 04Aug 1758:Remittance of PHP3,500.00 & commission of PHP40.25 was received from 639397659923.LIBRE ang pag-claim ng iyong customer.Ref:3e7633e9c0b8';

//$date = addslashes($_REQUEST['date']);
$date = '1501840737217';
//$address = addslashes($_REQUEST['address']);
$address = 'smartmoney';

	



		


		$con->query("insert into sms(date,body,address) values('$date','$body','$address')");












		$sms =  explode(" ",$body);

		$sms_config = $con->query("select * from sms_config");

		while($r = mysqli_fetch_array($sms_config))
		{

			
			$sms_config_static = $con2->query("select * from sms_config_static where sms_config_id= ".$r['id'] );
				 $ct = 0;

				while($s = mysqli_fetch_array($sms_config_static)){
					
					


						if($sms[$s['word_index']] == $s['word'])
						{
							 $ct++;
							 
							
						}else{

							break;
						}
				}


			
				
			if($con2->getRowCount() == $ct)
			{


					

					$values = $con->query("select * from sms_config_value where sms_config_id=".$r['id']);


					$str = '';


					while($v = mysqli_fetch_array($values)){

						$strDb = $sms[$v['slot']];

						if($v['exp'])
							$strDb =explode($v['exp'],$strDb)[$v['exp_index']];

						
						if($v['stripl'])
                            $strDb = substr($strDb,$v['stripl']);

                        
                        if($v['num'] == 1)
                           $strDb =  preg_replace("/[,]/", '', $strDb);
						
						$col[] = $v['colname'];

						switch ($v['colname']) {
							case 'date':
								$strDb = date('Y-m-d h:i:s',$date/1000);
							break;
							case 'status':
								$strDb = $r['status'];
							break;
							case 'direction':
								$strDb = $r['direction'];
							break;

						}


						$val[] = $strDb;





						///here are modification and addition to column names and values



						//date conversion date('Y-m-d h:i:s',$date/1000);
						//eend////




					}
					echo "(".implode(",", $col).") values";
					echo "('".implode("','", $val)."')";
			}


		}




 	


}

		 function checkRef($ref){

					$ct = mysqli_fetch_array($this->con
					->query("select tran_id as ct from transaction_sm where ref_no='$ref'"))['ct'];

					//echo $this->con->getRowCount();
					return  $this->con->getRowCount();

		}


?>