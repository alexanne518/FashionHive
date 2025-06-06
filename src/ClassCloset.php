<?php 
include_once "Database.php";
include "includes/header.php";
include "ClassSubmits.php";


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
		global $DatabaseName;
		
		if(!isset(self::$database)){ //self because the variable dtabase is static
			self::$database = new DatabasePDO($DatabaseName); //instead of database _name you can just wrigth 'lab_cars' 
		}
	}

    public static function ReadClosetItems($category = null, $size = null, $userId = null, $colorId = null, $description = null, $itemId = null){ //we can search by category size description
        $query = "SELECT * FROM closet_item";

        if($itemId != null){
            $query .= " WHERE Item_Id = $itemId"; 
        }
        else if($category != null){
            $query .= " WHERE Category_Id = $category"; 
        }
        else if($size != null){
            $query .= " WHERE Size_Id = $size"; //this one too
        }
        else if($userId != null){
            $query .= " WHERE User_Id = $userId";
        }
        else if($colorId != null){
            $query .= " WHERE Color_Id = $colorId";
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

    public static function GetFKData($table, $columnId, $id, $targetColumn) { //migth chencge this to be private
        $query = "SELECT $targetColumn FROM $table WHERE $columnId = $id";

        try{
            self::InitializeDatabase();
			$connection = self::$database->GetConnection();

			$stmt = $connection->prepare($query);
			$stmt->execute();

            $obj = $stmt->fetch(PDO::FETCH_OBJ);
            
            return $obj->$targetColumn; //its an object so we use this way

        }catch(PDOException $exception){
			echo "Query Failed: ".$exception->getMessage();
		}
    }


    public static function getItem($item_Id){
        $query = "SELECT * FROM closet_Item WHERE Item_Id  = ?";

        try{
            self::InitializeDatabase();
            $connection = self::$database->GetConnection();

            $stmt = $connection->prepare($query);
            $stmt->bindParam(1, $item_Id);
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
			//print_r($result[0]);
						
			return $result[0];
			
		}catch(PDOException $exception){
			echo "Query Failed: ".$exception->getMessage();
		}
    }

    //try to just call themfrom the database using orderby itemId Desc based on how much they appear
    public static function OrderFromDescLikeCount($table, $column){
        try{ //getting the count andd sorting they in decreasing order
            $query = "SELECT Item_Id, COUNT(*) AS like_countFROM $table GROUP BY Item_Id"; //ORDER BY like_count DESC";
        
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

    public static function GetAllItemsWithLikes() { //i dont think i ven use this function
        try { //get likes fron count of likes, have to coonect all the table, left join keeps the rows that dont have likes
            $query = "SELECT 
                        ci.*, COUNT(l.Item_Id) as like_count, cat.Name as category_name, s.Size as size_name,col.Color as color_name
                      FROM closet_item ci
                      LEFT JOIN likes l ON ci.Item_Id = l.Item_Id
                      LEFT JOIN category cat ON ci.Category_Id = cat.Category_Id
                      LEFT JOIN size s ON ci.Size_Id = s.Size_Id
                      LEFT JOIN color col ON ci.Color_Id = col.Color_Id
                      GROUP BY ci.Item_Id
                      ORDER BY like_count DESC";
            
            self::InitializeDatabase();
            $connection = self::$database->GetConnection();
            $stmt = $connection->prepare($query);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch(PDOException $exception) {
            echo "Query Failed: ".$exception->getMessage();
            return [];
        }
    }

    public static function GetLikeCount($Item_Id){ //geting like count for only one item
        try{ 
            $query = "SELECT Item_Id, COUNT(*) AS like_count FROM likes WHERE Item_Id = $Item_Id";
            
            self::InitializeDatabase();
            $connection = self::$database->GetConnection();
            $stmt = $connection->prepare($query);
            $stmt->execute();
                

            $result = $stmt->fetch(PDO::FETCH_ASSOC); //not fetch all becuase i dont want it to give me an array in an array, just the one array,,

            if ($result) { //dont wanna return an empty array
                return (int)$result['like_count']; // Return just the count as an integer
            }
            
            return 0; //return 0 if the array is empty

        }catch(PDOException $exception){
			echo "Query Failed: ".$exception->getMessage();
		}
    }

    public static function ReadFavItems($userId){
        try{
            $query  = "SELECT * FROM favortie_list , closet_item";
			$query .=" WHERE favortie_list.User_Id = ? AND favortie_list.Item_Id = closet_item.Item_Id ";
			self::InitializeDatabase();
			$connection = self::$database->GetConnection();
			$stmt = $connection->prepare($query);
			$stmt->bindParam(1, $userId);
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
			return $result;
        }catch(PDOException $exception){
			echo "Query Failed: ".$exception->getMessage();
		}
    }

    public static function SearchByDescription($Item_Id){
        $query = "SELECT * FROM closet_Item WHERE Description LIKE '%{$Item_Id}%' ";

        try{
            self::InitializeDatabase();
            $connection = self::$database->GetConnection();

            $stmt = $connection->prepare($query);
			$stmt->execute();
			$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
			//print_r($result);
						
			return $result;
			
		}catch(PDOException $exception){
			echo "Query Failed: ".$exception->getMessage();
		}
    }



    //sortin all the chlotes from lowest to highest liked
    /* public static function SortLowestToHighest($array){
        usort($array, "self::CompareLikesDecreasing");
    }
    */
    /*TODO 
    public static function CompareLikesDecreasing($array1, $array2){
        if($array1[""] == $array2[""]){ //the values gonna be likes or count likes or somthing i have to get the amount of likes before i finish this one
            return0;
        }
        return ($array1[""] < $array2[""]) ? 1 : -1;
    }*/


    public static function DisplayCloset1($array){ //shows images and all the items descriptions
        echo "<table class='fashion-table' border='0'>";
        //print_r($array);
        foreach($array as $key => $value) {

            $categoryName = self::GetFKData("category", "Category_Id", $value["Category_Id"], "Name");
            $sizeName = self::GetFKData("size", "Size_Id", $value["Size_Id"], "Size");
            $colorName = self::GetFKData("color", "Color_Id", $value["Color_Id"], "Color");
            
            echo "<tr>";
            echo "<td>";
            echo '<img class="fashion-image" src="./images/'.$value["Item_Image"].'" height="auto" width="200">';
            echo "</td>";
            echo "<td>";
            echo "<h4>".$categoryName."<br>"
                .$sizeName."<br>"
                .$colorName."<br>"
                .$value["Description"]."</h4>";
            echo "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }

    public static function DisplayCloset($array) {
        //print_r($array);
        echo '<div class="container">'; 
        echo '<div class="row">'; // Starting the bottstrap row so i can have the side by side look
        
        foreach($array as $key => $value) {
            $categoryName = self::GetFKData("category", "Category_Id", $value["Category_Id"], "Name");
            $sizeName = self::GetFKData("size", "Size_Id", $value["Size_Id"], "Size");
            $colorName = self::GetFKData("color", "Color_Id", $value["Color_Id"], "Color");

            $likeCount = isset($value['like_count']) ? $value['like_count'] : 0; //getting the number if there no like count wel just put 0;
            $itemId = $value["Item_Id"];


            // Each item in its own column 4 per row since 3 fits into 12 4 times so we can fit that manny cars
            echo '<div class="col-md-3 mb-4">';  //can 4 at the bottem so they dont stick to each other
            echo '<a href="itemDetails.php?id=' . $itemId . '" style="text-decoration: none; color: inherit;">';
                echo '<div class="border p-3" style="border-radius: 15px;">'; //padding 3, curved edges 
                echo '<img style="border-radius: 15px;" src="./images/'.$value["Item_Image"].'" height="auto" width="100%">';
                    echo '<h5>'.$categoryName.'</h5>'; //gonna use Category as title
                        echo '<div class="mt-2">'; //margin top
                            echo '<strong>Size:</strong> '.$sizeName.'<br>';
                            echo '<strong>Color:</strong> '.$colorName.'<br>';
                            echo '<strong>Description:</strong> '.$value["Description"].'<br>';
                            echo '<strong>Likes:</strong> '.$likeCount;
                    echo '</div>';
                echo '</div>';
            echo '</div>';
        }
        echo '</div>'; // Close row
        echo '</div>'; // Close container
    }

    public static function DisplayClosetAll($item, $userId = null) {
        
        $categoryName = self::GetFKData("category", "Category_Id", $item["Category_Id"], "Name");
        $sizeName = self::GetFKData("size", "Size_Id", $item["Size_Id"], "Size");
        $colorName = self::GetFKData("color", "Color_Id", $item["Color_Id"], "Color");
        
        $likeCount = isset($item['like_count']) ? $aritemray['like_count'] : 0; //getting the number if there no like count wel just put 0;


        echo '<div class="container">'; 
        echo '<div class="row">'; // Starting the bottstrap row so i can have the side by side look
        
            echo '<div class="col-md-3 mb-6">';
            echo '<div class="border p-3" style="border-radius: 15px;">';

            echo "<div class='row'>";
            // Each item in its own column 4 per row since 3 fits into 12 4 times so we can fit that manny cars
            echo '<div class="col-sm-92">';
            echo '<img style="border-radius: 15px;" src="./images/'.$item["Item_Image"].'" height="auto" width="100%">';
            echo '</div>';

            
            echo '<div class="col-sm-1">';
            if(!empty($userId)) {
                $isLiked = Submits::IsLiked($userId, $item["Item_Id"]);
                //Submits::DisplayForm($isLiked, $likeCount);
                Submits::DisplayForm($isLiked, $item["Item_Id"]);

            }
            
            echo '</div>';

            echo '<div class="card-footer">';
             echo '<div class="row">';
            
            echo '<div class="col-sm-12">';
                echo '<h5>'.$categoryName.'</h5>';
                echo '<div class="mt-2">';
                    echo '<strong>Size:</strong> '.$sizeName.'<br>';
                    echo '<strong>Color:</strong> '.$colorName.'<br>';
                    echo '<strong>Description:</strong> '.$item["Description"].'<br>';
                echo '</div>';
            echo '</div>';
            
            echo '</div>'; 
            
            echo '</div>'; 
            echo '</div>';
            echo '</div>'; 
            echo '</div>';


            echo '</div>'; 

            echo '</div>';
    }



    public static function DisplayOnlyImages($items){ //idk if i should name it items but wtv
        
        if(!empty($items)){
            echo '<div class="fashion-container">'; // Container for grid layout
            foreach ($items as $item) {
                echo '<div class="fashion-item">';
                echo '<a href="itemDetails.php? id=' . $item['Item_Id'] . '">';
                echo '<img class="fashion-image" src="./images/'.$item["Item_Image"].'" height="auto" width="200">';
                echo '</a>';
                echo '</div>';
            }
            echo '</div>';
        }
        else{
            echo "<h2>No Items in your favorites list yet, go back to add some items you like.</h2>";
        }

    }


    public static function DisplayComments($Item_Id) {
        $comments = self::GetCommentsForItem($Item_Id);
    
        echo '<div class="container">'; 
        echo '<div class="row">';
    
        foreach($comments as $comment) {
     
            $username = self::GetFKData("user", "User_Id", $comment['User_ID'], "username");
    
            echo '<div class="col-md-12 mb-3">';
            echo '  <div class="card">';
            echo '    <div class="card-body">';
            echo '      <h5 class="card-title">' . htmlspecialchars($username) . '</h5>';
            echo '      <p class="card-text">' . htmlspecialchars($comment['Comment']) . '</p>';
            echo '    </div>';
            echo '  </div>';
            echo '</div>';
        }
    
        echo '</div>'; // Close row
        echo '</div>'; // Close container
    }

    //read colums to get the cateogrys for the drop down
    public static function ReadColumnsFrom($table, $column){
        self::InitializeDatabase();

        try {
            $query = "SELECT $column FROM $table";
            $connection = self::$database->GetConnection();
            $stmt = $connection->prepare($query);
            $stmt->execute();
            
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $columns = array();
            
            foreach($result as $row){
                $columns[] = $row[$column];  
            }
            
            return $columns;
            
        } catch(PDOException $exception) {
            echo "Query Failed: ".$exception->getMessage();
            return array(); // Return empty array on failure
        }
    }

    public static function GetCommentsForItem($Item_Id){
        self::InitializeDatabase();
        try{
            $query = "SELECT * FROM user_comment WHERE Item_Id = $Item_Id";
            $connection = self::$database->GetConnection();
            $stmt = $connection->prepare($query);
            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $result;
        }catch(PDOException $exception){
			echo "Query Failed: ".$exception->getMessage();
		}
    }

    
    
    
    public static function GetIdFromName($table, $column, $name) { //fix this function
        self::InitializeDatabase();
        try {
            // get the ID column name based on the table
            error_log("Searching for $column = '$name' in $table");

            $idColumn = '';
            switch($table) {
                case 'color':
                    $idColumn = 'Color_Id';
                    break;
                case 'size':
                    $idColumn = 'Size_Id';
                    break;
                case 'category':
                    $idColumn = 'Category_Id';
                    break;
                default:
                throw new Exception("Unknown table: $table");
            }
            $query = "SELECT $idColumn FROM $table WHERE $column = ?";
            $connection = self::$database->GetConnection();
            $stmt = $connection->prepare($query);
            $stmt->bindParam(1, $name);
            $stmt->execute();
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if(!$result || !isset($result[$idColumn])) {
                throw new Exception("No matching record found for $column = $name in $table");
            }

            return $result[$idColumn];


        } catch(PDOException $exception) {
            echo "Query Failed: ".$exception->getMessage();
            return null;
        }
    }


    
    //function to save the new item the user uploads
    public static function CreateClosetItem($imageName, $categoryId, $sizeId, $colorId, $userId, $description) {
        self::InitializeDatabase();
        try {
            $query = "INSERT INTO closet_item (Item_Image, Category_Id, Size_Id, User_Id, Color_Id, Description) 
                      VALUES (?, ?, ?, ?, ?, ?)";
            $connection = self::$database->GetConnection();
            $stmt = $connection->prepare($query);
            
            $stmt->bindParam(1, $imageName);
            $stmt->bindParam(2, $categoryId);
            $stmt->bindParam(3, $sizeId);
            $stmt->bindParam(4, $userId);
            $stmt->bindParam(5, $colorId);
            $stmt->bindParam(6, $description);
            
            return $stmt->execute();

        } catch(PDOException $exception) {
            echo "Query Failed: ".$exception->getMessage();
            return false;
        }
    }
}
?>