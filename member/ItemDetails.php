<?php include "sessionTimeout.php" ?>
<?php include "includes/Header.php"?>
<?php include "includes/Menu.php"?>
<?php include "../src/ClassCloset.php"?>
<head>
    <style>
        body{
            background-image: url("images/backGround/longLace.jpg"); /*lave image*/
            background-repeat: repeat-y;
        }
    </style>
</head>
<body>
<div style="width: 80%; margin-left: auto; margin-right: 0;">
    <div class="container"> 
            <h2>See All Items Details,Comment, Like, Favorite!</h2>
        </div>

        <div class="container">
        <?php
            if(! isset($_SESSION)){
                session_start();
            }

            if(isset($_GET["id"])){ 
                $userId = $_SESSION["USER_ID"];
                $Item_Id = $_GET["id"];

            }

            if(isset($_POST["Like"])){ //if the like button was clicked and it hit the function onchange
                Submits::AddLike($userId, $Item_Id);
            }

            $isFavorite = Submits::isFavorite($userId, $Item_Id);
            
            if(isset($_POST["FavoriteForm"])){ 
                if($_POST["FavoriteForm"] == "Add") {
                    
                    //echo "adding to favotires";
                    Submits::AddFavorite($userId, $Item_Id);
                }
                else{
                    //echo "removing to favotires";
                    Submits::DelFavorite($userId, $Item_Id);
                    
                }
            }
            
            if(isset($_POST["CommentSubmit"])){
                $comment = $_POST["comment"];
                //echo "comment:".$comment;
                if(!empty($comment)){
                    //echo $comment." ".$userId." ".$Item_Id."<br>";
                    Submits::AddComment($comment, $Item_Id, $userId);
                }
            }

            if(isset($_POST["LikedForm"])){
                if(isset($_POST["Liked"])) {
                    Submits::AddLike($userId, $Item_Id);
                } else {
                    Submits::DelLike($userId, $Item_Id);
                }
            }
        

            $item = Closet::getItem($Item_Id);
            Closet::DisplayClosetAll($item, $userId);


            echo '<form method="post">';
            if($isFavorite) {
                echo '<button type="submit" name="FavoriteForm" value="Remove" class="btn btn-dark">Remove</button>';
            } else {
                echo '<button type="submit" name="FavoriteForm" value="Add" class="btn btn-danger">Save</button>';
            }
            echo '</form>';

            //$comments = Closet::GetCommentsForItem($Item_Id);
            //print_r($comments);

            echo "<h2>Comments</h2>";

            echo "<form method='post'>";
                echo '<div>';
                        echo '<textarea name="comment" class="form-control" rows="2" placeholder="Add your comment..." required></textarea>';
                echo '</div>';

                echo'<button type="submit" name="CommentSubmit" class="btn btn-secondary">Post Comment</button>';
            echo '</form>';


            Closet::DisplayComments($Item_Id); //TODO: wanna make the commnets nect to the card later

        ?>
        </div>
    </div>
</body>
</html>