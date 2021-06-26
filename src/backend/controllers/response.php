<?php
require_once(realpath(dirname(__FILE__) . '/../services/response-service.php'));

class ResponseController
{
  private $responseService;

  function __construct()
  {
    $this->responseService = new ResponseService();
  }

  function updateResponse($eventId, $status, $userId) {
    $this->responseService->updateResponse($eventId, $status, $userId);
  }
}
?>