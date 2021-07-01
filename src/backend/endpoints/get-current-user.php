<?php
    session_start();

    if (!isset($_SESSION['email'])) {
      echo json_encode([
        'success' => false,
        'message' => "No current user",
    ]);
    }

    $userInfo['firstName'] = $_SESSION['firstName'];
    $userInfo['lastName'] = $_SESSION['lastName'];
    $userInfo['email'] = $_SESSION['email'];
    $userInfo['specialty'] = $_SESSION['specialty'];
    $userInfo['fn'] = $_SESSION['fn'];
    $userInfo['course'] = $_SESSION['course'];
    
    echo json_encode([
      'success' => true,
      'message' => "Current user info",
      'value' => $userInfo,
  ]);

?>