<?php




class triage{

	private $connection;
	private $RemoteIp;

	public function __construct(){



		$this->connection = new connection(); 
		$this->RemoteIp = $_SERVER['REMOTE_ADDR'];


	}

	public function setConnection()
	{

		return $this->connection;

	}

	public function getConnection($con)
	{

		 $this->connection = $con;

	}

	public function checkUser($user,$password)
	{





		$ip = $this->RemoteIp;


		$user = addslashes($user);
		$password = addslashes($password);

/*
		user_id, username, password, firstname, middlename, lastname,
		 address, auth_level, status, branch_no
*/


	    $userInfo = $this->connection->query("select a.firstname,a.dob,a.user_id as user_id,a.username as username,a.password as password,a.firstname as firstname,
	    									   a.middlename as middlename,a.lastname as lastname,a.loc_id as address,a.auth_level as auth_level,a.status as status, 
	    									   a.branch_no as branch_no,b.main as main,b.branch_name as branch_name  from  users  a left join branch b on a.branch_no=b.branch_no where
	    									    a.username='$user' and a.password='$password'  limit 1;");


	    $resultQuery = mysqli_fetch_array($userInfo);
	   
	    if($this->connection->getRowCount() > 0)
	    {

		    	  if($resultQuery['status'] == 0)
		    {


		    	die("Sorry your account is currently deactivated. Please contact your System ADMIN.");

		    }

	    }


	  


        if($this->connection->getRowCount() <= 0){

         	$this->connection->query("insert into secureip(ip,invalid) values ('$ip',1);");

         

        	return false;

        }else{


        	$_SESSION['userz'] = $resultQuery;

            $this->connection->insert("insert into secureip(ip,invalid,user_id) values ('$ip',0,".$_SESSION['userz']['user_id'].");");

            
            
        	return true;

        }


	}
	public function validateUser($user,$password)
	{



		$user = addslashes($user);
		$password = addslashes($password);



	    $userInfo = $this->connection->query("select * from  users where username='$user' and password='$password';");

        if($this->connection->getRowCount() <= 0){


        	return false;

        }else{

        
        	return true;

        }


	}


	public function securePage(){

		$ip = $this->RemoteIp;

  		$entryResult =  $this->connection->query("select count(entry_no) as result from secureip where ip='$ip' and invalid=1 and verified=0;");


  		$left =  (mysqli_fetch_array($entryResult)['result']);
  		$attempts =  (2 - mysqli_fetch_array($entryResult)['result']);

  		/*

        if( $left >= 3){

            die('You are blocked :(');
        }

		*/
        	// return ($attempts - $left);

        return 3;



	}

	public function sessionEnd(){


		$_SESSION = array();

// If it's desired to kill the session, also delete the session cookie.
// Note: This will destroy the session, and not just the session data!
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finally, destroy the session.
@session_destroy();

	}



}








?>