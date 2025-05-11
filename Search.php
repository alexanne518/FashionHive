<!--where the user can search by cateogry color or by simiplar words from the description of the clothing item-->
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

        <!-- Home Page -->
        <div class="container"> <!--regulare css-->
            <h2>Search clothing items by category, color, and many more!</h2>
        </div>

        <div class="container">
        <?php 
            // Get all POST values at the start
            $selectedCategory = $_POST['category'] ?? '0';
            $selectedColor = $_POST['color'] ?? '0';
            $selectedSize = $_POST['size'] ?? '0';
            $selectedSort = $_POST['sort'] ?? '0';
            $searchDescription = $_POST['searchByDescription'] ?? '';

        ?>


            <form id="selectForm" action="#" method="post">

            Search Clothes by Category:
            <select name="category" class="form-control resettable" onchange="resetOtherFields(this)">
                <option value="0">Not Selected</option>
                <?php
                $categories = Closet::ReadColumnsFrom("category", "Name");
                foreach ($categories as $category) {
                    $safeCategory = htmlspecialchars($category, ENT_QUOTES);
                    $selected = ($_POST['category'] ?? '') === $category ? 'selected' : '';
                    echo "<option value=\"$safeCategory\" $selected>$category</option>";
                }
                ?>
            </select>

            Search Clothes by Color:
            <select name="color" class="form-control resettable" onchange="resetOtherFields(this)">
                <option value="0">Not Selected</option>
                <?php
                $colors = Closet::ReadColumnsFrom("color", "Color");
                foreach ($colors as $color) {
                    $safeColor = htmlspecialchars($color, ENT_QUOTES);
                    $selected = (isset($_POST['color']) && $_POST['color'] == $color) ? 'selected' : '';
                    echo "<option value=\"$safeColor\" $selected>$safeColor</option>";
                }
                ?>
            </select>

            Search Clothes by Size:
            <select name="size" class="form-control resettable" onchange="resetOtherFields(this)">
                <option value="0">Not Selected</option>
                <?php
                $sizes = Closet::ReadColumnsFrom("size", "Size");
                foreach ($sizes as $size) {
                    $safeSize = htmlspecialchars($size, ENT_QUOTES);
                    $selected = (isset($_POST['size']) && $_POST['size'] == $size) ? 'selected' : '';
                    echo "<option value=\"$safeSize\" $selected>$safeSize</option>";
                }
                ?>
            </select>

            <input class="btn btn-dark" type="submit" name="selectSearch" value="Search">

            </form>
            <br><br>


            <form id="radioSort" action="#" method="post">
            Sort by most liked to least <input class="btn btn-dark" type="submit" name="Sort" value="Sort">
            </form>
            <br><br>

            </form id="descriptionSearch" action="#" method="post"> <!--still need to implement-->
            <form id="searchText" action="#" method="post">
            Search by Description: <input class="form-control" type="text" name="searchByDescription">
            <input class="btn btn-dark" type="submit" name="textSearch" value="Search">
            </form>
            <br><br>

            <?php

            if(isset($_POST['selectSearch'])){
                $selectedCategory = $_POST['category'];
                $selectedSize = $_POST['size'];
                $selectedColor = $_POST['color'];

                //echo "selectedCategory:".$selectedCategory.", selectedSize:".$selectedSize.", selectedColor".$selectedColor;

                if($selectedCategory){
                    $categoryId = Closet::GetIdFromName("category", "Name", $selectedCategory); //table, column, name
                    $items = Closet::ReadClosetItems($categoryId);
                    Closet::DisplayOnlyImages($items);
                }
                else if($selectedSize){
                    $sizeId = Closet::GetIdFromName("size", "Size", $selectedSize);
                    $items = Closet::ReadClosetItems(null, $sizeId);
                    Closet::DisplayOnlyImages($items);
                }
                else if($selectedColor){
                    $colorId = Closet::GetIdFromName("color", "Color", $selectedColor);
                    $items = Closet::ReadClosetItems(null, null, null, $colorId);
                    Closet::DisplayOnlyImages($items);
                }
            }
            
            if(isset($_POST['Sort'])){
                $selectedSort = $_POST['Sort']; // Match the case with the form field name

                $items = Closet::GetAllItemsWithLikes();

                Closet::DisplayCloset($items);

            }
            
            
            if(isset($_POST['textSearch'])){
                $searchDescription = trim($_POST['searchByDescription']);

                if(!empty($searchDescription)){
                    $item = Closet::SearchByDescription($searchDescription);
                    Closet::DisplayOnlyImages($item);
                }
                echo "<h2>No clothes found with these keywords.</h2>";

            }
            
            ?>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    // Function to reset other fields when one changes
    function resetOtherFields(changedField) {
        const fields = document.querySelectorAll('.resettable');
        fields.forEach(field => {
            if (field !== changedField) {
                if (field.tagName === 'SELECT') {
                    field.selectedIndex = 0;
                } else if (field.type === 'radio') {
                    field.checked = false;
                }
            }
        });
    }

    // Function to fetch and display results via AJAX
    async function fetchSearchResults() {
        const form = document.getElementById('searchForm');
        const formData = new FormData(form);
        
        try {
            const response = await fetch('process_search.php', {
                method: 'POST',
                body: formData
            });
            
            if (!response.ok) throw new Error('Network error');
            
            const results = await response.text();
            document.getElementById('searchResults').innerHTML = results;
        } catch (error) {
            console.error('Error fetching results:', error);
        }
    }

    // Attach event listeners to all resettable fields
    document.querySelectorAll('.resettable').forEach(field => {
        field.addEventListener('change', function(e) {
            resetOtherFields(e.target);
            fetchSearchResults(); // Fetch new results when a field changes
        });
    });
    </script>
</body>
</html>
