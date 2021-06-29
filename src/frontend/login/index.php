<?php

?>

<!DOCTYPE html>
<html>

  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <link rel="stylesheet" type="text/css" href="../../style.css" />
    <script src="login.js" defer></script>

    <title>Login form</title>
  </head>

  <body>
    <div class="container">
      <form id="login-form" class="login-email" action="../../backend/endpoints/login.php" method="POST"> 
      <!--   -->
        <p class="login-text" style="font-size: 2rem; font-weight: 800">
          Вход
        </p>
        <div class="input-group">
          <input type="email" placeholder="Имейл" name="email" id="email" required />
        </div>
        <div class="input-group">
          <input type="password" placeholder="Парола" name="password" id="password" required />
        </div>
        <div class="input-group">
          <button id="submit-btn" class="btn">Вход</button>
        </div>
        <p id="user-message"></p>
        <p class="login-register-text">
          Все още нямаш профил?
          <a href="../register/register.html">Регистрирай се</a>
        </p>
      </form>
      </section>
  </body>

</html>
