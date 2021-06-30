<?php

class EventResponseModel {
  public $eventId;
  public $startTime;
  public $name;
  public $createdBy;
  public $status;

  function __construct($eventId, $startTime, $name, $createdBy, $status) {
    $this->eventId = $eventId;
    $this->startTime = $startTime;
    $this->name = $name;
    $this->createdBy = $createdBy;
    $this->status = $status;
  }
}

?>