<?php
	include("login/login.php");
	$url = $_SERVER['REQUEST_URI'];
	$baseLogin = "";
	$baseMainPages = "";
	if(strpos($url,"login/")){
		$baseMainPages = "../";
	} else {
		$baseLogin = "login/";
	}
	$displayBlock = "<a href=\"".$baseMainPages."index.php\" class=\"left\"><img src=\"".$baseMainPages."images/logo.png\" height=\"20px\" width=\"93.75px\" /></pa>";
	$displayBlock .= "<a href=\"".$baseMainPages."index.php\" class=\"left\">Home</a>";
	$displayBlock .= "<a href=\"".$baseMainPages."displayGallery.php?page=0\" class=\"left\">Gallery</a>";
	if(!isset($_SESSION['login_user'])){
		$displayBlock .= "<a href=\"".$baseLogin."loginForm.php\" class=\"left\">Add Location</a>";
		$displayBlock .= "<a href=\"".$baseLogin."loginForm.php\" class=\"left\">Your Map</a>";
		$displayBlock .= "<a href=\"".$baseLogin."loginForm.php\" class=\"right\">Login</a>";
		$displayBlock .= "<a href=\"".$baseLogin."signUp.php\" id=\"signUp\" class=\"right\">Sign Up</a>";
	} else {
		$displayBlock .= "<a href=\"".$baseMainPages."addLocation.php\" class=\"left\">Add Location</a>";
		$displayBlock .= "<a href=\"".$baseMainPages."displayMap.php?user=".$_SESSION['login_user']."\" class=\"left\">Your Map</a>";
		$displayBlock .= "<a href=\"".$baseLogin."logout.php\" class=\"right\">Logout</a>";
		$displayBlock .= "<a href=\"#\" id=\"welcome\" class=\"right\">Welcome, ".$_SESSION['login_name']."!</a>";
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>TravelMapIt</title>
		<style>
			#menuBar{
				background-color:#333333;
				overflow:hidden;
				width:100%;
			}
			#menuBar a{
				display:block;
				color:#f2f2f2;
				text-align:center;
				padding:13px 15px;
				text-decoration:none;
				height:20px;
				vertical-align:bottom;
			}
			#menuBar a:hover{
				background-color:#279F34;
				color:#333333;
			}
			.left{
				float:left;
			}
			.right{
				float:right;
			}
			@media only screen and (min-width : 790px) {
				#menuBar a {
					padding:13px 15px;
					font-size:17px;
				}
				#menuBar img{
					width:100%;
					height:100%;
				}
			}
			@media only screen and (max-width : 790px) and (min-width : 660px) {
				#menuBar a {
					padding:10px 13px;
					font-size:13px;
				}
				#menuBar img{
					width:90%;
					height:90%;
				}
			}
			@media only screen and (max-width : 660px) and (min-width : 555px) {
				#menuBar a {
					padding:10px 13px;
					font-size:13px;
				}
				#menuBar img {
					width:80%;
					height:80%;
				}
				#menuBar #welcome, #menuBar #signUp {
					display:none;
				}
			}
			@media only screen and (max-width : 555px) and (min-width : 405px) {
				#menuBar a {
					padding:7px 10px;
					font-size:10px;
				}
				#menuBar img {
					width:70%;
					height:70%;
				}
				#menuBar #welcome, #menuBar #signUp {
					display:none;
				}
			}
			@media only screen and (max-width : 405px) {
				#menuBar a {
					padding:5px 5px;
					font-size:10px;
				}
				#menuBar img{
					display:none;
				}
				#menuBar #welcome, #menuBar #signUp {
					display:none;
				}
			}
		</style>
	</head>
	<body>
		<div id="menuBar" width="100%">
			<?php echo $displayBlock; ?>
		</div><br />
	</body>
</html>