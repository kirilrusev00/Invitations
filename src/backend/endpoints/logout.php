<?php
    session_start();

    session_unset();

    if(session_destroy()) {
    echo json_encode([
        'success' => true,
        'message' => "User has logout."
        ]);
        
    header("Location: index.php");
    }
?>