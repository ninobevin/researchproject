<style>

    
    #menu
    {

        margin-right:20px;
        margin-left:20px;
    }

</style>
<?php

session_start();


    require('..\classes\connection.php');

    require('..\classes\computation.php');

    require('..\classes\triage.php');

     require('..\classes\loadConnection.php');

    $triage = new triage();

    $main =  $_SESSION['userz']['main'];

    $branchName =  $_SESSION['userz']['branch_name'];
    $branchNo = $_SESSION['userz']['branch_no'];
    $userId = $_SESSION['userz']['user_id'];
            
          

     $loginAttempt = $triage->securePage();
    
    if(isset($_SESSION['userz'])){


        $username = $_SESSION['userz']['username'];
        $password = $_SESSION['userz']['password'];

    

        $checked = $triage->validateUser($username,$password);

        
        if($_SESSION['userz']['auth_level'] == 2)
        {

            header('location: ../admin/');
        }


        if(!$checked){

          header('location: index.php');

        }

    }else{


         header('location: index.php');

    }


    //<span class="badge badge-danger" >4</span>


    $con = new connection();



    $comp = new computation($con->getConnection());

     $loadConnection = new loadConnection();


    $branchName =  $_SESSION['userz']['branch_name'];
    $branchNo = $_SESSION['userz']['branch_no'];
    $userID = $_SESSION['userz']['user_id'];



    $my_branch_no  = mysqli_fetch_array($loadConnection->query("select pay_account_no from tbl_branch_code
                                             where branch_no=".$branchNo.";"))['pay_account_no'];




echo "<span id='menu'><a href='home.php'>Home</a></span>";
echo "<span id='menu'><a href='claim.php'>Claim</a></span>";

echo "<span id='menu'><a href='sentRequest.php'>Send Request</a></span>";
echo "<span id='menu'><a href='viewRequest.php'>View Send Request</a></span>";
echo "<span id='menu'><a href='viewReports.php'>Sales SMARTPadala</a></span>";

echo "<span id='menu'><a href='loadRequest.php'>Load Request</a></span>";
echo "<span id='menu'><a href='viewLoadRequest.php'>View Load Request</a></span>";
echo "<span id='menu'><a href='viewLoadReports.php'>Sales Loadwallet</a></span>";

echo "<span id='menu'><a href='index.php'>Logout <b>".$_SESSION['userz']['username']."?</b></a></span>";

?>
