<?php include "includes/header.php"?>
<?php include "includes/menu.php"?>
<?php include "src/ClassCloset.php"?>

<body>
    

    <!-- Home Page -->
    <div class="container"> <!--regulare css-->
        <h1>Welcome to the Fashion App</h1>
        <p>Upload clothing items, save favorites, and rate others!</p>
    </div>

    <div class="container">
        <p>all closet items</p>
        <?php 
            //i want to print the array here
            // Get all closet items (you can add filters here if needed)
            $items = Closet::ReadClosetItems();
            Closet::DisplayCloset($items);
            /*
            if (!empty($items)): ?>
                <div class="row">
                    <?php foreach ($items as $item): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <img src="<?php echo htmlspecialchars($item['image_path']); ?>" class="card-img-top" alt="Clothing item">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($item['description']); ?></h5>
                                    <p class="card-text">
                                        Size: <?php echo htmlspecialchars($item['size']); ?><br>
                                        Category: <?php echo htmlspecialchars($item['Category_Id']); ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
        <?php else: ?>
            <p>No items found in the closet.</p>
        <?php endif; ?>*/
    ?>
    </div>


    <!-- create Outfits idk if ima do that-->
    <!-- <div class="container mt-4">
        <h2>Create an Outfit</h2>
        <p>Select clothing items to build your outfit.</p>
    </div> -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
