<?php
require_once(realpath(dirname(__FILE__) . '/../db/config.php'));

class ResourceService
{
  private $db;
  private $targetDir = "uploads/";
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

      // Check whether file type is valid 
      $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
      if (in_array($fileType, $this->allowTypes)) {
        // Upload file to server 
        if (move_uploaded_file($files["files"]["tmp_name"][$key], $targetFilePath)) {
          // Image db insert sql 

          // event_id is 1 for now
          $insertValuesSQL .= "('" . $fileName . "', NOW(), 1),";
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
    // try {
    //   $valuesToInsertInSql = $errorUpload = $errorUploadType = '';

    //   $sql = "INSERT INTO resourcres (file_name, event_id) VALUES (:file_name, :event_id)";
    //   $insert = $this->db->getConnection()->prepare($sql);

    //   foreach ($files['files']['name'] as $key => $val) {
    //     // File upload path 
    //     $fileName = basename($files['files']['name'][$key]);
    //     $targetFilePath = $this->targetDir . $fileName;

    //     // Check whether file type is valid 
    //     $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
    //     if (in_array($fileType, $this->allowTypes)) {
    //       // Upload file to server 
    //       if (move_uploaded_file($files["files"]["tmp_name"][$key], $targetFilePath)) {
    //         $valuesToInsertInSql .= "('" . $fileName . "', '" . $eventId . "')";
    //         $insert->execute(array(':file_name' => $fileName, ':event_id' => $eventId));
    //       } else {
    //         $errorUpload .= $files['files']['name'][$key] . ' | ';
    //       }
    //     } else {
    //       $errorUploadType .= $files['files']['name'][$key] . ' | ';
    //     }
    //   }

    //   if (!empty($errorUpload)) {
    //     throw new Exception('Upload Error: ' . trim($errorUpload, ' | '));
    //   }

    //   if (!empty($errorUploadType)) {
    //     throw new Exception('File Type Error: ' . trim($errorUploadType, ' | '));
    //   }

    //   return ["success" => true];
    // } catch (PDOException $e) {
    //   echo "exception test";
    //   $this->db->getConnection()->rollBack();
    //   return ["success" => false, "error" => "Connection failed: " . $e->getMessage()];
    // }
  // }
}
