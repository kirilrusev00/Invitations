<?php
    session_start();

    require_once(realpath(dirname(__FILE__) . '/../controllers/resource.php'));

    $resourceController = new ResourceController();

    $files = $_FILES;
    try {
        $resourceController->addResources($files);
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage(),
        ]);
        exit();
    }

    echo json_encode([
        'success' => true,
        'message' => "The event is created successfully.",
    ]);
?>