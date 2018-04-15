<?php
	include("login/login.php");
	include("includes/menuBar.php");
	$displayBlock = "";
	//connect to server and select database
	$mysqli = mysqli_connect("localhost", "root", "SonyaAriela1", "travelmap") or die(mysql_error());
	//issue query to find user
	$user_sql = "SELECT id FROM users WHERE username = '".$_GET['user']."'";
	$user_result = mysqli_query($mysqli, $user_sql) or die(mysqli_error($mysqli));
	$row = mysqli_fetch_row($user_result);
	$id = $row[0];
	if(isset($_GET['country'])){
		if(isset($_SESSION['login_user']) && $_SESSION['login_user'] == $_GET['user']){
			$displayBlock = "<h1 class='title' style='text-align:center;'>Your Map : ".$_GET['country']." Locations</h1>";
		} else {
			$displayBlock = "<h1 class='title' style='text-align:center;'>".ucwords(strtolower($_GET['user']))."'s Map : ".$_GET['country']." Locations</h1>";
		}
		//display pop up
		$cities_sql = "SELECT location,type FROM locations WHERE user = '".$id."' AND location LIKE '%".$_GET['country']."'";
		$cities_result = mysqli_query($mysqli, $cities_sql) or die(mysqli_error($mysqli));
		$cities = mysqli_fetch_all($cities_result,MYSQLI_NUM);
		$displayBlock .= "<hr /><br /><div id='locations'><ul>";
		for($i=0;$i<count($cities);$i++){
			$displayBlock .= "<li class='title'>".$cities[$i][0]."</li>";
			if(isset($_SESSION['login_user']) && $_SESSION['login_user'] == $_GET['user']){
				if($cities[$i][1] == "want to visit"){
					$displayBlock .= "<input type='radio' name='type".$i."' id='want to visit".$i."' value='want to visit' checked /><label for='want to visit".$i."'> Want To Visit</label>
					<a href='changeValue.php?user=".$_GET['user']."&location=".$cities[$i][0]."&value=visited'><input type='radio' name='type".$i."' id='visited".$i."' value='visited'></a><label for='visited".$i."' /> Visited</label>";
				} else if($cities[$i][1] == "visited"){
					$displayBlock .= "<a href='changeValue.php?user=".$_GET['user']."&location=".$cities[$i][0]."&value=want to visit'><input type='radio' name='type".$i."' id='want to visit".$i."' value='want to visit' /></a><label for='want to visit".$i."'> Want To Visit</label>
					<input type='radio' name='type".$i."' id='visited".$i."' value='visited' checked><label for='visited".$i."' /> Visited</label>";
				}
				$displayBlock .= "<br /><a href='changeValue.php?user=".$_GET['user']."&location=".$cities[$i][0]."&value=remove'><button class='button' name='remove".$i."' id='remove".$i."'>Remove</button></a>";
			} else {
				if($cities[$i][1] == "want to visit"){
					$displayBlock .= "<input type='radio' name='type".$i."' id='want to visit".$i."' value='want to visit' checked disabled /><label for='want to visit".$i."'> Want To Visit</label>
					<input type='radio' name='type".$i."' id='visited".$i."' value='visited' disabled><label for='visited".$i."' /> Visited</label>";
				} else if($cities[$i][1] == "visited"){
					$displayBlock .= "<input type='radio' name='type".$i."' id='want to visit".$i."' value='want to visit' /><label for='want to visit".$i."' disabled> Want To Visit</label>
					<input type='radio' name='type".$i."' id='visited".$i."' value='visited' checked disabled /><label for='visited".$i."'> Visited</label>";
				}
			}
			$displayBlock .= "<br /><br />";
		}
		$displayBlock .= "</ul></div>";
	} else {
		//display map
		include("includes/legend.html");
		if(isset($_SESSION['login_user']) && $_SESSION['login_user'] == $_GET['user']){
			$displayBlock = "<h1 class='title' style='text-align:center;'>Your Map</h1>";
		} else {
			$displayBlock = "<h1 class='title' style='text-align:center;'>".ucwords(strtolower($_GET['user']))."'s Map</h1>";
		}
		$displayBlock .= "<hr /><br /><div id='map' style='border:1px solid black; width:100%; height:400px;'></div>
		<br /><hr /><br /><div id='list' width='100%' style='display:flex;flex-wrap:wrap;justify-content:center;'></div>";
		//issue query to find locations for user
		$locations_sql = "SELECT latitude,longitude,location,type FROM locations WHERE user = '".$id."'";
		$locations_result = mysqli_query($mysqli, $locations_sql) or die(mysqli_error($mysqli));
		$array = mysqli_fetch_all($locations_result,MYSQLI_NUM);
		$displayBlock .= "<script>loadAllMarkers([";
		for($i=0;$i<count($array);$i++){
			if($i > 0){
				$displayBlock .= ",";
			}
			$displayBlock .= "[".$array[$i][0].",".$array[$i][1].",'".$array[$i][2]."','".$array[$i][3]."']";
		}
		$displayBlock .= "]);loadListOfLocations([";
		for($i=0;$i<count($array);$i++){
			if($i > 0){
				$displayBlock .= ",";
			}
			$displayBlock .= "['".$array[$i][2]."','".$array[$i][3]."']";
		}
		$displayBlock .= "]);</script>";
		//free result set
		mysqli_free_result($user_result);
		mysqli_free_result($locations_result);
	}
	//close connection
	mysqli_close($mysqli);
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
			.listItem:nth-child(even) {
				page-break-after:always;
			}
		</style>
		<link rel="stylesheet" type="text/css" href="stylesheets/main.css" />
	</head>
	<body>
		<?php echo $displayBlock; ?>
	</body>
</html>