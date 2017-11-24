<!DOCTYPE html>
<html>
	<head>
		<title>stuff</title>
		<style>
			table, th, td {
			    border: 1px solid black;
			}
		</style>

	</head>
	<body>
		<table>
			<tr>
				<th>ID</th>
				<th>Name</th>
				<th>Joined Timestamp</th>
				<th>Email</th>
				<th>Password</th>
				<th>Balance</th>
			</tr>
			<?php 
				include("DatabaseConnection.php");
				$sql="SELECT * FROM `Users`";
				$results=mysqli_query($con,$sql);
				while ($row=mysqli_fetch_assoc($results)) {
					echo "<tr>
					<td>".htmlspecialchars($row["ID"],ENT_QUOTES,'UTF-8')."</td>
					<td>".htmlspecialchars($row["Name"],ENT_QUOTES,'UTF-8')."</td>
					<td>".htmlspecialchars($row["UNIXJoined"],ENT_QUOTES,'UTF-8')."</td>
					<td>".htmlspecialchars($row["Email"],ENT_QUOTES,'UTF-8')."</td>
					<td>".htmlspecialchars($row["Password"],ENT_QUOTES,'UTF-8')."</td>
					<td>£".htmlspecialchars($row["Balance"],ENT_QUOTES,'UTF-8')."</td></tr>";
				}
				echo "Hello World:<br>";
				echo hash("sha256","test");
				echo "<br>";
				echo hash("sha512","12345678");
				echo "<br>";
				$t=time();
				echo($t . "<br>");

				date_default_timezone_set('UTC');
				echo(date("d-m-Y @ g:i a",$t));
				echo "<br>";
				echo (phpversion());
			 ?>

		 </table>
	</body>
</html>