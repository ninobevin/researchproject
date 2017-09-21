<?php




class loadConnection{


	private $con;
	private $user = "root";
	private $pass = "";
	private $host="localhost";
	private $database="mergeloadwallet";
	private $rowCount;
	


	function __construct(){

			$this->connect();

	}	

	private function connect(){
		date_default_timezone_set('Asia/Manila');

		$con_ = mysqli_connect($this->host,$this->user,$this->pass,$this->database) or die("Error connection...");

		$this->con = $con_ ;

	}


	public function query($query){

		
		mysqli_set_charset($this->con, "utf8");

		$res = mysqli_query($this->con,$query);



		$this->rowCount =  @mysqli_num_rows($res);

		return $res;


	}
	public function getConnection(){

		return $this->con;

	}

	public function getRowCount(){

		return $this->rowCount;

	}

	public function insert($query){

		//echo $query;


		$res = mysqli_query($this->con,$query);

		if($res)
			return true;
		else
			return false;

	}

	public function update($query){

		
		
		//echo $query;
		
		$res = mysqli_query($this->con,$query);

		$numAffect = mysqli_affected_rows($this->con);

		if($res && $numAffect > 0 )
			return true;
		else
			return false;

	}

		public function updateAffected($query){

		
		
		//echo $query;
		
		$res = mysqli_query($this->con,$query);

		$numAffect = mysqli_affected_rows($this->con);

		if($res && $numAffect > 0 ){
			return $numAffect;

		}elseif(!$res){

			return "Error";

		}else{
			return false;

		}
	}

}


?>

