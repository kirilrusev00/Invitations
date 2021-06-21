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

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" type="text/css" href="style.css">

  <title>Покани</title>
</head>

<body>
  <div class="container">
    <form action="" method="POST" class="login-email">
      <p class="login-text" style="font-size: 2rem; font-weight: 800;">Регистрация</p>

      <div class="input-group">
        <input type="email" placeholder="Имейл" name="email" value="<?php echo $email; ?>" required>
      </div>
      <div class="input-group">
        <input type="text" placeholder="Име" name="first_name" value="<?php echo $first_name; ?>" required>
      </div>
      <div class="input-group">
        <input type="text" placeholder="Фамилия" name="last_name" value="<?php echo $last_name; ?>" required>
      </div>
      <div class="input-group">
        <input type="text" placeholder="Факултетен номер" name="fn" value="<?php echo $fn; ?>" required>
      </div>
      <div class="input-group">
        <input type="text" placeholder="Специалност" name="specialty" value="<?php echo $specialty; ?>" required>
      </div>
      <div class="input-group">
        <input type="number" placeholder="Курс" name="course" min="1" max="4" value="<?php echo $course; ?>" required>
      </div>
      <div class="input-group">
        <input type="password" placeholder="Парола" name="password" value="<?php echo $_POST['password']; ?>" required>
      </div>
      <div class="input-group">
        <input type="password" placeholder="Потвърди парола" name="cpassword" value="<?php echo $_POST['cpassword']; ?>" required>
      </div>
      <div class="input-group">
        <button name="submit" class="btn">Регистрация</button>
      </div>
      <p class="login-register-text">Вече имаш профил? <a href="index.php">Влез в профила си</a></p>
    </form>
  </div>
</body>

</html>