<?php

require_once(realpath(dirname(__FILE__) . '/backend/db/config.php'));

error_reporting(0);

session_start();

if (isset($_SESSION['email'])) {
  header("Location: index.php");
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
    $result = mysqli_query($db, $sql);
    if (!$result->num_rows > 0) {
      $sql = "INSERT INTO users ( email, password)
					VALUES ('$email', '$password')";
      $result = mysqli_query($db, $sql);
      if ($result) {
        echo "<script>alert('User Registration Completed.')</script>";
        $username = "";
        $email = "";
        $_POST['password'] = "";
        $_POST['cpassword'] = "";
      } else {
        echo "<script>alert('Something went wrong!')</script>";
      }
    } else {
      echo "<script>alert('Email already exists.')</script>";
    }
  } else {
    echo "<script>alert('Password not matched.')</script>";
  }
}

?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

  <link rel="stylesheet" type="text/css" href="style.css">

  <title>Presentation invitations</title>
</head>

<body>
  <div class="container">
    <form action="" method="POST" class="login-email">
      <p class="login-text" style="font-size: 2rem; font-weight: 800;">Register</p>

      <div class="input-group">
        <input type="email" placeholder="Email" name="email" value="<?php echo $email; ?>" required>
      </div>
      <div class="input-group">
        <input type="text" placeholder="First name" name="first_name" value="<?php echo $first_name; ?>" required>
      </div>
      <div class="input-group">
        <input type="text" placeholder="Last name" name="last_name" value="<?php echo $last_name; ?>" required>
      </div>
      <div class="input-group">
        <input type="text" placeholder="Faculty number" name="fn" value="<?php echo $fn; ?>" required>
      </div>
      <div class="input-group">
        <input type="text" placeholder="Specialty" name="specialty" value="<?php echo $specialty; ?>" required>
      </div>
      <div class="input-group">
        <input type="number" placeholder="Course" name="course" min="1" max="4" value="<?php echo $course; ?>" required>
      </div>
      <div class="input-group">
        <input type="password" placeholder="Password" name="password" value="<?php echo $_POST['password']; ?>" required>
      </div>
      <div class="input-group">
        <input type="password" placeholder="Confirm Password" name="cpassword" value="<?php echo $_POST['cpassword']; ?>" required>
      </div>
      <div class="input-group">
        <button name="submit" class="btn">Register</button>
      </div>
      <p class="login-register-text">Have an account? <a href="index.php">Login Here</a>.</p>
    </form>
  </div>
</body>

</html>