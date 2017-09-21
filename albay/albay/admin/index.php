<?php


include('head.php');


$con = new connection();


    $query = "SELECT sum(amount) as amount,monthname(ifnull(date_claimed,date)) as months
            FROM transaction_sm where (status=2 or status=1) and year(ifnull(date_claimed,date))=year(now()) group by months order by months desc";

    $query2 = "SELECT sum(amount) as amount,monthname(date) as months
            FROM transaction_sm where status=3 and year(date)=year(now()) group by months order by months desc";



    $res = $con->query($query);
    $res2 = $con->query($query2);

    

    $amountArr = array();
    $monthArr = array();

    $amountArr2 = array();
    $monthArr2 = array();



    while ($row = mysqli_fetch_array($res)) {
       

        array_push($amountArr, $row['amount']);

        array_push($monthArr, $row['months']);




    }

    while ($row2 = mysqli_fetch_array($res2)) {
       

        array_push($amountArr2, $row2['amount']);

        array_push($monthArr2, $row2['months']);



    }





   
   


?>

<script src="../jquery.jqplot.js"></script>
<script src="../jqplot.json2.js"></script>
<link rel="stylesheet" href="../jquery.jqplot.css">
<script type="text/javascript" src="../jqplot.barRenderer.js"></script>

<script type="text/javascript" src="../jqplot.categoryAxisRenderer.js"></script>


<script>

$(document).ready(function(){



 


        

        $.jqplot.config.enablePlugins = true;
        var s1 = <?php

         echo "[".implode(",", $amountArr)."]" ;
      

        ?>;
        var ticks =  <?php

         echo "['".implode("','", $monthArr)."']" ;


        ?>;

        var s2 = <?php

         echo "[".implode(",", $amountArr2)."]" ;
      

        ?>;
        var ticks2 =  <?php

         echo "['".implode("','", $monthArr2)."']" ;


        ?>;
         
        plot1 = $.jqplot('chart1', [s1], {
            // Only animate if we're not using excanvas (not in IE 7 or IE 8)..
            animate: !$.jqplot.use_excanvas,
            seriesDefaults:{
                renderer:$.jqplot.BarRenderer,
                pointLabels: { show: true }
                
            },
            axes: {
                xaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer,
                    ticks: ticks
                }
            },
            highlighter: { show: false }
        }); 

         plot2 = $.jqplot('chart2', [s2], {
            // Only animate if we're not using excanvas (not in IE 7 or IE 8)..
            animate: !$.jqplot.use_excanvas,
            seriesDefaults:{
                renderer:$.jqplot.BarRenderer,
                pointLabels: { show: true }
                
            },
            axes: {
                xaxis: {
                    renderer: $.jqplot.CategoryAxisRenderer,
                    ticks: ticks2
                }
            },
            highlighter: { show: false }
        });



    



     
        
    });

</script>


<style>



</style>

<div class='container'>


<?php




?>

	

	<div class="page-header">
	  <h1>Progress View</h1>
	</div>

    <div class='row'>
        <h3>Incoming Transaction</h3>
	    <div id='chart1'></div>
    </div>


    <div class='row'>
    <h3>Outgoing Transaction</h3>
    <div id='chart2'></div>
    </div>	








</div>









<?php

	include('foot.php');
?>