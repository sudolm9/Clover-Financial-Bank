<?php
require '../connection.php';
$error = "";
if(isset($_POST['rlogin'])){
  try{
    $name=$_POST['name'];
    $email=$_POST['email'];
    $username=$_POST['username'];
    $password=$_POST['password'];
    $authpassword=$_POST['conpassword'];
    $startingcheck = 0;
    $startingsave = 0;
    //Checks if the information already exists in the database
    try {
      $getInfo = $conn->prepare("SELECT * FROM admin");
      $getInfo->execute();
      for ($i=0; $check = $getInfo->fetch(); $i++) {
        if ($check['username'] == $username || $check['email'] == $email) {
          $regVal = 0;
        } else {
          $regVal = 1;
        }
      }
      }catch (Exception $e){
        echo "Error: " . $e->getMessage();
      }
    } catch (Exception $e){
    echo "Error: " . $e->getMessage();
    }
     if ($authpassword != $password) {
      $error = "Passwords do not match, please try again";
    }
    //Checks regVal to see if the registration will go through or not
    if ($regVal == 0) {
      $error = "This information already exists, please try again!";
    } else if ($regVal == 1 && $authpassword == $password){
      $conn->exec("INSERT INTO admin (name, email, username, password)
      VALUES ('$name','$email','$username','$password')");
      $status = 'Your account has been successfully registered to our database, please attempt to login!';
      header("Location:closeAdmin.php");
     }
  }
  $conn=null;
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <link rel="stylesheet" href="AccountManagement/manage.css">
  <head>
    <meta charset="utf-8">
    <title>Register Admin</title>
  </head>
  <body>
    <h1 id="container">
      <div id="left">
        <img src="../img/logo_transparent.png" alt="Clover Financial Bank Logo" width="100px" height="100px" class="index">
      </div>
      <div id="right">
        Register New Admin
      </div>
    </h1>
    <form action='' method='post' name="register">
      <input type="text" name="name" value="" class="textfield" placeholder="Name" required>
      <p></p>
      <td><input type="email" name="email" value="" class="textfield" placeholder="Email" required>
      <p></p>
      <td><input type="text" name="username" value="" class="textfield" placeholder="UserID" required>
      <p></p>
      <td><input type="password" name="password" value="" class="textfield" placeholder="Password" required>
      <p></p>
      <td><input type="password" name="conpassword" value="" class="textfield" placeholder="Confirm Password" required>
      <p></p>
      <input type="submit" name="rlogin" value="Register Admin Account" class="long">
      <p></p>
      <?php echo $error;?>
    </form>
    <form action="admenu.php" method="post">
    	<input type="submit" name="menu" value="Go back" class="long">
    </form>
  </body>
</html>
