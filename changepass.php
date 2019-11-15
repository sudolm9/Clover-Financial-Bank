<?php
require 'connection.php';
session_start();
$error = "";
$getusersession = $_SESSION['user'];

if (isset($_POST['goback'])) {
  header("Location: menu.php");
}

if(isset($_POST['change'])){
  try{
    $password=$_POST['password'];
    $authpassword=$_POST['conpassword'];
    $oldpassword =$_POST['oldpassword'];
    $checkoldpass = '';
    //Checks if the information already exists in the database
    $getInfo = $conn->prepare("SELECT password FROM accounts WHERE username = '$getusersession'");
    $getInfo->execute();


    for ($i=0; $check = $getInfo->fetch(); $i++) {
      $checkoldpass = $check['password'];
    }

    if ($authpassword != $password) {
      $error = "Passwords do not match, please try again";
    } else if ($password == '' || $authpassword == '' || $oldpassword == '') {
     $error = 'Please fill in all the fields to proceed.';
   } else if ($oldpassword != $checkoldpass) {
      $error = 'Old Password does not match, please try again.';
    } else {
      $conn->exec("UPDATE accounts SET password = '$authpassword' WHERE username = '$getusersession'");
      $_SESSION['status'] = 3;
      header("Location: menu.php");
    }
  } catch (Exception $e){
    echo "Error!" . $e;
  }
  $conn=null;
}
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Clover Financial Bank - Change Password</title>
  </head>
  <link rel="stylesheet" href="styles.css">
  <body>
    <img src="img/logo_transparent.png" alt="Clover Financial Bank Logo" width="250px" height="250px" class="index">
    <p></p>
    <div id="dismenu">
    <h1>Enter the Following Fields to Change User Password</h1>
    </div>
    <p></p>
    <div id="menucontainer">
    <form action='' method='post' name="register" class="index">
          <input type="password" name="oldpassword" value=""  id="cpassfield" placeholder="Old Password" autofocus>
          <p></p>

          <input type="password" name="password" value=""  id="cpassfield" placeholder="New Password">
          <p></p>

          <td><input type="password" name="conpassword" value="" id="cpassfield" placeholder="Confirm New Password">
      <p></p>
      <input type="submit" name="change" value="Change Password of My Account" id="modifybutton">
      <p></p>
      <input type="submit" name="goback" value="Cancel" id="cancelbutton">
      <p></p>
    </form>
    </div>
    <p></p>
    <div id="diserror">
     <?php echo $error;?>
     </div>
  </body>
</html>
