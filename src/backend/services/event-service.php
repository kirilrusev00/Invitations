<?php
require_once(realpath(dirname(__FILE__) . '/../db/config.php'));
require_once(realpath(dirname(__FILE__) . '/user-service.php'));
require_once(realpath(dirname(__FILE__) . '/response-service.php'));
require_once(realpath(dirname(__FILE__) . '/../models/event.php'));
require_once(realpath(dirname(__FILE__) . '/../models/event-response.php'));

class EventService
{
  private $db;
  private $userService;
  private $responseService;

  function __construct()
  {
    $this->db = new Database();
    $this->userService = new UserService();
    $this->responseService = new ResponseService();
  }

  function addEvent($eventData)
  {
    $this->db->getConnection()->beginTransaction();
    try {
      $sql = "INSERT INTO events(start_time, end_time, venue, name, meeting_link, meeting_password, created_by) VALUES(:start_time, :end_time, :venue, :name, :meeting_link, :meeting_password, '{$_SESSION['userId']}')";
      $insertPost = $this->db->getConnection()->prepare($sql);
      $insertPost->execute($eventData);

      $eventId = $this->db->getConnection()->lastInsertId();

      $invitedUsers = $this->userService->getUsersByCourseAndSpecialty($_SESSION['course'], $_SESSION['specialty']);

      $insertResponseValues = '';

      foreach ($invitedUsers["data"] as $invitedUser) {
        if ($invitedUser['id'] !== $_SESSION['userId']) {
          $insertResponseValues .= "('" . $invitedUser['id'] . "', '" . $eventId . "'),";
        }
      }

      if (!empty($insertResponseValues)) {
        $insertResponseValues = trim($insertResponseValues, ',');
        $this->db->getConnection()->query("INSERT INTO responses(user_id, event_id) VALUES $insertResponseValues");
      }

      $this->db->getConnection()->commit();
      return ["success" => true];
    } catch (PDOException $e) {
      echo "exception test";
      $this->db->getConnection()->rollBack();
      return ["success" => false, "error" => "Connection failed: " . $e->getMessage()];
    }
  }

  function getEventById($id)
  {
    $this->db->getConnection()->beginTransaction();
    try {
      $sql = "SELECT events.*, status FROM events 
              LEFT JOIN responses ON responses.event_id = events.id
              WHERE events.id=:id";
      $getEventById = $this->db->getConnection()->prepare($sql);
      $getEventById->execute(["id" => $id]);
      $result = $getEventById->fetch(PDO::FETCH_ASSOC);
      if (empty($result)) {
        $result = "";
      } else if (empty($result["status"]) && $result["created_by"] != $_SESSION['userId']) {
        $result["status"] = "not invited";
      } else {
        $responses = $this->responseService->getAllResponsesFor($id);
        $result["responses"] = $responses["data"];
        // $isUserInvited = $this->responseService->isCurrentUserInvited($id);
        // $result["isUserInvited"] = $isUserInvited["data"];
      }
      $this->db->getConnection()->commit();
      return array("success" => true, "data" => $result);
    } catch (PDOException $e) {
      $this->db->getConnection()->rollBack();
      return ["success" => false, "error" => "Connection failed: " . $e->getMessage()];
    }
  }

  function getAllEventsAddedBy($userId)
  {
    $this->db->getConnection()->beginTransaction();
    try {
      $sql = "SELECT * FROM events WHERE created_by=:created_by ORDER BY created_at";
      $getAllEventsAddedBy = $this->db->getConnection()->prepare($sql);
      $getAllEventsAddedBy->execute(["created_by" => $userId]);
      $this->db->getConnection()->commit();

      $result = array();
      foreach ($getAllEventsAddedBy as $event) {
        array_push($result, new EventModel(
          $event["id"],
          $event["start_time"],
          $event["end_time"],
          $event["venue"],
          $event["name"],
          $event["meeting_link"],
          $event["meeting_password"],
          $event["created_by"],
          $event["created_at"]
        ));
      }

      return array("success" => true, "data" => $result);

      //return array("success" => true, "data" => $getAllEventsAddedBy);
    } catch (PDOException $e) {
      $this->db->getConnection()->rollBack();
      return ["success" => false, "error" => "Connection failed: " . $e->getMessage()];
    }
  }

  function getAllEventsInterestedOrGoing($userId)
  {
    $this->db->getConnection()->beginTransaction();
    try {
      $sql = "SELECT events.*, status FROM events 
              JOIN responses ON responses.event_id = events.id
              WHERE responses.user_id = '{$userId}' AND responses.status = 'interested' OR responses.status = 'going'";
      $getAllEventsInterestedOrGoing = $this->db->getConnection()->prepare($sql);
      $getAllEventsInterestedOrGoing->execute();
      $this->db->getConnection()->commit();

      $result = array();
      foreach ($getAllEventsInterestedOrGoing as $event) {
        array_push($result, new EventResponseModel(
          $event["id"],
          $event["start_time"],
          $event["name"],
          $event["created_by"],
          $event["status"]
        ));
      }

      return array("success" => true, "data" => $result);

      //return array("success" => true, "data" => $getAllEventsAddedBy);
    } catch (PDOException $e) {
      $this->db->getConnection()->rollBack();
      return ["success" => false, "error" => "Connection failed: " . $e->getMessage()];
    }
  }

  function getAllEventsInvited($userId)
  {
    $this->db->getConnection()->beginTransaction();
    try {
      $sql = "SELECT events.*, status FROM events 
              JOIN responses ON events.id = responses.event_id
              WHERE responses.user_id = '{$userId}' AND responses.status = 'invited'";
      $getAllEventsInvited = $this->db->getConnection()->prepare($sql);
      $getAllEventsInvited->execute();
      $this->db->getConnection()->commit();

      $result = array();
      foreach ($getAllEventsInvited as $event) {
        array_push($result, new EventResponseModel(
          $event["id"],
          $event["start_time"],
          $event["name"],
          $event["created_by"],
          $event["status"]
        ));
      }

      return array("success" => true, "data" => $result);

      //return array("success" => true, "data" => $getAllEventsAddedBy);
    } catch (PDOException $e) {
      $this->db->getConnection()->rollBack();
      return ["success" => false, "error" => "Connection failed: " . $e->getMessage()];
    }
  }
}
