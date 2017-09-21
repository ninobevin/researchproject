
<?php


  $state = "";




  if($GLOBALS['ids']){


    $ids = $GLOBALS['ids'];

    $state = "disabled";



  };

  
 ?>






      
     
           <div class='row'>
               <div class='col-md-4'>
                    <div class='form-group'>
                         <label for='customername' class='control-label'>Account Name: </label>
                    </div>
                </div>
            </div>


           <div class='row' style='margin-bottom:5%;'>
                    <div class='col-md-4'>
                      <div class='form-group'>
                            <input type='text' class='form-control'   id='customername' name='customername' required='required' placeholder='Firstname MI Lastname'  <?php echo $state; ?> autocomplete='off'>
                      </div>
                    </div>
                    <div class='col-md-2'>

                       <div class='form-group'>
                          <button type='button'  class='btn btn-primary center-block' style='width:90%;' <?php echo $state; ?>  id='btnCustomerFind'>Find</button>
                      </div>
                    </div>               
   


            </div>


 




<div id='response1'></div>
				
<script>

  $(document).ready(function(){


    
  $('#customername').typeahead({
            autoSelect: true,
            minLength: 2,
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

   
      $('#btnCustomerFind').click(function(){

            var query = $('#customername').val();
            findFunc(query);
      });


  
         
    });

    function findFunc(id){


              $.post('customerFormMenu.php',{query:id},function(data){


                    $('#response1').html(data);

              });

      }

	<?php 

      if(isset($_REQUEST['edit'])){

    echo "findFunc('".$ids."');";


         };
   ?>



</script>

