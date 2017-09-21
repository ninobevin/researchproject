<?php

include('head.php');



		$res = $con->query("select * from announcement where status=1");
	





?>


 <script src="../jquery.js"></script>
 <script src="../bootstrap/js/bootstrap.min.js"></script>
 <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../style/style1.css">


<div class='container'>

	<legend><H1 id="dataCenter">Announcement</H1></legend>
	<br>
	<marquee style='color:red;'><?php 


	//echo date("Y-m-d") ." >>> ". $_SESSION['userz']['dob'];


			 $str = strtotime($_SESSION['userz']['dob']);

			

			

		if( date("m-d") ==date("m-d",$str)){

			 $str = strtotime($_SESSION['userz']['dob']);

			
			echo "<blackqoute><p>Happy ".(date("Y") - date("Y",$str))." Birthday ".$_SESSION['userz']['firstname']."!!!</p>" ;

			echo "<footer>from MergePoint System Solution. God Bless! gurang ka na :)<footer><blackqoute>";

		}

	?></marquee>




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
			<div class='item active' href='#".$row['id']."'>
				<img class='img-stretch center-block' src='../img/".$row['imgLoc']."'>
				<div class='container'>
					<div class='carousel-caption'>
						<a style='color:white;' href='#".$row['id']."'><h1>".$row['title']."</h1></a>
						<p>".$row['description']."</p>
					</div>
				</div>
			</div>
			";

				}else{

					echo "
				<div class='item' >
				<img class='img-stretch center-block' src='../img/".$row['imgLoc']."'>
				<div class='container'>
					<div class='carousel-caption'>
						<a style='color:white;' href='#".$row['id']."'><h1>".$row['title']."</h1></a>
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
<div style='margin-top:10%;'>

	<?php
$res = $con->query("select * from announcement where status=1");
	while ($row = mysqli_fetch_array($res)) {

	echo "
		<div class='panel panel-primary' id='".$row['id']."'>
			<div class='panel-heading'>
				<h3 class='panel-title'>".$row['title']."</h3>
			</div>
			<div class='panel-body'>
				".$row['description']."
			</div>
		</div>
	";


	}



	?>

</div>

</div>


