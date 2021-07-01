<?php
require_once(realpath(dirname(__FILE__) . '/../controllers/response.php'));

session_start();

if (!isset($_SESSION['email'])) {
  echo json_encode([
    'success' => false,
    'message' => "No current user",
]);
exit();
}

$responseController = new ResponseController();

$phpInput = json_decode(file_get_contents('php://input'), true);

if (!isset($phpInput['eventId']) || !isset($phpInput['status']) || empty($phpInput['eventId']) || empty($phpInput['status'])) {
  echo json_encode([
    'success' => false,
  ]);
} else {
  $eventId = $phpInput['eventId'];
  $status = $phpInput['status'];

  try {
    $responseController->updateResponse($eventId, $status, $_SESSION["userId"]);
    echo json_encode([
      'success' => true,
    ]);
  } catch (Exception $e) {
    echo json_encode([
      'success' => false,
      'message' => $e->getMessage(),
    ]);
  }
}
