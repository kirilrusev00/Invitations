<?php
// Include the database configuration file 
require_once(realpath(dirname(__FILE__) . '/backend/db/config.php'));

if (isset($_POST['submit'])) {
  // File upload configuration 
  $targetDir = "uploads/";
  if (!is_dir($targetDir)) {
    mkdir($targetDir);
  }

  $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'pdf');

  $statusMsg = $errorMsg = $insertValuesSQL = $errorUpload = $errorUploadType = '';
  $fileNames = array_filter($_FILES['files']['name']);
  if (!empty($fileNames)) {
    foreach ($_FILES['files']['name'] as $key => $val) {
      // File upload path 
      $fileName = basename($_FILES['files']['name'][$key]);
      $targetFilePath = $targetDir . $fileName;

      // Check whether file type is valid 
      $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
      if (in_array($fileType, $allowTypes)) {
        // Upload file to server 
        if (move_uploaded_file($_FILES["files"]["tmp_name"][$key], $targetFilePath)) {
          // Image db insert sql 

          // event_id is 1 for now
          $insertValuesSQL .= "('" . $fileName . "', NOW(), 1),";
        } else {
          $errorUpload .= $_FILES['files']['name'][$key] . ' | ';
        }
      } else {
        $errorUploadType .= $_FILES['files']['name'][$key] . ' | ';
      }
    }

    // Error message 
    $errorUpload = !empty($errorUpload) ? 'Upload Error: ' . trim($errorUpload, ' | ') : '';
    $errorUploadType = !empty($errorUploadType) ? 'File Type Error: ' . trim($errorUploadType, ' | ') : '';
    $errorMsg = !empty($errorUpload) ? '<br/>' . $errorUpload . '<br/>' . $errorUploadType : '<br/>' . $errorUploadType;

    if (!empty($insertValuesSQL)) {
      $insertValuesSQL = trim($insertValuesSQL, ',');
      // Insert image file name into database 
      $insert = $db->query("INSERT INTO resourcres (file_name, uploaded_at, event_id) VALUES $insertValuesSQL");
      if ($insert) {
        $statusMsg = "Files are uploaded successfully." . $errorMsg;
      } else {
        $statusMsg = "Sorry, there was an error uploading your file.";
      }
    } else {
      $statusMsg = "Upload failed! " . $errorMsg;
    }
  } else {
    $statusMsg = 'Please select a file to upload.';
  }
}

?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

  <link rel="stylesheet" type="text/css" href="style.css">

  <title>Login Form - Pure Coding</title>
</head>

<body>
  <form action="upload.php" method="post" enctype="multipart/form-data">
    Select Image Files to Upload:
    <input type="file" name="files[]" multiple>
    <input type="submit" name="submit" value="UPLOAD">
  </form>
</body>

</html>