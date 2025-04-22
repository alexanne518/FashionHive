<!--where the user can search by cateogry color or by simiplar words from the description of the clothing item-->
<?php include "includes/Header.php"?>
<?php include "includes/Menu.php"?>
<?php include "src/ClassCloset.php"?>

<body>
    

    <!-- Home Page -->
    <div class="container"> <!--regulare css-->
        <h1>Welcome to the Fashion App</h1> <!--chnage this it sholdnt be welcome becuase its the search nit the home page-->
        <p>search clothing items by category, color, and many more!</p>
    </div>

    <div class="container">
    <?php 
        // Get all POST values at the start
        $selectedCategory = $_POST['category'] ?? '0';
        $selectedColor = $_POST['color'] ?? '0';
        $selectedSize = $_POST['size'] ?? '0';
        $selectedSort = $_POST['sort'] ?? '0';

    ?>


        <form id="searchForm" action="#" method="post">

        Search clothes by category:
        <select name="category" class="form-control resettable" onchange="resetOtherFields(this)">
            <option value=0> Not Selected</option>

            <?php
            $categories = Closet::ReadColumnsFrom("category", "Name");
            $count = count($categories);
            
            for($i = 1;$i <= $count; $i++){
                $selected = (isset($_POST['category']) && $_POST['category'] == $category) ? 'selected' : '';
                echo "<option value=".$categories[$i-1]."'$selected' >". $categories[$i-1]."</option>";
            }
            ?>
        </select>

        Search clothes by color:

        <select name="color" class="form-control resettable" onchange="resetOtherFields(this)">
        <option value=0> Not Selected</option>

            <?php
            $color = Closet::ReadColumnsFrom("color", "Color");
            $count = count($color);
            
            for($i = 1;$i <= $count; $i++){
                $selected = (isset($_POST['color']) && $_POST['color'] == $color) ? 'selected' : '';
                echo "<option value=".$color[$i-1]."'$selected' >". $color[$i-1]."</option>";
            }
            ?>
        </select>

        Search clothes by size:
        <select name="size" class="form-control resettable" onchange="resetOtherFields(this)"> 
        <option value=0> Not Selected</option>
            <?php
            $size = Closet::ReadColumnsFrom("size", "Size");
            $count = count($size);
            
            for($i = 1;$i <= $count; $i++){
                $selected = (isset($_POST['size']) && $_POST['size'] == $size) ? 'selected' : '';
                echo "<option value=".$size[$i-1]."'$selected' >". $size[$i-1]."</option>";
            }
            ?>
        </select>

        <input type= "radio" name="sort" value = "0"> Sort by most liked to least <!--make it so that when i ckile the others it uncliks-->
        <br><br>

        </form>
        <form>
        Search by description <input type= "text" name="searchByDescription"> <!--when i submit this it could redo everyhting-->
        <input type="submit" name="search" value="Search">
        </form>
    
        <br><br>


        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Your search logic here
            // You'll need to check which submit button was pressed
            // and process the appropriate fields
            echo "searching";
            $items = Closet::ReadClosetItems();
            Closet::DisplayOnlyImages($items);
        }

        if(isset($_POST['search'])) {
            $items = Closet::ReadClosetItems();
            Closet::DisplayOnlyImages($items);
        
        }
        ?>

    </div>

    <div id="searchResults"></div>



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

    document.querySelectorAll('.resettable').forEach(field => {
        field.addEventListener('change', function(e) {
            resetOtherFields(e.target);
            fetchSearchResults(); // Fetch new results when a field changes
        });
    });
</script>
</body>
</html>
