<?php
	include("login/login.php");
	$displayBlock = "";
	//check if login
	if(!isset($_SESSION['login_user'])){
		header("location: login/loginForm.php");
	}
	include("includes/menuBar.php");
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>TravelMapIt</title>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
		<script type="text/javascript" src="http://maps.google.com/maps/api/js?key=GoogleMapsAPIKey"></script>
		<script type="text/javascript" src="createMap.js"></script>
		<link rel="stylesheet" type="text/css" href="stylesheets/main.css" />
	</head>
	<body>
		<div id="mapform">
			<h1 class="title">Add Location</h1><hr /><br />
			<form class="mapinfo" action="displayNewLocation.php" method="post">
				<fieldset>
					<legend>Location:</legend>
					<label for="city">City</label>
					<br /><input type="text" id="city" name="city" />
					<br /><br /><label for="state">State</label>
					<br /><input type="text" id="state" name="state" />
					<br /><br /><label for="country">Country</label>
					<br /><input type="text" id="country" name="country" />
				</fieldset>
				<fieldset>
					<legend>Type:</legend>
					<input type="radio" name="type" id="want to visit" value="want to visit" checked><label for="want to visit"> Want To Visit</label>
					<br><input type="radio" name="type" id="visited" value="visited"><label for="visited"> Visited</label><br>
				</fieldset>
				<br /><button type="submit" class="button" name="submit" value="submit">Submit</button>
			</form>
		</div>
	</body>
</html>