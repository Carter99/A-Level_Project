<?php 
	session_start();
	if(!isset($_SESSION["ID"])){
		header("Location:LogIn.php");
	}
	include("DatabaseConnection.php");
	$group=$_GET["Group"];
	$user=$_SESSION["ID"];
	$sql="SELECT * FROM `Memberships` WHERE `GroupID`=".$group." AND `UserID`=".$user;
	$results=mysqli_query($con,$sql);
	$member=mysqli_num_rows($results);
	if ($member==0){
		header("Location: Dashboard.php");
	}

	$sql2="SELECT * FROM `Groups` WHERE `ID`=".$group;
	$results2=mysqli_query($con,$sql2);
	$groupInfo=mysqli_fetch_assoc($results2);
 ?>

<!DOCTYPE html>
<html>
<head>
	<link href="https://fonts.googleapis.com/css?family=Roboto:300,700" rel="stylesheet">
	<title><?php echo $groupInfo["Name"] ?></title>
</head>
<link rel="stylesheet" type="text/css" href="TopMenuBar.css" />
<script src="Dynamics.js"></script>

<body onload="changeBackground();">

	<div class="topnav">
	  <a href="Dashboard.php">Dashboard</a>
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
			<h1><u><?php echo $groupInfo["Name"] ?></u></h1>
			<table>
				<tr>
			 		<td style="font-size: 20px; text-align: center;" colspan="2">My Selection</td>
			 	</tr>
				<tr>
					<th>Celebrity Name</th>
					<th>Time On List</th>
				</tr>
				<?php
					$numOfRows=$groupInfo["MaxSelect"];
					$sql="SELECT * FROM `Selection` WHERE `GroupID`=".$group." AND `UserID`=".$user;
					$results=mysqli_query($con,$sql);
					while ($row=mysqli_fetch_assoc($results)) {
						$numOfRows-=1;
						echo 
						"<tr>
							<td>".$row["CelebrityID"]."</td>
							<td>".$row["UnixTime"]."</td>
						</tr>"; ## ADD CODE TO DISPLAY THE NAME INFORMATION OF THE CELEBRITY AND TO DISPLAY THE TIME SINCE THE LAST DEATH
					}
					while ($numOfRows>0) {
						$numOfRows-=1;
						echo 
						"<tr>
							<td><input type='text' name='selection'></td>
							<td><button style='width:100%;'>click to add</button></td>
						</tr>";
					}
					## ADD CODE TO DISPLAY THE INFORMATION OF THE OTHER PEOPLE IN THE GROUP 
				?>
			</table>
		</div>

	</div>

</body>
</html>
