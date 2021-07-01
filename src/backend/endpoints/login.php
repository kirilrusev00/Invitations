<?php 
include('../controllers/user.controller.php');

// echo $_SERVER['DOCUMENT_ROOT'];
$userController = new UserController();

$userController->login();
?>