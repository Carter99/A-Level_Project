<?php 
	session_start();
	if(isset($_SESSION["ID"])){
		header("Location:Dashboard.php");
	}
 ?>

<!DOCTYPE html>
<html>
<head>
	<link href="https://fonts.googleapis.com/css?family=Roboto:300" rel="stylesheet">
	<title>About</title>
</head>
<link rel="stylesheet" type="text/css" href="TopMenuBar.css" />
<script src="Dynamics.js"></script>

<body class="splash" onload="changeBackground();">

	<div class="topnav">
	  <a class="active" href="About.php">About</a>
	  <a href="LogIn.php">Log in</a>
	  <a href="SignUp.php">Sign Up</a>
	  <p>DEATHLIST.CLUB</p>
	</div>

	<div style="height: 2px; background-color: black;"></div>
	<div style="height: 4px;"></div>

	<div class="ghosts" style="height: 100vh;">
		<div class="centre border" style="width: 660px; height: 530px;">
			<div class="centre internal" style="width: 650px; height: 520px; overflow-y: scroll">
				<h1><center>About</center></h1>
				<p style="font-size: 17px; text-align: justify; padding: 10px;">My parents and family friends run what is effectively a deadpool amongst themselves. They select someone famous (who is still alive) and add them to a list that people keep a collective and individual record of… Each list has a maximum number of 5 people on it at any one time and can only add someone new when one of the people already on their list dies… For every week that passes each person adds 50p into a “pot” and when someone on someone’s list dies the respective person receives the entirety of the pot (in reality they just keep track of the dates when the previous person dies and pays out to the person accordingly). 
				<br>Currently they merely use paper for keeping track of the lists and a WhatsApp group chat alongside a Messenger chat, not to mention dozens of direct messages for communicating to each other… Although this has its drawbacks, for instance, not everyone keeps a log of who people have on their lists or neglects to update their list and hence when it comes round to the next death there can be conflicting data in regards to if someone has the respective deceased on their list or not… Often this is sorted within a day or so, although still generates unnecessary confusion and paperwork.
				<br>This chaotic situation spawned the creation of this site...
				<br><br>Enjoy your visit.</p>
			</div>
		</div>
	</div>

</body>
</html>
