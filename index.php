<?php
try{
	session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<title>MASA Messaging Platform</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	<div class="body_div">
		<h1 class="head" style="width: 70%;">MASA Messaging Application</h1>
		<a href="register.php" class="nav_link">Register</a>
		<a href="login.php" class="nav_link">Login</a>
		<br><br>

<?php
	if(isset($_SESSION["er"]))
	{ ?>
		<p style="color: red"> .................. <?=$_SESSION["er"]?> .................. </p>
<?php	unset($_SESSION["er"]);
	}
	if(isset($_SESSION["msg"]))
	{ ?>
		<p style="color: green"> .................. <?=$_SESSION["msg"]?> .................. </p>
<?php	unset($_SESSION["msg"]);
	}
?>
		<br><br>
		<a href="dump.php" class="nav_link" style="width: 80%; display: block; line-height: 300%">Dump DataBase</a>
	</div>
</body>
</html>
<?php
}
catch (Exception $ex) {
	echo ("internal error, please contact support");
	error_log("page_name, SQL error=" . $ex->getMessage());
	return;
}
?>