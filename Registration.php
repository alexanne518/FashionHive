<?php include "includes/header.php"?>
<?php include "includes/menu.php"?>
<?php include "src/ClassUser.php"?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fashion App</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <style>
        body{
            background-image: url("images/backGround/bgimg.png"); /*lace image*/
        }
    </style>
</head>
<body>
    <?php 
        if (isset($_POST['submit'])){

            $username = $_POST['username'];
            $password = $_POST['password'];
            echo $password;

            //username cant be used by somone else
            if(User::Contains('Username', $username)){
                echo "<br> error: this username already exists";
            }

            if(!User::Contains('Username', $username)){
                $user = new User($username, $password);
                $user->Save(); //read the values and insert them into database
                
            }
        }
   ?>

    <div class="container" style="text-align: center">
        <h1>Welcome to the Fashion Hive</h1>
        <p>first Register then, Upload clothing items, save favorites, and rate others!</p>
    </div>
    
    </div>
    <div class="container d-flex justify-content-center">
     <div style="width: 28rem; padding: 15px; background-color:rgb(247, 247, 247); border-radius: 15px;">

            <div class="card-body">
                <h2 class="card-title text-center mb-4">Register</h2>

                <form action ="#" method="post">
                    <div class="mb-4"> <!--mergin bottom 4-->
                        <label for="username">Username</label>
                        <input type="text" class="form-control" placeholder="Enter username" name="username" required>
                    </div>
                    <div class="mb-4">
                        <label for = 'password' style= 'float:left'>Password</label>
                        <input type='password' class='form-control' placeholder="Enter password" name="password" required>
                    </div>
                    <div class="d-grid mt-4">
                            <button type="submit" name="submit" class="btn btn-dark">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


</body>
</htm>
