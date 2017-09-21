<?php



include('head.php');


		


$received = array(
				array(2,"You"),
				array(3,"have"),
				array(6,"on"),
				array(7,"your"),
				array(11,"PayMaya")
			);


?>


<style>
	
.received{

	background-color: #4CAF50;
}
.transferred{

	background-color: #4285F4;
}

</style>	


<div class='container'>




<?php 

			if(isset($_REQUEST['save'])){


				$comp = new computation($con);



				$bodyfilter = explode(" ",$_REQUEST['body']);

				$trChargeId = $comp->getTransferChargeId(str_replace(",","",str_replace('PHP','',$bodyfilter[5])));




			
				$status =  $_REQUEST['status'];
				$account = $_REQUEST['account'];

					
				$amount = str_replace(",","",str_replace('PHP','',$bodyfilter[5]));


				$trServiceCharge = $comp->getSentServiceCharge($amount,$account);
					//$con->query("insert into fr_type(name,type) values('df','2')");
				if($status == '1'){
				  $con->query("insert into transaction_sm(
 				 date, smart_money, account, ref_no, amount, status, balance, 
 				 body_sms) 
 				 values
 				 ('".substr($bodyfilter[0]." ".$bodyfilter[1],0,19)."',
 				 '".$bodyfilter[13]."',
 				 '".$account."',
 				 '".substr($bodyfilter[21],0,12)."',
 				 '".$amount."',
 				 '".$status."',
 				 '".substr(str_replace(",","",str_replace('PHP','',$bodyfilter[18])),0,-1)."',
 				 '".implode(" ",$bodyfilter)."');");
				  }else{

				  
	
				  
				  
				  
				  	 $con->query("insert into transaction_sm(
 				 date, smart_money, account, ref_no, amount, status, balance, 
 				 network_charge_no,service_charge,body_sms) 
 				 values
 				 ('".substr($bodyfilter[0]." ".$bodyfilter[1],0,19)."',
 				 '".$bodyfilter[13]."',
 				 '".$_REQUEST['account']."',
 				 '".substr($bodyfilter[21],0,12)."',
 				 '".str_replace(",","",str_replace('PHP','',$bodyfilter[5]))."',
 				 '".$status."',
 				 '".substr(str_replace(",","",str_replace('PHP','',$bodyfilter[18])),0,-1)."',
 				 '".$trChargeId[1]."',
 				 '".$trServiceCharge."',
 				 '".implode(" ",$bodyfilter)."');");
				 
				 	exit("Refreshing data: <a href='Assign.php'>Click here to continue</a>");		
 			


				  }

		 

			exit("Refreshing data: <a href='claim.php'>Click here to continue</a>");		
 			




			}

 ?>


		<div class="row">
			
			<div class="col-md-12">
								<h2>
									PayMaya Transaction only
								</h2>
			</div>


					<form method="get" action='' id='selfForm' role="form">
						

						<div class="form-group">
							<div class="col-md-2">
								<input type="text" class="form-control" id="search" name="search">
							</div>
							
							<button type="submit" class="btn btn-primary">Search</button> 
						</div>
					</form>

		</div>

		<div class="row">
			


			<?php


			
					if(isset($_REQUEST['search'])){


						$result = $con->query("select * from sms where body like '%paymaya%'and body like '%"
											.$_REQUEST['search']."%' and address='SMARTMoney' ");


						while($row = mysqli_fetch_array($result)){


								$body = explode(" ",$row['body']);

								$ret = filterNow($body,$received,$con);
								if($ret  == 'received' ||
									$ret  == 'transferred' ){

										echo "<form name=''>";
										echo "<div class='panel panel-default '>";
										echo "<input type='hidden' name='status' value='".(($ret =='received') ? '1':'3')."'>";
										echo "<input type='hidden' name='body' value='".$row['body']."'>";
										echo 		"<div class='panel-body $ret'>";
										echo			$row['body'];
										echo 		"</div>";
										echo "<button type='submit'  name='verify' >Verify</button>";
										echo "</div>";
										echo "</form>";

								}


						}


					}

			?>



		</div>


		<div class="row col-md-12">
			


			<?php


			
					if(isset($_REQUEST['verify'])){

						?>

						<div class="col-md-6 col-md-offset-3">					
						<div class="panel panel-default ">
						  <div class="panel-heading">Verify Tranasction</div>
						  <div class="panel-body">
						  		
						  		<form>
						  			<fieldset class="form-group">
						  				<label for="formGroupExampleInput">Choose an Account</label>
										<input type="hidden" name="status" value="<?php echo $_REQUEST['status'] ?>">
						  				<input type="hidden" name="body" value="<?php echo $_REQUEST['body'] ?>">
						  				
						  				<select class="form-control" name="account">
						  					<?php

						  					$dbaccount = $con->query("select * from account_sm");

						  					while($row = mysqli_fetch_array($dbaccount)){

						  							echo "<option value='".$row['account_no']."'>
						  							".$row['name']."</option>";

						  					}

						  					 
						  					 ?>


						  				</select>

						  			</fieldset>
						  			
						  			<summary>
							  			<?php

												echo $_REQUEST['body'];



							  			 ?>
						  			 </summary>
						  			 <button type="submit" name='save' class="btn btn-primary pull-right">Confirm</button>
						  		</form>

						  </div>
						</div>

						</div>
	
		

						<?php

					

						}


					

			?>



		</div>
		






</div>


<?php

 function filterNow($bodyfilter,$check,$con){




 	if(count($bodyfilter) < 22)
 		return false;

	if(isset($bodyfilter[22])){


		foreach ($check as $k) {
			
			if(!$bodyfilter[$k[0]] == $k[1]){
				return false;
			}
		}




	}
	
		$ref = substr($bodyfilter[21],0,12);
	
		$rows = $con->query("select count('tran_id')  as ctr from transaction_sm where ref_no = '".$ref."'");
		$ctr = mysqli_fetch_array($rows)['ctr'];
		if($ctr >= 1)
			return false;

	return $bodyfilter[4];


}


include('foot.php');




?>
