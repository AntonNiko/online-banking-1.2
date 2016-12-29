<?php
	session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Account Summary</title>

	<!-- Bootstrap CSS -->
	<link href="http://localhost/resources/css/bootstrap.min.css" rel="stylesheet">
    <!-- JQuery -->
	<script src="http://localhost/resources/js/jquery.min.js"></script>
	<script src="http://localhost/resources/js/bootstrap.min.js"></script>
	<!-- [if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

	<!-- Jquery Canvas for charts -->
	<script src="http://localhost/resources/js/canvasjs.min.js"></script>

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

	</style>
</head>
<body>
<?php
if(isset($_SESSION["loggedIn"]) && isset($_SESSION["ipAddress"])){
	if($_SESSION["loggedIn"][0] && $_SERVER["REMOTE_ADDR"]==$_SESSION["ipAddress"]){
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
				<h2>My Accounts</h2>
			</div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<form class="navbar-form navbar-right" action="http://localhost/resources/php/logout.php" method="post">
					<button type="submit" class="btn btn-lg btn-default" name="logout">Sign Out</button>
				</form>
			</div>
		</div>
		<div class="row" style="margin-top:10px;">
			<?php
			// Connect to Database and retrieve all accounts related to Card Number
			$db = new mysqli("Localhost","root","***","onlinebanking");
			$cardNum = $_SESSION["loggedIn"][1];
			$rChequing = $db -> query("SELECT * FROM chequingaccounts WHERE card_num='$cardNum'");
			$rSavings = $db -> query("SELECT * FROM savingsaccounts WHERE card_num='$cardNum'");
			$db -> close();

			// Fetch All Accounts and Append to an array that'll be used to output HTML
			$accounts = Array();
			// Append Chequing Accounts
			$chequingAccounts = $rChequing -> fetch_all(MYSQLI_ASSOC);
			if(!empty($chequingAccounts)){
				foreach($chequingAccounts as $chequingAccount){
					$accounts[$chequingAccount['account_num']] = Array('Chequing',$chequingAccount['balance']);
				}
			}
			// Append Savings Accounts
			$savingsAccounts = $rSavings -> fetch_all(MYSQLI_ASSOC);
			if(!empty($savingsAccounts)){
				foreach($savingsAccounts as $savingsAccount){
					$accounts[$savingsAccount['account_num']] = Array('Savings',$savingsAccount['balance']);
				}
			}

			// Output each Account Summary in HTML Form
			foreach($accounts as $account_num => $data){
				?>
				<div class="col-xs-4 col-sm-3 col-md-2 col-lg-2 accountsummary" style="background-color:<?php if($data[0]=="Chequing"){echo"#d4fbdd";}elseif($data[0]=="Savings"){echo "#d4d9fb";}?>;">
					<h3 style=""><?php echo $data[0];?></h3>
					<p><?php echo $account_num;?></p>
					<p style="font-weight:700;font-size:1.6rem;">$<?php echo number_format($data[1],2);?></p>
				</div>
				<?php
			}
			?>
		</div>
		<div class="row" style="margin-top:30px;">
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 accountlist">

				<div class="list-group">
					<a href="#" class="list-group-item active">
					  <h4 class="list-group-item-heading">Deposit Accounts</h4>
					</a>

					<?php
					foreach($accounts as $account_num => $data){
						?>
						<a href="" class="list-group-item" style="height:70px;">
						  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<h4 class="list-group-item-heading" style="display:inline;"><?php echo $data[0];?></h4>
							<span class="glyphicon glyphicon-collapse-down dropdown-toggle" aria-hidden="true" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></span>
							<p class="list-group-item-text" style="margin-top:10px;"><?php echo $account_num;?></p>
						  </div>
						  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
							<p>Balance: <span style="font-weight:700;">$<?php echo number_format($data[1],2);?></span></p>
							<form action="http://localhost/myaccount/accountinfo/" method="post">
								<input type="hidden" name="accountNum" value="<?php echo $account_num;?>">
								<button type="submit" class="btn btn-xs btn-default" name="accountInfo">View Transactions</button>
							</form>
						  </div>
						</a>
						<?php
					}

					// Show Total Amount of Deposit Accounts amount
					$totalDepositAmount = 0;
					foreach($accounts as $account_num=>$data){
						$totalDepositAmount+=$data[1];
					}
					?>
					<a href="" class="list-group-item" style="height:55px;background-color:#f1f1f1;">
					  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						<h4 class="list-group-item-heading" style="display:inline;"><?php echo "Total Deposit:";?></h4>
						<span class="glyphicon glyphicon-collapse-down dropdown-toggle" aria-hidden="true" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></span>
					  </div>
					  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						<p>Balance: <span style="font-weight:700;">$<?php echo number_format($totalDepositAmount,2);?></span></p>
					  </div>
					</a>

					<?php

					?>
				</div>
			</div>
			<div class="visible-xs-inline-block visible-sm-inline-block"></div>
			<div class="col-md-6 col-lg-6">
				<ul class="list-group" id="quicktransfer">
					<form action="http://localhost/resources/php/quicktransferverify.php" method="post">
						<li class="list-group-item">
							<h4 style="margin:2px;font-weight:700;">Quick Transfer</h4>
						</li>
						<li class="list-group-item">
							<p>From:</p>
							<select class="selectpicker" name="originaccount">
								<option selected="selected">Choose an Account...<span class="caret"></span></option>

								<?php
								foreach($accounts as $account_num=>$data){
									?>
									<option value="<?php echo $account_num;?>"><?php echo $data[0]." (".$account_num.") $".number_format($data[1],2);?></option>
									<?php
								}
								?>
							</select>
						</li>
						<li class="list-group-item">
							<p>To:</p>
							<select class="selectpicker" name="destinationaccount">
								<option selected="selected">Choose an Account...<span class="caret"></span></option>
								<?php
								foreach($accounts as $account_num=>$data){
									?>
									<option value="<?php echo $account_num;?>"><?php echo $data[0]." (".$account_num.") $".number_format($data[1],2);?></option>
									<?php
								}
								?>
							</select>
						</li>
						<li class="list-group-item">
							<p>Amount:</p>
							<span>$ </span><input type="text" name="transferamount" style="line-height:1px;">
						</li>
						<li class="list-group-item">
							<?php
							// Checks for Any Transfer Fails. If so, unsets session val & displays error
							if(isset($_SESSION["transferFail"])){
								if($_SESSION["transferFail"]){
									unset($_SESSION["transferFail"]);
									?>
									<div class="alert alert-danger" role="alert"><strong>Error - </strong> Invalid Transfer details. Please make sure all the information above is correct & you have sufficient funds</div>
									<?php
								}
							}
							?>
							<button type="submit" class="btn btn-primary" name="verifyquicktransfer">Next</button>
						</li>
					</form>
				</ul>
			</div>
		</div>

		<div class="row" style="margin-top:0px;">
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
					<script type="text/javascript">
						window.onload = function () {
							var chart = new CanvasJS.Chart("chartContainer",
							{
								title: {
									text: "Balance Distribution"
								},
								animationEnabled: true,
								animationDuration: 1000,
								legend: {
									verticalAlign: "bottom",
									horizontalAlign: "center"
								},
								data: [
								{
									indexLabelFontSize: 20,
									indexLabelFontFamily: "Monospace",
									indexLabelFontColor: "darkgrey",
									indexLabelLineColor: "darkgrey",
									indexLabelPlacement: "outside",
									type: "pie",
									dataPoints: [
										<?php
											foreach($accounts as $account_num=>$data){
												echo '{y:'.round($data[1],2).',toolTipContent:"<strong>${y} - '.$data[0].'</strong> - '.$account_num.'"},';
											}
										?>
									]
								}
								]
							});
							chart.render();
						}
					</script>
					<div id="chartContainer" style="height:300px;"></div>
			</div>
		</div>
	</div>
		<?php
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
}else{
	header("Location: http://localhost");
}
?>
</body>
</html>
