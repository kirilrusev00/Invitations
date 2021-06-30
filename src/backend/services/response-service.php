<?php
require_once(realpath(dirname(__FILE__) . '/../db/config.php'));

class ResponseService
{
  private $db;

  function __construct()
  {
    $this->db = new Database();
  }

  function updateResponse($eventId, $status, $userId)
  {
    $this->db->getConnection()->beginTransaction();
    try {
      $sql = "UPDATE responses SET status = '{$status}', updated_at = NOW() WHERE user_id = '{$userId}' AND event_id = '{$eventId}'";
      $updateResponse = $this->db->getConnection()->prepare($sql);
      $updateResponse->execute();
      $this->db->getConnection()->commit();
      return ["success" => true];
    } catch (PDOException $e) {
      echo "exception test";
      $this->db->getConnection()->rollBack();
      return ["success" => false, "error" => "Connection failed: " . $e->getMessage()];
    }
  }

  function getAllResponsesFor($eventId)
  {
    $this->db->getConnection()->beginTransaction();
    try {
      $sql = "SELECT COUNT(*) AS responses_count, status 
              FROM responses 
              WHERE event_id = '{$eventId}' 
              GROUP BY status";
      $getAllResponsesFor = $this->db->getConnection()->prepare($sql);
      $getAllResponsesFor->execute();
      $responsesCount = $getAllResponsesFor->fetchAll(PDO::FETCH_ASSOC);
      $result = ["invited" => 0, "going" => 0, "notGoing" => 0, "interested" => 0];
      foreach ($responsesCount as $responseCount) {
        if ($responseCount['status'] === 'not going') {
          $result['notGoing'] = $responseCount['responses_count'];
        }
        else {
          $result[$responseCount['status']] = $responseCount['responses_count'];
        }
      }
      $this->db->getConnection()->commit();
      return ["success" => true, "data" => $result];
    } catch (PDOException $e) {
      echo "exception test";
      $this->db->getConnection()->rollBack();
      return ["success" => false, "error" => "Connection failed: " . $e->getMessage()];
    }
  }

  // function isCurrentUserInvited($eventId)
  // {
  //   $this->db->getConnection()->beginTransaction();
  //   try {
  //     $sql = "SELECT * FROM responses WHERE event_id = '{$eventId}' AND user_id = '{$_SESSION['userId']}'";
  //     $isCurrentUserInvited = $this->db->getConnection()->prepare($sql);
  //     $isCurrentUserInvited->execute();
  //     $result = $isCurrentUserInvited->fetch(PDO::FETCH_ASSOC);
  //     if (empty($result)) {
  //       $result = false;
  //     } else {
  //       $result = true;
  //     }
  //     $this->db->getConnection()->commit();
  //     return ["success" => true, "data" => $result];
  //   } catch (PDOException $e) {
  //     echo "exception test";
  //     $this->db->getConnection()->rollBack();
  //     return ["success" => false, "error" => "Connection failed: " . $e->getMessage()];
  //   }
  // }

  // function createResponse($userId, $eventId)
  // {
  //   $this->db->getConnection()->beginTransaction();
  //   try {
  //     $sql = "INSERT INTO responses(user_id, event_id) VALUES (:userId, :eventId)";
  //     $insertResponse = $this->db->getConnection()->prepare($sql);
  //     $insertResponse->execute(["userId" => $userId, "eventId" => $eventId]);
  //     $this->db->getConnection()->commit();
  //     return ["success" => true];
  //   } catch (PDOException $e) {
  //     $this->db->getConnection()->rollBack();
  //     return ["success" => false, "error" => "Connection failed: " . $e->getMessage()];
  //   }
  // }

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
}
