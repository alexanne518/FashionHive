<?php 

    if(!isset($_SESSION)){ //cant start the session more then onc
        session_start();						//like initializing a new array for this session
    }
/*
    session_unset(); //beter cause we migth have alot of session var
    echo "<script>console.log('session destroyed');</script>";
    session_destroy();
    */
    if(!empty($SESSION['USERNAME'])) //is session var isnt empty
    {
        //destroy variables
        unset($SESSION['USERNAME']); //this is better it atually gets ri dof it
        //$SESSION['USERNAME'] = NULL;//this one only makes it null    
    }

    if(!empty($SESSION['USER_ID'])) 
    {
        unset($SESSION['USER_ID']); 
    }

    header('Location: ../index.php'); //going to home page
    exit; 
?>