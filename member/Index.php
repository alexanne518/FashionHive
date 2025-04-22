<?php include "includes/Header.php"?>
<?php include "includes/Menu.php"?>
<?php include "../src/ClassCloset.php"?>

<body>
    

    <!-- Home Page -->
    <div class="container"> <!--regulare css-->
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


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
