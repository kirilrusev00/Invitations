<?php
    session_start();

    require_once(realpath(dirname(__FILE__) . '/../controllers/event.php'));

    if (!isset($_SESSION['email'])) {
      echo json_encode([
        'success' => false,
        'message' => "No current user",
    ]);
    exit();
    }

    $eventController = new EventController();

    $phpInput = json_decode(file_get_contents('php://input'), true);
    header('Content-Type: application/json');

    $startTime = $phpInput['startTime'];
    $endTime = $phpInput['endTime'];
    $venue = $phpInput['venue'];
    $name = $phpInput['name'];
    $meetingLink = $phpInput['meetingLink'];
    $meetingPassword = $phpInput['meetingPassword'];

    $event = new EventModel(null, $startTime, $endTime, $venue, $name, $meetingLink, $meetingPassword, null, null);
    try {
        $eventController->createEvent($event);
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