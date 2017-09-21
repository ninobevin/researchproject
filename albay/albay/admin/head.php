<?php

session_start();



    //authentication area
    //redirect page if unauthorized



    require('..\classes\connection.php');

    require('..\classes\computation.php');

    require('..\classes\triage.php');

    $triage = new triage();


     $loginAttempt = $triage->securePage();
    
    if(isset($_SESSION['userz'])){


        $username = $_SESSION['userz']['username'];
        $password = $_SESSION['userz']['password'];
    

        $checked = $triage->validateUser($username,$password);

        
        if(!$_SESSION['userz']['auth_level'] == 2)
        {

            header('location: ../');
        }


        if(!$checked){

          header('location: ../authorization.php');

        }

    }else{


         header('location: ../authorization.php');

    }


    //<span class="badge badge-danger" >4</span>


    $con = new connection();



?>

<html lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SMARTPadala</title>

        <link rel="shortcut icon" href="../img/user_logo/Moniter2.png" >
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="../style/style1.css">
        <script src="../jquery.js"></script>
        <script src="../bootstrap/js/bootstrap.min.js"></script>
        <script src="../bootstrap/js/typeahead.js"></script>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>

   

<nav class="navbar navbar-default navbar-static-top" role="navigation">
    <div class="container">
        <a class="navbar-brand" href="#">ADMIN</a>
        <ul class="nav navbar-nav">
            <li>
                <a href="index.php">Home</a>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Management<b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="users.php">Users</a></li>
                                <li><a href="announcement.php">Announcement</a></li>
                                <li><a href="repairTable.php">Repair Table</a></li>
                                <li><a href="#">Event</a></li>
                                <li><a href="#">Others</a></li>
                            </ul>
            </li>
              
          
           
            <li><a href="#">Accounts</a></li>
            <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Reports <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="reportbybranch.php">Sales</a></li>
                                <li><a href="returnPay.php">Return and Payment</a></li>
                                <li><a href="chronoReport.php">History</a></li>
                                <li><a href="trackCash.php">Track</a></li>
                                <li><a href="#">Activity</a></li>
                                 <li><a href="fsms.php">SMS</a></li>
                            </ul>
            </li>
            <li class="dropdown">
            
            <li><a href="powerSearch.php">Power Search</a></li>

        </ul>
         <ul class="nav navbar-nav navbar-right">


                        <li> <img src="../img/user_logo/unknown.png" class="user-image" alt="User Image"> </li>
                        
                       <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Hi! <?php echo $_SESSION['userz']['firstname']  ?><b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="userProfile.php">View Profile</a></li>
                                <li><a href="userSettings.php">Settings</a></li>
                                <li><a href="userSecurity.php">Security</a></li>
                            </ul>
                        </li>

                        <li><a href="../authorization.php">Logout</a> </li>

                         

        </ul>
    </div>
</nav>
 


<script>


var bleep = new Audio();
bleep.src = "../sound/sms.wav";





var doIt = function() {

        //bleep.play();

}





setInterval(doIt, 3000);

</script>
         <!-- jQuery -->
        
        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->


       
    

       

 


