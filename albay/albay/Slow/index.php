<!DOCTYPE html>
<?php
  //print_r($_SERVER);



 
    session_start();


  

    include('../classes/connection.php');
    include('../classes/triage.php');





    $con = new connection();

    $triage = new triage();

   

    $loginAttempt = 0;

    $replyResult = "<font color='blue'>WARNING: IP will be blocked<br>for 3 (three) consecutive wrong login details.</font>" ;
  
   






    if(isset($_REQUEST['login-submit'])){

        
        $loginAttempt = $triage->securePage();


        $username = $_REQUEST['username'];
        $password = $_REQUEST['password'];


        

       

        $checked = $triage->checkUser($username,$password);

            

        if(!$checked){

            $replyResult = "<font color='red'>Invalid Username and Password!<br>You have ($loginAttempt) attempts left.</font>";  


        }else{

          
            header('location: home.php');

        }




    }else{

         $triage->sessionEnd();
    }



?>



<!DOCTYPE html>
<html lang="">
    <head>
      
    </head>
    <body>
       

       <div style='width:100%; margin-top:20%; text-align:center;'>
            <div style='width:300px; margin:0 auto;'>
                 <h2>Merge Point Sys. Solution</h2>
                 <p color='blue'>SMARTMoney online</p>
            </div>
       </div>


       <div>
            <form action='' method='post'>
                    
                    <table style='margin:0 auto;'>

                     
                        <tr>
                            <td style='padding-bottom:20px;' colspan="2"><?php echo @$replyResult;?></td>
                        </tr>

 
                        <tr>
                            <td>Username:</td>
                            <td><input type='text' style='text-align:center;' name='username'></td>
                        </tr>
                        <tr>
                            <td>Password:</td>
                            <td><input type='password' style='text-align:center;' name='password'></td>
                        </tr>
                        <tr>
                             <td></td>
                            <td>
                                <input type='submit' value='Login' style='width:40%;'  name='login-submit'>
                                <input type='submit' value='Cancel' style='width:40%;' name='btn-cancel'>
                            </td>
                           
                        </tr>
                

                    </table>
            </form>
        </div>




    </body>
</html>