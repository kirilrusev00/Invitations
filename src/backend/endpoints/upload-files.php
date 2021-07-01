<?php
    session_start();

    require_once(realpath(dirname(__FILE__) . '/../controllers/resource.php'));

    if (!isset($_SESSION['email'])) {
      echo json_encode([
        'success' => false,
        'message' => "No current user",
    ]);
    }

    $referer = $_SERVER['HTTP_REFERER'];
    header("Location: $referer");

    $resourceController = new ResourceController();

    $eventId = $_GET['id'];

    $files = $_FILES;
    try {
        $resourceController->addResources($files, $eventId);
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage(),
        ]);
        exit();
    }

    echo json_encode([
        'success' => true,
        'message' => "The resources are uploaded successfully.",
    ]);
?>