<?php
require_once(realpath(dirname(__FILE__) . '/../models/user.php'));
require_once(realpath(dirname(__FILE__) . '/../services/user-service.php'));

class UserController
{
  private $userService;

  function __construct()
  {
    $this->userService = new UserService();
  }

  private function checkLogin($email, $password)
  {
    $result = $this->userService->getUserByEmail($email);
    $resultData = $result["data"]->fetch(PDO::FETCH_ASSOC);
    if (!$result["success"] || empty($resultData)) {
      
      throw new Exception("Грешно потребителско име или парола.");
    }

    if (strcmp(md5($password), $resultData["password"]) != 0) {
      throw new Exception("Грешно потребителско име или парола.");
    }
    
    session_start();
    return $resultData["id"];
  }

  function login()
  {
    $phpInput = json_decode(file_get_contents('php://input'), true);

    if (!isset($phpInput['email']) || !isset($phpInput['password']) || empty($phpInput['email']) || empty($phpInput['password'])) {
      echo json_encode([
        'success' => false,
        'message' => "Моля, попълнете имейл и парола.",
      ]);
    } else {
      $email = $phpInput['email'];
      $password = $phpInput['password'];

      try {
        $userId = $this->checkLogin($email, $password);
        $_SESSION['userId'] = $userId;

        $info = $this->userService->getCurrentUserData()["data"]->fetch(PDO::FETCH_ASSOC);
        $_SESSION['firstName'] = $info["first_name"];
        $_SESSION['lastName'] = $info["last_name"];
        $_SESSION['fn'] = $info["fn"];
        $_SESSION['course'] = $info["course"];
        $_SESSION['specialty'] = $info["specialty"];

        $_SESSION['email'] = $phpInput['email'];

        echo json_encode([
          'success' => true,
          'email' => $_SESSION['email'],
        ]);
      } catch (Exception $e) {
        echo json_encode([
          'success' => false,
          'message' => $e->getMessage(),
        ]);
      }
    }
  }
}
