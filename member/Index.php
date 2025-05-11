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
        <h1>Welcome to the Fashion App</h1>
        <p>Upload clothing items, save favorites, and rate others!</p>
    </div>

    <div class="container">
    <h2>All Closet Items</h2> <!--sytle this to make it look good-->
    <?php 
    
        //i want to print the array here
        // Get all closet items (you can add filters here if needed)
        $items = Closet::ReadClosetItems();
        Closet::DisplayOnlyImages($items);
        
    ?>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
