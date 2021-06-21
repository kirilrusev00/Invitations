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

  function addResources($files)
  {
    $fileNames = array_filter($_FILES['files']['name']);
    if (empty($fileNames)) {
      throw new Exception("Choose files to upload.");
    }
    $this->resourceService->addResources($files, 1); // to do -> not 1
  }
}
