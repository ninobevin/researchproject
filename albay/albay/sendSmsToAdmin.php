
<?php



include('head.php');

$comp = new computation($con->getConnection());



	
	$dateTo = date("Y-m-d");




$totalbal = $comp->getBalance($dateTo);


if (isset($_REQUEST['btnSend'])) {

	$num = $_REQUEST['cpnumber'];
	$sms = $_REQUEST['body'];

	$con->query("insert into sms_stack(sms_body,mobile_no) values('$sms','$num');");


	# code...
}



?>
<style type="text/css">
	
#bodysms{

	width: 400px;
	height: 400px;
}


</style>
<div class='container'>

        <row class="col-md-12">
        	<h4>SMS REPORT</h4>
        <form method="get">

        	<div class="col-md-6">
        		
        		<?php 

        		 $query = "select b.name as name,a.description as description,a.debit as debit,a.credit as credit from tmp a join fr_type b on a.ledger=b.fr_type_no
						  group by a.ledger ";

        		$raw = $con->query($query);


        		$str = "";


        		while($row = mysqli_fetch_array($raw)){


        				$str = $str.$row['name']." (".$row['description']."): P ".number_format($row['debit']+$row['credit'],2)."  \r\n"; 


        		}

        		



        	


        		 $query = "select b.name as accountname,a.balance as bal from transaction_sm a join account_sm b on
						   a.account=b.account_no where a.account = 2 order by a.date desc limit 1;";

        		$raw = $con->query($query);

        		$row = mysqli_fetch_array($raw);


        		$str = 'Smart Money Current Balance, '.$row['accountname']." ".$row['bal']." \r\nSales:\r\n".$str;


        		 
        		$str = $str."\r\n"."Current Drawer Cash:\r\n".number_format($totalbal,2);


				//$con->query("insert into sms_stack(sms_body,mobile_no) values('$str','09394380608');");



        		 $query = "select sum(amount) as pending from transaction_sm where status = 1";

        		$raw = $con->query($query);

        		$pending = mysqli_fetch_array($raw)['pending'];


        		$str = $str."\r\n"."Pending Transaction Amount:\r\n".number_format($pending,2);


        		 ?>
        		<input type="number_format" name="cpnumber" style="margin-right: 10px;"><button type="submit" name='btnSend' class="btn btn-primary">SEND</button><br><br>
        		<input type="hidden" name="body" value="<?php echo $str; ?>">
        		<textarea id='bodysms' name=''><?php echo $str; ?></textarea>        		

        	</div>
        	</form>

        </row>









</div>


  


<script type="text/javascript">
  
$('#generate').click(function(){


     var dateEntry = $('#dateEntry').val();

     var dateEntryTo = $('#dateEntryTo').val();


     $('iframe').attr('src','frprint.php?dateEntry='+dateEntry+'&dateEntryTo='+dateEntryTo);


  });

</script>
	<!--	$con->query("insert into sms_stack(sms_body,mobile_no) values('$smsSend','$recipient');");

-->

