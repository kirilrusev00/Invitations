<?php
require_once(realpath(dirname(__FILE__) . '/../models/event.php'));
require_once(realpath(dirname(__FILE__) . '/../services/event-service.php'));

class EventController
{
  private $eventService;

  function __construct()
  {
    $this->eventService = new EventService();
  }

  function getAllEventsByCurrentUser()
  {
    return $this->eventService->getAllEventsAddedBy($_SESSION["userId"]);
  }

  function createEvent($event)
  {
    if (empty($event->startTime)) {
      throw new Exception("Start time should be specified.");
    }
    if (empty($event->endTime)) {
      throw new Exception("End time should be specified.");
    }
    if (empty($event->venue)) {
      throw new Exception("Venue should be specified.");
    }
    if (empty($event->name)) {
      throw new Exception("Name should be specified.");
    }
    $this->eventService->addEvent([
      "start_time" => $event->startTime,
      "end_time" => $event->endTime,
      "venue" => $event->venue,
      "name" => $event->name,
      "meeting_link" => $event->meetingLink,
      "meeting_password" => $event->meetingPassword
    ]);
  }

  function getEvent($eventId) {
    return $this->eventService->getEventById($eventId)["data"];
  }
}
