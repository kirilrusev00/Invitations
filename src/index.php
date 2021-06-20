<?php

require_once(realpath(dirname(__FILE__) . '/backend/db/config.php'));

session_start();

error_reporting(0);

if (isset($_SESSION['email'])) {
  header("Location: welcome.php");
}

if (isset($_POST['submit'])) {
  $email = $_POST['email'];
  $password = md5($_POST['password']);

  $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
  $result = mysqli_query($db, $sql);
  if ($result->num_rows > 0) {
    $row = mysqli_fetch_assoc($result);
    $_SESSION['email'] = $row['email'];
    header("Location: welcome.php");
  } else {
    echo "<script>alert('Грешен имейл или парола!')</script>";
  }
}

?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" type="text/css" href="style.css">

  <title>Login form</title>
</head>

<body>
  <div class="container">
    <form action="" method="POST" class="login-email">
      <p class="login-text" style="font-size: 2rem; font-weight: 800;">Вход</p>
      <div class="input-group">
        <input type="email" placeholder="Имейл" name="email" value="<?php echo $email; ?>" required>
      </div>
      <div class="input-group">
        <input type="password" placeholder="Парола" name="password" value="<?php echo $_POST['password']; ?>" required>
      </div>
      <div class="input-group">
        <button name="submit" class="btn">Вход</button>
      </div>
      <p class="login-register-text">Все още нямаш профил? <a href="register.php">Регистрирай се</a></p>
    </form>
  </div>
</body>

</html>