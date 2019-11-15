<?php
 require '../connection.php';
 session_start();
 $error = '';
 $attempt=1;
 if(isset($_POST['slogin'])){
   $vuser = $_POST['user'];
   $vpass = $_POST['pwd'];
   $attempt=0;
   try {
     $getAll = $conn->prepare("SELECT COUNT(*) FROM admin WHERE username = '$vuser' AND password = '$vpass'");
     $getAll->execute();
     $c = $getAll->fetchColumn();
   } catch (\Exception $e) {
     $error = "Error: " . $e;
   }
   if ($c == 1) {
     $_SESSION['user'] = $vuser;
     header("Location: admenu.php");
   } else if ($vuser == '' || $vpass == '') {
       $error = "Enter a Username/Password!";
   } else {
       $error = "Please enter in valid credentials, you must correctly login to view the contents of this website!";
       session_destroy();
   }
 }
 /*
 if (isset($_POST['register'])) {
   header("Location: register.php");
 }
 */
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Main Page</title>
    <meta charset="utf-8">
  </head>
  <link rel="stylesheet" href="main.css">
  <body>
    <img src="../img/logo_transparent.png" alt="Clover Financial Bank Logo" width="200px" height="200px" class="main">
    <form action = "" method="post" class="main">
      <h1 class="main">Admin Portal</h1>
      <div id="login">
      <p></p>
      <input type="text" name="user" class="textfield" placeholder="Username" autofocus>
      <p></p>
      <input type="password" name="pwd" class="textfield" placeholder="Password">
      <p></p>
      <input type="submit" name="slogin" value="Login" class="main">
      <p></p>
      <p></p>
      </div>
      <?php if($attempt==1){ ?>
      <p>You must login to view this site.</p>
      <p>If you need to register, please ask to one of our admin</p>
      <?php } ?>
      <p></p>
      <p class="error"><b>
        <?php echo $error; ?>
        <?php echo $status; ?>
      </b>
      </p>
      <p></p>
    </form>
  </body>
</html>
