<?php
require_once(realpath(dirname(__FILE__) . '/../models/resource.php'));
require_once(realpath(dirname(__FILE__) . '/../services/resource-service.php'));

class ResourceController
{
  private $resourceService;

  function __construct()
  {
    $this->resourceService = new ResourceService();
  }

  function addResources($files, $eventId)
  {
    $fileNames = array_filter($files['files']['name']);
    if (empty($fileNames)) {
      throw new Exception("Choose files to upload.");
    }
    $this->resourceService->addResources($files, $eventId); // to do -> not 1
  }

  function getAllResourcesByEventId($eventId) {
    return $this->resourceService->getAllResourcesByEventId($eventId);
  }
}
