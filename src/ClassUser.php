<?php 
include_once "Database.php";

Class User{
    private static $database;
    private $User_Id;
    private $Username;
    private $Password;
    private $Salt;

    function __construct($username, $password, $salt = null, $userId = null){
        $this->User_Id = $userId;
        $this->Username = $username;
        $this->Password = $password;
        $this->Salt = $salt;
    }

    private static function InitializeDatabase(){

		global $DatabaseName;
		
		if(!isset(self::$database)){ //self because the variable dtabase is static
			self::$database = new DatabasePDO($DatabaseName); //instead of database _name you can just wrigth 'lab_cars' 
		}
	}


    //crate salt function
    public static function CreateSalt($password){
        $passMD5 = MD5($password); //genarates a 32-character hash, example: alex = 534b44a19bf18d20b71ecc4eb77c572f
        //echo "MD5: ".$passMD5;

        $passSubStr = Substr($passMD5, 0, 22); // extracting from 0 (the start), and we end when we have 22 chars
        //echo "<br> pass with substr: ".$passSubStr;

        $beginning = array("$2a$", "$2x$", "$2y$"); //diffrent algorythems for blue fish has diffrent starts
        $index = rand(0,2); //used to randomly generate the index that will be used to chose which index we will get fron the array
        $hash = $beginning[$index];

        $numbLoops = rand(5, 10); //real blue fish goes untill 21, ima go wtih 5 to 10 becuase or else it will slow doent he log in and registration

        $salt = $hash.$numbLoops."$".$passSubStr."$"; //putting everything together to create the salt

        //echo"<br> salt: ".$salt;
        return $salt;
    }

    //get salt
    public static function GetSalt($username){ //get the slat of the user with the username
        try{
            $query = "SELECT * FROM User WHERE Username = ?";

            self::InitializeDatabase();
            $connection = self::$database->GetConnection(); //create this nd the databse file

            $stmt = $connection->prepare($query);
            $stmt->bindParam(1, $username);
            $stmt->execute();

            $obj = $stmt->fetch(PDO::FETCH_OBJ);

            return $obj->Salt; //returns the value of the salt coulumm out of all the columns we got


        }catch(PDOException $exception){
			echo "Query Failed: ".$exception->getMessage();
        }
    }

    //contains for the registration
    public static function Contains($column, $value){ //return true if the email or username already esists in the database
        try{
            $query = "SELECT User_Id FROM User WHERE $column = '$value' "; //value is a strng so we use ' ' 

            self::InitializeDatabase();
            $conneciton = self::$database->GetConnection();

            $stmt = $conneciton->prepare($query);
            $stmt->execute();

            $obj = $stmt->fetch(PDO::FETCH_OBJ);

            return ! (empty($obj->User_Id)); //will return true is it is found and flase if not

        }
        catch(PDOException $exception){
            echo "Query Failed: ".$exception->getMessage();

        }
    } 
    
    //get value, like ocntains but i actually return the value
    public static function ReadValueFrom($table, $column){
        self::InitializeDatabase();

        try {
            $query = "SELECT $column FROM $table";
            $connection = self::$database->GetConnection();
            $stmt = $connection->prepare($query);
            $stmt->execute();
            
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
                        
            return $row[$column];
            
        } catch(PDOException $exception) {
            echo "Query Failed: ".$exception->getMessage();
            return array(); // Return empty array on failure
        }
    }

    public static function GetUSerId($column, $username){
        try{
            $query = "SELECT * FROM User WHERE Username = ?";

            self::InitializeDatabase();
            $connection = self::$database->GetConnection();

            $stmt = $connection->prepare($query);
            $stmt-> bindParam(1, $username); //bind user name to put it into the select
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            return $row[$column]; //reutnr the value of the column

        }catch(PDOException $exception){

			echo "Query Failed: ".$exception->getMessage();
        }
    }
    //save new user
    public function Save(){
        try{
            $query = "INSERT INTO User (Username, Password, Salt) VALUES (?, ?, ?)";

            $salt = self::CreateSalt($this->Password);
            $encrypted_Password = crypt($this->Password, $salt); //problem with the crypt or the salt returns 0*

            self::InitializeDatabase();
            $connection = self::$database->GetConnection();
           /* echo "Attempting to save user:<br>";
            echo "Username: " . $this->Username."<br>";
            echo "Password: " . $this->Password."<br>";
            echo "encripted pass: " . $encrypted_Password."<br>";
*/
            $stmt = $connection->prepare($query);
            $stmt->bindParam(1, $this->Username);
            $stmt->bindParam(2, $encrypted_Password); //never actually save the clear password
            $stmt->bindParam(3, $salt);
            // Right before executing the query
            $stmt->execute();
            return $connection->lastInsertId(); //just so we can see u dont need to do this
            echo "<br> your account is sussessfully created";

        }catch(PDOException $exception){
            //$2x$10$202cb962ac59075b964b0u17KOeAgWKmMLNwnJdPBNvzQ3dRZ6ukK

			echo "Query Failed: ".$exception->getMessage();
        }
    }


    public static function Login($username, $password){ 
        
        try{
            $query = "SELECT * FROM User";
            $query .= " WHERE Username = ? AND Password = ? ";

            $salt = self::GetSalt($username); //encriptthe password that they put in the form and if it is the same after using the key 
            $encrypted_Password = crypt($password, $salt); //crypt() used to encript the pass using the salt 

            self::InitializeDatabase();
            $connection = self::$database->GetConnection();

            $stmt = $connection->prepare($query); //binding to avoid sql injection
            $stmt-> bindParam(1, $username);
            $stmt-> bindParam(2, $encrypted_Password);
            $stmt->execute();

            $obj = $stmt->fetch(PDO::FETCH_OBJ);

            return !(empty($obj->User_Id)); //! empty is true

        }catch(PDOException $exception){

			echo "Query Failed: ".$exception->getMessage();
        }
    }
}
