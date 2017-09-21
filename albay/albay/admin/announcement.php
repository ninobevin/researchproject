<?php

include('head.php');


if(isset($_REQUEST['btnsave']))
{
		


		$title = mysqli_real_escape_string($con->getConnection(),$_REQUEST['Title']);
		$Description = mysqli_real_escape_string($con->getConnection(),$_REQUEST['Description']);
		$cboPicture = $_REQUEST['cboPicture'];

	//	echo "insert into announcement(title, description,imgLoc, status) values('$title','$Description','$cboPicture',1";

		 $con->insert("insert into announcement(title, description,imgLoc, status) values('$title','$Description','$cboPicture',1)");
}

if(isset($_REQUEST['btnDelete'])){

	$id = $_REQUEST['id'];
	$con->query("delete from announcement where id='$id'");


}

?>

<style>

	#navFrame
	{
		height: 40%;
	}
	

</style>


	<div class='container' style='margin-top:2%;'>

		<form action="" method="POST" role="form">

		  	<div class="form-group">
				<legend>Announcement Form</legend>
			</div>

			<div class='row'>
	    		<div class="col-md-4">
			        <div class="form-group">
			              <label for="inputType" class="control-label">Title :</label>
			        </div>
	    		</div>
			</div>
			<div class='row'>
	    		<div class="col-md-4">
			        <div class="form-group">
			              <input type="text" name="Title" id="Title" class="form-control" value="" required="required">
			        </div>
	    		</div>
			</div>
			<div class='row'>
	    		<div class="col-md-4">
			        <div class="form-group">
			              <label for="inputType" class="control-label">Description :</label>
			        </div>
	    		</div>
			</div>
			<div class='row'>
	    		<div class="col-md-4">
			        <div class="form-group">
			              <textarea name="Description" id="Description" class="form-control" rows="3" required="required"></textarea>
			        </div>
	    		</div>
			</div>
			<div class='row'>
	    		<div class="col-md-4">
			        <div class="form-group">
			              <label for="cboPicture" class="control-label">Background Picture :</label>
			        </div>
	    		</div>
			</div>
			<div class='row'>
	    		<div class="col-md-4">
			        <div class="form-group">
			              <select class='form-control' onchange='preview()' id='cboPicture' name='cboPicture'>

			              	<?php

			              	 $arr= scandir("../img");
			              	
			              	$count = 0;
			              	foreach ($arr as $key => $value) {
			              		
			              		echo "<option value='$value'>$value</option>";

			              	}

			              	
			              	?>
			              </select>
			        </div>
	    		</div>
	    		<div class="col-md-4">
			       <div id='imgDiv'></div>
	    		</div>
			</div>


			<div class='row'>
	    		<div class="col-md-4">
			        <div class="form-group">
			              <button type="submit" name="btnsave" id="btnsave" class="btn btn-primary">POST</button>
			        </div>
	    		</div>
			</div>


			</form>


			<h3>Preview</h3>
			<iframe id='navFrame'  src='../previewAnnouncement.php'  class='row col-md-12'></iframe>
	


		<div class='row col-md-12'>
			<div class="table-responsive">
				<table class="table table-hover">
					<thead>
						<tr>
							<th>#</th><th>Title</th><th >Description</th><th>Activate</th><th></th>
						</tr>
					</thead>
					<tbody>
						<?php


								$sql=$con->query("select * from announcement");
								$ctr = 1;
								while ($row=mysqli_fetch_array($sql)) 
								{
									$isActive = $row['status'];

									echo "<form action=''><tr>
											<input type='hidden' name='id' value='".$row['id']."' >
											<td>$ctr</td><td>".$row['title']."</td><td>".$row['description']."</td>";
										if($isActive==1){
											echo "<td><input value='".$row['id']."' type='checkbox' id='checkbox' class='checkbox' checked></td>";
										}
										else{
											echo "<td><input value='".$row['id']."' type='checkbox' id='checkbox' class='checkbox'></td>";
										}
										echo "<td><button  type='submit' name='btnDelete' id='check' class='btn btn-danger'>Delete</button></td>";

									echo "</tr></form>";

								$ctr+=1;

								}
						?>
						</div>
						
					</tbody>
				</table>
			</div>
		</div>

	</div>

<script>

	$(document).ready(function() {

		$("input[type='checkbox']").click(function(e){

		var val = 1;
		var id =  e.currentTarget.value;

		 if(e.currentTarget.checked){
		 		val = 1; 		
		 }else{
	 		val = 0;
		 }
	//	 alert(id);


		 $.post('../jsquery/updateAnnouncement.php',{id:id,val:val},function(data){

		 			if(data){

		 				alert("Settings Saved!");

		 			}
		 		
		 });

	});


	
});

	function preview(){


		var loc = $("#cboPicture").val();

		$("#imgDiv").html("<img src='../img/"+loc+"' style='height:20%';width:20%;>");


	}


</script>



<?php

	include('foot.php');
?>

