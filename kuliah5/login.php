<?php
session_start();
if (isset($_SESSION['login'])) {
  header("location: index.php");
  exit;
}
require 'functions.php';

if (isset($_POST['login'])) {
  $login = login($_POST);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
</head>

<body>
  <h3>Form Login</h3>
  <?php if (isset($login['error'])) : ?>
    <p style="color:red; font-style: italic;"><?= $login['pesan']; ?></p>
  <?php endif; ?>
  <form action="" method="POST">
    <ul>
      <li>
        <label>
          Username :
          <input type="text" name="username" autofocus required autocomplete="off">
        </label>
      </li>
      <li>
        <label>
          Password :
          <input type="password" name="password" required autocomplete="off">
        </label>
      </li>
      <li>
        <button type="submit" name="login">Login</button>
        <button type="reset">Reset</button>
      </li>
    </ul>
  </form>
</body>

</html>