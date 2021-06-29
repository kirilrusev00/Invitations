<?php

include('../db/config.php');

$db = new Database();

error_reporting(0);

session_start();

// if (isset($_SESSION['email'])) {
//   header("Location: ../../frontend/login/index.php");
// }

if (isset($_POST['submit'])) {
  $email = $_POST['email'];
  $first_name = $_POST['first_name'];
  $last_name = $_POST['last_name'];
  $fn = $_POST['fn'];
  $specialty = $_POST['specialty'];
  $course = $_POST['course'];
  $password = md5($_POST['password']);
  $cpassword = md5($_POST['cpassword']);
  $created_at = date("Y-m-d H:i:s");

  if ($password == $cpassword) {
    $checkEmailSql = "SELECT * FROM users WHERE email='$email'";
    $checkEmailresult = mysqli_query($db->getConnection(), $checkEmailSql);

    // check if there are users with this email
    if (!$checkEmailresult->num_rows > 0) {
      $sqlQuery = "INSERT INTO users ( email, password, first_name, last_name, fn, course, specialty, created_at)
					VALUES ('$email', '$password', '$first_name, '$last_name', '$fn', '$course', '$specialty', '$created_at')";
      $resultRegistration = mysqli_query($db->getConnection(), $sqlQuery);

      if ($resultRegistration) { 
        echo "<script>alert('Успешна регистрация!')</script>";
        $username = "";
        $email = "";
        $_POST['password'] = "";
        $_POST['cpassword'] = "";

        header("Location: ../../frontend/login/index.php");
      } 
      else echo "<script>alert('Нещо се обърка!')</script>";

    } else echo "<script>alert('Вече съществува потребител със този имейл.')</script>";

  } else {
    echo "<script>alert('Паролите не съвпадат!')</script>";
  }
  
}

?>
