<?php 
require_once(realpath(dirname(__FILE__) . '/../db/config.php'));

$data = file_get_contents("php://input");

$user_data = null; 
if (strlen($data) > 0) $user_data = json_decode($data, true);
else exit(json_encode(["success" => false, "message" => "Дължината е нула!"]));

$email = $user_data["email"]; 
$firstname = $user_data["first_name"]; 
$lastname = $user_data["last_name"];
$fn = $user_data["fn"]; 
$specialty = $user_data["specialty"];
$course = $user_data["course"]; 
$password = $user_data["password"];
$repeated_password = $user_data["repeat_password"]; 
$md5_password = md5($password); 

if ($password != $repeated_password) {
    exit(json_encode(["success" => false, "message" => "Паролите не съвпадат!"]));
}

try {
    $db = new Database();
    $connection = $db->getConnection();
    
    $sql = "SELECT * FROM users WHERE email = :email";

    $statement = $connection->prepare($sql);
    $statement->execute(["email" => $email]);

    if ($statement->rowCount() != 0) {
        exit(json_encode(["success" => false, "error" => "Потребител с този имейл адрес вече съществува!"]));
    }
} catch (PDOException $e) {
    return json_encode(["success" => false, "error" => "Connection failed: " . $e->getMessage()]);
}

try {
    $insert = "INSERT INTO users (first_name, last_name, fn, specialty, course, email, password)
                      VALUES (:first_name, :last_name, :fn, :specialty, :course, :email, :password)";

    $stmt = $connection->prepare($insert);
    
    if ($stmt->execute(["first_name" => $firstname, "last_name" => $lastname, "fn" => $fn, "specialty" => $specialty, "course" => $course, "email" => $email, "password" => $md5_password])) {
        $user_id = $connection->lastInsertId(); 

        session_start();
        $user = array("id" => $user_id, "first_name" => $firstname, "last_name" => $lastname,  "fn" => $fn, "specialty" => $specialty, "course" => $course, "email" => $email, "password" => $md5_password);
        $_SESSION["user"] = $user; 

        exit(json_encode(["success" => true, "message" => "Успешна регистрация!"]));
    }
    else {
        exit(json_encode(["success" => false,  "error" => "Connection failed: " . $e->getMessage()]));
    }
} catch (PDOException $e) {
    exit(json_encode(["success" => false, "error" => "Connection failed: " . $e->getMessage()]));
}

?>