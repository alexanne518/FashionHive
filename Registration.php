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

    <div class="container">
        <h1>Welcome to the Fashion Hive</h1>
        <p>first Register then, Upload clothing items, save favorites, and rate others!</p>
    </div>
    
    </div>
    <div class="container">
        <h2>Register</h2>
        <form action ="#" method="post">
                <label for="username">Username</label>
                <input type="text" class="form-control" placeholder="Enter username" name="username" required>
            
                <label for = 'password' style= 'float:left'>Password</label>
                <input type='password' class='form-control' placeholder="Enter password" name="password" required>

                <input type = 'submit' name = 'submit' value = 'Register'>
        </form>
    </div>


</body>
</htm>
