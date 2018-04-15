<?php
	include("login.php");
	include("../includes/menuBar.php");
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Login</title>
		<link rel="stylesheet" type="text/css" href="../stylesheets/main.css" />
	</head>
	<body>
		<h1 class="title">Log In</h1><hr /><br />
		<form class="loginForm" <?php echo "action=\"".$_SERVER['PHP_SELF']."\""; ?> method="post">
			<label for="username">Username</label>
			<br /><input type="text" id="username" name="username" required />
			<br /><br /><label for="password">Password</label>
			<br /><input type="password" id="password" name="password" required />
			<br /><br /><button type="submit" class="button" name="submit" value="submit">Log In</button><br /><br />
			<?php echo $error; ?>
		</form><br /><hr /><br />
		<a href="signUp.php">Don't have an account? Sign up here.</a>
	</body>
</html>