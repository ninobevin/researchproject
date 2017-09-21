<?php


include('head.php');












?>
<style>



</style>



<div class='container' style='padding-top:10px;'>


<div class='row'>
	<div class="page-header">
	  		<h3>User's Activation</h3>
	</div>
</div>

<div class="table-responsive">
	<table class="table table-hover">
		<thead style='background-color:#265a88'>
			<tr>
				<th>Username</th> <th>Firstname</th> <th>Lastname</th> <th>Branch</th> <th>Status</th>
			</tr>
		</thead>
		<tbody>
					<?php
				$res = $con->query("select a.*,b.branch_name as branch_name,b.branch_no as branch_no  from users a left join branch b on a.branch_no=b.branch_no;");

				while ($row = mysqli_fetch_array($res)) 
				{
					echo "<tr>";
					echo "<td>".$row['username']."</td>";
					echo "<td>".$row['firstname']."</td>";
					echo "<td>".$row['lastname']."</td>";


					echo "<td class='col-md-3'><select class='branch form-control '>";

					$branch = $con->query("select * from branch");
					
					while ($rowBranch = mysqli_fetch_array($branch))
					{
						if($row['branch_no']==$rowBranch['branch_no']){
							echo "<option value='".$row['user_id']."-".$rowBranch['branch_no']."' selected>".$rowBranch['branch_name']."</option>";
						}else{
							echo "<option value='".$row['user_id']."-".$rowBranch['branch_no']."' >".$rowBranch['branch_name']."</option>";
						}

					}
					echo "</select></td>";

					echo "<td>";
					if($row['status']){
							echo "	
								<label style='color:green;'>
									<input type='checkbox' id='checkBox' value='".$row['user_id']."' checked>
									Active
								</label>";

						}else{
							echo "
								<label style='color:red;'>
									<input type='checkbox' id='checkBox' value='".$row['user_id']."'>
									Active
								</label>";

						}
					echo "</td>";
					echo "</tr>";
					
				}

				?>
	
		</tbody>
	</table>
</div>


	
</div>



<script>

$(document).ready(function(){

	$('.branch').on('change',function(e){

		var cboValue = e.currentTarget.value;

		var arr = cboValue.split('-');

		var user_id = arr[0];
		var branch_no = arr[1];

		arr = "";

		$.post('../jsquery/updateUserBranch.php',{user_id:user_id,branch_no:branch_no},function(data){

					//alert(data);

		 			if(data)
		 			{

		 				alert("Settings Saved!");

		 			}else{

		 				alert("Connection error...Please contact the ADMIN");
		 			}
		});


	});
	
	$("input[type='checkbox']").click(function(e){


		var val = 1;

		var user_idUpdate =  e.currentTarget.value;

		 if(e.currentTarget.checked){

		 		val = 1;
		 		
		 }else{

		 		val = 0;
		 }

		 $.post('../jsquery/updateUser.php',{user_idUpdate:user_idUpdate,val:val},function(data){


		 		

		 			if(data){

		 				alert("Settings Saved!");

		 			}else{

		 				alert("Connection error...Please contact the ADMIN");
		 			}
		 		
		 });

	});



});


</script>






<?php

	include('foot.php');
?>



