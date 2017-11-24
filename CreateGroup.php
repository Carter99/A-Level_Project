<?php 
	session_start();
	if(!isset($_SESSION["ID"])){
		header("Location:LogIn.php");
	}
	date_default_timezone_set('UTC');
	include("DatabaseConnection.php");
 ?>

<!DOCTYPE html>
<html>
<head>
	<link href="https://fonts.googleapis.com/css?family=Roboto:300,700" rel="stylesheet">
	<title>Group Creator</title>
</head>
<link rel="stylesheet" type="text/css" href="TopMenuBar.css" />
<script src="Dynamics.js"></script>

<body onload="changeBackground();">

	<div class="topnav">
	  <a href="Dashboard.php">Dashboard</a>
	  <a href="JoinGroup.php">Join Group</a>
	  <a class="active" href="CreateGroup.php">Create Group</a>
	  <a href="LogOut.php">Log Out</a>
	  <p>DEATHLIST.CLUB</p>
	</div>

	<div style="height: 2px; background-color: black;"></div>
	<div style="height: 4px;"></div>
	<div class="ghosts" style="height: 20vh; background-size: 120px;"></div>
	<div style="height: 4px; background-color: black;"></div>
	<div style="background-color: #eee; min-height: 100vh; width: 100vw; position: absolute;">

		<div style="padding-left: 15px; padding-right: 15px;">
			<div style="display: inline-block; text-align: center;">
				<h1><u>Create Group</u></h1>
				<form method="POST" style="text-align: center;">
					Group:<br>
					<input type="text" name="Name"><br>
					<br>
					Input per Cycle (£):<br>
					<input type="number" min="0.00" step="0.01" name="Input" placeholder="eg: 0.42"><br>
					<br>
					Cycle Duration (days):<br>
					<input type="number" step="0.25" name="Duration" placeholder="eg: 7"><br>
					<br>
					Max Celebrities:<br>
					<input type="number" min="1" step="1" name="Max" placeholder="eg: 5"><br>
					<br>
					<button>Create Group</button>
				</form>
			</div>

		</div>

	</div>
	<?php 
		if($_SERVER["REQUEST_METHOD"]=="POST"){
			$name=htmlspecialchars($_POST["Name"],ENT_QUOTES,'UTF-8');
			$input=$_POST["Input"];
			$duration=$_POST["Duration"];
			$max=$_POST["Max"];
			$errorReport="Invalid LogIn:";
			$hasError=false;

			if(empty($name)||empty($input)||empty($duration)||empty($max)){
				$hasError=true;
				$errorReport.="\\nOne or more of the required fields was left empty.";
			}else{
				if (strlen($name)>255){
					$hasError=true;
					$errorReport.="\\nThe name you entered was too long (maximum is 255 characters, you had ".strlen($name).").";
				}

				$sql="SELECT * FROM `Groups` WHERE `Name`='".$name."'";
				$results=mysqli_query($con,$sql);
				$info=mysqli_fetch_assoc($results);
				if (isset($info['Name'])){
					$hasError=true;
					$errorReport.="\\nThis name is already in use for an account.";
				}
				
				if ($input<0){
					$hasError=true;
					$errorReport.="\\nThe value input per cycle can not be negative.";
				}
				if ($input>100){
					$hasError=true;
					$errorReport.="\\nThe value input per cycle is too high.";
				}
				if ($duration<0.25){
					$hasError=true;
					$errorReport.="\\nThe cycle duration can not be less than 6 hours.";
				}
				if ($duration>365){
					$hasError=true;
					$errorReport.="\\nThe cycle duration can not be more than 1 year.";
				}
				if (round($max)!=$max) {
					$hasError=true;
					$errorReport.="\\nThe number of celebrites must be an integer.";
				}
				if ($max<1) {
					$hasError=true;
					$errorReport.="\\nThe Number of celebrites needs to be at least 1.";
				}
				if ($max>15) {
					$hasError=true;
					$errorReport.="\\nWoah don't go overboard with the number of people that each person can select, the maximum has been set to 15.";
				}
			}
			if ($hasError){
				$errorReport.="\\n\\n Please try again...";
				echo '<script language="javascript">alert("'.$errorReport.'")</script>';
			}else{
				$timestamp=time();
				$duration*=4;
				$duration=round($duration);
				$duration/=4;
				$duration*=86400;
				$sql="INSERT INTO `Groups`(`Name`, `CycleDuration`, `CycleInput`, `LastDeath`, `MaxSelect`) VALUES ('$name','$duration','$input','$timestamp','$max')";

				if(mysqli_query($con,$sql)){
					$sql="SELECT * FROM `Groups` WHERE `Name`='".$name."'";
					$results=mysqli_query($con,$sql);
					$info=mysqli_fetch_assoc($results);
					$id=$info["ID"];
					$user=$_SESSION["ID"];
					$sql="INSERT INTO `Memberships` VALUES ('$id','$user')";
					if(mysqli_query($con,$sql)){
						echo '<script language="javascript">alert("Your group has been created, and yourself added to it.");window.location.href = "Dashboard.php";</script>';
					}else{
						echo '<script language="javascript">alert("Your group has been created, although there was an issue with joining yourself to said group, please join it manually...");window.location.href = "JoinGroup.php";</script>';
					}
				}else{
					echo '<script language="javascript">alert("An error occured, please try again...")</script>';
				}
			}
		}
	 ?>
</body>
</html>
