<?php
	include("includes/menuBar.php");
	//connect to server and select database
	$mysqli = mysqli_connect("localhost", "root", "SonyaAriela1", "travelmap") or die(mysql_error());
	//display title
	$displayBlock = "<h1 class='title' style='text-align:center;'><img id='logo' src='images/logo.png' /></h1><hr />
	<p>Been to some amazing places? Want to visit others? <span id='title' class='title'>TravelMapIt!</span></p><hr /><br />";
	//adds the map
	include("login/login.php");
	if(!isset($_SESSION['login_user'])){
		$displayBlock .= "<div id='mapPreview'><a class='title' href='login/loginForm.php' style='font-style:normal;'>View Your Map:</a><br /><br />
			<p>Log in to view your map!</p>";
	} else {
		$displayBlock .= "<div id='mapPreview'><a href='displayMap.php?".$_SESSION['login_user']."' class='title' style='font-style:normal;'>View Your Map:</a><br /><br />
			<div id='map' style='border:1px solid black; width:100%; height:300px;'></div>";
		//issue query to find user
		$user_sql = "SELECT id FROM users WHERE username = '".$_SESSION['login_user']."'";
		$user_result = mysqli_query($mysqli, $user_sql) or die(mysqli_error($mysqli));
		$row = mysqli_fetch_row($user_result);
		$id = $row[0];
		//issue query to find locations for user
		$mapLocations_sql = "SELECT latitude,longitude,location,type FROM locations WHERE user = '".$id."'";
		$mapLocations_result = mysqli_query($mysqli, $mapLocations_sql) or die(mysqli_error($mysqli));
		$array = mysqli_fetch_all($mapLocations_result,MYSQLI_NUM);
		$displayBlock .= "<script>loadAllMarkers([";
		for($i=0;$i<count($array);$i++){
			if($i > 0){
				$displayBlock .= ",";
			}
			$displayBlock .= "[".$array[$i][0].",".$array[$i][1].",'".$array[$i][2]."','".$array[$i][3]."']";
		}
		$displayBlock .= "]);</script>";
	}
	$displayBlock .= "</div><br /><hr /><br />";
	//preview gallery
	$displayBlock .= "<div id='galleryPreview'><a class='title' href='displayGallery.php?page=0' style='font-style:normal;'>View Other People's Maps in the Gallery:</a><br /><br />";
	//issue query to find users
	$gallery_sql = "SELECT username,id FROM users LIMIT 3";
	$gallery_result = mysqli_query($mysqli, $gallery_sql) or die(mysqli_error($mysqli));
	$gallery = mysqli_fetch_all($gallery_result,MYSQLI_NUM);
	$displayBlock .= "<div id='gallery' width='100%' style='display:flex;flex-wrap:wrap;justify-content:center;'>";
	for($i=0;$i<count($gallery);$i++){
		$displayBlock .= "<div class='galleryItem' id='item".$i."' style='height:300px;border:3px solid black;padding:5px;margin:5px;flex:1;'><a href='displayMap.php?user=".$gallery[$i][0]."' style='font-style:normal;'>
			<p class='title' style='text-align:center;'>".ucwords(strtolower($gallery[$i][0]))."'s Map</p><hr />";
		$locations_sql = "SELECT location,type FROM locations WHERE user=".$gallery[$i][1]." LIMIT 3";
		$locations_result = mysqli_query($mysqli, $locations_sql) or die(mysqli_error($mysqli));
		$locations = mysqli_fetch_all($locations_result,MYSQLI_NUM);
		if(count($locations) == 0){
			$displayBlock .= "<blockquote style='font-style:italic;'>No Locations</blockquote>";
		} else {
			$displayBlock .= "<ul>";
			for($y=0;$y<count($locations);$y++){
				$displayBlock .= "<li>".$locations[$y][0]."</li><p style='display:inline;'>".ucwords($locations[$y][1])."</p><br /><br />";
			}
			$displayBlock .= "</ul>";
		}
		$displayBlock .= "</a></div>";
	}
	if(count($gallery)%3 == 2){
		$displayBlock .= "<div style='padding:10px;margin:10px;flex:1;'></div>";
	} else if(count($gallery)%3 == 1){
		$displayBlock .= "<div style='padding:10px;margin:10px;flex:1;'></div>";
		$displayBlock .= "<div style='padding:10px;margin:10px;flex:1;'></div>";
	}
	$displayBlock .= "</div></div>";
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
		<style>
			@media only screen and (min-width : 600px) {
				.galleryItem:nth-child(3n) {
					page-break-after:always;
				}
			}
			@media only screen and (max-width : 600px) and (min-width : 385px) {
				.galleryItem:nth-child(2n) {
					page-break-after:always;
				}
				#item2{
					display:none;
				}
				#logo{
					height:64px;
					width:300px;
				}
			}
			@media only screen and (max-width : 385px) {
				.galleryItem:nth-child(n) {
					page-break-after:always;
				}
				#item2{
					display:none;
				}
				#logo{
					width:100%;
					height:100%;
				}
			}
		</style>
		<link rel="stylesheet" type="text/css" href="stylesheets/main.css" />
	</head>
	<body>
		<?php echo $displayBlock; ?>
	</body>
</html>