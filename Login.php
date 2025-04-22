<?php ob_start(); //turn on the output buffering, becuase we have a header funcition in this page?>
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

<body >

<?php
    if(!isset($_SESSION)){
        //echo "starting new session";
        session_start();
    }

    if(isset($_POST['submit'])){
        $username = $_POST['username'];
        $password = $_POST['password'];

        if(User::Login($username, $password)){
            echo "logging in";

            //once the user logs in i can add them to the session
            $userId = User::GetUSerId("User_Id" ,$username); //read the user id from where the user name is that
            print_r($userId);
            $_SESSION['USER_ID'] = User::GetUSerId("User_Id", $username);
            $_SESSION['USERNAME'] = $username;

            header('Location: member/Profile.php');
            //header('Location: member/index.php'); //idk if i want to go to the profile of the hime page

        }else{
            echo "error invalid username or password";
        }
    }
?>

    <div class="container" style="text-align: center">
        <h1 >Welcome back to the Fashion Hive</h1>
        <p>Login then continue Upload clothing items, save favorites, and rate others!</p>
    </div>
    
    </div>
    <!--div class="container">
        <h2>Login</h2>
        <form action ="#" method="post">
            <label for="username">Username</label>
            <input type="text" class="form-control" placeholder="Enter username" name="username" required>
        
            <label for = 'password' style= 'float:left'>Password</label>
            <input type='password' class='form-control' placeholder="Enter password" name="password" required>

            <input type="submit" name="submit" value="Login" class="btn btn-primary">
        </form>
    </div-->

    <div class="container d-flex justify-content-center mt-5">
        <div style="width: 28rem; 15px; ">
            <div class="card-body">
                <h2 class="card-title text-center mb-4">Login</h2>
                
                <form action="#" method="post">
                    <div class="mb-4">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" 
                            placeholder="Enter username" name="username" required>
                    </div>
                    
                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" 
                            placeholder="Enter password" name="password" required>
                    </div>
                    
                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" name="submit" 
                                class="btn btn-secondary">Login</button>
                    </div>
                </form>
                
                <!-- need to do this part -->
                <div class="mt-3 text-center">
                    <div class="form-check mb-2">
                        <label class="form-check-label" for="remember">Remember me</label>
                        <input class="form-check-input" type="checkbox" id="remember">
                    </div>
                </div>
            </div>
        </div>
    </div>


</body>
</html>