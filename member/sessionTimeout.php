<?php
    if(!isset($_SESSION)){
        session_start();
    }

    $timeoutDuration = 60*15; //15 min

    if(isset($_SESSION["LastActiveMember"])){
        $inactivityDuration = time() - $_SESSION["LastActiveMember"];

        if($inactivityDuration > $timeoutDuration){
            session_unset();
            session_destroy();

            header("Location: ../Login.php?Timeout=true");
            exit;
        }
    }

    $_SESSION['LastActiveMember'] = time();

?>