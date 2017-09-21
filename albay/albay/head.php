<?php

session_start();


    date_default_timezone_set('Asia/Manila');

    

  
    //authentication area
    //redirect page if unauthorized

    require('classes\connection.php');

    require('classes\computation.php');

    require('classes\triage.php');

    $triage = new triage();

    $main =  $_SESSION['userz']['main'];
            
          

     $loginAttempt = $triage->securePage();
    
    if(isset($_SESSION['userz'])){


        $username = $_SESSION['userz']['username'];
        $password = $_SESSION['userz']['password'];

    

        $checked = $triage->validateUser($username,$password);

        
        if($_SESSION['userz']['auth_level'] == 2)
        {

            header('location: admin/');
        }


        if(!$checked){

          header('location: authorization.php');

        }

    }else{


         header('location: authorization.php');

    }


    //<span class="badge badge-danger" >4</span>


    $con = new connection();



?>
<!DOCTYPE html>
<html lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title> 
            SMARTPadala
        </title>

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="style/style1.css">
        <script src="jquery.js"></script>
         <script src="jsquery-ui.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script src="bootstrap/js/typeahead.js"></script>
        <script type="text/javascript" src="bootstrap/js/webcam.js"></script>

        <link rel="shortcut icon" href="img/user_logo/Moniter2.png" >
    </head>
    <script>

var bleep = new Audio();
bleep.src = "sound/happy-ending.wav";


var  getNotif = function(){


    $.post('jsquery/notificationCount.php',function(data){

            $("#notifArea").html(data);


         



           

    });

    $.post('jsquery/notificationDropdown.php',function(data){


          $("#notifDropdown").html(data);

    });


   
}


getNotif();


setInterval(getNotif,3000);


</script>

<?php
    
    $sql=$con->query("select * from usersettings where user_id=".$_SESSION['userz']['user_id']."");
    $rowCount = $con->getRowCount();

    $row = mysqli_fetch_array($sql);
   
    if($rowCount==0){
        $con->update("insert usersettings(formColor, headColor, tableHeadColor, user_id) values('#c0c0c0','#1e1e1e',
            '#265a88',".$_SESSION['userz']['user_id'].")");
    }
    
echo "<style>
        #selfForm{
            background-color: ".$row['formColor'].";
            padding-left: 5%;
            padding-right: 5%;
            padding-top: 5%;
            padding-bottom: 5px;
            margin-bottom:2%;
        }
        #header{

            background-color: ".$row['headColor'].";
            margin-bottom: 1%;
        }
        #tableHead{

            background-color: ".$row['tableHeadColor'].";
            color:White;
        }

</style>";
?>

<style>





</style>

    <body>
        
        <nav class="navbar-inverse" role="navigation" id="header">
            <div class="container-default">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                        
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">SMARTPadala Online</a>
                </div>
        
                <div class="collapse navbar-collapse navbar-ex1-collapse">
                    <ul class="nav navbar-nav">
                        <li><a href="home.php">Home</a></li>
						<li><a href="eload/">Loadwallet</a></li>
                        <li ><a href="claim.php">Claim</a></li>
                        <li ><a href="paymaya.php">PayMaya</a></li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">SENT<b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                
                                <?php
                                   // echo "<li><a href='viewRequest.php'>View Request</a></li>";
									// echo "<li><a href='viewAllRequest.php'>Request History</a></li>";
                                    if($main)
                                    {

                                       // echo "<li><a href='assignToMain.php'>Assign to Main</a></li>";
                                         echo "<li><a href='Assign.php'>Assign</a></li>";
                                       // echo "<li><a href='offlineRequest.php'>Offline Request</a></li>";
                                      //  echo "<li><a href='#'>OTHERS</a></li>";
                                    }else
                                    {
                                      // echo "<li><a href='sentRequest.php'>Send Request</a></li>";
                                    }

                                ?>
                                
                                

                            </ul>
                        </li>
                       

                       <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Finance<b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="finance.php">Finance Entry</a></li>
                                <li><a href="financeReport.php">Fianancial History</a></li>
                                <li><a href="reading.php">Reading</a></li>
                               
                            </ul>
                        </li>
                    
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Report<b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="readingToday.php">Sales Report</a></li>
                                <li><a href="#">Transaction History</a></li>
                                <li><a href="pending.php">Pending Transaction</a></li>
                                <li><a href="#">Statistics</a></li>
                               
                            </ul>
                        </li>
                       
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Customer<b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="customerProfile.php">Profile</a></li>
                            </ul>
                        </li>
                       <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">SMS<span class="badge" id='notifArea'></span></a>
                            <ul class="dropdown-menu" >
                             <li><a href="smsCurrent.php">Current</a></li>
                                <li><a href="smsArchive.php">Archive</a></li>
                
                            </ul>
                        </li>

                         <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Notification <span class="badge" id='notifArea'></span></a>
                            <ul class="dropdown-menu" id='notifDropdown'>
                             
                            </ul>
                        </li>
                    </ul>
                    
                    <ul class="nav navbar-nav navbar-right">


                        <li> <img src="img/user_logo/unknown.png" class="user-image" alt="User Image"> </li>
                        
                       <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Hi! <?php echo $_SESSION['userz']['firstname']  ?><b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="userProfile.php">View Profile</a></li>
                                <li><a href="userSettings.php">Settings</a></li>
                                <li><a href="userSecurity.php">Security</a></li>
                                <li><a href="viewCash.php">My Drawer</a></li>
                            </ul>
                        </li>

                         <li><a href="authorization.php">Logout</a> </li>

                         

                    </ul>
                </div><!-- /.navbar-collapse -->
            </div>
        </nav>
    

       <div style='width:100%;' >

<h1 style='width:70%; margin:0 auto;'>
<?php    echo "<b style='color:red;'>Note:</b> Please check if you are in ". $_SESSION['userz']['branch_name'];    ?>
</h1>
       </div>

<script>

  Webcam.reset();

</script>
 




