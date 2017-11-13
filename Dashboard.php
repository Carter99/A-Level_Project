<?php 
	session_start();
 ?>

<!DOCTYPE html>
<html>
<head>
	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
	<title>User Dashboard</title>
</head>
<link rel="stylesheet" type="text/css" href="TopMenuBar.css" />
<script src="Dynamics.js"></script>

<body onload="changeBackground();">

	<div class="topnav">
	  <a class="active" href="Dashboard.php">Dashboard</a>
	  <a href="LogOut.php">Log Out</a>
	  <p>DEATHLIST.CLUB</p>
	</div>

	<div style="height: 2px; background-color: black;"></div>
	<div style="height: 4px;"></div>

	<div class="ghosts" style="height: 20vh; background-size: 120px;"></div>

	<div style="height: 4px; background-color: black;"></div>

	<div style="background-color: #eee; min-height: 100vh; width: 100vw; position: absolute;">

		<div style="padding-left: 15px; padding-right: 15px;">
			<h1><u>Dashboard</u></h1>
			<?php 
				include("DatabaseConnection.php");

				if(!isset($_SESSION["ID"])){
					echo 'NOT LOGGED IN<br><br>To Log in, please visit the <a href="LogOut.php">Login Page</a>';
				}else{
					$sql="SELECT * FROM `Users` WHERE `ID`=".$_SESSION["ID"];
					$results=mysqli_query($con,$sql);
					$user_info=mysqli_fetch_assoc($results);
					echo "Your user ID is: ".$user_info["ID"];
					echo "<br>Your name is: ".$user_info["Name"];
					echo "<br>Date and time of you joining: ".date("d-m-Y @ g:i a \G\M\T",$user_info["UNIXJoined"]);
					echo "<br>Your Balance, by comparison to when you created your account is: £".money_format("%n", $user_info["Balance"]);
				}
			 ?>
		</div>

		<div style="background-color: lightblue; width: 100px; height: 200px;">
		 	<p>TEST</p>
		</div>
		<p>START OF TEXT<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>END OF TEXT</p>

	</div>

</body>
</html>
