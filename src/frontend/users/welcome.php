<?php

session_start();

if (!isset($_SESSION['email'])) {
  header("Location: ../login/index.php");
}


// include('profile.html');

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Начална страница</title>
</head>

<body>
  <?php echo "<h1> " . $_SESSION['email'] . "</h1>"; ?>
  <a href="logout.php">Изход</a>
</body>

</html>