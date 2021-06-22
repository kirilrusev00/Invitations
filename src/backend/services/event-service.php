<?php
require_once(realpath(dirname(__FILE__) . '/../db/config.php'));
require_once(realpath(dirname(__FILE__) . '/resource-service.php'));

class EventService
{
  private $db;

  function __construct()
  {
    $this->db = new Database();
  }

  function addEvent($eventData)
  {
    $this->db->getConnection()->beginTransaction();
    try {
      $sql = "INSERT INTO events(start_time, end_time, venue, name, meeting_link, meeting_password, created_by) VALUES(:start_time, :end_time, :venue, :name, :meeting_link, :meeting_password, '{$_SESSION['userId']}')";
      $insertPost = $this->db->getConnection()->prepare($sql);
      $insertPost->execute($eventData);
      //$last_id = $this->db->getConnection()->lastInsertId();
      //(new ResourceService())->addResources($last_id);
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
      $sql = "SELECT * FROM events WHERE id=:id";
      $getEventById = $this->db->getConnection()->prepare($sql);
      $getEventById->execute(["id" => $id]);
      $result = $getEventById->fetch(PDO::FETCH_ASSOC);
      if (empty($result)) {
        $result = "";
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
      $sql = "SELECT * FROM events WHERE created_by=:created_by";
      $getAllEventsAddedBy = $this->db->getConnection()->prepare($sql);
      $getAllEventsAddedBy->execute(["created_by" => $userId]);
      $this->db->getConnection()->commit();
      return array("success" => true, "data" => $getAllEventsAddedBy);
    } catch (PDOException $e) {
      $this->db->getConnection()->rollBack();
      return ["success" => false, "error" => "Connection failed: " . $e->getMessage()];
    }
  }
}
