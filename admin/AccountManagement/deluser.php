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

	if (isset($_POST['deleteuser'])) {
		$assignuser = $_SESSION['user'];
		$conn->exec("DELETE FROM accounts WHERE username = '$assignuser'");
    $check='deleted';
	}
?>



<!DOCTYPE html>
<html>
	<script type="text/javascript">
		 function addorder(name, price){
						 alert(name + ' : ' + price);
		 }
	</script>
  <style>
  a {
    color:black !important;
    text-decoration: none;
  }
  </style>
	<link rel="stylesheet" href="manage.css">
	<head>
		<title>Account Management - Delete User</title>
	</head>
	<body>
		<h1 id="container">
      <div id="left">
        <img src="../../img/logo_transparent.png" alt="Clover Financial Bank Logo" width="100px" height="100px" class="index">
      </div>
      <div id="right">
        Terminate User Portal
      </div>
    </h1>
		<div id="login">
			<p></p>
		<form action="" method="post">
					<input type="text" name="searchuser" value="" class="textfield" placeholder="Search User" required autofocus>
					<p></p>
					<input type="submit" name="search" value="Search" class="search">
		</form>
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
				</table>
			</button>
			<p style="color:red;"><strong>Is this the user's account you wish to terminate?</strong></p>
<p></p>
<form method="post">
<input type="submit" name="deleteuser" value="Yes" class="search">
<input type="submit" name "cancel" value="No" class="search">
</form>
<p></p>
</div>
<?php }?>
<?php if($check == 'deleted'){?>
<div id="discont">
<p></p>
<p style="color:red;"><strong>User: <b style="color:red;"><?php echo $assignuser ?></b> has been deleted from the server.</strong></p>
<?php session_destroy(); ?>
<button type='button' id="A" class="index">
  <a href="../admin.php">Restart the session</a>
</button>
<p></p>
</div>
<?php }?>
<p></p>
<form action="admanage.php" method="post">
	<input type="submit" name="menu" value="Cancel" class="search">
</form>
</body>
</form>
</html>
