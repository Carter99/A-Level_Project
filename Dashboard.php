<?php 
	session_start();
	include("DatabaseConnection.php");
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
	  <a href="JoinGroup.php">Join Group</a>
	  <a href="CreateGroup.php">Create Group</a>
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
				if(!isset($_SESSION["ID"])){
					header("Location:~LogIn.php");
					echo 'NOT LOGGED IN<br><br>To Log in, please visit the <a href="LogOut.php">Login Page</a>';
				}else{
					$sql="SELECT * FROM `Users` WHERE `ID`=".$_SESSION["ID"];
					$results=mysqli_query($con,$sql);
					$user_info=mysqli_fetch_assoc($results);
					echo "Your user ID is: ".$user_info["ID"];
					echo "<br>Your name is: ".$user_info["Name"];
					date_default_timezone_set('UTC');
					echo "<br>Date and time of you joining: ".date("d-m-Y @ g:i a",$user_info["UNIXJoined"]);
					echo "<br>Your Balance, by comparison to when you created your account is: £".money_format("%n", $user_info["Balance"]);
				}
			 ?>
			 <table>
			 	<tr>
			 		<th>Groups</th>
			 	</tr>
			 	<?php
			 		$sql="SELECT * FROM `Memberships` WHERE `UserID`=".$_SESSION["ID"];
			 		$results=mysqli_query($con,$sql);
					while ($row=mysqli_fetch_assoc($results)) {
						echo "<tr><td>".htmlspecialchars($row["UserID"],ENT_QUOTES,'UTF-8')."</td></tr>";
					}
			 	?>
			 	<tr><td>Create New Group</td></tr>
			 	<tr><td>Join Existing Group</td></tr>
			 </table>

			 <p>START OF TEXT<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>END OF TEXT</p>

		</div>

	</div>

</body>
</html>
