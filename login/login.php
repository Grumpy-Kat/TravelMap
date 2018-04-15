<?php 
	//start session for login
	session_start();
	//error message
	$error = '';
	if (isset($_POST['submit'])) {
		if (!isset($_POST['username']) || !isset($_POST['password'])) {
			$error = "Username or Password is Invalid!";
		} else {
			//connect to server and select database
			$mysqli = mysqli_connect("localhost", "root", "SonyaAriela1", "travelmap") or die(mysql_error());
			//use mysqli_real_escape_string to clean the input
			$username = mysqli_real_escape_string($mysqli, $_POST['username']);
			$password = mysqli_real_escape_string($mysqli, $_POST['password']);
			//issue query to find user account
			$check_sql = "SELECT username,password,name FROM users WHERE username = '".$username."' AND password = PASSWORD('".$password."')";
			$check_result = mysqli_query($mysqli, $check_sql) or die(mysqli_error($mysqli));
			$rows = mysqli_num_rows($check_result);
			if ($rows == 1) {
				$row = mysqli_fetch_row($check_result);
				$_SESSION['login_user'] = $row[0]; //init session
				$_SESSION['login_name'] = $row[2];
				header("location: ../index.php"); //redirecting to next page
			} else {
				$error = "Username or Password is Invalid!";
			}
			mysqli_close($mysqli); //close connection
		}
	}
?>