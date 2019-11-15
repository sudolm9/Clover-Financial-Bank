<?php
require '../../connection.php';
session_start();
if (isset($_POST['search'])) {
  $id = $_POST['type'];
}
?>

 <!DOCTYPE html>
 <html lang="en" dir="ltr">
  <link rel="stylesheet" href="../AccountManagement/manage.css">
  <body>
    <h1 id="container">
      <div id="left">
        <img src="../../img/logo_transparent.png" alt="Clover Financial Bank Logo" width="100px" height="100px" class="index">
      </div>
      <div id="right">
        Display Users
      </div>
    </h1>
    <div id="detail">
    <div id="login1">
      <p></p>
   	<form action="adviewcontents.php" method="post">
   	<select name="type" required>
        <option value="" disabled selected>--Select an option--</option>
        <option value="All">*</option>
        <option value="ID">ID</option>
        <option value="Name">Name</option>
        <option value="Email">Email</option>
        <option value="Credentials">Credentials</option>
      </select>
    <p></p>
      <input type="submit" name="search" value="Search" class="search">
      </form>
      <p></p>
      <form action="../admenu.php" method="post">
      	<input type="submit" name="menu" value="Go back" class="search">
      </form>
      <p></p>
        </div>
        </div>
    </body>
</html>
