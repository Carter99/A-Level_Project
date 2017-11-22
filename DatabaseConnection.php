<?php 
	$host="localhost";
	$username="root";
	$password="password";
	$db_name="DEATHLIST";
	$con=mysqli_connect($host,$username,$password,$db_name) or die("cannot connect");

	function time_format($seconds){
		$totalHours=floor($seconds/3600);
		$days=floor($totalHours/24);
		$hours=$totalHours-(24*$days);
		$message="";
		if ($days!=0) {
			$message.=$days." day";
			if ($days!=1) {
				$message.="s";
			}
			$message.=", ";
		}

		$message.=$hours." hour";
		if ($hours!=1) {
			$message.="s";
		}
		return $message;
	}
 ?>