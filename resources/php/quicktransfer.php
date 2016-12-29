<?php
session_start();

function transferFunds($originAccount,$destinationAccount,$transferAmount){
	$db = new mysqli("localhost","root","***","onlinebanking");

	// Origin Account
	if($originAccount[0]=='1'){
		// Fetch Current Balance
		$result = $db -> query("SELECT balance FROM chequingaccounts WHERE account_num=$originAccount");
		$balances = $result->fetch_all(MYSQLI_ASSOC);
		$startOriginBalance = $balances[0]['balance'];
		// Calculate New Balance and Update Field
		$finalOriginBalance = $startOriginBalance - $transferAmount;
		$_SESSION["finalOriginBalance"] = round($finalOriginBalance,2);
		if($db -> query("UPDATE chequingaccounts SET balance=$finalOriginBalance WHERE account_num=$originAccount") != True){
			return False;
		}

	}elseif($originAccount[0]=='2'){
		// Fetch Current Balance
		$result = $db -> query("SELECT balance FROM savingsaccounts WHERE account_num=$originAccount");
		$balances = $result->fetch_all(MYSQLI_ASSOC);
		$startOriginBalance = $balances[0]['balance'];

		// Calculate New Balance and Update Field
		$finalOriginBalance = $startOriginBalance - $transferAmount;
		$_SESSION["finalOriginBalance"] = round($finalOriginBalance,2);
		if($db -> query("UPDATE savingsaccounts SET balance=$finalOriginBalance WHERE account_num=$originAccount") != True){
			return False;
		}
	}else{
		return False;
	}

	// Destination Account
	if($destinationAccount[0]=='1'){
		// Fetch Current Balance
		$result = $db -> query("SELECT balance FROM chequingaccounts WHERE account_num=$destinationAccount");
		$balances = $result->fetch_all(MYSQLI_ASSOC);
		$startDestinationBalance = $balances[0]['balance'];
		// Calculate New Balance and Update Field
		$finalDestinationBalance = $startDestinationBalance + $transferAmount;
		$_SESSION["finalDestinationBalance"] = round($finalDestinationBalance,2);
		if($db -> query("UPDATE chequingaccounts SET balance=$finalDestinationBalance WHERE account_num=$destinationAccount") != True){
			return False;
		}else{
			return True;
		}

	}elseif($destinationAccount[0]=='2'){
		// Fetch Current Balance
		$result = $db -> query("SELECT balance FROM savingsaccounts WHERE account_num=$destinationAccount");
		$balances = $result->fetch_all(MYSQLI_ASSOC);
		$startDestinationBalance = $balances[0]['balance'];

		// Calculate New Balance and Update Field
		$finalDestinationBalance = $startDestinationBalance + $transferAmount;
		$_SESSION["finalDestinationBalance"] = round($finalDestinationBalance,2);
		if($db -> query("UPDATE savingsaccounts SET balance=$finalDestinationBalance WHERE account_num=$destinationAccount") != True){
			return False;
		}else{
			return True;
		}
	}else{
		return False;
	}
}

function deleteTransferInfo(){
	unset($_SESSION["originAccount"]);
	unset($_SESSION["destinationAccount"]);
	unset($_SESSION["transferAmount"]);
	unset($_SESSION["validQuickTransfer"]);

	// UNSET Record Session Vars
	if(isset($_SESSION["finalOriginBalance"])){
		unset($_SESSION["finalOriginBalance"]);
	}
	if(isset($_SESSION["finalDestinationBalance"])){
		unset($_SESSION["finalDestinationBalance"]);
	}
}

function getRandomString($length) {
    $characters = '0123456789';
    $string = '';
    for ($i=0;$i<$length;$i++) {
        $string.= $characters[mt_rand(0, strlen($characters) - 1)];
    }
    return $string;
}

function recordTransaction($origin,$destination,$amount,$originBalance,$destinationBalance){
	$db = new mysqli("localhost","root","***","onlinebanking");
	$transferID = intval(getRandomString(10));
    while($db -> query("INSERT INTO quicktransfers(transfer_id, origin_account, destination_account, amount, origin_balance, destination_balance,description) VALUES
						($transferID, $origin, $destination, $amount, $originBalance ,$destinationBalance,'Internet Banking QUICK TRANSFER');") != True){
		$transferID = intval(getRandomString(10));
	}
	$db -> close();
}

if(isset($_POST["quicktransfer"]) && isset($_SESSION["validQuickTransfer"]) && isset($_SESSION["loggedIn"]) && isset($_SESSION["ipAddress"])){
	if($_SESSION["validQuickTransfer"] && $_SESSION["loggedIn"][0] && $_SERVER["REMOTE_ADDR"]==$_SESSION["ipAddress"]){
		// Execute the transaction. If any Session Vars unavailable, return Error
		if(isset($_SESSION["originAccount"]) && isset($_SESSION["destinationAccount"]) && isset($_SESSION["transferAmount"])){

			/* Connect to Database and Perform Transfer (Updating Balance Fields of records concerned.) */
			$result = transferFunds($_SESSION["originAccount"],$_SESSION["destinationAccount"],$_SESSION["transferAmount"]);
			if($result){
				// Successful Transfer TODO: Record Transaction
				recordTransaction($_SESSION["originAccount"],$_SESSION["destinationAccount"],$_SESSION["transferAmount"],$_SESSION["finalOriginBalance"],$_SESSION["finalDestinationBalance"]);
				$_SESSION["transferSuccess"] = True;
				deleteTransferInfo();
				header("Location: http://localhost/myaccount/transactionsuccess");
			}else{
				$_SESSION["invalidTransferInfo"] = True;
				header("Location: http://localhost/myaccount/confirmtransaction");
			}
		}else{
			$_SESSION["invalidTransferInfo"] = True;
			header("Location: http://localhost/myaccount/confirmtransaction");
		}
		die();
	}else{
		// If IP addresses do not match, log out the user
		unset($_SESSION["ipAddress"]);
		if(isset($_SESSION["loggedIn"])){
			unset($_SESSION["loggedIn"]);
			deleteTransferInfo();
			header("Location: http://localhost");
		}else{
			deleteTransferInfo();
			header("Location: http://localhost");
		}
		die();
	}
}else{
	header("Location: http://localhost");
	die();
}
