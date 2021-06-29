<?php 
include('../models/user.php');
include('../services/user.service.php');

class UserController {
  private $userService;

  function __construct() {
    $this->userService = new UserService();
  }

  private function checkLogin($email, $password) {
    session_start();

    $resultUser = $this->userService->getUserByEmail($email);
    $resultData = $resultUser["data"]->fetch(PDO::FETCH_ASSOC);
    if (!$resultUser["success"] || empty($resultData) || mysqli_num_rows($resultUser) > 1) { // || !password_verify($password, $resultData["password"])) {
        throw new Exception("Възникна грешка.");
    } 

    $resultLogin = $this->userService->loginUser($email, $password);
    if (!$resultLogin["success"]) {
        throw new Exception("Грешно потребителско име или парола.");
    }
    echo "ura!";
    return $resultData["id"];
}

  function login() {
    $phpInput = json_decode(file_get_contents('php://input'), true);

    $email = $phpInput['email'];
    $password = $phpInput['password'];

    if (!isset($email) || !isset($password) || empty($email) || empty($password)) {
        echo json_encode([
            'success' => false,
            'message' => "Моля, попълнете имейл и парола.",
        ]);
        return;
    } 

    try {
        $userId = $this->checkLogin($email, $password);
        $_SESSION['userId'] = $userId;

        $userData = $this->userService->getCurrentUserData()["data"]->fetch(PDO::FETCH_ASSOC);
        $_SESSION['firstName'] = $userData["first_name"];
        $_SESSION['lastName'] = $userData["last_name"];
        $_SESSION['fn'] = $userData["fn"];
        $_SESSION['course'] = $userData["course"];
        $_SESSION['specialty'] = $userData["specialty"];

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

?>