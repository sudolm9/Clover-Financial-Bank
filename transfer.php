<?php
require 'connection.php';
session_start();
$amterror = '';
$error = '';
if (isset($_POST['transfer'])) {
  $compare1 = $_POST['from'];
  $compare2 = $_POST['to'];
  $amount = $_POST['amt'];
  $checkstr = strlen($amount);
  $rollbackcheck = 0;
  $transamt = 0;
  $processstat = '';
  $checkchecking = 0;

  try {
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
  } catch (Exception $e) {
    echo "Error! " . $e;
  }

  if ($checkstr >= 7) {
    $_SESSION['status'] = 4;
  } else if ($compare1=='checking') {
    $transamt = $checking - $amount;
    $savings = $savings + $amount;
    $checking = $transamt;
    $getAll = $conn->prepare("UPDATE balance SET checking = '$checking' WHERE name = '$name'");
    $getAll->execute();
    $getAll = $conn->prepare("UPDATE balance SET savings = '$savings' WHERE name = '$name'");
    $getAll->execute();

    $processstat = 'true';
    if ($processstat == 'true') {
      $getAll = $conn->prepare("SELECT checking FROM balance WHERE name = '$name'");
      $getAll->execute();
      for ($i=0; $r = $getAll->fetch(); $i++) {
          $verifychecking = $r['checking'];
      }
      if ($verifychecking < 0) {
        $rollbackcheck = $verifychecking + $amount;
        $rollbacksave = $savings - $amount;

        $getAll = $conn->prepare("UPDATE balance SET checking = '$rollbackcheck' WHERE name = '$name'");
        $getAll->execute();
        $getAll = $conn->prepare("UPDATE balance SET savings = '$rollbacksave' WHERE name = '$name'");
        $getAll->execute();
        $_SESSION['status'] = 1;
      } else {
        $_SESSION['status'] = 2;
      }
  }
    header("Location: menu.php");
  } else if ($compare1 == 'savings') {
    $transamt = $savings - $amount;
    $checking = $checking + $amount;
    $savings = $transamt;
    $getAll = $conn->prepare("UPDATE balance SET checking = '$checking' WHERE name = '$name'");
    $getAll->execute();
    $getAll = $conn->prepare("UPDATE balance SET savings = '$savings' WHERE name = '$name'");
    $getAll->execute();

    $processstat = 'true';
    if ($processstat == 'true') {
      $getAll = $conn->prepare("SELECT savings FROM balance WHERE name = '$name'");
      $getAll->execute();
      for ($i=0; $r = $getAll->fetch(); $i++) {
          $verifysavings= $r['savings'];
      }
      if ($verifysavings < 0) {
        $rollbacksave = $verifysavings + $amount;
        $rollbackcheck = $checking - $amount;
        $getAll = $conn->prepare("UPDATE balance SET savings = '$rollbacksave' WHERE name = '$name'");
        $getAll->execute();
        $getAll = $conn->prepare("UPDATE balance SET checking = '$rollbackcheck' WHERE name = '$name'");
        $getAll->execute();
        $_SESSION['status'] = 1;
      } else {
        $_SESSION['status'] = 2;
      }
  } 
  } 
    header("Location: menu.php");
  }

if (isset($_POST['cancel'])) {
  $_SESSION['status'] = 0;
  header("Location: menu.php");
}
?>

 <!DOCTYPE html>
 <html lang="en" dir="ltr">
<link rel="stylesheet" href="styles.css">
 <script type="text/javascript">
     function showForm() {
         var selmode = document.getElementById("mode").value;
         if (selmode == 'checking') {
             document.getElementById("option1").style.display = "block";
             document.getElementById("option2").style.display = "none";
         }
         if (selmode == 'savings') {
             document.getElementById("option2").style.display = "block";
             document.getElementById("option1").style.display = "none";
         }
         if (selmode == 'null') {
             document.getElementById("option2").style.display = "none";
             document.getElementById("option1").style.display = "none";
         }
     }
 </script>
   <head>
     <meta charset="utf-8">
     <title>Clover Financial Bank - Transfering Funds</title>
   </head>
   <img src="img/logo_transparent.png" alt="Clover Financial Bank Logo" width="250px" height="250px" class="index">
   <body>
   <form action="" method="post">
     <div id="menucontainer">
     <h3>Select the Account to Transfer Funds from:</h3>
     <select id="mode" onchange="showForm()" name="from">
        <option value="null" disabled selected>--Select Option--</option>
        <option value="checking">Checking</option>
        <option value="savings">Savings</option>
     </select>
     <p></p>
    <div id="option1" style="display:none">
        <h3>Select the Account to Transfer Funds to:</h3>
            <select id="opts" onchange="showForm()" name="to">
                <option value="null" disabled selected>--Select Option--</option>
                <option value="checking" style="display: none">Checking</option>
                <option value="savings" selected>Savings</option>
            </select>
            <p></p>
    </div>
    <div id="option2" style="display:none">
      <h3>Please select the account you would like to transfer to:</h3>
            <select id="opts" onchange="showForm()" name="to">
                <option value="null" disabled selected>--Select Option--</option>
                <option value="checking" selected>Checking</option>
                <option value="savings" style="display: none;">Savings</option>
            </select>
            <p></p>
    </div>
    </div>
     <p></p>
     <div id="inputamt">
       <p></p>
     <input type="number" name="amt" value="" step=".01" maxlength="6" class="textfield">
     <p></p>
     <input type="submit" name="transfer" value="Transfer Funds" id="modifybutton">
     <p></p>
     <input type="submit" name="cancel" value="Cancel" id="modifybutton">
     <p></p>
     </form>
     </div>
     <p></p>
     <div id="diserror">     
      <?php echo $error;?>
    </div>
   </body>
 </html>
