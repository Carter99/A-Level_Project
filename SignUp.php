<?php 
	session_start();
	if(isset($_SESSION["ID"])){
		header("Location:Dashboard.php");
	}
	date_default_timezone_set('UTC');
	include("DatabaseConnection.php");
 ?>

<!DOCTYPE html>
<html>
<head>
	<link href="https://fonts.googleapis.com/css?family=Roboto:300" rel="stylesheet">
	<title>SignUp</title>
</head>
<link rel="stylesheet" type="text/css" href="TopMenuBar.css" />
<script src="Dynamics.js"></script>

<body class="splash" onload="changeBackground()">
	
	<div class="topnav">
	  <a href="About.php">About</a>
	  <a href="LogIn.php">Log in</a>
	  <a class="active" href="SignUp.php">Sign Up</a>
	  <p>DEATHLIST.CLUB</p>
	</div>
	
	<div style="height: 2px; background-color: black;"></div>
	<div style="height: 4px;"></div>

	<div class="ghosts" style="height: 100vh;">
		<div class="centre border" style="width: 310px; height: 360px;">
			<div class="centre internal" style="width: 300px; height: 350px;">
				<h1 style="text-align: center;">Sign up Page</h1>
				<form method="POST" style="text-align: center;">
					Name:<br>
					<input type="text" name="Name"><br>
					<br>
					Email:<br>
					<input type="email" name="Email"><br>
					<br>
					Password:<br>
					<input type="password" name="Password"><br>
					<br>
					Confirm Password:<br>
					<input type="password" name="PasswordConfirm"><br>
					<br>
					<button>log in</button>
				</form>
			</div>
		</div>
	</div>

	<?php 
		if($_SERVER["REQUEST_METHOD"]=="POST"){
			$name=htmlspecialchars($_POST["Name"],ENT_QUOTES,'UTF-8');
			$email=htmlspecialchars($_POST["Email"],ENT_QUOTES,'UTF-8');
			$password=htmlspecialchars($_POST["Password"],ENT_QUOTES,'UTF-8');
			$password2=htmlspecialchars($_POST["PasswordConfirm"],ENT_QUOTES,'UTF-8');
			$errorReport="Invalid LogIn:";
			$hasError=false;
			if(empty($name)||empty($email)||empty($password)||empty($password2)){
				$hasError=true;
				$errorReport.="\\nOne or more of the required fields was left empty.";
			}else{
				if (strlen($name)>255){
					$hasError=true;
					$errorReport.="\\nThe name you entered was too long (maximum is 255 characters, you had ".strlen($name).").";
				}
				if (strlen($email)>255){
					$hasError=true;
					$errorReport.="\\nEmail Address was too long (maximum is 255 characters, you had ".strlen($email).").";
				}
				$emailLocation=strpos($email, '@');
				if ($emailLocation==false){
					$hasError=true;
					$errorReport.="\\nEmail address was missing '@' symbol.";
				}else{
					if (strpos($email, '.',$emailLocation)==false||(strlen($email)-$emailLocation)<3){
						$hasError=true;
						$errorReport.="\\nEmail address has invalid domain.";
					}
					if ($emailLocation==0){
						$hasError=true;
						$errorReport.="\\nEmail address has no local component present.";
					}
				}
				$sql="SELECT * FROM `Users` WHERE `Email`='".$email."'";
				$results=mysqli_query($con,$sql);
				$user_info=mysqli_fetch_assoc($results);
				if (isset($user_info['Email'])){
					$hasError=true;
					$errorReport.="\\nEmail already has a corresponding account.";
				}
				if (strlen($password)<8) {
					$hasError=true;
					$errorReport.="\\nPassword is too short (minimum is 8 characters).";
				}
				if ($password!=$password2){
					$hasError=true;
					$errorReport.="\\nThe two passwords that you entered do not match.";
				}
			}
			if ($hasError){
				$errorReport.="\\n\\n Please try again...";
				echo '<script language="javascript">alert("'.$errorReport.'")</script>';
			}else{
				$timestamp=time();
				$hashed=hash("sha512",$password);
				$sql="INSERT INTO `Users`(`Name`, `UNIXJoined`, `Email`, `Password`) VALUES ('$name','$timestamp','$email','$hashed')";
				if(mysqli_query($con,$sql)){
					echo '<script language="javascript">alert("Your data has been added, please log in...");window.location.href = "LogIn.php";</script>';
				}else{
					echo '<script language="javascript">alert("An error occured, please try again...")</script>';
				}

			}
		}
	 ?>




</body>
</html>