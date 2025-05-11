<?php include "includes/Header.php"?>
<?php include "includes/Menu.php"?>
<?php include "src/ClassCloset.php"?>
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
            <h2>See Items Details, login or signup to Comment, Like, Favorite!</h2>
        </div>

        <div class="container">
        <?php
        

            if(isset($_GET["id"])){ 
                $Item_Id = $_GET["id"];

            }


            $item = Closet::getItem($Item_Id);
            Closet::DisplayClosetAll($item);
        ?>
        </div>

    </div

</body>
</html>