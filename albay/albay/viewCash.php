
<?php



include('head.php');

 $dateEntry =  date('Y-m-d');
	
	
$comp = new computation($con->getConnection());


$cash = $currBalance = $comp->getBalance($dateEntry);




?>	
<div class="container">
  


<div style="margin-top: 30px;" class="alert alert-success" role="alert">
  <h1>Cash in your drawer  <strong><u>P <?php echo number_format($cash,2); ?></strong></u></h1>
</div>

</div>
    
<?php

include('foot.php');

?>


<script>

</script>

