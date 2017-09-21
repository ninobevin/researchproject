<?php


    //authentication area
    //redirect page if unauthorized


   require('classes\connection.php');


    //<span class="badge badge-danger" >4</span>



?>
<!DOCTYPE html>
<html lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Title Page</title>

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="style/style1.css">
        <script src="jquery.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script src="bootstrap/js/typeahead.js"></script>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>


    <body>
        
     

<?php


		$con = new connection();

		$res = $con->query("select * from announcement where status=1");
	





?>





<div class='container'>

	<legend><H1 id="dataCenter">Announcement</H1></legend>


	<div id="carousel-id" class="carousel slide" data-ride="carousel">
		<ol class="carousel-indicators">

			<?php
				$count =0;

			while ($count < $con->getRowCount()) {

						if($count < 1){

							echo "<li data-target='#carousel-id' data-slide-to='$count' class='active'></li>";

						}else{

							echo "<li data-target='#carousel-id' data-slide-to='$count' class=''></li>";
						}


				$count++;

			}


			?>

			
			
		
		</ol>
		<div class="carousel-inner">
			

		<?php
		
			$count =0;
			while ($row = mysqli_fetch_array($res)) {




				if($count == 0){
					echo "
				<div class='item active' >
				<img class='img-stretch center-block' src='img/".$row['imgLoc']."'>
				<div class='container'>
					<div class='carousel-caption'>
						<h1>".$row['title']."</h1>
						<p>".$row['description']."</p>
					</div>
				</div>
			</div>
			";

				}else{

					echo "
				<div class='item' >
				<img class='img-stretch center-block' src='img/".$row['imgLoc']."'>
				<div class='container'>
					<div class='carousel-caption'>
						<h1>".$row['title']."</h1>
						<p>".$row['description']."</p>
					</div>
				</div>
			</div>
			";


			


			}

					

			$count++;
				
			}





		?>	
			


		</div>
		<a class="left carousel-control" href="#carousel-id" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
		<a class="right carousel-control" href="#carousel-id" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
	</div>

	
</div>


<?php

include('foot.php');

?>
