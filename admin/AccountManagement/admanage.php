<?php
require '../../connection.php';
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Account Management</title>
  </head>
  <link rel="stylesheet" href="manage.css">
  <body>
    <h1 id="container">
      <div id="left">
        <img src="../../img/logo_transparent.png" alt="Clover Financial Bank Logo" width="100px" height="100px" class="index">
      </div>
      <div id="right">
        Account Management
      </div>
    </h1>
    <div id="detail">
    <div id="login">
      <p></p>
      <button type='button' id="A" class="index">
        <a href="unblockuser.php">Unblock Accounts</a>
      </button>
      <p></p>
      <button type='button' id="B" class="index">
        <a href="deluser.php">Delete Users</a>
      </button>
      <p></p>
      <form action="../admenu.php" method="post">
        <input type="submit" name="menu" value="Go back to menu" class="long">
      </form>
      <p></p>
    </div>
    </div>
  </body>
</html>
