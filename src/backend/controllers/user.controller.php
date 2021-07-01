<?php 
include("../models/user.php");
include("../services/user-service.php");

class UserController {
  private $userService;

  function __construct() {
    $this->userService = new UserService();
  }

  private function checkLogin($email, $password) {
    
    $resultUser = $this->userService->getUserByEmail($email);
    if (!$resultUser["success"]) throw new Exception($resultUser["error"]);
    
    if (empty($resultUser["data"])) {
      throw new Exception("Възникна грешка.");
    } 
    
    if (strcmp(md5($password), $resultUser["data"]["password"]) != 0) {
      return  ["success" => false, "message" => "Грешен имейл или парола!"];
    } 
  
    session_start();
    return $resultUser["data"]["id"];
}

  function login($email, $password) {
    if (!isset($email) || !isset($password) || empty($email) || empty($password)) {
        // echo json_encode([
        //     "success" => false,
        //     "message" => "Моля, попълнете имейл и парола.",
        // ]);
        return  [
            "success" => false,
            "message" => "Моля, попълнете имейл и парола.",
        ];
    } 

        $userId = $this->checkLogin($email, $password);
        // echo $userId;
        $_SESSION["userId"] = $userId;
        $userData = $this->userService->getCurrentUserData()["data"]->fetch(PDO::FETCH_ASSOC);
       
        $_SESSION["firstName"] = $userData["first_name"];
        $_SESSION["lastName"] = $userData["last_name"];
        $_SESSION["fn"] = $userData["fn"];
        $_SESSION["course"] = $userData["course"];
        $_SESSION["specialty"] = $userData["specialty"];
    
        $_SESSION["email"] = $email;

        // echo json_encode([
        //     "success" => true,
        //     "email" => $_SESSION["email"],
        // ]);
        
        setcookie("email", $email, time() + 600, "/");
        setcookie("password", $password, time() + 600, "/");

        return  ["success" => true, "email" => $_SESSION["email"]];
  }  
  
}

?>