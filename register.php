<?php
try{
if (isset($_POST["Register"])&&$_POST["Register"]==="Register")
{
	if(isset($_POST["Username"])&&isset($_POST["Password"]))
	{
		if(strlen($_POST["Password"])<9)
		{
			session_start();
			$_SESSION["er"]="Please chose a stronger password - at least 9 characters";
			header("Location:register.php");
		}
		else
		{
			$letters = str_split($_POST["Password"]);
			$result  = 1;
			$previous = '';
			foreach($letters as $letter)
			{
				if($letter === $previous) $result++;
				else $result=1;
			    $previous = $letter;
			}
			if($result>2)
			{
				session_start();
				$_SESSION["er"]="Please chose a stronger password - try not to repeat characters";
				header("Location:register.php");				
			}
			else
			{
				$pass=sha1($_POST["Password"]);
			}
		}
		require 'conn.php';

		$sql_sel = "SELECT * FROM u WHERE N=:X";
		$stmt = $conn->prepare($sql_sel);
		$stmt->execute(array(
			':X' => $_POST["Username"],
		));
		$row = $stmt->fetch(PDO::FETCH_ASSOC);
		if($row)
		{
			session_start();
			$_SESSION["er"]="name is already taken";
			header("Location:register.php");
		}
		else
		{
		$sql_ins = "INSERT INTO u (N,P) VALUES (:X,:Y)";
		$stmt=$conn->prepare($sql_ins);
		$stmt->execute(array(
			':X' => $_POST["Username"],
			':Y' => $pass
		));

		session_start();
		$_SESSION["msg"]="You have been registered successfully, you can login now";
		header("Location:login.php");
		}
	}
	else
	{
		session_start();
		$_SESSION["er"]="please fill all the fields";
		header("Location:register.php");
	}
}

elseif (isset($_GET)) {
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Registration</title>
	<link rel="stylesheet" href="style.css">
	<!-- jQuery library -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<!-- Latest compiled JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body >
	<div class="body_div">
		<h1 class="head" style="margin-bottom: 10%;">This Is Your Registration Page</h1>
		<a href="index.php" class="nav_link">Back</a>

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
		<form method="post">
			<label>Username: <input type="text" name="Username" placeholder="Username" autofocus></label>
			<div style="width: 100%">
				<p>The only hard requirement is for the password to have a minimum length of 9 characters.  We recommend that you come up with something secure and memorable, such as a phrase that means something to you but not easily guessed by someone else.  It could be your favorite line from a song, or your favorite passage from a religious text, or your favorite quote from a book you loved in high school.  It could also be a series of random words you’re likely to remember, such as what’s shown <a href="https://xkcd.com/936/">here</a>.<br>
				For more ideas on how to come up with secure and usable passwords, check out <a href="https://www.baekdal.com/trends/password-security-usability">this article</a>!</p>
				<label>Password: <input type="Password" name="Password" minlength="9"></label>		
			</div>
			<input type="submit" name="Register" value="Register" class="botton">
		</form>
	</div>
</body>
</html>
<?php } 
}
catch (Exception $ex) {
	echo ("internal error, please contact support");
	error_log("page_name, SQL error=" . $ex->getMessage());
	return;
}
?>