<?php
    session_start();

//session_start();
//session_destroy();

//header("Location: index.php");

// ?> 
    session_unset();

    session_destroy();

    header("location:frontend/login/index.html");

    exit();
?>
