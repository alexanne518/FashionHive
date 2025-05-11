<?php ob_start(); //turn on the output buffering, becuase we have a header funcition in this page?>
<?php include "includes/header.php"?>
<?php include "includes/menu.php"?>
<?php include "src/ClassUser.php"?>
<?php //include "src/Class_Sorting.php"?>
<?php //include "src/Class_Closet.php"?>

<head>
    <style>
        body{
            background-image: url("images/backGround/bgimg.png"); /*lave image*/
        }
    </style>
</head>

<body >

<?php

    $savedUsername = "";
    $savedPassword = "";

    if(isset($_COOKIE["RememberUsername"]) AND isset($_COOKIE["RememberPassword"])){
        $savedUsername = $_COOKIE['RememberUsername'];
        $savedPassword = $_COOKIE['RememberPassword'];
    }


    if(!isset($_SESSION)){
        //echo "starting new session";
        session_start();
    }

    
    if(isset($_POST['submit'])){
        $username = $_POST['username'];
        $password = $_POST['password'];

        $checkedRemeberMe = $_POST['rememberMe'];
        
        if(User::Login($username, $password)){
            echo "logging in";
            
            //once the user logs in i can add them to the session
            $userId = User::GetUSerId("User_Id" ,$username); //read the user id from where the user name is that
            print_r($userId);
            $_SESSION['USER_ID'] = User::GetUSerId("User_Id", $username);
            $_SESSION['USERNAME'] = $username;
            
            if(isset($checkedRemeberMe)){ //the user checkd the box to remember password and username
                $expirationLimite = time() + (60*60*24*365); //1 year

                setcookie("RememberUsername", $username, $expirationLimite); //name of cookie, value, how long before it expiriate
                setcookie("RememberPassword", $password, $expirationLimite);

            }

            header('Location: member/Profile.php');
            //header('Location: member/index.php'); //idk if i want to go to the profile of the hime page
            
        }else{
            echo "error invalid username or password";
        }
    }
    ?>

    <div class="container" style="text-align: center">
        
        <?php
        if(isset($_GET['Timeout'])){
            echo "<p>Session expired due to inactivity. <br>Please log in again!</p>";
        }?>


        <h1 >Welcome back to the Fashion Hive</h1>
        <p>Login then continue Upload clothing items, save favorites, and rate others!</p>
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

    <div class="container d-flex justify-content-center mt-2">
        <div style="width: 28rem; padding: 15px; background-color:rgb(247, 247, 247); border-radius: 15px;">
            <div class="card-body">
                <h2 class="card-title text-center mb-4">Login</h2>
                
                <form action="#" method="post">
                    <div class="mb-4">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" placeholder="Enter username" name="username" <?php echo "value='".$savedUsername."'" ?> required>
                    </div>
                    
                    <div class="mb-4">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" placeholder="Enter password" name="password" <?php echo "value='".$savedPassword."'" ?> required>
                    </div>
                    
                    <!-- need to do this part -->
                    <div class="mt-3 text-center">
                        <div class="form-check mb-2">
                            <input class="" type="checkbox" name="rememberMe" > Remember Me
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" name="submit" class="btn btn-dark">Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


</body>
</html>