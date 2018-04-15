<?php
	include("../includes/menuBar.php");
	$displayBlock = "";
	if($_POST){
		//check for required fields from the form
		if ((!isset($_POST['username'])) || (!isset($_POST['password'])) || (!isset($_POST['name']))) {
			header("Location: signUp.php");
			exit;
		}
		//connect to server and select database
		$mysqli = mysqli_connect("localhost", "root", "SonyaAriela1", "travelmap") or die(mysql_error());
		//use mysqli_real_escape_string to clean the input
		$name = mysqli_real_escape_string($mysqli, $_POST['name']);
		$password = mysqli_real_escape_string($mysqli, $_POST['password']);
		$username = mysqli_real_escape_string($mysqli, $_POST['username']);
		//issue the query
		$check_sql = "SELECT username,password FROM users WHERE username = '".$username."' OR password = PASSWORD('".$password."')";
		$check_result = mysqli_query($mysqli, $check_sql) or die(mysqli_error($mysqli));
		if (mysqli_num_rows($check_result) < 1) {
			//if doesn't exist, create new account
			$insert_sql = "INSERT INTO users(username,password,name) VALUES('".$username."',PASSWORD('".$password."'),'".$name."')";
			$insert_result = mysqli_query($mysqli, $insert_sql) or die(mysqli_error($mysqli));			 
			//start session
			session_start();
			$_SESSION['login_user'] = $username; //init session
			$_SESSION['login_name'] = $name;
			//create display string
			$displayBlock = "<h1 class=\"title\">Sign Up</h1><hr /><p>".$name." is now signed up!</p><hr /><br /><a href=\"../index.php\">Go to home page</a>";
		} else {
			//redirect back to sign up form if username or password already exists
			$displayBlock = "<h1 class=\"title\">Sign Up</h1><hr /><br />";
			$displayBlock .= "<form method=\"post\" action=\"".$_SERVER['PHP_SELF']."\">";
			$displayBlock .= <<<ENDOFBLOCK
					<label for="name">Name</label>
					<br/><input type="text" id="name" name="name" />
					<br /><br /><label for="username">Username</label>
					<br/><input type="text" id="username" name="username" required />
					<br /><br /><label for="password">Password</label>
					<br/><input type="password" id="password" name="password" required />
					<br /><br /><button type="submit" name="submit" value="submit">Submit</button>
				</form>
				<p>The password or username already exists. Please choose different information.</p></form><hr /><br />
				<a href="login.php">Already have an account? Login.</a>
ENDOFBLOCK;
		}
		//close connection to MySQL
		mysqli_close($mysqli);
	} else {
		//display form
		$displayBlock = "<h1 class=\"title\">Sign Up</h1><hr /><br />";
		$displayBlock .= "<form method=\"post\" action=\"".$_SERVER['PHP_SELF']."\">";
		$displayBlock .= <<<ENDOFBLOCK
				<label for="name">Name</label>
				<br/><input type="text" id="name" name="name" />
				<br /><br /><label for="username">Username</label>
				<br/><input type="text" id="username" name="username" required />
				<br /><br /><label for="password">Password</label>
				<br/><input type="password" id="password" name="password" required />
				<br /><br /><button type="submit" class="button" name="submit" value="submit">Sign Up</button>
			</form><br /><hr /><br />
			<a href="loginForm.php">Already have an account? Login.</a>
ENDOFBLOCK;
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Sign Up</title>
		<link rel="stylesheet" type="text/css" href="../stylesheets/main.css" />
	</head>
	<body>
		<?php echo $displayBlock; ?>
	</body>
</html>