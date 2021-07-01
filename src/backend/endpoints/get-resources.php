<?php
session_start();

require_once(realpath(dirname(__FILE__) . '/../controllers/resource.php'));

if (!isset($_SESSION['email'])) {
  echo json_encode([
    'success' => false,
    'message' => "No current user",
]);
}

$resourceController = new ResourceController();

$eventId = $_GET['id'];

$allResources = $resourceController->getAllResourcesByEventId($eventId)["data"];

echo json_encode([
  'success' => true,
  'message' => "Event resources",
  'value' => $allResources,
]);

?>