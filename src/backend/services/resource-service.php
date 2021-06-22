<?php
require_once(realpath(dirname(__FILE__) . '/../db/config.php'));

class ResourceService
{
  private $db;
  private $targetDir = "uploads/";
  private $fullTargetDirPath = '../../backend/endpoints/uploads/';
  private $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'pdf');

  function __construct()
  {
    $this->db = new Database();

    if (!is_dir($this->targetDir)) {
      mkdir($this->targetDir);
    }
  }

  function addResources($files, $eventId)
  {
    $statusMsg = $errorMsg = $insertValuesSQL = $errorUpload = $errorUploadType = '';
    foreach ($files['files']['name'] as $key => $val) {
      // File upload path 
      $fileName = basename($files['files']['name'][$key]);
      $targetFilePath = $this->targetDir . $fileName;

      if (file_exists($targetFilePath)) {
        $errorUpload .= "File" . $files['files']['name'][$key] . " already exists." . ' | ';
      }

      if ($files['files']["size"] > 500000) {
        $errorUpload .= "File" . $files['files']['name'][$key] . " is too large." . ' | ';
      }

      // Check whether file type is valid 
      $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
      if (in_array($fileType, $this->allowTypes)) {
        // Upload file to server 
        if (move_uploaded_file($files["files"]["tmp_name"][$key], $targetFilePath)) {
          // Image db insert sql 

          // event_id is 1 for now
          $insertValuesSQL .= "('" . $fileName . "', NOW(), '" . $eventId . "'),";
        } else {
          $errorUpload .= $files['files']['name'][$key] . ' | ';
        }
      } else {
        $errorUploadType .= $files['files']['name'][$key] . ' | ';
      }
    }

    // Error message 
    $errorUpload = !empty($errorUpload) ? 'Upload Error: ' . trim($errorUpload, ' | ') : '';
    $errorUploadType = !empty($errorUploadType) ? 'File Type Error: ' . trim($errorUploadType, ' | ') : '';
    $errorMsg = !empty($errorUpload) ? '<br/>' . $errorUpload . '<br/>' . $errorUploadType : '<br/>' . $errorUploadType;

    if (!empty($insertValuesSQL)) {
      $insertValuesSQL = trim($insertValuesSQL, ',');
      // Insert image file name into database 
      $insert = $this->db->getConnection()->query("INSERT INTO resources (file_name, uploaded_at, event_id) VALUES $insertValuesSQL");
      if ($insert) {
        $statusMsg = "Успешно качване на файловете!" . $errorMsg;
      } else {
        $statusMsg = "Нещо се обърка - грешка при качването на файловете.";
      }
    } else {
      $statusMsg = "Неуспешно качване! " . $errorMsg;
    }
  }
  
  function getAllResourcesByEventId($eventId) {
    $this->db->getConnection()->beginTransaction();
    try {
      $sql = "SELECT * FROM resources WHERE event_id=:eventId ORDER BY id DESC";
      $getAllResourcesByEventId = $this->db->getConnection()->prepare($sql);
      $getAllResourcesByEventId->execute(["eventId" => $eventId]);
      $this->db->getConnection()->commit();

            $result = array();
            foreach ($getAllResourcesByEventId as $resource) {
              //echo $resource;
              $imageURL = $this->fullTargetDirPath . $resource["file_name"];
              //echo $imageURL;
              array_push($result, $imageURL);
            }

            //return $result;

      return array("success" => true, "data" => $result);
    } catch (PDOException $e) {
      $this->db->getConnection()->rollBack();
      return ["success" => false, "error" => "Connection failed: " . $e->getMessage()];
    }
  }
}
