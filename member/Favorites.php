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
    <div class="container"> <!--regulare css-->
        <h1>See All your favorited items</h1>
        <p>Click the items to see them in greater detail!</p>
    </div>

    <div class="container">
        <!--img src="images/cars/red_Car.jpg" width="400px" /-->	
        <?php 
            if(!isset($_SESSION)){
                session_start();
            }
            
            $favoriteItems = Closet::ReadFavItems($_SESSION['USER_ID']);

            /*$user = $_SESSION['USER_ID'];
            print_r($user);
            print_r($favoriteItems);
            */

            Closet::DisplayOnlyImages($favoriteItems);
        
        ?>
    </div>
</div>
 </body>
 </html>