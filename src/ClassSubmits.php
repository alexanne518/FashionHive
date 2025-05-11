<?php
class Submits{
    private static $database;

    private static function InitializeDatabase(){
        global $DatabaseName;

        if(!isset(self::$database)){
            self::$database = new DatabasePDO($DatabaseName);
        }
    }

    public static function IsFavorite($User_Id, $Item_Id){
        try{
            $query = "SELECT COUNT(*) FROM favortie_list WHERE User_Id = ? AND Item_Id = ?";

            self::InitializeDatabase();
            $conection = self::$database->GetConnection();
            $stmt = $conection->prepare($query);

            $stmt->bindParam(1, $User_Id);
			$stmt->bindParam(2, $Item_Id);

            $result = $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

			return !empty($result['COUNT(*)']);

        }catch(PDOException $e){
			echo "Query Failed: ".$e->getMessage();
		}	
    }

	public static function IsLiked($User_Id, $Item_Id){
        try{
            $query = "SELECT COUNT(*) FROM likes WHERE User_Id = ? AND Item_Id = ?";

            self::InitializeDatabase();
            $conection = self::$database->GetConnection();
            $stmt = $conection->prepare($query);

            $stmt->bindParam(1, $User_Id);
			$stmt->bindParam(2, $Item_Id);

            $result = $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

			return !empty($result['COUNT(*)']);

        }catch(PDOException $e){
			echo "Query Failed: ".$e->getMessage();
		}	
    }


    public static function AddFavorite($User_Id, $Item_Id)
	{
		try{
			$query = "INSERT INTO favortie_list VALUES (?, ?)";
			
			self::InitializeDatabase();
			$connection = self::$database->GetConnection();
			$statement = $connection->prepare($query);
			$statement->bindParam(1, $User_Id);
			$statement->bindParam(2, $Item_Id);
			$statement->execute();
			
			$result = $statement->fetch(PDO::FETCH_ASSOC);

			//echo "inserting $User_Id and $Item_Id";
						
		}catch(PDOException $e){
			echo "Query Failed: ".$e->getMessage();
		}	
	}

    public static function DelFavorite($User_Id, $Item_Id)
	{
		try{
			$query = "DELETE FROM favortie_list WHERE User_ID = ? AND Item_Id = ?";
			
			self::InitializeDatabase();
			$connection = self::$database->GetConnection();
			$statement = $connection->prepare($query);
			$statement->bindParam(1, $User_Id);
			$statement->bindParam(2, $Item_Id);
			$statement->execute();
			
			$result = $statement->fetch(PDO::FETCH_ASSOC);
						
		}catch(PDOException $e){
			echo "Query Failed: ".$e->getMessage();
		}	
	}


	public static function AddLike($User_Id, $Item_Id)
	{
		try{
			$query = "INSERT INTO likes VALUES (?, ?)";
			
			self::InitializeDatabase();
			$connection = self::$database->GetConnection();
			$statement = $connection->prepare($query);
			$statement->bindParam(1, $User_Id);
			$statement->bindParam(2, $Item_Id);
			$statement->execute();
			
			$result = $statement->fetch(PDO::FETCH_ASSOC);

			//echo "inserting $User_Id and $Item_Id";
						
		}catch(PDOException $e){
			echo "Query Failed: ".$e->getMessage();
		}	
	}


	public static function DelLike($User_Id, $Item_Id)
	{
		try{
			$query = "DELETE FROM likes WHERE User_ID = ? AND Item_Id = ?";
			
			self::InitializeDatabase();
			$connection = self::$database->GetConnection();
			$statement = $connection->prepare($query);
			$statement->bindParam(1, $User_Id);
			$statement->bindParam(2, $Item_Id);
			$statement->execute();
			
			$result = $statement->fetch(PDO::FETCH_ASSOC);
						
		}catch(PDOException $e){
			echo "Query Failed: ".$e->getMessage();
		}	
	}

	
    public static function AddComment($Comment, $Item_Id, $User_Id)
	{
		try{
			$query = "INSERT INTO user_comment (Comment, Item_Id, User_Id)  VALUES (?, ?, ?)";
			
			self::InitializeDatabase();
			$connection = self::$database->GetConnection();
			$statement = $connection->prepare($query);
			$statement->bindParam(1, $Comment);
			$statement->bindParam(2, $Item_Id);
			$statement->bindParam(3, $User_Id);
			$statement->execute();
			
			$result = $statement->fetch(PDO::FETCH_ASSOC);

			//echo "inserting into comments $User_Id and $Item_Id";
						
		}catch(PDOException $e){
			echo "Query Failed: ".$e->getMessage();
		}	
	}

	public static function DisplayForm($isLiked, $Item_Id){

		//$likeCount = isset($value['like_count']) ? $value['like_count'] : 0; //getting the number if there no like count wel just put 0;
		$likeCount = Closet::GetLikeCount($Item_Id);

        echo '<form action="#" method="post">';

        echo '<div class="pretty p-icon p-toggle p-plain" style="font-size:16px;color:red;">';
        
        echo '<input type="hidden" name="LikedForm" />'; //to know if it was submitted or not
        echo '<input type="checkbox" name="Liked" '; //to add and remove, cause we are taken the vlaie from the check box
        echo ($isLiked) ? "checked" : ""; 
        echo ' onchange="this.form.submit();"  />'; //when its checked i wanna submit the form
    
        // no tliked
		echo '<div class="state p-off">';
		echo '<i class="icon fa fa-heart-o"></i>';
		echo '<label class="like-count" style="margin-left:5px;">'.$likeCount.'</label>';
		echo '</div>';
		
		// already liked
		echo '<div class="state p-on p-danger-o">';
		echo '<i class="icon fa fa-heart"></i>';
		echo '<label class="like-count" style="margin-left:5px;">'.$likeCount.'</label>';
		echo '</div>';


		//here

        echo '</div>';
        echo '</form>';
	
    }
}
?>