<?php ob_start();?>
<?php include "includes/header.php"?>
<?php include "includes/menu.php"?>
<?php include "src/ClassUser.php"?>
<?php //include "src/Class_Sorting.php"?>
<?php //include "src/Class_Closet.php"?>

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
    if(!isset($_SESSION)){
        session_start();
    }

    if(isset($_POST['submit'])){
        $username = $_POST['username'];
        $password = $_POST['password'];

        if(User::Login($username, $password)){
            echo "logging in";
        }else{
            echo "error invalid username or password";
        }
    }
?>

    <div   div class="container">
        <h1>Welcome back to the Fashion Hive</h1>
        <p>Login then continue Upload clothing items, save favorites, and rate others!</p>
    </div>
    
    </div>
    <div class="container">
        <h2>Login</h2>
        <form action ="#" method="post">
                <label for="username">Username</label>
                <input type="text" class="form-control" placeholder="Enter username" name="username" required>
            
                <label for = 'password' style= 'float:left'>Password</label>
                <input type='password' class='form-control' placeholder="Enter password" name="password" required>

                <input type = 'submit' name = 'submit' value = 'Login'>
        </form>
    </div>


</body>
</html>