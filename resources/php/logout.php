<?php
session_start();

if(isset($_POST["logout"])){
	if(isset($_SESSION["loggedIn"])){
		unset($_SESSION["loggedIn"]);
		unset($_SESSION["ipAddress"]);
		header("Location: http://localhost");
	}else{
		header("Location: http://localhost");
	}
}
