<?php include "includes/header.php"?>
<?php include "includes/menu.php" //check if i need to but this in the body ?>
<?php include "src/ClassCloset.php"?>


<script>
function updateSearchBy(){
	document.getElementById("search_By_check").checked = true; 
}
</script>

<body>

<?php 
    $selectedCategory = "NONE";

    if(isset($_POST["submit"])){
        $selectedCategory = $_POST["category"]; //makes it stay if u sibmit not if u refreash
    }
?>

    <!-- Profile Page -->
    <div class="container">
        <h2>User Profile</h2>
        <p>Add, View and manage your closet.</p>
    </div>

    <!-- Upload Page -->
    <div class="container">
        <h2>Upload Clothing Item</h2>
        <form action="#" method="post">
            <select name="category" onChange="updateSearchBy()"> <!--ima take these value from the databse later-->
            <option value="NONE" <?php echo $selectedCategory == "NONE" ? 'selected' : ''; ?>>Not selected</option>
                    <?php 
                        $categories = Closet::ReadColumns();
                        $count = count($categories);

                        foreach($categories as $category) {
                            echo '<option value="'.$category.'"';
                            echo $selectedCategory == $category ? ' selected' : '';
                            echo '>'.$category.'</option>';
                        }
                    ?>
            </select>

<!--will also need to add a name and description feilds before uploading so i can properally add it to the database-->

            <label class="form-label">Upload Image</label>
            <input type="file" class="form-control">

            <input type = 'submit' name = 'submit' value = 'Upload'> <!--will -->
        </form>

    <p>thinking that ima show all yr own clothing items here too  and a list of the items the user has favoritied </p>
    </div>
</body>
</html>