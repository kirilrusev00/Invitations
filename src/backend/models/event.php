<?php

class EventModel {
  public $id;
  public $startTime;
  public $endTime;
  public $venue;
  public $name;
  public $meetingLink;
  public $meetingPassword;
  public $createdBy;
  public $createdAt;

  function __construct($id, $startTime, $endTime, $venue, $name, $meetingLink, $meetingPassword, $createdBy, $createdAt) {
    $this->id = $id;
    $this->startTime = $startTime;
    $this->endTime = $endTime;
    $this->venue = $venue;
    $this->name = $name;
    $this->meetingLink = $meetingLink;
    $this->meetingPassword = $meetingPassword;
    $this->createdBy = $createdBy;
    $this->createdAt = $createdAt;
  }
}

?>