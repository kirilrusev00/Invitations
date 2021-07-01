<?php
require_once(realpath(dirname(__FILE__) . '/../db/config.php'));

class UserService {
  private $db;

  function __construct() {
    $this->db = new Database(); 
  }

  function addUser($userData) {
    $this->db->getConnection()->beginTransaction();
    try {
      $sql = "INSERT INTO users(email, password, firstName, lastName, fn, course, specialty) VALUES(:email, :password, :firstName, :lastName, :fn, :course, :specialty)";
      $addUser = $this->db->getConnection()->prepare($sql);
      $addUser->execute($userData);
      $this->database->getConnection()->commit();   
      return ["success" => true];
    } catch (PDOException $e) {
      echo "exception test";
      $this->database->getConnection()->rollBack();
      return ["success" => false, "error" => "Connection failed: " . $e->getMessage()];
    }
  }

  function getUserByEmail($data) {
    $this->db->getConnection()->beginTransaction();
    try{
        $sql = "SELECT * FROM users WHERE email=:email";
        $getUserByEmail = $this->db->getConnection()->prepare($sql);
        $getUserByEmail->execute(["email" => $data]);
        $this->db->getConnection()->commit();
        return array("success" => true, "data" => $getUserByEmail);
    } catch(PDOException $e){
        $this->db->getConnection()->rollBack();
        return ["success" => false, "error" => "Connection failed: " . $e->getMessage()];
    }
  }

  function getUsersByCourseAndSpecialty($course, $specialty) {
    $this->db->getConnection()->beginTransaction();
    try{
        $sql = "SELECT id, email FROM users WHERE course = '{$course}' AND specialty = '{$specialty}'";
        $getUsersByCourseAndSpecialty = $this->db->getConnection()->prepare($sql);
        $getUsersByCourseAndSpecialty->execute();
        $this->db->getConnection()->commit();
        return array("success" => true, "data" => $getUsersByCourseAndSpecialty);
    } catch(PDOException $e){
        $this->db->getConnection()->rollBack();
        return ["success" => false, "error" => "Connection failed: " . $e->getMessage()];
    }
  }

    function getCurrentUserData() {
      $this->db->getConnection()->beginTransaction();
      try{
          $sql = "SELECT first_name, last_name, fn, course, specialty FROM users WHERE id = {$_SESSION['userId']}";
          $currentUserData = $this->db->getConnection()->prepare($sql);
          $currentUserData->execute();
          $this->db->getConnection()->commit();
          return ["success" => true, "data" => $currentUserData];
      } catch(PDOException $e){
          $this->db->getConnection()->rollBack();
          return ["success" => false, "error" => "Connection failed: " . $e->getMessage()];
      }
  }
}

?>