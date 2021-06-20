<?php

class ResourceModel {
  public $id;
  public $fileName;
  public $status;
  public $uploadedAt;
  public $eventId;

  function __construct($id, $fileName, $status, $uploadedAt, $eventId) {
    $this->id = $id;
    $this->fileName = $fileName;
    $this->status = $status;
    $this->uploadedAt = $uploadedAt;
    $this->eventId = $eventId;
  }
}

?>