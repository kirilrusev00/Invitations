<?php 
include('../controllers/user.controller.php');

// echo $_SERVER['DOCUMENT_ROOT'];
$userController = new UserController();

$phpInput = json_decode(file_get_contents("php://input"), true);
header('Content-Type: application/json');

$email = $phpInput["email"];
$password = $phpInput["password"];

try {
$userController->login($email, $password);
}
catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "message" => $e->getMessage(),
    ]);
    exit();
}

echo json_encode([
            "success" => true,
            "message" => "User logged in succesfully!",
            "email" => $_SESSION["email"],
        ]);

?>