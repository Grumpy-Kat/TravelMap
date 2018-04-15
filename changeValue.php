<?php
	//connect to server and select database
	$mysqli = mysqli_connect("localhost", "root", "SonyaAriela1", "travelmap") or die(mysql_error());
	//issue query to find user
	$user_sql = "SELECT id FROM users WHERE username = '".$_GET['user']."'";
	$user_result = mysqli_query($mysqli, $user_sql) or die(mysqli_error($mysqli));
	$row = mysqli_fetch_row($user_result);
	$id = $row[0];
	if($_GET['value'] != "remove"){
		//issue query to change value
		$update_sql = "UPDATE locations SET type='".$_GET['value']."' WHERE user = '".$id."' AND location = '".$_GET['location']."'";
		$update_result = mysqli_query($mysqli, $update_sql) or die(mysqli_error($mysqli));
	} else {
		//issue query to delete value
		$update_sql = "DELETE FROM locations WHERE user = '".$id."' AND location = '".$_GET['location']."'";
		$update_result = mysqli_query($mysqli, $update_sql) or die(mysqli_error($mysqli));
	}
	header("location: displayMap.php?user=".$_GET['user']);
?>