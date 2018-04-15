<?php
	$displayBlock = "";
	//connect to server and select database
	$mysqli = mysqli_connect("localhost", "root", "SonyaAriela1", "travelmap") or die(mysql_error());
	$users_sql = "SELECT username FROM users";
	$users_result = mysqli_query($mysqli, $users_sql) or die(mysqli_error($mysqli));
	$count = mysqli_num_rows($users_result);
	$pages = ceil($count / 9);
	if($_GET['page'] == 0){
		$displayBlock = "<a href=\"#\">&laquo;</a>";
	} else {
		$displayBlock = "<a href=\"displayGallery.php?page=".($_GET['page'] - 1)."\">&laquo;</a>";
	}
	for($i=0;$i<$pages;$i++){
		if($i == $_GET['page']){
			$displayBlock .= "<a class=\"active\" href=\"displayGallery.php?page=".$i."\">".($i + 1)."</a>";		
		} else {
			$displayBlock .= "<a href=\"displayGallery.php?page=".$i."\">".($i + 1)."</a>";
		}
	}
	if($_GET['page'] == $pages - 1){
		$displayBlock .= "<a href=\"#\">&raquo;</a>";
	} else {
		$displayBlock .= "<a href=\"displayGallery.php?page=".($_GET['page'] + 1)."\">&raquo;</a>";
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>TravelMapIt</title>
		<style>
			#center {
				 text-align:center;
			}
			#pagination{
				background-color:#333333;
				display:inline-block;
			}
			#pagination a{
				display:block;
				color:#f2f2f2;
				text-align:center;
				padding:14px 16px;
				text-decoration:none;
				font-size:17px;
				float:left;
			}
			#pagination a.active{
				background-color:#279F34;
				color:#333333;
			}
		</style>
	</head>
	<body>
		<br />
		<div id="center" width="100%">
			<div id="pagination" width="100%">
				<?php echo $displayBlock; ?>
			</div>
		</div>
	<body>
</html>