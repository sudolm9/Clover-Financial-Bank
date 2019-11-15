<?php
require 'connection.php';
$error = "";
if(isset($_POST['rlogin'])){
    $name=$_POST['name'];
    $email=$_POST['email'];
    $username=$_POST['username'];
    $password=$_POST['password'];
    $authpassword=$_POST['conpassword'];
    $checkuser = '';
    $checkemail = '';
    $errorcode;
    $register = false;
    $startingcheck = 0;
    $startingsave = 0;
    //Checks if the information already exists in the database
    try {
      $getInfo = $conn->prepare("SELECT * FROM accounts");
      $getInfo->execute();
      } catch (Exception $e){
        echo "Error: " . $e->getMessage();
      }

      for ($i=0; $check = $getInfo->fetch(); $i++) {
        $checkuser = $check['username'];
        $checkemail = $check['email'];
      }

      if ($checkuser == $username) {
        $errorcode = 405;
      } else if ($checkemail == $email){
        $errorcode = 406;
      } else {
        $errorcode = 1;
      }

      if ($authpassword != $password) {
        $error = "Passwords do not match, please try again";
      } else if ($errorcode == 405) {
        $error = "This username already exists, please try again!";
      } else if ($errorcode == 406) {
        $error = "This email address already exists, please try again!";
      } else if ($errorcode == 1) {
        $register = true;
      }

      if ($register == true && $authpassword == $password){
        $conn->exec("INSERT INTO accounts (name, email, username, password, logcounter)
        VALUES ('$name','$email','$username','$password',4)");
        $conn->exec("INSERT INTO balance (name, savings, checking)
        VALUES ('$name','$startingsave','$startingcheck')");
        header("Location:close.php");
       }

    }
  $conn=null;
?>

<!DOCTYPE html>
<html lng="en" dir="ltr">
  <style>
    body {
      text-align: center;
    }
    table {
      padding-left: 70px;
    }
    h1 {
      border: 2px solid blue;
    }
  </style>
  <head>
    <meta charset="utf-8">
    <title>Clover Financial Bank - Registration</title>
  </head>
  <link rel="stylesheet" href="admin/AccountManagement/manage.css">
  <body>
    <h1 id="container">
      <div id="left">
        <img src="img/logo_transparent.png" alt="Clover Financial Bank Logo" width="100px" height="100px" class="index">
      </div>
      <div id="right">
        Register Your Account!
      </div>
    </h1>
    <form action='' method='post' name="register">
      <input type="text" name="name" value="" class="textfield" placeholder="Full Name" required>
      <p></p>
      <input type="email" name="email" value="" class="textfield" placeholder="Email" required>
      <p></p>
      <input type="text" name="username" value="" class="textfield" placeholder="User ID" required>
      <p></p>
      <input type="password" name="password" value="" class="textfield" placeholder="Password" required>
      <p></p>
      <input type="password" name="conpassword" value="" class="textfield" placeholder="Confirm Password" required>
      <p></p>
      <p></p>
      <input type="submit" name="rlogin" value="Register my Account" id="modifybutton">
      <p></p>
      <p class="error">
        <b>
      <?php echo $error;?>
        </b>
      </p>
    </form>
  </body>
</html>
