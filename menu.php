<?php
include 'connection.php';
session_start();

if (isset($_SESSION['status'])) {
  $status = $_SESSION['status'];
  $displaytype = '';
}
if ($status == 1) {
  $webstatus = 'You do not have enough money on this account to execute this process, please try again.';
  $_SESSION['status'] = 0;
  $displaytype = 'diserror';
  header("Refresh: 10; url=menu.php");
} else if ($status == 2) {
  $webstatus = 'Your request has been processed!';
  $_SESSION['status'] = 0;
  $displaytype = 'disprocess';
  header("Refresh: 10; url=menu.php");
} else if ($status == 3) {
  $webstatus = 'Your password has been changed!';
  $_SESSION['status'] = 0;
  $displaytype = 'disprocess';
  header("Refresh: 10; url=menu.php");
} else if ($status == 4) {
  $webstatus = 'The amount you have chosen exceeds the limit that our Online Banking service allows, Please try again.';
  $_SESSION['status'] = 0;
  $displaytype = 'diserror';
  header("Refresh: 10; url=menu.php");
} else if ($status == 0) {
  $webstatus = '';
} else {
  $webstatus = '';
}

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
    $discheck= sprintf("%.2f", $checking);
    $dissave = sprintf("%.2f", $savings);
}

if(isset($_POST['logout'])){
session_destroy();
header("Location: index.php");
}
if (isset($_POST['remove']) || isset($_POST['add'])) {
  if (isset($_POST['remove'])) {
    $_SESSION['mode'] = "Withdraw";
  } else if (isset($_POST['add'])) {
    $_SESSION['mode'] = "Deposit";
  } else {
    $_SESSION['mode'] = null;
  }
  if (isset($_POST['acc'])) {
    $_SESSION['accVal'] = $_POST['acc'];
  }
  header("Location: modify.php");
}

  if (isset($_POST['transfer'])) {
    $getAll = $conn->prepare("SELECT * FROM balance WHERE name = '$name'");
    $getAll->execute();
    for ($i=0; $r = $getAll->fetch(); $i++) {
        $checking = $r['checking'];
        $savings = $r['savings'];
    }
    if ($checking == 0 && $savings == 0) {
      $webstatus = 'You do not have enough money on this account to execute this process, please try again.';
      $displaytype = 'diserror';
    } else {
        header("Location: transfer.php");
    }
  }

  if (isset($_POST['changepass'])) {
    header("Location: changepass.php");
  }
?>

 <!DOCTYPE html>
 <html lang="en" dir="ltr">
 <script type="text/javascript">
   // When the user clicks on register, windows will pop up
   function popup(url) {
     popupWindow=window.open(
       url,'popUpWindow','height=300,width=400,scrollbar=yes,toolbar=yes,menubar=no,status=yes'
     )
   }
   //Closes when user submit registration form
   function exit() {
     popupWindow.close();
   }

   function showOpt() {
           document.getElementById("functions").style.display = "block";
   }

   function showFunc() {
       var selmode = document.getElementById("select").value;
       if (selmode == 'check' || selmode == 'save') {
           document.getElementById("options").style.display = "block";
       }
   }
 </script>
   <head>
     <meta charset="utf-8">
     <title>Clover Financial Bank - Menu</title>
   </head>
   <link rel="stylesheet" href="styles.css">
   <body class="index">
     <div id="dismenu">
       <h1>Clover Financial Bank</h1>
       <h5>You are currently logged in as: <?php echo $name; ?></h5>
     </div>

     <p></p>


     <form action="" method="post">
     <p></p>
     <div id="menucontainer">
     <h3>Account Balances</h3>
     <table border="0" align="center">
       <tr>
         <td>Checking:</td>
         <td><?php echo "$ ".$discheck; ?></td>
       </tr>
       <tr>
         <td>Savings:</td>
         <td><?php echo "$ ".$dissave; ?></td>
       </tr>
     </table>
     <p></p>
     <input type="submit" name="transfer" value="Transfer">
     <input type="button" name="transfer" value="Functions" onclick="showOpt()">
     <p></p>
   </div>

   <div id="functions" style="display:none;">
   <p></p>
   <div id="menucontainer">
   <p></p>

   <h3>Banking Functions:</h3>
   <table class="opt" align="center">
     <th>Please select an account: </th>
     <tr>
       <td><select id= "select" name="acc" onchange="showFunc()">
         <option value="" disabled selected>Select an Account</option>
         <option value="check">Checking</option>
         <option value="save">Savings</option>
       </select>
     </td>
     </tr>
   </table>


   <p></p>
   <div id="options" style="display:none;">
     <input type="submit" name="remove" value="Withdraw">
     <input type="submit" name="add" value="Deposit">
   </div>
   <p></p>
   </div>
   <p></p>
   <div id="menucontainer">
     <h3>Account Functions: </h3>
     <p></p>
     <input type="submit" name="changepass" value="Change Password">
     <p></p>
     <input type="submit" name="logout" value="Logout">
     <p></p>
   </div>
   <p></p>
   </form>
   <p></p>
   </div>
   </div>

     <p></p>


    <div id="<?php echo $displaytype ?>">
      <?php echo $webstatus; ?>
    </div>

   </body>
 </html>
