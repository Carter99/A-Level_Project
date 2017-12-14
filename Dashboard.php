<?php 
	session_start();
	include("DatabaseConnection.php");
	date_default_timezone_set('UTC');
	if(!isset($_SESSION["ID"])){
		header("Location:LogIn.php");
	}
 ?>

<!DOCTYPE html>
<html>
<head>
	<link href="https://fonts.googleapis.com/css?family=Roboto:300,700" rel="stylesheet">
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
				$sql="SELECT * FROM `Users` WHERE `ID`=".$_SESSION["ID"];
				$results=mysqli_query($con,$sql);
				$user_info=mysqli_fetch_assoc($results);
				echo "Your user ID is: ".$user_info["ID"];
				echo "<br>Your name is: ".$user_info["Name"];
				echo "<br>Date and time of you joining: ".date("d-m-Y @ g:i a",$user_info["UNIXJoined"]);
				echo "<br>Your Balance, by comparison to when you created your account is: £".money_format("%n", $user_info["Balance"]);

				$sql="SELECT * FROM `Memberships` WHERE `UserID`=".$_SESSION["ID"];
			 	$results=mysqli_query($con,$sql);
			 ?>
			 <table>
			 	<tr>
			 		<td style="font-size: 20px; text-align: center;" colspan="5">My Groups (<?php echo(mysqli_num_rows($results))?> Active)</td>
			 	</tr>
			 	<tr>
			 		<th>Group Name</th>
			 		<th>Time Since Last Death</th>
			 		<th>Potential Loss</th>
			 		<th>Potential Win</th>
			 		<th>Jump to Group</th>
			 	</tr>
			 	<?php
					while ($row=mysqli_fetch_assoc($results)) {
						$sql2="SELECT * FROM `Groups` WHERE `ID`=".$row["GroupID"];
						$results2=mysqli_query($con,$sql2);
						$groupInfo=mysqli_fetch_assoc($results2);
						
						$lastDeathSeconds=time()-$groupInfo["LastDeath"];
						$lastDeath=time_format($lastDeathSeconds);
						$cyclesSinceDeath=floor($lastDeathSeconds/$groupInfo["CycleDuration"]);
						$singlePerson=$cyclesSinceDeath*$groupInfo['CycleInput'];

						$sql3="SELECT * FROM `Memberships` WHERE `GroupID`=".$row["GroupID"];
						$results3=mysqli_query($con,$sql3);
						$peopleInGroup=mysqli_num_rows($results3)-1;

						$testLink="GroupPage.php?Group=".$row["GroupID"];

						echo "
						<tr>
							<td>
								".htmlspecialchars($groupInfo["Name"],ENT_QUOTES,'UTF-8')."
							</td>
							<td>
								".$lastDeath."
							</td>
							<td>
								£".money_format("%n",$singlePerson)."
							</td>
							<td>
								£".money_format("%n",$peopleInGroup*$singlePerson)."
							</td>
							<td>
								<button style='width:100%;' onclick='location.href=\"$testLink\";' >click to jump</button>
							</td>
						</tr>";
					}
			 	?>
			 </table>
			 <br>
			 <hr>
			 <h3>Events</h3>
			 <?php
			 	
			 ?>
		</div>

	</div>

</body>
</html>
