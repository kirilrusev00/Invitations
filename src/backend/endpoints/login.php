<?php 
require_once(realpath(dirname(__FILE__) . '/../controllers/user.php'));

$userController = new UserController();

$userController->login();
?>