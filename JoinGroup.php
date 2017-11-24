<?php 
	session_start();
	if(!isset($_SESSION["ID"])){
		header("Location:LogIn.php");
	}
	include("DatabaseConnection.php");
?>

<!DOCTYPE html>
<html>
<head>
	<link href="https://fonts.googleapis.com/css?family=Roboto:300,700" rel="stylesheet">
	<title>Join Group</title>
</head>
<link rel="stylesheet" type="text/css" href="TopMenuBar.css" />
<script src="Dynamics.js"></script>

<body onload="changeBackground();">

	<div class="topnav">
	  <a href="Dashboard.php">Dashboard</a>
	  <a class="active" href="JoinGroup.php">Join Group</a>
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
			<h1><u>Join Group</u></h1>
			<table>
				<tr>
					<td style="font-size: 20px; text-align: center;" colspan="5">Please Select Any Groups To Join</td>
				</tr>
				<tr>
					<th>Group Name</th>
					<th>Number of Members</th>
					<th>Cycle Duration</th>
					<th>Input per Cycle</th>
					<th>Join?</th>
				</tr>
				<?php
					if($_SERVER["REQUEST_METHOD"]=="POST"){
						$joining=$_POST["Joining"];
						$user=$_SESSION["ID"];

						$sql="SELECT * FROM `Memberships` WHERE `GroupID`=".$joining." AND `UserID`=".$user;
						$results=mysqli_query($con,$sql);
						$row=mysqli_fetch_assoc($results);
						if (!isset($row['GroupID'])){
							$sql="INSERT INTO `Memberships` VALUES ('$joining','$user')";
							if(!mysqli_query($con,$sql)){
								echo '<script language="javascript">alert("An error occured, please try again...")</script>';
							}
						}
					}

					$sql="SELECT * FROM `Groups`";
			 		$results=mysqli_query($con,$sql);
					while ($row=mysqli_fetch_assoc($results)) {
						$sql2="SELECT * FROM `Memberships` WHERE `GroupID`=".$row["ID"];
						$results2=mysqli_query($con,$sql2);
						$value=mysqli_num_rows($results2);
						$inGroup=false;
						while ($row2=mysqli_fetch_assoc($results2)) {
							if ($row2["UserID"]==$_SESSION["ID"]) {
								$inGroup=true;
								break;
							}
						}


						echo "<tr>
						<td>".htmlspecialchars($row["Name"],ENT_QUOTES,'UTF-8')."</td>
						<td>".$value."</td>
						<td>".time_format($row["CycleDuration"])."</td>
						<td>£".money_format("%n",$row["CycleInput"])."</td>
						<td>";
						if ($inGroup) {
							echo "Already a member";
						}else{
							echo "
								<form method='POST'>
									<input type='hidden' name='Joining' value='".$row["ID"]."'>
									<button style='width:100%;'>click to join</button>
								</form>";
							}
						echo "
						</td>
						</tr>";
					}
				?>
			</table>

		</div>

	</div>

</body>
</html>
