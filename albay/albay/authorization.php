<!DOCTYPE html>
<?php
  //print_r($_SERVER);



 
    session_start();


  

    include('classes/connection.php');
    include('classes/triage.php');





    $con = new connection();

    $triage = new triage();

   

    $loginAttempt = 0;

    $replyResult = "WARNING: IP will be blocked for 3 (three) consecutive wrong login details." ;
  
   






    if(isset($_REQUEST['login-submit'])){

        
        $loginAttempt = $triage->securePage();


        $username = $_REQUEST['username'];
        $password = $_REQUEST['password'];


        

       

        $checked = $triage->checkUser($username,$password);

            

        if(!$checked){

            $replyResult = "Invalid Username and Password! You have ($loginAttempt) attempts left.";  


        }else{

          
            header('location: home.php');

        }




    }else{

         $triage->sessionEnd();
    }



?>



<html>


<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css"></link>
<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css"></link>
<link rel="stylesheet" type="text/css" href="style/style1.css"></link>
<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-theme.css.map"></link>
<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css.map"></link>
<script src="jquery.js"></script>
<script src="bootstrap/js/bootstrap.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
 <title>SMARTPadala</title>
<link rel="shortcut icon" href="../img/user_logo/Moniter2.png" >

</head>

<body>
       <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-login">
                    <div class="panel-heading">
                        <div class="row">
                            <h2 class='page-header' id="dataCenter">Merge Point Sys. Solution</h2>
                            <p color='blue' id="dataCenter">SMARTMoney online</p>
                            <h5 style='color:red;' id="dataCenter" ><?php echo $replyResult; ?></h5>
                        </div>
                        <hr>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <form id="login-form" action="" method="post" role="form" style="display: block;">
                                    <div class="form-group">
                                        <input type="text" name="username" id="username" tabindex="1" class="form-control" placeholder="Username" value="">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="password" id="password" tabindex="2" class="form-control" placeholder="Password">
                                    </div>
                                    <div class="form-group text-center">
                                        <a href='registerUser.php'>Register</a>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-sm-6 col-sm-offset-3">
                                                <input type="submit" name="login-submit" id="login-submit" tabindex="4" class="form-control btn-primary" value="Log In">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="text-center">
                                                    <a href="#" tabindex="5" class="forgot-password">Forgot Password?</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>