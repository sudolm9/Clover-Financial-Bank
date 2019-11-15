<?php
	require '../../connection.php';
	session_start();
	$check = 'false';
	$name = '';
	$user = '';
	$failedlogs = '';
	if (isset($_POST['search'])) {
		$user = $_POST['searchuser'];
		$username = '';
	 	$getAll = $conn->prepare("SELECT * FROM accounts WHERE username = '$user'");
    $getAll->execute();

		for($i=0; $view=$getAll->fetch();$i++){
			$name=$view['name'];
			$username=$view['username'];
			$_SESSION['user'] = $username;
			$failedlogs = $view['logcounter'];
		}

		if ($username == '') {
			$check = '404';
		} else {
			$check='true';
		}

		if ($failedlogs < 0) {
			$failedlogs = ($failedlogs + 4) * -1;
		}
	}

	function genpassword( $length = 6 ) {
   	    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456";
    	$randompass = substr(str_shuffle($chars), 0, $length );
    	return $randompass;
	}

	if (isset($_POST['resetuserpass'])) {
		$assignuser = $_SESSION['user'];
		$setnewpass = genpassword(6);
		$conn->exec("UPDATE accounts SET password = '$setnewpass' WHERE username = '$assignuser'");
		$conn->exec("UPDATE accounts SET logcounter = '4' WHERE username = '$assignuser'");
		$check = 'changeprocessed';
	}
?>



<!DOCTYPE html>
<html>
	<script type="text/javascript">
		 function addorder(name, price){
						 alert(name + ' : ' + price);
		 }
	</script>
	<head>
		<title>Account Management - Unblock User</title>
	</head>
	<link rel="stylesheet" href="manage.css">
	<body>
		<h1 id="container">
      <div id="left">
        <img src="../../img/logo_transparent.png" alt="Clover Financial Bank Logo" width="100px" height="100px" class="index">
      </div>
      <div id="right">
        Unblock User Portal
      </div>
    </h1>
		<div id="login">
			<p></p>
		<form action="" method="post">
			<input type="text" name="searchuser" value="" required="" class="textfield" placeholder ="Search User" autofocus>
			<p></p>
			<input type="submit" name="search" value="Search" class="search">
		</form>
		<p></p>
		<?php if($check == '404'){?>
		<p class="error">This account does not exist on this database. Please try again.</p>
		<?php }?>
		<p></p>
		</div>
		<p></p>
		<?php if($check == 'true'){?>
		<div id="discont">
			<p></p>
		<button class="output" type="button" name="function" value="Options" style="color:black;" disabled>
			<table border="0">
				<tr>
					<td style="text-align:left;">Name: </td>
					<td style="color:navy;"><?php echo $name ?></td>
				</tr>
				<tr>
					<td style="text-align:left;">UserID: </td>
					<td style="color:navy;"><?php echo $username ?></td>
				</tr>
				<tr>
					<td style="text-align:left;">LogCount:</td>
					<td style="color:navy;"><?php echo $failedlogs ?></td>
				</tr>
			</table>
		</button>
<p style="color:red;"><strong>Is this the account you wish to unblock?</strong></p>
<p></p>
<form method="post">
<input type="submit" name="resetuserpass" value="Yes" class="search">
<input type="submit" name "cancel" value="No" class="search">
<p></p>
</form>
</div>
<?php }?>
<?php if($check == 'changeprocessed'){?>
	<div id="discont">
<p>User: <?php echo $assignuser ?> has been changed to <b style="color:red;"><?php echo $setnewpass ?></b>.</p>
</div>
<?php }?>

<p></p>
<form action="admanage.php" method="post">
	<input type="submit" name="menu" value="Cancel" class="search">
</form>
</body>
</form>
</html>
