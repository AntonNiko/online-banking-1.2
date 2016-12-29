<?php
session_start();

// Retrieves Unsafe Data from Variables (typically User-input)
function safeString($d){
	$d = trim(htmlspecialchars($d));
	return $d;
}

// Fetches the Current User's Chequing & Savings Accounts and Checks if account_num is one of their accounts. Returns True/False
function validClientAccount($account_num){
	$db = new mysqli("localhost","root","***","onlinebanking");
	$cardNum = $db -> real_escape_string($_SESSION["loggedIn"][1]);
	// CHEQUING ACCOUNT
	if($account_num[0]=='1'){
		$rChequing = $db -> query("SELECT account_num FROM chequingaccounts WHERE card_num='$cardNum'");
		$db -> close();
		$chequingAccounts = $rChequing -> fetch_all(MYSQLI_ASSOC);
		if(empty($chequingAccounts)){
			return False;
		} else{
			// Loops through each row, as client may have multiple chequing accounts
			$valid = False;
			foreach($chequingAccounts as $account){
				if($account['account_num']==$account_num){
					$valid = True;
				}
			}
			if($valid){
				return True;
			}else{
				return False;
			}
		}
	}
	// SAVINGS ACCOUNT
	elseif($account_num[0]=='2'){
		$rSavings = $db -> query("SELECT account_num FROM savingsaccounts WHERE card_num='$cardNum'");
		$db -> close();
		$savingsAccounts = $rSavings -> fetch_all(MYSQLI_ASSOC);
		if(empty($savingsAccounts)){
			return False;
		} else{
			// Loops through each row, as client may have multiple savings accounts
			$valid = False;
			foreach($savingsAccounts as $account){
				if($account['account_num']==$account_num){
					$valid = True;
				}
			}
			if($valid){
				return True;
			}else{
				return False;
			}
		}
	}else{
		return False;
	}
}

// Checks if sufficient funds in OriginAccount to fund the transaction. If no such account exists, returns fale. Sufficient: True, Insufficient: False
function validTransferAmount($account,$amount){
	if($account[0]=='1'){
		$db = new mysqli("localhost","root","***","onlinebanking");
		$amount = $db -> real_escape_string($amount);
		$rChequing = $db -> query("SELECT balance FROM chequingaccounts WHERE account_num='$account'");
		$db -> close();

		$chequingBalance = $rChequing -> fetch_all(MYSQLI_ASSOC);
		if(empty($chequingBalance)){
			return False;
		}else{
			if($chequingBalance[0]['balance']>=$amount){
				return True;
			}else{
				return False;
			}
		}

	}elseif($account[0]='2'){
		$db = new mysqli("localhost","root","***","onlinebanking");
		$amount = $db -> real_escape_string($amount);
		$rSavings = $db -> query("SELECT balance FROM savingsaccounts WHERE account_num='$account'");
		$db -> close();

		$savingsBalance = $rSavings -> fetch_all(MYSQLI_ASSOC);
		if(empty($savingsBalance)){
			return False;
		}else{
			if($savingsBalance[0]['balance']>=$amount){
				return True;
			}else{
				return False;
			}
		}
	}else{
		return False;
	}
}

/* If Client requests to Transfer Funds */
if(isset($_POST["verifyquicktransfer"])){
	$originAccount = safeString($_POST["originaccount"]);
	$destinationAccount = safeString($_POST["destinationaccount"]);
	$transferAmount = safeString($_POST["transferamount"]);

	// Checks that originAccount,destinationAccount match account number formats. Checks that transfer amount is valid number (NOTE: Returns error on amount=0)
	if(preg_match("/^\d{7}$/",$originAccount) && preg_match("/^\d{7}$/",$destinationAccount) && floatval($transferAmount)){
		// Returns Error if OriginAccount and DestinationAccount the same
		if($originAccount == $destinationAccount){
			$_SESSION["transferFail"] = True;
			header("Location: http://localhost/myaccount");
			die();
		}else{
			// Verify IP same as User Login, Check that OriginAccount valid, Transfer Amount Valid and DestinationAccount Valid
			if(isset($_SESSION["ipAddress"])){
				if($_SERVER["SERVER_ADDR"] == $_SESSION["ipAddress"]){

					// OriginAccount Valid?
					$originValid = validClientAccount($originAccount);
					// DestinationAccount Valid?
					$destinationValid = validClientAccount($destinationAccount);
					// TransferAmount Valid?
					$transferAmountValid = validTransferAmount($originAccount,$transferAmount);
					echo $originValid.$destinationValid.$transferAmountValid;

					if($originValid && $destinationValid && $transferAmountValid){
						$_SESSION["originAccount"] = $originAccount;
						$_SESSION["destinationAccount"] = $destinationAccount;
						$_SESSION["transferAmount"] = round($transferAmount,2);
						$_SESSION["validQuickTransfer"] = True;
						header("Location: http://localhost/myaccount/confirmtransaction");
						die();
					}else{
						$_SESSION["transferFail"] = True;
						header("Location: http://localhost/myaccount");
						die();
					}
				}else{
					// If IP addresses do not match, log out the user
					unset($_SESSION["ipAddress"]);
					if(isset($_SESSION["loggedIn"])){
						unset($_SESSION["loggedIn"]);
						header("Location: http://localhost");
					}else{
						header("Location: http://localhost");
					}
					die();
				}
			}
		}
	}else{
		$_SESSION["transferFail"] = True;
		header("Location: http://localhost/myaccount");
		die();
	}
}elseif(isset($_POST["cancelquicktransfer"])){
	unset($_SESSION["originAccount"]);
	unset($_SESSION["destinationAccount"]);
	unset($_SESSION["transferAmount"]);
	unset($_SESSION["validQuickTransfer"]);
	header("Location: http://localhost/myaccount");
}else{
	header("Location: http://localhost");
	die();
}
