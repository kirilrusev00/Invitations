<?php

require_once(realpath(dirname(__FILE__) . '/backend/db/config.php'));

$db = new Database();

error_reporting(0);

session_start();

if (isset($_SESSION['email'])) {
  header("Location: index.html");
}

if (isset($_POST['submit'])) {
  $email = $_POST['email'];
  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $fn = $_POST['fn'];
  $specialty = $_POST['specialty'];
  $course = $_POST['course'];
  $password = md5($_POST['password']);
  $cpassword = md5($_POST['cpassword']);

  if ($password == $cpassword) {
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($db->getConnection(), $sql);
    if (!$result->num_rows > 0) {
      $sql = "INSERT INTO users ( email, password)
					VALUES ('$email', '$password')";
      $result = mysqli_query($db->getConnection(), $sql);
      if ($result) {
        echo "<script>alert('Успешна регистрация!')</script>";
        $username = "";
        $email = "";
        $_POST['password'] = "";
        $_POST['cpassword'] = "";
      } else {
        echo "<script>alert('Нещо се обърка!')</script>";
      }
    } else {
      echo "<script>alert('Вече съществува потребител със този имейл?')</script>";
    }
  } else {
    echo "<script>alert('Паролите не съвпадат!')</script>";
  }
}

?>