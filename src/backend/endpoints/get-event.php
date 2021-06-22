<?php
    session_start();

    require_once(realpath(dirname(__FILE__) . '/../controllers/event.php'));

    $eventController = new EventController();

    // $phpInput = json_decode(file_get_contents('php://input'), true);
    // header('Content-Type: application/json');

    $eventId = $_GET['id'];

    try {
        $eventData = $eventController->getEvent($eventId);
        $eventData["isAddedByCurrentUser"] = $eventData["created_by"] == $_SESSION['userId'];

        echo json_encode([
          'success' => true,
          'message' => "Event info",
          'value' => $eventData,
      ]);
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'message' => $e->getMessage(),
        ]);
        exit();
    }

    
?>