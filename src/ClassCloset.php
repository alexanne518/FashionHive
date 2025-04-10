<?php 
include_once "Database.php";
include "includes/header.php";

Class Closet{

    private static $database;

    private $Item_Id; //write the name exactly how they are in the database
    private $Item_Image;
    private $Category_Id;
    private $Size_Id;
    private $Description;

    function __construct($image, $category, $size, $description, $id = null){
        $this->Item_Id = $id;
        $this->Item_Image = $image;
        $this->Category_Id = $category;
        $this->Size_Id = $size; 
        $this->Description = $description;
    }


    private static function InitializeDatabase(){
		global $Database_Name;
		
		if(!isset(self::$database)){ //self because the variable dtabase is static
			self::$database = new DatabasePDO($Database_Name); //instead of database _name you can just wrigth 'lab_cars' 
		}
	}

    public static function ReadClosetItems($category = null, $size = null, $userId = null, $description = null){ //we can search by category size description
        $query = "SELECT * FROM closet_item";

        if($category != null){
            $query .= " WHERE Cateogry_Id = $category"; //idk how ima do this because its a FK
        }
        else if($size != null){
            $query .= " WHERE Cateogry_Id = $size"; //this one too
        }
        else if($userId != null){
            $query .= " WHERE User_Id = $userId";
        }
        else if($description != null){
            $query .= " WHERE Description LIKE '$description' ";
        }

        try{
			self::InitializeDatabase();
			$connection = self::$database->GetConnection();

			$stmt = $connection->prepare($query);
			$stmt->execute();

			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
						
			return $result;
			
		}catch(PDOException $exception){
			echo "Query Failed: ".$exception->getMessage();
		}
    }


    public static function DisplayCloset($array){
        echo "<table class='fashion-table' border='0'>";
        foreach($array as $key => $value) {
            echo "<tr>";
            echo "<td>";
            echo '<img class="fashion-image" src="./images/'.$value["Item_Image"].'" height="auto" width="200">';
            echo "</td>";
            echo "<td>";
            echo "<h3>".$value["Category_Id"]."<br>"
                .$value["User_Id"]."<br>"
                .$value["Description"]."</h3>";
            echo "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }

    //read colums to get the cateogrys for the drop down
    public static function ReadColumns(){
        self::InitializeDatabase();

        try {
            $query = "SELECT Name FROM category";
            $connection = self::$database->GetConnection();
            $stmt = $connection->prepare($query);
            $stmt->execute();
            
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $columns = array();
            
            foreach($result as $row){
                $columns[] = $row["Name"];  
            }
            
            return $columns;
            
        } catch(PDOException $exception) {
            echo "Query Failed: ".$exception->getMessage();
            return array(); // Return empty array on failure
        }
    }

    //function to get the closet of only the user
    
    
}
?>