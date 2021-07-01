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

try {
  $allEvents = $eventController->getAllEventsInvitedCurrentUser();

  echo json_encode([
    'success' => true,
    'message' => "Events invited for current user",
    'value' => $allEvents["data"],
  ]);
} catch (Exception $e) {
  echo json_encode([
      'success' => false,
      'message' => $e->getMessage(),
  ]);
  exit();
}

?>