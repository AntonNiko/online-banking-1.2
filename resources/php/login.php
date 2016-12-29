<?php
session_start();

// Retrieves Unsafe Data from Variables (typically User-input)
function safeString($str){
	$strSafe = trim(htmlspecialchars($str));
	return $strSafe;
}

function sha3($str){
	$python = 'C:\python34\python.exe';
	$script = 'C:\xampp\htdocs\resources\py\hash-gen.py';
	$cmd = "$python $script $str";
	exec($cmd,$output);
	return $output[0];
}

if(isset($_POST["login"])){
	// Connect to DB here such that we are able to use mysqli_real_escape_string
	$db = new mysqli("localhost","root","***","onlinebanking");
	$safeCardNum = $db->real_escape_string(safeString($_POST["cardnum"]));
	$safePassword = safeString($_POST["password"]);

	// Assign SHA-3 Hash to User Password
	$safePassword = $db->real_escape_string(sha3($safePassword));
	// Retrieve Array of Hash
	$r = $db -> query("SELECT hash FROM clients WHERE card_num='$safeCardNum'");
	$db -> close();
	$data = $r -> fetch_all(MYSQLI_ASSOC);

	// Verify if hashes match or if array is empty
	if(empty($data)){
		$_SESSION["loginFail"] = True;
	}else{
		if($safePassword == $data[0]["hash"]){
			$_SESSION["loggedIn"] = Array(True,$safeCardNum);
			$_SESSION["ipAddress"] = $_SERVER["REMOTE_ADDR"];
			header("Location: http://localhost/myaccount");
			die();
		}else{
			$_SESSION["loginFail"] = True;
		}
	}

	if($_SESSION["loginFail"]){
		// Redirects to this page. Since $_POST empty, will redirect back to Localhost
		$redirectLocation = $_SERVER["REQUEST_URI"];
		header("Location: $redirectLocation");
	}
}else{
	header("Location: http://localhost");
	die();
}
