<?php

class ResponseModel {
  public $id;
  public $userId;
  public $eventId;
  public $status;
  public $createdAt;

  function __construct($id, $userId, $eventId, $status, $createdAt) {
    $this->id = $id;
    $this->userId = $userId;
    $this->eventId = $eventId;
    $this->status = $status;
    $this->createdAt = $createdAt;
  }
}

?>