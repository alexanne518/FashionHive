<?php
$Host = 'localhost';
$User = 'root';
$Password = '';
$DatabaseName = 'fasionhive_db'; 

class DatabasePDO{
	
	private $connection;
	
	function __construct($dbName){ //runs when u create a new DatabasePDO object like a normal constructor
		
        $this->OpenConnection($dbName);
		if(!empty($this->connection)){
			echo "You are connected !";
		}
	}
	
	function __destruct(){ //to destroy the obj
		$this->CloseConnection();
	}
	
	public function GetConnection(){ //getter
		return $this->connection;
	}
	
	private function OpenConnection($dbName){
		global $Host, $User, $Password;
		
		try{
			$this->connection = new PDO("mysql:host=$Host; dbname=$dbName",$User, $Password ); //creating the connection
			$this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //thorw exceptions if there is an error
		
		}catch(PDOEXCEPTION $exception){
			echo "Connection Failed: ".$exception->getMessage();
		}
	}
	private function CloseConnection(){
		$this->connection = null;
	}
}
?>