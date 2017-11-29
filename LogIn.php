<?php 
	session_start();
	if(isset($_SESSION["ID"])){
		header("Location:Dashboard.php");
	}
	include("DatabaseConnection.php");

	if($_SERVER["REQUEST_METHOD"]=="POST"){
		$email=htmlspecialchars($_POST["email"],ENT_QUOTES,'UTF-8');
		$password=$_POST["password"];
		if(empty($email)||empty($password)){
			echo '<script language="javascript">alert("Invalid LogIn:\nOne or more of the required fields was left empty...\n\nPlease try again.")</script>';
		}else{
			$sql="SELECT * FROM `Users` WHERE `Email`='".$email."'AND `Password`='".hash("sha512",$password)."'";
			$results=mysqli_query($con,$sql);
			$row=mysqli_fetch_assoc($results);
			if (isset($row['ID'])){
				session_start();
				$_SESSION["ID"]=$row["ID"];
				header("Location: Dashboard.php");
			}else{
				echo '<script language="javascript">alert("Invalid LogIn:\nAt least one of the log in details was incorrect...\n\nPlease try again.")</script>';
			}
		}
	}
 ?>

<!DOCTYPE html>
<html>
<head>
	<link href="https://fonts.googleapis.com/css?family=Roboto:300" rel="stylesheet">
	<title>Log In</title>
</head>
<link rel="stylesheet" type="text/css" href="TopMenuBar.css" />
<script src="Dynamics.js"></script>

<body class="splash" onload="changeBackground();">

	<div class="topnav">
	  <a href="About.php">About</a>
	  <a class="active" href="LogIn.php">Log in</a>
	  <a href="SignUp.php">Sign Up</a>
	  <p>DEATHLIST.CLUB</p>
	</div>

	<div style="height: 2px; background-color: black;"></div>
	<div style="height: 4px;"></div>

	<div class="ghosts" style="height: 100vh;">
		<div class="centre border" style="width: 310px; height: 260px;">
			<div class="centre internal" style="width: 300px; height: 250px;">
				<h1 style="text-align: center;">Log In Page</h1>
				<form method="POST" style="text-align: center;">
					Email:<br>
					<input type="text" name="email" placeholder="joe@blogs.com"><br>
					<br>
					Password:<br>
					<input type="password" name="password"><br>
					<br>
					<button>log in</button>
				</form>
			</div>
		</div>
	</div>
</body>
</html>