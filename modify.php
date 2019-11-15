<?php
require 'connection.php';
session_start();
$newamount = 0;
$checkacc = $_SESSION['accVal'];
$checkmode = $_SESSION['mode'];
$error = '';
if(isset($_POST['withdraw']) || isset($_POST['deposit'])){
  try{
   $amount = $_POST['amount'];
   $getAll = $conn->prepare("SELECT * FROM accounts");
   $getAll->execute();
   for ($i=0; $r = $getAll->fetch(); $i++) {
    if ($r['username'] == $_SESSION['user']) {
      $name = $r['name'];
     }
   }
   $getAll = $conn->prepare("SELECT * FROM balance WHERE name = '$name'");
   $getAll->execute();
   for ($i=0; $r = $getAll->fetch(); $i++) {
       $checking = $r['checking'];
       $savings = $r['savings'];
   }

   switch ($checkacc) {
     case 'check':
       if (isset($_POST['withdraw'])) {
         $checking = $checking - $amount;
         if ($checking < 0) {
           $_SESSION['status'] = 1;
         } else {
           $_SESSION['status'] = 2;
           $getAll = $conn->prepare("UPDATE balance SET checking = '$checking' WHERE name = '$name'");
           $getAll->execute();
           break;
         }
       } else if (isset($_POST['deposit'])) {
         $_SESSION['status'] = 2;
         $checking = $checking + $amount;
         $getAll = $conn->prepare("UPDATE balance SET checking = '$checking' WHERE name = '$name'");
         $getAll->execute();
         break;
       }

    case 'save':
     if (isset($_POST['withdraw'])) {
         $savings = $savings - $amount;
         if ($savings < 0) {
           $_SESSION['status'] = 1;
         } else {
           $_SESSION['status'] = 2;
           $getAll = $conn->prepare("UPDATE balance SET savings = '$savings' WHERE name = '$name'");
           $getAll->execute();
           break;
         }
      } else if (isset($_POST['deposit'])) {
         $_SESSION['status'] = 2;
         $savings = $savings + $amount;
         $getAll = $conn->prepare("UPDATE balance SET savings = '$savings' WHERE name = '$name'");
         $getAll->execute();
         break;
      }
    }
    header("Location: menu.php");
   } catch(PDOException $e){
     echo $sql."<br>".$e->getMessage();
   }
 }

 if (isset($_POST['cancel'])) {
   $_SESSION['status'] = 0;
   header("Location: menu.php");
 }
  $conn=null;
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
<link rel="stylesheet" href="styles.css">
  <head>
    <meta charset="utf-8">
    <title>Clover Financial Bank - <?php echo $checkmode; ?></title>
  </head>
  <body>
    <div id="modify">
    <form action="" method="post">
      <img src="img/logo_transparent.png" alt="Clover Financial Bank Logo" width="250px" height="250px">
    <h2>Please enter the amount you would like to <?php echo $checkmode; ?>?</h2>
    </div>
    <p></p>
    <div id="inputamt">
    <p></p>
    <input type="number" name="amount" value="" step=".01" class="textfield">
    <p></p>
    <input type="submit" <?php if($checkmode == 'Deposit') { echo 'style="display:none"'; } ?> name="withdraw" value="Withdraw Amount" id="modifybutton">
    <input type="submit" <?php if($checkmode == 'Withdraw') { echo 'style="display:none"'; } ?> name="deposit" value="Deposit Amount" id="modifybutton">
    <p></p>
    <input type="submit" name="cancel" value="Cancel" id="modifybutton">
    <p></p>
    </form>
  </div>
  </body>
</html>
