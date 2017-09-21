
<?php ?>

 
<style>
    

  
</style>

<div class='row'>
    <div class="col-md-4">
        <div class="form-group">
              <label for="inputType" class="control-label">Customer Name: </label>
        </div>
    </div>
</div>  


 <div class='row'>

          <div class="col-md-4">
            <div class="form-group">
              <input type="text" class="form-control"   id="customername" name="customername" required='required' placeholder="Firstname MI Lastname" autocomplete="off">
            </div>
          </div>
          <div class="col-md-2">
             <div class="form-group">
                <button type="button"  class="btn btn-primary center-block" style='width:90%;'  id='btnCustomerFind'>Find</button>
            </div>
          </div>

          <div class="col-md-2">
            <div class="form-group">       
              <button type="button" class="btn btn-primary center-block" data-toggle="modal" data-target="#myModal" style='width:90%;'>New Customer</button>
            </div>
          </div>
     
  </div>
  <?php

      if($main){
      
      echo "<div class='row'>
                    <div class='col-md-4'>
                        <div class='form-group'>
                            <input type='text' class='form-control'   id='cust_id_off' name='cust_id_off' placeholder='Offline Customer ID' autocomplete='off'>
                        </div>
                    </div>
            </div>";




      }



 ?>



<div id='response1'></div>
				
<script>

	$(document).ready(function(){


		
	$('#customername').typeahead({
		        autoSelect: true,
		        minLegth: 2,
		        delay: 400,

        source: function (query, process) {
            $.ajax({
                url: 'jsquery/autoCompleteCustomer.php',
                data: {query: query},
                dataType: 'json'
            })
                .done(function(response) {
                    //console.log(response);

                   
                    return process(response);
                });
        }
    });


		$("#btnCustomerFind").click(function(){

			var query = $("#customername").val();
      
			$.post('jsquery/customerDetailsSent.php',{query:query},function(data){


					$("#response1").html(data);

			});


		});
			


	});

</script>