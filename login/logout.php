<?php
	include("login.php");
	//used to destroy specific session
	if(isset($_SESSION['login_user'])){
		unset($_SESSION['login_user']);
	}
	header("location: ../index.php");
?>