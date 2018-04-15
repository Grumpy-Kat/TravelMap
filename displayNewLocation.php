<?php
	include("login/login.php");
	if(!isset($_SESSION['login_user'])){
		header("location: login/loginForm.php");
	}
	include("includes/menuBar.php");
	include("includes/legend.html");
	$displayBlock = "";
	if($_POST && isset($_POST['submit']) && ($_POST['city'] != "" || $_POST['state'] != "" || $_POST['country'] != "")){
		$city = urlencode($_POST['city']);
		$state = urlencode($_POST['state']);
		$country = urlencode($_POST['country']);
		$type = $_POST['type'];
		$geocode = file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$city.',+'.$state.',+'.$country.'&sensor=false');
		$output = json_decode($geocode); //store values in variable
		$lat = $output->results[0]->geometry->location->lat;//returns latitude
		$long = $output->results[0]->geometry->location->lng;//returns longitude
		$loc = $output->results[0]->formatted_address;
		$displayBlock = "<h1 class='title'>Map</h1><hr /><p id='lat'>Latitude: ".$lat."</p>";
		$displayBlock .= "<p id='long'>Longitude: ".$long."</p>";
		$displayBlock .= "<p id='loc'>Address: ".$loc."</p>";
		$displayBlock .= "<hr /><br /><div id='map' style='border:1px solid black; width:100%; height:400px;'></div>";
		$displayBlock .= "<script>initMap(".$lat.",".$long.",\"".$loc."\",\"".$type."\");";
		//connect to server and select database
		$mysqli = mysqli_connect("localhost", "root", "SonyaAriela1", "travelmap") or die(mysql_error());
		//issue query to find user
		$user_sql = "SELECT id FROM users WHERE username = '".$_SESSION['login_user']."'";
		$user_result = mysqli_query($mysqli, $user_sql) or die(mysqli_error($mysqli));
		$row = mysqli_fetch_row($user_result);
		$id = $row[0];
		//issue query to find locations for user
		$locations_sql = "SELECT latitude,longitude,location,type FROM locations WHERE user = '".$id."'";
		$locations_result = mysqli_query($mysqli, $locations_sql) or die(mysqli_error($mysqli));
		$array = mysqli_fetch_all($locations_result,MYSQLI_NUM);
		$displayBlock .= "loadAllMarkers([";
		for($i=0,$y=0;$i<count($array);$i++){
			if($y > 0){
				$displayBlock .= ",";
			}
			if($array[$i][0] != $lat || $array[$i][1] != $long || $array[$i][2] != $loc){
				$y++;
				$displayBlock .= "[".$array[$i][0].",".$array[$i][1].",'".$array[$i][2]."','".$array[$i][3]."']";
			}
		}
		$displayBlock .= "]);</script>";
		//issue query to add location to database;
		if(in_array(array($lat,$long,$loc,'want to visit'),$array) == false && in_array(array($lat,$long,$loc,'visited'),$array) == false){
			$add_sql = "INSERT INTO locations (user,latitude,longitude,location,type) VALUES(".$id.",".$lat.",".$long.",'".$loc."','".$type."')";
			$add_result = mysqli_query($mysqli, $add_sql) or die(mysqli_error($mysqli));		
		}
		//free result set
		mysqli_free_result($user_result);
		mysqli_free_result($locations_result);
		//close connection
		mysqli_close($mysqli);
	} else {
		header("location: addLocation.php");
	}
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
		<?php echo $displayBlock; ?>
	</body>
</html>