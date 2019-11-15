<?php
 require 'connection.php';
 session_start();
 $error = '';
 $displaycounter = '';
 $displayattempts = '';
 $resetlogcount = 4;
 $holder = '';
 $checkatp = '';
 $errortype = '';
 $name = '';
 $checkusername = '';
 function genpassword( $length = 6 ) {
     $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456";
     $randompass = substr(str_shuffle($chars), 0, $length );
     return $randompass;
 }

 if(isset($_POST['slogin'])){
     $vuser = $_POST['user'];
     $vpass = $_POST['pwd'];
     try {
       $getAll = $conn->prepare("SELECT COUNT(*) FROM accounts WHERE username = '$vuser' AND password = '$vpass'");
       $getAll->execute();
       $c = $getAll->fetchColumn();
     } catch (\Exception $e) {
       $error = "Error: " . $e;
     }

     $getAll = $conn->prepare("SELECT * FROM accounts WHERE username = '$vuser'");
     $getAll->execute();
     for($i=0; $view=$getAll->fetch();$i++){
       $checkusername=$view['username'];
     }

     if ($c == 1) {
        $_SESSION['user'] = $vuser;
        $conn->exec("UPDATE accounts SET logcounter = '$resetlogcount' WHERE username = '$vuser'");
       header("Location: menu.php");
     } else if ($vuser == '' || $vpass == '') {
         $error = "Enter a Username/Password!";
     } else {
         $error = "Please enter in valid credentials, you must correctly login to view the contents of this website!";
         if ($checkusername == '' ) {
           $errortype = '404';
         } else {
           $errortype = 'failed';
         }
     }

     if ($errortype == '404') {
        $error = "This account does not exist or you are entering the incorrect credentials, please try again or register your account.";
     }

     if ($errortype == 'failed') {
       $getAll = $conn->prepare("SELECT logcounter FROM accounts WHERE username = '$vuser'");
       $getAll->execute();
       for ($i=0; $g = $getAll->fetch(); $i++) {
         $_SESSION['logcount'] = $g['logcounter'];
         $holder = $_SESSION['logcount'];
       }
       $holder--;
       $conn->exec("UPDATE accounts SET logcounter = '$holder' WHERE username = '$vuser'");

       $getAll = $conn->prepare("SELECT logcounter FROM accounts WHERE username = '$vuser'");
       $getAll->execute();
       for ($i=0; $g = $getAll->fetch(); $i++) {
         $checkatp = $g['logcounter'];
       }
       $displaycounter = 'You have ' . $checkatp . ' login attempts left.';

       if ($checkatp < 0) {
          $error = 'Your account has been blocked due to exceeding login attempt limit, contact an administrator.';
          $displaycounter = '';
       }

       if ($checkatp == 0) {
         $blockuser = genpassword(6);
         $error = "Your account has been blocked, please contact an admin for a password reset.";
         $conn->exec("UPDATE accounts SET password = '$blockuser' WHERE username = '$vuser'");
         $displaycounter = '';
       }
       header("Refresh: 15; url=index.php");
       session_destroy();
     }
   }
?>

<!DOCTYPE html>
<html>
  <script type="text/javascript">
    // When the user clicks on register, windows will pop up
    function popup(url) {
      popupWindow=window.open(
        url,'popUpWindow','height=600,width=600,scrollbar=yes,toolbar=yes,menubar=no,status=yes'
      )
    }
    function popupAdmin(url) {
      popupWindow=window.open(
        url,'popUpWindow','height=600,width=600,scrollbar=yes,toolbar=yes,menubar=no,status=yes'
      )
    }

    //Closes when user submit registration form
    function exit() {
      popupWindow.close();
    }
  </script>
  <head>
    <title>Clover Financial Bank - Login</title>
    <meta charset="utf-8">
  </head>
  <link rel="stylesheet" href="styles.css">
  <img src="img/logo_transparent.png" alt="Clover Financial Bank Logo" width="250px" height="250px" class="index">
  <body class="index">
    <div id="login">
    <form action = "" method="post" class="">
        <p></p>
        <input type="text" name="user" class="textfield" placeholder="Username" autofocus>
        <p></p>
        <input type="password" placeholder="Password" name="pwd" class="textfield">
       <p></p>
      <input type="submit" name="slogin" value="Login" class="index">
      <p></p>
      <button type="button" value="Register!" class="index">
        <a class="index" href="JavaSCript:popup('register.php');">Register
      </a></button>
      <p></p>
      <button type="button" value="Admin" class="index">
        <a class="index" href="JavaSCript:popupAdmin('admin/admin.php');">Administrator
      </a></button>
    </form>
    <p></p>
    </div>

    <p></p>
    <?php if ($error != '') {?>
    <div id="diserror">
      <?php echo $error; ?>
      <p></p>
      <?php echo $displaycounter; ?>
    </div>
    <?php }?>
    <p></p>
  </body>
</html>
