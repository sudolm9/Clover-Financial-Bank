<?php
require '../connection.php';
session_start();
$getAll = $conn->prepare("SELECT * FROM admin");
$getAll->execute();
for ($i=0; $r = $getAll->fetch(); $i++) {
 if ($r['username'] == $_SESSION['user']) {
   $name = $r['name'];
  }
}

if (isset($_POST['unblock'])) {
  header("Location: adunblock.php");
}
if (isset($_POST['manage'])) {
  header("Location: AccountManagement/admanage.php");
}
if (isset($_POST['view'])) {
  header("Location: DisplayUsers/adview.php");
}
if (isset($_POST['register'])) {
  header("Location: registerAdmin.php");
}


?>

 <!DOCTYPE html>
 <html lang="en" dir="ltr">
 <script>
 </script>
 <link rel="stylesheet" href="menu.css">
 <body>
   <h1 id="container">
     <div id="left">
       <img src="../img/logo_transparent.png" alt="Clover Financial Bank Logo" width="100px" height="100px" class="main">
     </div>
     <div id="right">
       Welcome <p class="ani"><?php echo $name;?></p>Admin Portal!
     </div>
   </h1>
   <div id="login">
     <form action = "" method="post">
       <td><input type="submit" name="manage" value="Account Management" class="index"></td>
       <p></p>
       <td><input type="submit" name="view" value="Display Users" class="index"></td>
       <p></p>
       <td><input type="submit" name="register" value="Register" class="index"></td>
       <p></p>
       <td><input type="submit" name="logout" value="Logout"  class="index"<?php if (isset($_POST['logout'])) { session_destroy();?> onclick="javascript:self.close()"; <?php } ?>>
     </form>
     <p></p>
   </div>
 </body>
</html>
