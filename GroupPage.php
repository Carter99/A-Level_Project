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
					if($_SERVER["REQUEST_METHOD"]=="POST"){
						$selection=$_POST["selection"];
						$position=strpos($selection,"en.wikipedia.org/wiki/");
						if ($position) {
							$position+=22;
							$wikiName=substr($selection,$position);

							$sql="SELECT * FROM `Selection` INNER JOIN `Celebrities` ON `Selection`.`CelebrityID`=`Celebrities`.`ID` WHERE `Selection`.`GroupID`='$group' AND `Celebrities`.`Wiki_Name`='$wikiName'";

							$results=mysqli_query($con,$sql);
							$row=mysqli_fetch_assoc($results);
							if (isset($row['Wiki_Name'])) {
								echo '<script language="javascript">alert("It would appear that this person is, or at least was at some stage, already selected by either you or another member of your group. Please select another person and try again.")</script>';
							}else{
								$sql="SELECT * FROM `Celebrities` WHERE `Wiki_Name`='$wikiName'";
								$results=mysqli_query($con,$sql);
								$row=mysqli_fetch_assoc($results);
								if (!isset($row['Wiki_Name'])) {
									$adjustedName=str_replace("_"," ",$wikiName);
									$sql="INSERT INTO `Celebrities`(`Name`,`Wiki_Name`) VALUES ('$adjustedName','$wikiName')";
									if(!mysqli_query($con,$sql)){
										echo '<script language="javascript">alert("An error occured, please try again...")</script>';
									}
								}
								$sql="SELECT * FROM `Celebrities` WHERE `Wiki_Name`='$wikiName'";
								$results=mysqli_query($con,$sql);
								$row=mysqli_fetch_assoc($results);
								$celebrityID=$row["ID"];
								$time=time();
								$sql = "INSERT INTO `Selection`(`GroupID`, `UserID`, `CelebrityID`, `UnixTime`) VALUES ('$group','$user','$celebrityID','$time')";
								if(!mysqli_query($con,$sql)){
									echo '<script language="javascript">alert("An error occured, please try again...")</script>';
								}
							}


						}else{
							echo '<script language="javascript">alert("An error occured, please ensure that the link contains \"en.wikipedia.org/wiki/\", please try again...")</script>';
						}
					}
					$numOfRows=$groupInfo["MaxSelect"];
					$sql="SELECT `Celebrities`.`Name`, `Selection`.`UnixTime` FROM `Selection` INNER JOIN `Celebrities` ON `Selection`.`CelebrityID`=`Celebrities`.`ID` WHERE `GroupID`='$group' AND `UserID`='$user'";
					$results=mysqli_query($con,$sql);
					while ($row=mysqli_fetch_assoc($results)) {
						$numOfRows-=1;
						echo
						"<tr>
							<td>".$row["Name"]."</td>
							<td>".time_format(time()-$row["UnixTime"])." ago</td>
						</tr>";
					}
					if ($numOfRows>0) {
						$numOfRows-=1;
						echo 
						"<tr>
							<form method='POST'>
								<td><input type='text' name='selection' placeholder='Paste Wikipedia Link Here'></td>
								<td><button style='width:100%;'>click to add</button></td>
							</form>
						</tr>";
					}
					while ($numOfRows>0) {
						$numOfRows-=1;
						echo 
						"<tr>
							<td colspan='2' style='text-align: center'>YET TO BE SELECTED</td>
						</tr>";
					}
					echo "</table>";
					
					$sql = "SELECT `Users`.`ID`, `Users`.`Name` FROM `Users` INNER JOIN `Memberships` ON `Memberships`.`UserID`=`Users`.`ID` WHERE `Memberships`.`GroupID`='$group' AND `Memberships`.`UserID`<>'$user' ORDER BY `Users`.`Name` ASC";
					$results=mysqli_query($con,$sql);
					
					while ($row=mysqli_fetch_assoc($results)) {
						$tmp=$row["ID"];
						echo 
						"<br>
						<table>
							<tr>
								<td style=\"font-size: 20px; text-align: center;\" colspan=\"2\">".$row["Name"]."'s Selection</td>
							</tr>";
						$sql2 = "SELECT `Celebrities`.`Name`, `Selection`.`UnixTime` FROM `Selection` INNER JOIN `Celebrities` ON `Selection`.`CelebrityID`=`Celebrities`.`ID` WHERE `Selection`.`GroupID`=$group AND `Selection`.`UserID`=$tmp";
						$results2=mysqli_query($con,$sql2);
						$numOfRows=$groupInfo["MaxSelect"];
						while ($row2=mysqli_fetch_assoc($results2)) {
							$numOfRows-=1;
							echo
							"<tr>
								<td>".$row2["Name"]."</td>
								<td>".time_format(time()-$row2["UnixTime"])." ago</td>
							</tr>";
						}
						while ($numOfRows>0) {
							$numOfRows-=1;
							echo 
							"<tr>
								<td colspan='2' style='text-align: center'>YET TO BE SELECTED</td>
							</tr>";
						}
						echo "</table>";
					}
				?>
				<br>
			</table>
		</div>

	</div>

</body>
</html>
