<?php include "sessionTimeout.php" ?>
<?php include "includes/header.php"?>
<?php include "../src/ClassCloset.php"?>
<head>
    <style>
        body{
            background-image: url("images/backGround/longLace.jpg"); /*lave image*/
            background-repeat: repeat-y;
        }
    </style>
</head>
<script>
    function updateSearchBy(){
        document.getElementById("search_By_check").checked = true; 
    }
    
</script>

<body>
    <?php include "includes/menu.php" //check if i need to but this in the body ?>

    <?php 
    if(! isset($_SESSION)){
        session_start();
    }

    //do the session var so i can add it to save the closet item thats wgast missing

        $selectedCategory = "NONE";
        $selectedSize = "NONE";
        $selectedColor = "NONE";


        if(isset($_POST["submit"])){
            $selectedCategory = $_POST["category"]; //makes it stay if u sibmit not if u refreash
            $selectedSize = $_POST["size"];
            $selectedColor = $_POST["color"];
            $description = $_POST["description"]; // ADD THIS LINE
        }
    ?>

    <!-- Profile Page -->
    <div style="width: 80%; margin-left: auto; margin-right: 0;">
        <div class="container">
            <h2>User Profile</h2>
            <p>Add, View and manage your closet.</p>
        </div>

        <!-- Upload Page -->
        <div class="container">
            <h2>Upload Clothing Item</h2>
            <form action="#" method="post" enctype="multipart/form-data"> <!--so i can actually send the file in the form-->

            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    Category
                    <select name="category" class="form-control"> 
                    <option value="NONE"> Not selected</option>
                            <?php 
                                $categories = Closet::ReadColumnsFrom("category", "Name");

                                foreach($categories as $category) {
                                    echo '<option value="'.$category.'"';
                                    echo '>'.$category.'</option>';
                                }
                            ?>
                    </select>
                </div>

                <div class="col-md-4">
                    Size
                    <select name="size" class="form-control" required>
                        <option value="NONE"> Not Selected</option>
                        <?php
                        $sizes = Closet::ReadColumnsFrom("size", "Size");
                        foreach($sizes as $size) {
                            $safeSize = htmlspecialchars($size, ENT_QUOTES); //had to do this or else it was messing up the upload to the database
                            echo '<option value="'.$safeSize.'" '.$selected.'>'.$safeSize.'</option>';
                        }
                        ?>
                    </select>
                </div>

                
                <div class="col-md-4">
                    Color
                    <select name="color" class="form-control" required>
                        <option value="NONE">Select Color</option>
                        <?php
                        $colors = Closet::ReadColumnsFrom("color", "Color");
                        foreach($colors as $color) {
                            $SafeColor = htmlspecialchars(trim($color), ENT_QUOTES); //same thing here with the end quotes it was messing up the databse
                            echo '<option value="'.$SafeColor.'" '.$selected.'>'.$SafeColor.'</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
                <br>

                <!--will also need to add a name and description feilds before uploading so i can properally add it to the database-->
                Description:
                <input type="text" class="form-control" placeholder="Enter description" name="description" required>
                <br>

                <label class="form-label">Upload Image</label>
                <input type="file" class="form-control" name="itemImage" accept="image/*" required>
                <br>

                <input type = 'submit' name = 'submit' value = 'Upload' class="btn btn-dark">
            </form>

        </div>

        <div class="container">
            <h2>Your Closet</h2>        
            
            <?php
            if(isset($_POST["submit"])){
                //call and save the info and new item here
                if(isset($_FILES['itemImage'])){ //checks if the file way uploaded

                    $targetDir1 = "images/"; //where ima save the file, altou i should also save it in the other images folder too
                    $targetDir2 = "../images/"; //the one outside so i can also see the images logedout
                    $fileName = basename($_FILES["itemImage"]["name"]); //what the file names will originally be
                    $targetFile1 = $targetDir1 . $fileName; //the full path so images/theFileName
                    $targetFile2 = $targetDir2 . $fileName; //the full path for external folder

                    $uploadOk = 1; //an error

                    if(empty($selectedSize) || empty($selectedColor) || $selectedCategory == "NONE") {
                        //echo "<div class='error'>Please select a valid category, size, and color</div>";
                        echo "<div class='alert alert-warning'>Warning! Please select a valid category, size, and color</div>";
                        
                        $uploadOk = 1;
                    }
                    
                    $imageFileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION)); //the file extention
                    
                    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "webp" ) {
                        //echo "invalid file formate we only exceptt JPG, JPEG and PNG files";
                        echo '<div class="alert alert-warning"><strong>Warning! invalid file formate we only exceptt JPG, JPEG, PNG and webp file </strong></div>';
                        $uploadOk = 0; //not an error
                    }
                    
                    if ($uploadOk == 0) { 
                        echo "<div class='alert alert-danger'>Sorry, your file was not uploaded.</div>";
                    } else {
                        // First copy to primary location
                        if (move_uploaded_file($_FILES["itemImage"]["tmp_name"], $targetFile1)) {
                            // Then copy to secondary location
                            if (copy($targetFile1, $targetFile2)) {
                                // Get IDs not the actual names cause i have FKs in the databse
                                $categoryId = Closet::GetIdFromName("category", "Name", $selectedCategory);
                                $sizeId = Closet::GetIdFromName("size", "Size", $selectedSize);
                                $colorId = Closet::GetIdFromName("color", "Color", $selectedColor);
                                
                                // Get current user ID 
                                $userId = $_SESSION['USER_ID'];
                                
                                // Insert into database
                                $result = Closet::CreateClosetItem($fileName, $categoryId, $sizeId, $colorId, $userId, $description);
                                
                                if($result) {
                                    echo "<div class='alert alert-success'><strong>Item uploaded successfully to both locations!</strong></div>";
                                    
                                } else {
                                    echo "<div class='alert alert-danger'><strong>Error saving to database.</strong></div>";
                                }
                            } else {
                                // gonna have to delete the first upload if second fails
                                unlink($targetFile1);
                                echo "<div class='alert alert-danger'>Failed to save to secondary location.</div>";
                            }
                        } else {
                            echo "<div class='alert alert-danger'>Sorry, there was an error uploading your file.</div>";
                        }
                    }
                }
            }
            
            $userId = (string)$_SESSION["USER_ID"]; //if i put this here it refreshes after i upload but i dont have then when i first open the page
            $items = Closet::ReadClosetItems(null, null, $userId); //get getting the items so they show uo even if they didnt upload anyhting
            if(isset($_POST['submit'])){
                $items = Closet::ReadClosetItems(null, null, $userId); //geting the itmes if it was submited, idk if this is the best way but wtv
            }
            Closet::DisplayCloset($items);
            ?>
        </div>
    </div>
</body>
</html>