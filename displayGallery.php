<?php
	include("includes/menuBar.php");
	//connect to server and select database
	$mysqli = mysqli_connect("localhost", "root", "SonyaAriela1", "travelmap") or die(mysql_error());
	//issue query to find user
	$users_sql = "SELECT username,id FROM users LIMIT ".(9 * $_GET['page']).",9";
	$users_result = mysqli_query($mysqli, $users_sql) or die(mysqli_error($mysqli));
	$users = mysqli_fetch_all($users_result,MYSQLI_NUM);
	$displayBlock = "<h1 class='title' style='text-align:center;'>Gallery</h1><hr /><br />
	<div id='gallery' width='100%' style='display:flex;flex-wrap:wrap;justify-content:center;'>";
	for($i=0;$i<count($users);$i++){
		$displayBlock .= "<div class='galleryItem' style='height:300px;border:3px solid black;padding:5px;margin:5px;flex:1;'><a href='displayMap.php?user=".$users[$i][0]."' style='font-style:normal;'>
			<p class='title' style='text-align:center;'>".ucwords(strtolower($users[$i][0]))."'s Map</p><hr />";
		$locations_sql = "SELECT location,type FROM locations WHERE user=".$users[$i][1]." LIMIT 3";
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
	if(count($users)%3 == 2){
		$displayBlock .= "<div style='padding:10px;margin:10px;flex:1;'></div>";
	} else if(count($users)%3 == 1){
		$displayBlock .= "<div style='padding:10px;margin:10px;flex:1;'></div>";
		$displayBlock .= "<div style='padding:10px;margin:10px;flex:1;'></div>";
	}
	$displayBlock .= "</div>";
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
			}
			@media only screen and (max-width : 385px) {
				.galleryItem:nth-child(n) {
					page-break-after:always;
				}
			}
		</style>
		<link rel="stylesheet" type="text/css" href="stylesheets/main.css" />
	</head>
	<body>
		<?php
			echo $displayBlock; 
			include("includes/pagination.php");
		?>
	</body>
</html>