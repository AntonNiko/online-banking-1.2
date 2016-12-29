<?php
	session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Account Details</title>

	<!-- Bootstrap CSS -->
	<link href="http://localhost/resources/css/bootstrap.min.css" rel="stylesheet">
  <!-- JQuery -->
	<script src="http://localhost/resources/js/jquery.min.js"></script>
	<script src="http://localhost/resources/js/bootstrap.min.js"></script>
	<!-- [if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

	<!-- Style for Webpage specific elements. When complete, transfer all common elements in single CSS -->
	<style>
	.navbar-inverse {
		background-color:#bb0c0c;
		border-color:#bb0c0c;
	}
	.navbar-inverse .navbar-nav>li>a {
		color:#ffffff;
	}
	.navbar-inverse .navbar-nav>.active>a {
		background-color:#9c3f3f;
	}
	.navbar-inverse .navbar-brand {
		color:#ffffff;
	}
	.accountsummary {
		height:125px;
		background-color:#f2f2f2;
		border-color:#cccccc;
		border-width: 1px;
        border-style: solid;
	}
	.accountlist {
		padding-left:0px;
		padding-right:20px;
	}
	.list-group-item.active, .list-group-item.active:focus {
		background-color:#dcdcdc;
		border-color:#dcdcdc;
		color:#000000;
	}
	.list-group-item.active:hover{
		background-color:#cccccc;
		border-color:#cccccc;
		color:#000000;
	}
	.balance {
		height: 90px;
		background-color: #f2f2f2;
		border-color: #cccccc;
		border-width: 1px;
		border-style: solid;
	}
	table{
		border-color: #cccccc;
		border-width: 1px;
		border-style: solid;
	}
	</style>
</head>
<body>
<?php
if(isset($_SESSION["loggedIn"]) && isset($_SESSION["ipAddress"]) && isset($_POST["accountInfo"])){
	if($_SESSION["loggedIn"][0] && $_SERVER["REMOTE_ADDR"]==$_SESSION["ipAddress"] && $_POST["accountNum"]){
		/*
		Retrieve all Account Information, in order to display Details
		*/
		$db = new mysqli("localhost","root","***","onlinebanking");
		$cardNum = $_SESSION["loggedIn"][1];
		// Fetch All Accounts and Place Info in Array
		$accounts = Array();
		$rChequing = $db -> query("SELECT * FROM chequingaccounts WHERE card_num='$cardNum'");
		$rSavings = $db ->query("SELECT * FROM savingsaccounts WHERE card_num='$cardNum'");
		// Append Chequing Accounts
		$chequingAccounts = $rChequing -> fetch_all(MYSQLI_ASSOC);
		foreach($chequingAccounts as $chequingAccount){
			$accounts[$chequingAccount['account_num']] = Array('Chequing',$chequingAccount['balance']);
		}
		// Append Savings Accounts
		$savingsAccounts = $rSavings -> fetch_all(MYSQLI_ASSOC);
		foreach($savingsAccounts as $savingsAccount){
			$accounts[$savingsAccount['account_num']] = Array('Savings',$savingsAccount['balance']);
		}

		?>

	<nav class="navbar navbar-inverse">
		<div class="container-fluid">
			<div class="navbar-header">
				<a class="navbar-brand" href="http://localhost">DBC Online Banking</a>
			</div>
			<ul class="nav navbar-nav">
				<li><a href="http://localhost">Home</a></li>
				<li class="dropdown">
					<a class="dropdwon-toggle" data-toggle="dropdown"
					href="#">Banking<span class="caret"></span></a>
					<ul class="dropdown-menu">
						<li><a href="#">Bank Accounts</a></li>
						<li><a href="#">Credit Cards</a></li>
					</ul>
				</li>
				<li><a href="#">Mortgages</a></li>
				<li><a href="#">Lending</a></li>
				<li><a href="#">Investments</a></li>
			</ul>
			<ul class="nav navbar-nav" style="float:right;">
				<li><a href="http://localhost/services/globalmoneytransfer/">
					<span class="glyphicon glyphicon-usd" aria-hidden="true"></span>
					<span class="glyphicon glyphicon-globe" aria-hidden="true"></span>
				Global Money Transfer</a></li>
			</ul>
		</div>
	</nav>

	<div class="container" style="font-size:1.2rem;">
		<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<h2>Account Details</h2>
			</div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<div style="float:right;">
					<a href="http://localhost/myaccount/"><button type="button" class="btn btn-lg btn-primary">Back to Account</button></a>
					<form class="" action="http://localhost/resources/php/logout.php" method="post" style="display:inline;">
						<button type="submit" class="btn btn-lg btn-default" name="logout">Sign Out</button>
					</form>
				</div>
			</div>
		</div>
		<div class="row" style="margin-top:15px;">
			<form action="http://localhost/myaccount/accountinfo/" method="post">
				<select class="selectpicker" name="accountNum" style="margin-left: 15px;width: 300px;">
					<?php
					foreach($accounts as $account_num => $data){
						if($account_num==$_POST["accountNum"]){
							?>
							<option selected="selected" value="<?php echo $account_num;?>"><?php echo $data[0]." (".$account_num.")"; ?></option>
							<?php
						}else{
							?>
							<option value="<?php echo $account_num;?>"><?php echo  $data[0]." (".$account_num.")"; ?></option>
							<?php
						}
					}
					?>
				</select>
				<button type="submit" class="btn btn-sm btn-default" name="accountInfo">View</button>
			</form>
		</div>
		<div class="row" style="margin-top:30px;">
			<div class="col-xs-4 col-sm-3 col-md-2 col-lg-2 balance" style="padding:10px;">
					<h4>Balance <sup>1</sup></h4>
					<p style="font-weight:700;">$<?php echo number_format($accounts[$_POST["accountNum"]][1],2);?></p>
			</div>
			<div class="col-xs-4 col-sm-3 col-md-2 col-lg-2 balance" style="padding:10px;">
					<h4>Available Funds <sup>2</sup></h4>
					<p style="font-weight:700;">$<?php echo number_format($accounts[$_POST["accountNum"]][1],2);?></p>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top:10px;">
				<!-- Format Table Correctly such that all data shown -->
				<h4>Quick Transfers</h4>
				<table class="table">
					<thead>
						<tr style="background-color:#eeeeee;">
							<th>Date</th>
							<th>Transactions</th>
							<th>Debit</th>
							<th>Credit</th>
							<th>Running Balance</th>
						</tr>
					</thead>
					<tbody>
						<?php
						// Fetch All Transactions Involving account in question
						$db = new mysqli("localhost","root","***","onlinebanking");
						$accountNum = $_POST["accountNum"];
						$rTransfers = $db -> query("SELECT * FROM quicktransfers WHERE origin_account=$accountNum OR destination_account=$accountNum ORDER BY timestamp DESC;");
						$db -> close();
						$transfers = $rTransfers -> fetch_all(MYSQLI_ASSOC);

						foreach($transfers as $transfer){
							$transferID = $transfer["transfer_id"];
							$transferTime = $transfer["timestamp"];
							$transferOrigin = $transfer["origin_account"];
							$transferDestination = $transfer["destination_account"];
							$transferAmount = number_format($transfer["amount"],2);
							$originBalance = number_format($transfer["origin_balance"],2);
							$destinationBalance = number_format($transfer["destination_balance"],2);
							$description = $transfer["description"];


							// Calculate if Debit or Credit Transaction
							$credit=$debit=$runningBalance=null;
							if($transferOrigin == $_POST["accountNum"]){
								$debit = "$".$transferAmount;
								$runningBalance = $originBalance;
							}elseif($transferDestination == $_POST["accountNum"]){
								$credit = "$".$transferAmount;
								$runningBalance = $destinationBalance;
							}
							?>
							<tr>
								<th scope="row"><?php echo substr($transfer["timestamp"],0,10);?></th>
								<td><?php echo $transfer["description"]."  ".$transfer["transfer_id"];?></td>
								<td><?php echo $debit;?></td>
								<td><?php echo $credit;?></td>
								<td><?php echo "$".$runningBalance;?></td>
							</tr>
							<?php
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<?php
	}else{
		//if IP addresses do not match, log user out
		unset($_SESSION["ipAddress"]);
		if(isset($_SESSION["loggedIn"])){
			unset($_SESSION["loggedIn"]);
			header("Location: http://localhost");
		}else{
			header("Location: http://localhost");
		}
		die();
	}
}else{
	header("Location: http://localhost");
}
?>
</body>
</html>
